<?php

namespace App\Http\Controllers;

use App\Models\Buque;
use App\Models\SistemasEquipos;
use App\Models\Colaborador;
use App\Models\Mision;
use App\Models\BuqueMision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


// Agregar el modelo SistemasBuque
use App\Models\SistemasBuque;

class BuquesController extends Controller
{
    public function index(Request $request)
    {
        $query = Buque::where('user_id', Auth::id());

        if ($request->has('search')) {
            $query->where('nombre_proyecto', 'LIKE', '%' . $request->input('search') . '%');
        }

        $buques = $query->paginate(8);
        $currentDate = Carbon::now()->format('d/m/y');

        return view('buques.index', compact('buques', 'currentDate'));
    }

    public function create()
    {
        // No necesitamos cargar sistemas y equipos aquí, ya que ahora los sistemas se crean en el formulario

        $misiones_activas = [];

        return view('buques.create', compact('misiones_activas'));
    }

    private function convertPercentageToDecimal($percentage)
    {
        $value = str_replace('%', '', $percentage);
        return floatval($value) / 100;
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'tipo_buque' => 'required|string|max:255',
            'descripcion_proyecto' => 'required|string|max:500',
            'autonomia_horas' => 'required|integer',
            'horas_navegacion_anual' => 'required|integer',
            'vida_diseno' => 'required|integer|min:1', // Validación del campo Vida de Diseño
            'image' => 'nullable|image|max:2048', // Validación de la imagen
            'roh_1' => 'nullable|integer|min:0', // ROH año 1
            'roh_3' => 'nullable|integer|min:0', // ROH año 3
            'roh_5' => 'nullable|integer|min:0', // ROH año 5
            'mant_basico_1' => 'nullable|integer|min:0', // Mantenimiento básico año 1
            'mant_intermedio_3' => 'nullable|integer|min:0', // Mantenimiento intermedio año 3
            'mant_basico_3' => 'nullable|integer', // Mantenimiento básico año 3
            'mant_mayor_5' => 'nullable|integer|min:0', // Mantenimiento mayor año 5
        ]);

        // Manejar la imagen del buque
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('buques', 'public'); // Guardar la imagen en el almacenamiento público
        }

        // Manejar los checkboxes padres (fuera de puerto y puerto base)
        $fueraDePuerto = filter_var($request->input('fuera_de_puerto'), FILTER_VALIDATE_BOOLEAN);
        $puertoBase = filter_var($request->input('puerto_base'), FILTER_VALIDATE_BOOLEAN);

        // Determinar el valor de 'misiones' para el modelo Buque
        $misiones = null;
        if ($fueraDePuerto) {
            $misiones = $request->input('misiones') ? json_encode(array_column($request->input('misiones'), 'nombre')) : null;
        } elseif ($puertoBase) {
            $misiones = json_encode(['Puerto Base']);
        } else {
            $misiones = json_encode([]);
        }

        // Crear el registro del buque
        $buque = Buque::create([
            'user_id' => Auth::id(),
            'nombre_proyecto' => $request->nombre_proyecto,
            'tipo_buque' => $request->tipo_buque,
            'descripcion_proyecto' => $request->descripcion_proyecto,
            'autonomia_horas' => $request->autonomia_horas,
            'horas_navegacion_anual' => $request->horas_navegacion_anual,
            'vida_diseno' => $request->vida_diseno, // Asignar Vida de Diseño al buque
            'image_path' => $imagePath, // Asignar la ruta de la imagen al buque
            'misiones' => $misiones, // Asignar las misiones determinadas
        ]);

        // Guardar colaboradores si se proporcionan
        if ($request->has('colaboradores')) {
            foreach ($request->colaboradores as $colaborador) {
                $buque->colaboradores()->create($colaborador); // Crear cada colaborador asociado al buque
            }
        }

        // Guardar los datos de FUA en la tabla `buque_fua`
        BuqueFua::create([
            'buque_id' => $buque->id, // Relacionar con el buque
            'roh_1' => $request->roh_1,
            'roh_3' => $request->roh_3,
            'roh_5' => $request->roh_5,
            'mant_basico_1' => $request->mant_basico_1,
            'mant_intermedio_3' => $request->mant_intermedio_3,
            'mant_mayor_5' => $request->mant_mayor_5,
        ]);

        // Guardar misiones en la tabla `buque_misions` si corresponde
        if ($request->has('misiones')) {
            foreach ($request->input('misiones') as $misionData) {
                $buque->buqueMisiones()->create([
                    'mision' => $misionData['nombre'],
                    'velocidad' => $misionData['velocidad'] ?? '',
                    'num_motores' => $misionData['motores'] ?? 0,
                    'potencia' => $misionData['potencia'] ?? 0,
                    'porcentaje' => $misionData['porcentaje'] ?? 0,
                    'descripcion' => $misionData['descripcion'] ?? '',
                ]);
            }
        }

        // Procesar y guardar sistemas del buque
        if ($request->has('sistemas_buque')) {
            $sistemasBuqueData = json_decode($request->input('sistemas_buque', '[]'), true) ?? [];
            foreach ($sistemasBuqueData as $grupo => $sistemasGrupo) {
                foreach ($sistemasGrupo as $sistemaData) {
                    $sistemaBuque = SistemasBuque::create([
                        'codigo' => $sistemaData['cj'],
                        'nombre' => $sistemaData['nombre'],
                        'descripcion' => $sistemaData['descripcion'] ?? '',
                        'buque_id' => $buque->id, // Relacionar con el buque
                    ]);
                    $buque->sistemasBuques()->attach($sistemaBuque->id); // Asociar el sistema al buque
                }
            }
        }

        // Procesar los sistemas y equipos existentes (si corresponde)
        if ($request->has('sistemas_equipos')) {
            $buque->sistemasEquipos()->sync($request->sistemas_equipos); // Sincronizar los sistemas existentes
        }

        // Redireccionar con mensaje de éxito
        return redirect()->route('buques.edit', $buque->id)->with('success', 'Buque creado exitosamente.');
    }


    public function edit(Buque $buque)
    {
        // Cargar las relaciones necesarias del buque
        $buque->load('colaboradores', 'sistemasEquipos', 'buqueMisiones', 'sistemasBuques');

        // Obtener los equipos seleccionados para el buque
        $equipos_seleccionados = $buque->sistemasEquipos->pluck('id')->toArray();

        // Decodificar las misiones del buque
        $misiones = json_decode($buque->misiones, true);

        // Inicializar las variables de misiones
        $fueraDePuerto = true;
        $puertoBase = false;
        $misiones_activas = [];

        if ($misiones) {
            if (in_array('Puerto Base', $misiones)) {
                $puertoBase = true;
            } else {
                $fueraDePuerto = true;
                $misiones_activas = $buque->buqueMisiones->unique('mision')->map(function ($mision) {
                    return [
                        'nombre' => $mision->mision,
                        'velocidad' => $mision->velocidad,
                        'motores' => $mision->num_motores,
                        'potencia' => $mision->potencia,
                        'porcentaje' => $mision->porcentaje,
                        'descripcion' => $mision->descripcion,
                    ];
                })->values()->toArray();
            }
        }

        // Inicializar $sistemasBuqueData con los grupos vacíos (100, 200, ..., 700)
        $sistemasBuqueData = collect(['100', '200', '300', '400', '500', '600', '700'])->mapWithKeys(function ($grupo) {
            return [$grupo => []];
        })->toArray();

        // Agrupar sistemas existentes por grupo
        foreach ($buque->sistemasBuques as $sistema) {
            $grupo = substr($sistema->codigo, 0, 1) . '00'; // Determinar el grupo con el primer dígito del código
            $sistemasBuqueData[$grupo][] = [
                'id' => $sistema->id,
                'cj' => $sistema->codigo,
                'nombre' => $sistema->nombre,
                'descripcion' => $sistema->descripcion,
            ];
        }

        // Devolver la vista con los datos necesarios
        return view('buques.edit', compact(
            'buque',
            'equipos_seleccionados',
            'misiones_activas',
            'fueraDePuerto',
            'puertoBase',
            'sistemasBuqueData' // Sistemas agrupados por grupo
        ));
    }


    public function update(Request $request, Buque $buque)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'tipo_buque' => 'required|string|max:255',
            'descripcion_proyecto' => 'required|string|max:500',
            'autonomia_horas' => 'required|integer',
            'horas_navegacion_anual' => 'required|integer',
            'vida_diseno' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'misiones.*.porcentaje' => 'numeric|min:0|max:100', // Validar el porcentaje
            'colaboradores' => 'array',
            'colaboradores.*.col_cargo' => 'required|string|max:255',
            'colaboradores.*.col_nombre' => 'required|string|max:255',
            'colaboradores.*.col_entidad' => 'required|string|max:255',
            'roh_1' => 'nullable|integer|min:0', // ROH Año 1
            'roh_3' => 'nullable|integer|min:0', // ROH Año 3
            'roh_5' => 'nullable|integer|min:0', // ROH Año 5
            'mant_basico_1' => 'nullable|integer|min:0', // Mantenimiento Básico Año 1
            'mant_intermedio_3' => 'nullable|integer|min:0', // Mantenimiento Intermedio Año 3
            'mant_basico_3' => 'nullable|integer|min:0', // Validación para la nueva columna
            'mant_mayor_5' => 'nullable|integer|min:0', // Mantenimiento Mayor Año 5
            //TABLAS FUA
            'vida_diseño' => 'nullable|integer',
            'horas_ano' => 'nullable|integer',
            'horas_mant_año' => 'nullable|integer',
            'horas_disp_año' => 'nullable|integer',
            'max_mis_año' => 'nullable|integer',
            'mis_plan_mant' => 'nullable|integer',
            'dias_op_año' => 'nullable|integer',
            'dias_mision' => 'nullable|integer',
            'dias_nav_mision' => 'nullable|integer',
            'horas_op_mision' => 'nullable|integer',
            'horas_op_año' => 'nullable|integer',
            'horas_nav_mision' => 'nullable|integer',
        ]);



        // Manejar la imagen del buque si se ha subido una nueva
        if ($request->file('image')) {
            if ($buque->image_path) {
                Storage::disk('public')->delete($buque->image_path); // Eliminar la imagen anterior
            }
            $buque->image_path = $request->file('image')->store('buques', 'public'); // Guardar la nueva imagen
        }

        // Manejar los checkboxes padres
        $fueraDePuerto = filter_var($request->input('fuera_de_puerto'), FILTER_VALIDATE_BOOLEAN);
        $puertoBase = filter_var($request->input('puerto_base'), FILTER_VALIDATE_BOOLEAN);

        // Determinar el valor de 'misiones'
        $misiones = null;
        if ($fueraDePuerto) {
            $misiones = $request->input('misiones') ? json_encode(array_column($request->input('misiones'), 'nombre')) : null;
        } elseif ($puertoBase) {
            $misiones = json_encode(['Puerto Base']);
        } else {
            $misiones = json_encode([]);
        }

        // Calcular Disponibilidad de Mantenimiento - 1er Año
        $mant_basico_1 = $request->mant_basico_1;
        $disponibilidad_mantenimiento_1 = $mant_basico_1;

        // Calcular Disponible para Misiones - 1er Año
        $roh_1 = $request->roh_1;
        $horas_navegacion_anual = $buque->horas_navegacion_anual;
        $disponible_misiones_1 = 8760 - ($disponibilidad_mantenimiento_1 + $roh_1 + $horas_navegacion_anual);

        // Calcular valores para el 3er año
        $mantIntermedio3 = $request->mant_intermedio_3 ?? 0;
        $mantBasico3 = $request->mant_basico_3 ?? 0;
        $roh3 = $request->roh_3 ?? 0;

        $horas_navegacion_anual = $buque->horas_navegacion_anual;
        $disponibilidadMantenimiento3 = $mantIntermedio3 + $mantBasico3;
        $disponibleMisiones3 = 8760 - ($disponibilidadMantenimiento3 + $roh3 + $horas_navegacion_anual);


        // Calcular valores del 5to Año
        $mant_mayor_5 = $request->mant_mayor_5 ?? 0;
        $roh_5 = $request->roh_5 ?? 0;

        $disponibilidad_mantenimiento_5 = $mant_mayor_5;
        $disponible_misiones_5 = 8760 - ($disponibilidad_mantenimiento_5 + $roh_5 + $horas_navegacion_anual);

        // Establecer $fueraDePuerto en true directamente
        $fueraDePuerto = true;

        // Ya que no estamos utilizando $puertoBase, podemos ignorarlo
        $puertoBase = false;

        // Determinar el valor de 'misiones' para el buque
        $misiones = null;
        if ($fueraDePuerto) {
            $misiones = $request->input('misiones') ? json_encode(array_column($request->input('misiones'), 'nombre')) : null;
        } else {
            $misiones = json_encode([]);
        }


        // Actualizar los datos del buque
        $buque->update([
            'nombre_proyecto' => $request->nombre_proyecto,
            'tipo_buque' => $request->tipo_buque,
            'descripcion_proyecto' => $request->descripcion_proyecto,
            'autonomia_horas' => $request->autonomia_horas,
            'horas_navegacion_anual' => $request->horas_navegacion_anual,
            'vida_diseno' => $request->vida_diseno,
            'image_path' => $buque->image_path,
            'misiones' => $misiones, // Guardar las misiones calculadas
        ]);

        // Actualizar o crear datos en la tabla `buque_fua`
        $buque->fua()->updateOrCreate(
            ['buque_id' => $buque->id],
            [
                'roh_1' => $roh_1,
                'roh_3' => $request->roh_3,
                'roh_5' => $request->roh_5,
                'mant_basico_1' => $mant_basico_1,
                'mant_intermedio_3' => $request->mant_intermedio_3,
                'mant_basico_3' => $request->mant_basico_3, // Confirmar que esté aquí
                'mant_mayor_5' => $request->mant_mayor_5,
                'disponibilidad_mantenimiento_1' => $disponibilidad_mantenimiento_1,
                'disponible_misiones_1' => $disponible_misiones_1,
                'disponibilidad_mantenimiento_3' => $disponibilidadMantenimiento3,
                'disponible_misiones_3' => $disponibleMisiones3,
                'disponibilidad_mantenimiento_5' => $disponibilidad_mantenimiento_5,
                'disponible_misiones_5' => $disponible_misiones_5,
            ]
        );


        // Calcular valores para la tabla `tablas_fua`
        $vida_diseño = $buque->vida_diseno; // De la tabla `buques`
        $horas_ano = 8760; // Constante
        $horas_mant_año = $buque->fua->disponibilidad_mantenimiento_1 ?? 0; // Tomado de `buque_fua`

        // Calcular valores necesarios
                $disponible_misiones_1 = $buque->fua->disponible_misiones_1 ?? 0; // De la tabla `buque_fua`
                $horas_navegacion_anual = $buque->horas_navegacion_anual; // De la tabla `buques`

        // Calcular horas disponibles al año
                $horas_disp_año = $disponible_misiones_1 + $horas_navegacion_anual;


        $horas_navegacion_anual = $buque->horas_navegacion_anual; // Horas de navegación al año
        $disponible_misiones_1 = $buque->fua->disponible_misiones_1 ?? 0; // Disponible para misiones del primer año
        $autonomia_horas = $buque->autonomia_horas; // Autonomía en horas

        // Evitar divisiones por cero
        if ($autonomia_horas > 0) {
            // Calcular máxima misiones por año
            $max_mis_año = ($horas_navegacion_anual + $disponible_misiones_1) / $autonomia_horas;
        } else {
            $max_mis_año = 0; // Asignar 0 si autonomía es inválida
        }

        // Calcular valores necesarios
        $horas_navegacion_anual = $buque->horas_navegacion_anual; // Horas de navegación al año
        $autonomia_horas = $buque->autonomia_horas; // Autonomía en horas

        // Evitar divisiones por cero
        if ($autonomia_horas > 0) {
            // Calcular misiones acuerdo plan de uso y mantenimiento
            $mis_plan_mant = $horas_navegacion_anual / $autonomia_horas;
        } else {
            $mis_plan_mant = 0; // Asignar 0 si autonomía es inválida
        }

        // Calcular valores necesarios
        $horas_navegacion_anual = $buque->horas_navegacion_anual; // Horas de navegación al año

        // Calcular días de operación por año
        $dias_op_año = $horas_navegacion_anual / 24;

        // Calcular valores necesarios
        $autonomia_horas = $buque->autonomia_horas; // Autonomía en horas

        // Calcular días por misión
        $dias_mision = $autonomia_horas / 24;

        // Calcular valores necesarios
        $dias_mision = $autonomia_horas / 24; // Días por Misión calculado previamente

        // Calcular días de navegación por misión
        $dias_nav_mision = $dias_mision - 1;

        // Obtener autonomía en horas
        $horas_op_mision = $buque->autonomia_horas; // Directamente de la tabla `buques`

        // Obtener horas de navegación al año
        $horas_op_año = $buque->horas_navegacion_anual; // Directamente de la tabla `buques`

        // Obtener autonomía en horas
        $autonomia_horas = $buque->autonomia_horas; // Directamente de la tabla `buques`

        // Calcular horas de navegación por misión
        $horas_nav_mision = $autonomia_horas - 24;


        // Actualizar o crear datos en la tabla `tablas_fua`
        $buque->tablaFua()->updateOrCreate(
            ['buque_id' => $buque->id],
            [
                'vida_diseño' => $vida_diseño,
                'horas_ano' => $horas_ano,
                'horas_mant_año' => $horas_mant_año,
                'horas_disp_año' => $horas_disp_año, // Guardar el valor calculado
                'max_mis_año' => $max_mis_año, // Guardar el valor calculado
                'mis_plan_mant' => $mis_plan_mant, // Guardar el valor calculado
                'dias_op_año' => $dias_op_año, // Guardar el valor calculado
                'dias_mision' => $dias_mision, // Guardar el valor calculado
                'dias_nav_mision' => $dias_nav_mision, // Guardar el valor calculado
                'horas_op_mision' => $horas_op_mision, // Guardar el valor directo
                'horas_op_año'=> $horas_op_año,
                'horas_nav_mision' => $horas_nav_mision, // Guardar el valor calculado
            ]
        );


        // Actualizar los sistemas y equipos (si es necesario)
        $buque->sistemasEquipos()->sync($request->input('sistemas_equipos', []));

        // Actualizar los colaboradores
        $buque->colaboradores()->delete(); // Eliminar los colaboradores actuales
        foreach ($request->input('colaboradores', []) as $colaborador) {
            $buque->colaboradores()->create($colaborador); // Crear colaboradores nuevos
        }

        $misiones = $request->input('misiones');
        if (!is_array($misiones)) {
            $misiones = [];
        }

        $buque->buqueMisiones()->delete(); // Limpiar misiones actuales

// Guardar nuevas misiones
        if ($request->has('misiones')) {
            foreach ($request->input('misiones') as $misionData) {
                $buque->buqueMisiones()->create([
                    'mision' => $misionData['nombre'],
                    'velocidad' => $misionData['velocidad'] ?? '',
                    'num_motores' => $misionData['motores'] ?? 0,
                    'potencia' => $misionData['potencia'] ?? 0,
                    'porcentaje' => $misionData['porcentaje'] ?? 0, // Guardar porcentaje
                    'descripcion' => $misionData['descripcion'] ?? '',
                ]);
            }
        }

        // Procesar los sistemas del buque
        $jsonString = $request->input('sistemas_buque', '[]'); // Obtener datos de sistemas
        $sistemasBuqueData = json_decode($jsonString, true);
        if (!is_array($sistemasBuqueData)) {
            $sistemasBuqueData = [];
        }

        $processedSystemIds = []; // IDs de los sistemas procesados
        if (!empty($sistemasBuqueData)) {
            foreach ($sistemasBuqueData as $grupo => $sistemasGrupo) {
                if (is_array($sistemasGrupo)) {
                    foreach ($sistemasGrupo as $sistemaData) {
                        if (isset($sistemaData['id'])) {
                            // Actualizar sistema existente
                            $sistemaBuque = SistemasBuque::find($sistemaData['id']);
                            if ($sistemaBuque) {
                                $sistemaBuque->update([
                                    'codigo' => $sistemaData['cj'],
                                    'nombre' => $sistemaData['nombre'],
                                    'descripcion' => $sistemaData['descripcion'],
                                ]);
                                $processedSystemIds[] = $sistemaBuque->id;
                            }
                        } else {
                            // Crear nuevo sistema
                            $nuevoSistema = SistemasBuque::create([
                                'codigo' => $sistemaData['cj'],
                                'nombre' => $sistemaData['nombre'],
                                'descripcion' => $sistemaData['descripcion'] ?? '',
                                'buque_id' => $buque->id,
                            ]);
                            $processedSystemIds[] = $nuevoSistema->id;
                        }
                    }
                }
            }
        }

        // Eliminar sistemas que ya no están asociados
        $existingSystemIds = $buque->sistemasBuques()->pluck('sistemas_buque_id')->toArray();
        $idsToDelete = array_diff($existingSystemIds, $processedSystemIds);
        if (!empty($idsToDelete)) {
            $buque->sistemasBuques()->detach($idsToDelete); // Eliminar de la tabla pivote
            SistemasBuque::whereIn('id', $idsToDelete)->delete(); // Eliminar sistemas de la tabla principal
        }

        // Redireccionar con mensaje de éxito
        return redirect()->route('buques.edit', $buque->id)->with('success', 'Buque actualizado exitosamente.');
    }


    public function destroy(Buque $buque)
    {
        if ($buque->user_id !== Auth::id()) {
            return redirect()->route('buques.index')->with('error', 'No tienes permiso para eliminar este buque.');
        }

        if ($buque->image_path) {
            Storage::disk('public')->delete($buque->image_path);
        }

        $buque->delete();

        return redirect()->route('buques.index')->with('success', 'Buque eliminado exitosamente.');
    }

    public function getSistemasEquipos(Buque $buque)
    {
        $sistemasEquipos = $buque->sistemasEquipos;
        return response()->json($sistemasEquipos);
    }

    public function show(Buque $buque)
    {
        return view('buques.show', compact('buque'));
    }

    public function showGres(Buque $buque)
    {
        $sistemasBuques = $buque->sistemasBuques()->withPivot('mec', 'image', 'titulo', 'observaciones', 'mision')->get();

        foreach ($sistemasBuques as &$sistema) {
            if ($sistema->pivot->image) {
                $sistema->pivot->imageUrl = Storage::disk('public')->url($sistema->pivot->image);
            } else {
                $sistema->pivot->imageUrl = asset('storage/images/ImageNullGres.png');
            }
        }

        return view('buques.gres', compact('buque', 'sistemasBuques'));
    }

    public function showGresSistema(Buque $buque)
    {
        $sistemas = $buque->sistemas()->withPivot('mec', 'image', 'observaciones', 'misiones')->get();

        return view('buques.mod_gres_sistema', compact('buque', 'sistemas'));
    }

    public function showFua($id)
    {
        $buque = Buque::findOrFail($id);
        $misiones = $buque->buqueMisiones;
        $sistemasEquipos = $buque->sistemasEquipos()
            ->withPivot('mec', 'image', 'titulo', 'diagrama_id', 'observaciones')
            ->orderBy('mfun')
            ->get();

        return view('buques.fua', compact('buque', 'misiones', 'sistemasEquipos'));
    }

    public function updateMec(Request $request, Buque $buque, $sistemaBuqueId)
    {
        $mec = $request->input('mec');
        $image = $request->input('image');

        $image = basename($image);

        $buque->sistemasBuques()->updateExistingPivot($sistemaBuqueId, [
            'mec' => $mec,
            'image' => $image,
        ]);

        return response()->json(['message' => 'MEC actualizado correctamente']);
    }

    public function updateMecSistema(Request $request, Buque $buque, $sistemaId)
    {
        $mec = $request->input('mec');
        $image = $request->input('image');
        $image = basename($image); // Asegúrate de que solo se guarde el nombre del archivo

        $buque->sistemas()->updateExistingPivot($sistemaId, [
            'mec' => $mec,
            'image' => $image,
        ]);

        return response()->json(['message' => 'MEC de sistema actualizado correctamente']);
    }

    public function updateEquipoTitulo(Request $request, Buque $buque, $sistemaBuqueId)
    {
        $request->validate(['titulo' => 'required|string|max:255']);

        $buque->sistemasBuques()->updateExistingPivot($sistemaBuqueId, ['titulo' => $request->input('titulo')]);

        return response()->json(['message' => 'Título actualizado correctamente']);
    }

    public function storeSistemaEquipo(Request $request, $buqueId)
    {
        $request->validate([
            'mfun' => 'required|unique:sistemas_equipos,mfun|regex:/^[0-9]{4}[0-9A-Za-z]$/',
            'titulo' => 'required|string|max:255',
        ]);

        $buque = Buque::findOrFail($buqueId);

        $equipo = SistemasEquipos::firstOrCreate(
            ['mfun' => $request->mfun],
            ['titulo' => $request->titulo]
        );

        if (!$buque->sistemasEquipos->contains($equipo->id)) {
            $buque->sistemasEquipos()->attach($equipo->id, ['mec' => null]);
        }

        return response()->json(['message' => 'Equipo agregado correctamente', 'equipo' => $equipo]);
    }

    public function saveObservations(Request $request, Buque $buque, $sistemaBuqueId)
    {
        $observaciones = $request->input('observaciones');

        $buque->sistemasBuques()->updateExistingPivot($sistemaBuqueId, [
            'observaciones' => json_encode($observaciones),
        ]);

        return response()->json(['success' => true, 'observaciones' => $observaciones]);
    }

    public function exportPdf($buqueId)
    {
        try {
            // Encontrar el buque
            $buque = Buque::findOrFail($buqueId);

            // Obtener los sistemasBuques con datos adicionales
            $sistemasBuques = $buque->sistemasBuques()
                ->withPivot('mec', 'image', 'titulo', 'observaciones')
                ->get();

            // Procesar las observaciones y filtrar sistemas con MEC asignado
            $sistemasBuques = $sistemasBuques->filter(function ($sistema) {
                return !empty($sistema->pivot->mec);
            })->map(function ($sistema) {
                // Convertir observaciones de JSON a array si existen
                if (!empty($sistema->pivot->observaciones)) {
                    $sistema->pivot->observaciones = json_decode($sistema->pivot->observaciones, true) ?? [];
                } else {
                    $sistema->pivot->observaciones = [];
                }

                return $sistema;
            });

            // Generar el PDF
            $pdf = Pdf::loadView('buques.pdf', compact('buque', 'sistemasBuques'))
                ->setPaper('letter', 'portrait');

            // Devolver el PDF como stream
            return $pdf->stream('GRES_' . $buque->nombre_proyecto . '.pdf');
        } catch (\Exception $e) {
            // Loguear el error exacto y devolver el mensaje al usuario
            Log::error('Error al generar PDF: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo generar el PDF. Error: ' . $e->getMessage()], 500);
        }
    }


    public function showPdf($buqueId)
    {
        $buque = Buque::findOrFail($buqueId);
        return view('buques.view-pdf', compact('buque'));
    }

    public function showGres2($buque)
    {
        return view('buques.gres2', compact('buque'));
    }

    public function deleteCollaborator($id)
    {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->delete();

        return response()->json(['message' => 'Colaborador eliminado correctamente']);
    }

    // Método para obtener el MEC de la tabla `buque_sistema`
    private function obtenerMEC($buqueId)
    {
        // Consultamos la tabla `buque_sistema` para obtener el MEC del buque
        $mec = DB::table('buque_sistemas_buque')
            ->where('buque_id', $buqueId)
            ->value('mec');  // Retornamos el MEC correspondiente

        return $mec;
    }
    
    public function accederLSA(Request $request) {
        // Obtener el ID del buque desde la ruta o solicitud
        $buqueId = $request->route('id');
        
        // Obtener el MEC del buque
        $mec = $this->obtenerMEC($buqueId);
        
        // Datos para la URL (sin necesidad de enviar un token)
        $url = 'http://localhost:5000/LSA?buqueId=' . $buqueId . '&mec=' . $mec;
        
        // Redirigir a LSA con los parámetros del buque
        return redirect($url);
    }
    
    public function LSA(Buque $buque)
    {
        // Obtener los sistemas del buque desde la relación sistemasBuques
        $sistemasBuques = $buque->sistemasBuques()->withPivot('mec', 'image', 'observaciones', 'mision')->get();
    
        // Obtener las misiones del buque
        $misiones = $this->obtenerMisiones($buque->id);

        $datosPuertoBase = $this->obtenerDatosPuertoBase($buque->id);
    
        // Retornar la vista con los datos necesarios
        return view('buques.lsa', compact('buque', 'sistemasBuques', 'misiones', 'datosPuertoBase'));
    }
    

    private function obtenerMisiones($buqueId)
    {
        // Consultamos la tabla `buque_misiones` para obtener las misiones del buque
        return DB::table('buque_misiones')
            ->select('id', 'mision', 'porcentaje')
            ->where('buque_id', $buqueId)
            ->get();
    }
    
    
    private function obtenerDatosPuertoBase($buqueId)
    {
        // Consultamos la tabla `buque_misiones` para obtener las misiones del buque
        return DB::table('buque_fua')
            ->select('roh_1', 'mant_basico_1', 'disponible_misiones_1')
            ->where('buque_id', $buqueId)
            ->get();
    }

}
