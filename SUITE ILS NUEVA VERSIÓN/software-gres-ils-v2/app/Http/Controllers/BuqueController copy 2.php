<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Buque;
use App\Models\Mision;
use App\Models\GrupoConstructivo;
use App\Models\SistemaSuite;
use App\Models\GresColab;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class BuqueController extends Controller
{
    public function index()
    {
        $buques = Buque::all();
        return view('gestion-buques', compact('buques'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'numero_casco' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'etapa' => 'required|string',
            'autonomia_horas' => 'required|integer|min:1',
            'vida_diseno_anios' => 'required|integer|min:1',
            'horas_navegacion_anio' => 'required|integer|min:1',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    
            // Nuevos campos del formulario
            'mision_organizacion' => 'nullable|string',
            'operaciones_tipo' => 'nullable|string',
            'estandares_calidad' => 'nullable|string',
            'estandares_ambientales' => 'nullable|string',
            'estandares_seguridad' => 'nullable|string',
            'lugar_operaciones' => 'nullable|string',
            'intensidad_operaciones' => 'nullable|string',
            'redundancia' => 'nullable|string',
            'tareas_operacion' => 'nullable|string',
            'repuestos' => 'nullable|string',
            'demanda_repuestos' => 'nullable|string',
        ]);
    
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('public/buques');
        }
    
        $buque = Buque::create($validated);
    
        return redirect()->route('buques.edit', $buque->id)
            ->with('success', 'Buque creado exitosamente. Ahora puedes agregar misiones y editar sus datos.');
    }
    

    public function edit(Buque $buque)
    {
        $misiones = Mision::all();
        $misionesSeleccionadas = $buque->misiones;  // Misiones seleccionadas del buque

        $grupos = GrupoConstructivo::with('sistemas')->get();

        // Obtener datos del puerto base, con valores de la base de datos para "Mantenimiento Básico" y "ROH"
        $datosPuertoBase = $this->obtenerDatosPuertoBase($buque->id);

        return view(
            'editar-buque',
            compact('buque', 'misiones', 'misionesSeleccionadas', 'grupos', 'datosPuertoBase')
        );
    }


    public function update(Request $request, Buque $buque)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'numero_casco' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'etapa' => 'required|string',
            'autonomia_horas' => 'required|integer',
            'vida_diseno_anios' => 'required|integer',
            'horas_navegacion_anio' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    
            // Nuevos campos del formulario
            'mision_organizacion' => 'nullable|string',
            'operaciones_tipo' => 'nullable|string',
            'estandares_calidad' => 'nullable|string',
            'estandares_ambientales' => 'nullable|string',
            'estandares_seguridad' => 'nullable|string',
            'lugar_operaciones' => 'nullable|string',
            'intensidad_operaciones' => 'nullable|string',
            'redundancia' => 'nullable|string',
            'tareas_operacion' => 'nullable|string',
            'repuestos' => 'nullable|string',
            'demanda_repuestos' => 'nullable|string',
        ]);
    
        if ($request->hasFile('imagen')) {
            if ($buque->imagen) {
                Storage::delete($buque->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('public/buques');
        }
    
        $buque->update($validated);
    
        return redirect()->route('buques.edit', $buque->id)
            ->with('success', 'Datos del buque actualizados exitosamente.');
    }
    

    public function saveSistemas(Request $request, Buque $buque)
    {
        $validated = $request->validate([
            'sistemas' => 'array', // Validar que sea un array
            'sistemas.*' => 'integer|exists:sistemas_suite,id', // Validar que cada sistema exista en la tabla sistemas_suite
        ]);

        // Sincronizar los sistemas seleccionados con la tabla pivote
        $buque->sistemas()->sync($validated['sistemas'] ?? []);

        return redirect()->route('buques.edit', $buque->id)
            ->with('success', 'Sistemas guardados exitosamente.');
    }


    public function saveMisiones(Request $request, Buque $buque)
    {
        // Validación de los datos
        $validated = $request->validate([
            'misiones' => 'array',
            'misiones.*.porcentaje' => 'nullable|numeric|min:0|max:100',
            'misiones.*.descripcion' => 'nullable|string|max:255',
            'misiones.*.velocidad' => 'nullable|string|max:255',
            'misiones.*.num_motores' => 'nullable|integer',
            'misiones.*.potencia' => 'nullable|integer|min:0|max:100',
        ]);

        // Obtener las misiones enviadas
        $misiones = $request->input('misiones', []);

        // Validación de porcentaje total
        $totalPorcentaje = collect($misiones)->sum('porcentaje');
        if ($totalPorcentaje > 100) {
            return redirect()->back()
                ->withErrors(['porcentaje' => 'El total de porcentajes no puede superar el 100%'])
                ->withInput();
        }

        // Desasociar las misiones anteriores
        $buque->misiones()->detach();

        // Guardar las nuevas misiones con sus datos adicionales
        foreach ($misiones as $misionId => $data) {
            $buque->misiones()->attach($misionId, [
                'porcentaje' => $data['porcentaje'] ?? null,
                'descripcion' => $data['descripcion'] ?? null,
                'velocidad' => $data['velocidad'] ?? null,
                'num_motores' => $data['num_motores'] ?? null,
                'potencia' => $data['potencia'] ?? null,
            ]);
        }

        return redirect()->route('buques.edit', $buque->id)
            ->with('success', 'Misiones guardadas exitosamente.');
    }


    public function destroy(Buque $buque)
    {
        try {
            if ($buque->imagen) {
                Storage::delete($buque->imagen);
            }

            $buque->misiones()->detach();
            $buque->delete();

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Buque eliminado exitosamente'
                ]);
            }

            return redirect()->route('buques.index')
                ->with('success', 'Buque eliminado exitosamente');

        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el buque: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('buques.index')
                ->with('error', 'Error al eliminar el buque: ' . $e->getMessage());
        }
    }

    public function modulos(Buque $buque)
    {
        return view('modulos', compact('buque'));
    }

    public function modGres(Buque $buque)
    {
        $buque->load([
            'sistemas' => function ($query) {
                $query->orderBy('codigo');
            },
            'misiones'
        ]);

        foreach ($buque->sistemas as $sistema) {
            $gresRecord = \App\Models\GresSistema::where('buque_id', $buque->id)
                ->where('sistema_id', $sistema->id)
                ->first();

            if ($gresRecord) {
                $sistema->mec = $gresRecord->mec;
                $sistema->diagrama = $gresRecord->diagrama;
                $sistema->observaciones = $gresRecord->observaciones;
            }
        }

        return view('mod_gres', compact('buque'));
    }



    public function saveGresSistema(Request $request)
    {
        $validated = $request->validate([
            'buque_id'   => 'required|exists:buques,id',
            'sistema_id' => 'required|exists:sistemas_suite,id',
            'mec'        => 'nullable|string|max:255',
            'diagrama'   => 'nullable|string|max:255',
            'observaciones' => 'nullable|array', // <-- validar que es array
        ]);

        try {
            $gresSistema = \App\Models\GresSistema::updateOrCreate(
                [
                    'buque_id'   => $validated['buque_id'],
                    'sistema_id' => $validated['sistema_id'],
                ],
                [
                    'mec'          => $validated['mec'] ?? null,
                    'diagrama'     => $validated['diagrama'] ?? null,
                    'observaciones'=> $validated['observaciones'] ?? [],
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'GRES guardado correctamente.',
                'data'    => $gresSistema,
            ]);
        } catch (\Exception $e) {
            logger()->error('Error saving GRES system:', [
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el GRES del sistema.',
            ], 500);
        }
    }

    #GRES EQUIPOS


    public function modGresEquipo(Buque $buque)
    {
        // Consultar los equipos asociados a este buque desde la DB 'lsa'
        $equipos = DB::connection('lsa')->select("
            SELECT id, nombre_equipo, GRES, id_sistema, id_buque
            FROM equipo_info
            WHERE id_buque = ?
        ", [$buque->id]);

        // Pasar los equipos a la vista
        return view('mod_gres_equipo', compact('buque', 'equipos'));
    }


    public function getEquiposBuque($buqueId)
{
    try {
        $equipos = DB::connection('lsa')
            ->table('equipo_info')
            ->where('id_buque', $buqueId)
            ->select('id', 'nombre_equipo as nombre', 'GRES')
            ->get();

        return response()->json([
            'success' => true,
            'equipos' => $equipos
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener equipos: ' . $e->getMessage()
        ], 500);
    }
}




    public function dashboard()
    {
        $buques = Buque::all();
        return view('dashboard', compact('buques'));
    }

    public function getMisiones(Buque $buque)
    {
        $misiones = $buque->misiones->map(function ($mision) {
            return [
                'nombre' => $mision->nombre,
                'porcentaje' => $mision->pivot->porcentaje,
                'descripcion' => $mision->pivot->descripcion,
            ];
        });

        return response()->json($misiones);
    }

    public function getColaboradores($buqueId)
    {
        $colaboradores = GresColab::where('buque_id', $buqueId)->get();
        return response()->json(['colaboradores' => $colaboradores]);
    }

    public function getColaborador($buqueId, $colaboradorId)
    {
        $colaborador = GresColab::where('buque_id', $buqueId)->where('id', $colaboradorId)->firstOrFail();
        return response()->json($colaborador);
    }

    public function createColaborador(Request $request)
    {
        $validated = $request->validate([
            'buque_id' => 'required|exists:buques,id',
            'cargo'    => 'required|string|max:255',
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'entidad'  => 'required|string|max:255',
        ]);

        try {
            $colaborador = GresColab::create($validated);

            // Asegúrate de retornar una respuesta JSON adecuada
            return response()->json([
                'success' => true,
                'message' => 'Colaborador añadido correctamente.',
                'colaborador' => $colaborador // Retornar los datos del colaborador creado si es necesario
            ]);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante la creación
            return response()->json([
                'success' => false,
                'message' => 'Error al añadir el colaborador.',
                'error' => $e->getMessage() // Opcional: solo para depuración
            ], 500);
        }
    }



    public function updateColaborador(Request $request, $colaboradorId)
    {
        $validated = $request->validate([
            'cargo'    => 'required|string|max:255',
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'entidad'  => 'required|string|max:255',
        ]);

        try {
            $colaborador = GresColab::findOrFail($colaboradorId);
            $colaborador->update($validated);

            return response()->json(['success' => true, 'message' => 'Colaborador actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el colaborador.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteColaborador($colaboradorId)
    {
        $colaborador = GresColab::findOrFail($colaboradorId);
        $colaborador->delete();

        return response()->json(['success' => true, 'message' => 'Colaborador eliminado correctamente.']);
    }

    public function getSistemasGres($buqueId)
    {
        try {
            // Obtenemos directamente de la tabla gres_sistema
            $sistemas = \App\Models\GresSistema::where('buque_id', $buqueId)
                ->with('sistema') // Asumiendo que tienes la relación definida
                ->get()
                ->map(function ($gresSistema) {
                    // Verificamos y procesamos el campo observaciones
                    $observaciones = is_string($gresSistema->observaciones)
                        ? json_decode($gresSistema->observaciones, true)
                        : (is_array($gresSistema->observaciones) ? $gresSistema->observaciones : []);

                    return [
                        'id' => $gresSistema->sistema->id,
                        'nombre' => $gresSistema->sistema->nombre,
                        'codigo' => $gresSistema->sistema->codigo,
                        'gres_sistema' => [
                            'mec' => $gresSistema->mec,
                            'ruta_diagrama' => $gresSistema->diagrama, // Mostrar la ruta como texto
                            'observaciones' => $observaciones // Siempre será un array
                        ]
                    ];
                });

            \Log::info('Sistemas GRES obtenidos para buque:', [
                'buque_id' => $buqueId,
                'cantidad_sistemas' => $sistemas->count()
            ]);

            return response()->json([
                'success' => true,
                'sistemas' => $sistemas
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al obtener sistemas GRES:', [
                'buque_id' => $buqueId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los sistemas: ' . $e->getMessage()
            ], 500);
        }
    }



    public function exportPdf(Request $request)
    {
        // Aumentar límites de memoria y tiempo de ejecución
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $validated = $request->validate([
            'buque_id' => 'required|exists:buques,id'
        ]);

        $buqueId = $validated['buque_id'];
        $buque = \App\Models\Buque::find($buqueId);

        if (!$buque) {
            return response()->json(['error' => 'El buque asociado no existe.'], 404);
        }

        try {
            $colaboradores = json_decode($request->colaboradores, true) ?? [];
            $titulo = "Anexo GRES: {$buque->nombre}";

            // Agregar fecha de generación
            $fechaGeneracion = now()->format('d/m/Y');


            // Procesar el logo de la portada
            $logoPath = public_path('images/CotecmarLogo.png');
            $logoBase64 = null;
            if (file_exists($logoPath)) {
                $logoData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
            }

            // Procesar el logo del header
            $headerLogoPath = public_path('images/CotecmarLogoPDF.png');
            $headerLogoBase64 = null;
            if (file_exists($headerLogoPath)) {
                $headerLogoData = file_get_contents($headerLogoPath);
                $headerLogoBase64 = 'data:image/png;base64,' . base64_encode($headerLogoData);
            }

            // Procesar la imagen de fondo de la portada
            $portadaPath = public_path('images/ImagenPortada.jpg');
            $portadaBase64 = null;
            if (file_exists($portadaPath)) {
                $portadaData = file_get_contents($portadaPath);
                $portadaBase64 = 'data:image/jpeg;base64,' . base64_encode($portadaData);
            }

            $sistemas = \App\Models\GresSistema::where('buque_id', $buqueId)
                ->with(['sistema' => function ($query) {
                    $query->select('id', 'codigo', 'nombre', 'grupo_constructivo_id')
                        ->with(['grupoConstructivo' => function ($query) {
                            $query->select('id', 'codigo', 'nombre');
                        }]);
                }])
                ->get()
                ->map(function ($gresSistema) {
                    // Convertir observaciones a array si es necesario
                    $observaciones = is_string($gresSistema->observaciones)
                        ? json_decode($gresSistema->observaciones, true)
                        : ($gresSistema->observaciones ?? []);

                    // Manejo simplificado de la imagen
                    $imagePath = null;
                    if ($gresSistema->diagrama) {
                        if (Storage::exists('public/' . $gresSistema->diagrama)) {
                            $imagePath = Storage::path('public/' . $gresSistema->diagrama);
                        } elseif (file_exists(public_path($gresSistema->diagrama))) {
                            $imagePath = public_path($gresSistema->diagrama);
                        }
                    }

                    // Convertir imagen a base64 si existe
                    $imageBase64 = null;
                    if ($imagePath && file_exists($imagePath)) {
                        $imageData = file_get_contents($imagePath);
                        $imageBase64 = 'data:image/png;base64,' . base64_encode($imageData);
                    }

                    // Agregamos 'grupo_nombre' para poder mostrarlo en la vista
                    return [
                        'nombre' => $gresSistema->sistema->nombre ?? 'Sin nombre',
                        'codigo' => $gresSistema->sistema->codigo ?? 'X',
                        'grupo_codigo' => $gresSistema->sistema->grupoConstructivo->codigo ?? 'X',
                        'grupo_nombre' => $gresSistema->sistema->grupoConstructivo->nombre ?? 'Sin Nombre',
                        'mec' => $gresSistema->mec ?? '',
                        'observaciones' => $observaciones,
                        'diagrama' => $imageBase64,
                        'ruta_escrita' => $gresSistema->diagrama ?? ''
                    ];
                });

            // Configurar opciones de PDF
            $config = [
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif',
                'dpi' => 96,
                'defaultPaperSize' => 'a4',
                'defaultPaperOrientation' => 'portrait',
                'isFontSubsettingEnabled' => true
            ];

            // Crear instancia de PDF con configuración, incluyendo ambos logos
            $pdf = PDF::loadView('pdf.gres-export',
                compact('colaboradores', 'titulo', 'sistemas', 'logoBase64', 'headerLogoBase64', 'portadaBase64', 'fechaGeneracion'))
                ->setOptions($config)
                ->setPaper('A4', 'portrait');

            // Generar el PDF y devolverlo con los headers correctos
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="anexo-gres.pdf"',
                'Cache-Control' => 'public, must-revalidate, max-age=0',
                'Pragma' => 'public',
                'X-Content-Type-Options' => 'nosniff'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error generando PDF:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Error generando el PDF',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function sistemas(Buque $buque)
    {
        // Cargar sistemas del buque y ordenarlos por código
        $buque->load([
            'sistemas' => function ($query) {
                $query->orderBy('codigo');
            },
            'misiones'
        ]);

        // Obtener datos adicionales de `gres_sistema`
        foreach ($buque->sistemas as $sistema) {
            $gresRecord = \App\Models\GresSistema::where('buque_id', $buque->id)
                ->where('sistema_id', $sistema->id)
                ->first();

            if ($gresRecord) {
                $sistema->mec = $gresRecord->mec;
                $sistema->diagrama = $gresRecord->diagrama;
                $sistema->observaciones = $gresRecord->observaciones;
            }
        }

        // Guardar la colección de sistemas en una variable
        $sistemas = $buque->sistemas;

        // Obtener misiones y datos del puerto base
        $misiones = $this->obtenerMisiones($buque->id);
        $datosPuertoBase = $this->obtenerDatosPuertoBase($buque->id);

        // Retornar la vista con la información completa
        return view('sistemas-buque', compact('buque', 'sistemas', 'misiones', 'datosPuertoBase'));
    }

    public function clearObservations($systemId)
    {
        try {
            // Eliminar todas las observaciones del sistema
            $system = \App\Models\GresSistema::where('sistema_id', $systemId)->first();

            if ($system) {
                $system->observaciones = []; // Reiniciar observaciones
                $system->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Observaciones eliminadas correctamente.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar observaciones:', [
                'systemId' => $systemId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar las observaciones.',
            ], 500);
        }
    }

    // Método para obtener el MEC de la tabla `buque_sistemas`
    private function obtenerMEC($buqueId)
    {
        return DB::table('gres_sistema')
            ->where('buque_id', $buqueId)
            ->value('mec');
    }

    public function accederLSA(Request $request)
    {
        $buqueId = $request->route('id');
        $mec = $this->obtenerMEC($buqueId);

        return redirect('http://localhost:5000/LSA?buqueId=' . $buqueId . '&mec=' . $mec);
    }

    public function LSA(Buque $buque)
    {
        // Cargar sistemas del buque y ordenarlos por código
        $buque->load([
            'sistemas' => function ($query) {
                $query->orderBy('codigo');
            },
            'misiones'
        ]);

        // Obtener datos adicionales de `gres_sistema`
        foreach ($buque->sistemas as $sistema) {
            $gresRecord = \App\Models\GresSistema::where('buque_id', $buque->id)
                ->where('sistema_id', $sistema->id)
                ->first();

            if ($gresRecord) {
                $sistema->mec = $gresRecord->mec;
                $sistema->diagrama = $gresRecord->diagrama;
                $sistema->observaciones = $gresRecord->observaciones;
            }
        }

        // Guardar la colección de sistemas en una variable
        $sistemasBuques = $buque->sistemas;

        // Obtener misiones y datos del puerto base
        $misiones = $this->obtenerMisiones($buque->id);
        $datosPuertoBase = $this->obtenerDatosPuertoBase($buque->id);

        return view('buques.lsa', compact('buque', 'sistemasBuques', 'misiones', 'datosPuertoBase'));
    }

    private function obtenerMisiones($buqueId)
    {
        return DB::table('buque_misiones')
            ->join('misiones', 'buque_misiones.mision_id', '=', 'misiones.id')
            ->select(
                'buque_misiones.id',
                'misiones.nombre as mision', //
                'buque_misiones.porcentaje',
                'buque_misiones.descripcion'
            )
            ->where('buque_misiones.buque_id', $buqueId)
            ->get();
    }


    private function obtenerDatosPuertoBase($buqueId)
    {
        if (Schema::hasTable('buque_fua')) {
            return DB::table('buque_fua')
                ->select(
                    'disponibilidad_mantenimiento_1',
                    'mant_basico_1',
                    'roh_1',
                    'disponible_misiones_1'
                )
                ->where('buque_id', $buqueId)
                ->first();
        }

        return (object) [
            'disponibilidad_mantenimiento_1' => null,
            'mant_basico_1'                  => null,
            'roh_1'                          => null,
            'disponible_misiones_1'         => null,
        ];
    }

    public function saveCicloOperacional(Request $request, Buque $buque)
{
    // 1. Validar los datos que necesitas
    $validated = $request->validate([
        'disponibilidad_mantenimiento_1' => 'required|numeric',
        'mant_basico_1'                  => 'nullable|numeric',
        'roh_1'                          => 'required|numeric',
    ]);

    // 2. Calcular mant_basico_1 si es exactamente igual a disponibilidad_mantenimiento_1
    //    $mantBasico1 = $validated['disponibilidad_mantenimiento_1'];
    //    Caso contrario, tomas lo que venga en mant_basico_1:
    $mantBasico1 = $validated['mant_basico_1'] ?? 0;

    // 3. Obtener las horas de navegación del buque
    $horasNavegacion = $buque->horas_navegacion_anio;

    // 4. Calcular "disponible_misiones_1"
    //    8760 - (mant_basico_1 + roh_1 + horasNavegacion)
    $disponibleMisiones1 = 8760 - (
        $mantBasico1
        + $validated['roh_1']
        + $horasNavegacion
    );

    // 5. Insertar o actualizar en la tabla buque_fua:
    DB::table('buque_fua')->updateOrInsert(
        ['buque_id' => $buque->id],
        [
            'disponibilidad_mantenimiento_1' => $validated['disponibilidad_mantenimiento_1'],
            'mant_basico_1'                  => $mantBasico1,
            'roh_1'                          => $validated['roh_1'],
            'disponible_misiones_1'         => $disponibleMisiones1,
            'updated_at'                     => now(),
        ]
    );

    // 5.1. Notificar a Flask en localhost:5000
    $misionesSeleccionadas = $this->obtenerMisiones($buque->id)->toArray();
    $datosPuertoBase = (array) $this->obtenerDatosPuertoBase($buque->id);

    try {
        Http::post('http://host.docker.internal:5000/actualizar_buque', [
            'buque_id' => $buque->id,
            'nombre_buque' => $buque->nombre,
            'misiones' => $misionesSeleccionadas,
            'datos_puerto_base' => $datosPuertoBase,
        ]);
    } catch (\Exception $e) {
        Log::error('Error al enviar datos a Flask: ' . $e->getMessage());
    }

    // 6. redireccionar con mensaje
    return redirect()
        ->route('buques.edit', $buque->id)
        ->with('success', 'Datos de ciclo operacional (Año 1) guardados correctamente.');
    }

    public function modFua(Buque $buque)
    {
        return view('mod_fua', compact('buque'));
    }

    public function create()
    {
        $buque = new \stdClass(); // o new Buque si quieres instanciar el modelo
        $buque->id = null;
        $buque->nombre = '';
        $buque->tipo = '';
        $buque->descripcion = '';
        $buque->etapa = '';
        $buque->autonomia_horas = '';
        $buque->vida_diseno_anios = '';
        $buque->horas_navegacion_anio = '';
        $buque->sistemas = collect(); // vacío para que no haya sistemas seleccionados

        $misiones = Mision::all();
        $misionesSeleccionadas = collect(); // vacío
        $grupos = GrupoConstructivo::with('sistemas')->get();
        $datosPuertoBase = null; // no hay datos porque es nuevo

        return view('editar-buque', compact('buque', 'misiones', 'misionesSeleccionadas', 'grupos', 'datosPuertoBase'));
    }

    public function guardarMisionesYCiclo(Request $request, Buque $buque)
    {
        // Validar
        $request->validate([
            'disponibilidad_mantenimiento_1' => 'required|numeric',
            'mant_basico_1' => 'nullable|numeric',
            'roh_1' => 'required|numeric',
            'misiones' => 'nullable|array',
            'misiones.*.porcentaje' => 'nullable|numeric|min:0|max:100',
            'misiones.*.descripcion' => 'nullable|string|max:255',
            'misiones.*.velocidad' => 'nullable|string|max:255',
            'misiones.*.num_motores' => 'nullable|integer',
            'misiones.*.potencia' => 'nullable|integer|min:0|max:100',
        ]);
    
        // === 1. Guardar parámetros de ciclo operacional ===
        $mantBasico1 = $request->input('mant_basico_1', $request->input('disponibilidad_mantenimiento_1'));
        $horasNavegacion = $buque->horas_navegacion_anio;
        $disponibleMisiones1 = 8760 - ($mantBasico1 + $request->input('roh_1') + $horasNavegacion);
    
        DB::table('buque_fua')->updateOrInsert(
            ['buque_id' => $buque->id],
            [
                'disponibilidad_mantenimiento_1' => $request->input('disponibilidad_mantenimiento_1'),
                'mant_basico_1' => $mantBasico1,
                'roh_1' => $request->input('roh_1'),
                'disponible_misiones_1' => $disponibleMisiones1,
                'updated_at' => now(),
            ]
        );
    
        // === 2. Guardar misiones ===
        $buque->misiones()->detach();
    
        $misiones = $request->input('misiones', []);
    
        foreach ($misiones as $misionId => $data) {
            $buque->misiones()->attach($misionId, [
                'porcentaje' => $data['porcentaje'] ?? null,
                'descripcion' => $data['descripcion'] ?? null,
                'velocidad' => $data['velocidad'] ?? null,
                'num_motores' => $data['num_motores'] ?? null,
                'potencia' => $data['potencia'] ?? null,
            ]);
        }
    
        // === 3. Notificar a Flask
        try {
            Http::post('http://host.docker.internal:5000/actualizar_buque', [
                'buque_id' => $buque->id,
                'nombre_buque' => $buque->nombre,
                'misiones' => $this->obtenerMisiones($buque->id)->toArray(),
                'datos_puerto_base' => (array) $this->obtenerDatosPuertoBase($buque->id),
            ]);
        } catch (\Exception $e) {
            Log::error('Error al enviar datos a Flask: ' . $e->getMessage());
        }
    
        // === 4. Retorno condicional según el tipo de petición
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Misiones y ciclo operacional guardados correctamente.',
            ]);
        }
    
        return redirect()->route('buques.edit', $buque->id)
            ->with('success', 'Ciclo operacional y misiones guardados correctamente.');
    }
    



}
