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
use App\Models\GresEquipo;
use App\Models\EquipoSuite;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class BuqueController extends Controller
{
    public function index()
    {
        $buques = Buque::all();
        return view('gestion-buques', compact('buques'));
    }


    // Helpers privados en tu controlador (por ej. BuqueController)
    private function vf($arr, string $key)
    {
        return data_get($arr, "$key.valor_final", data_get($arr, "$key.valor"));
    }

    private function construirTecnicoParaPayload(Buque $b): array
    {
        $fmt = fn($v) => $v === '' ? null : $v;

        return [
            'ESLORA'                        => $fmt($b->eslora),
            'MANGA'                         => $fmt($b->manga),
            'PUNTAL'                        => $fmt($b->puntal),
            'Calado en Metros'              => $fmt($b->calado_metros),
            'Altura Mastil'                 => $fmt($b->altura_mastil),
            'Altura Maxima del Buque'       => $fmt($b->altura_maxima_buque),
            'Tipo de Material Construccion' => $fmt($b->tipo_material_construccion),
            'Sigla Internacional Unidad'    => $fmt($b->sigla_internacional_unidad),
            'Plano Numero'                  => $fmt($b->plano_numero),
            'Autonomia Millas Nauticas'     => $fmt($b->autonomia_millas_nauticas),

            // Desplazamientos
            'Desp Cond 1 Peso en Rosca'         => $fmt($b->desp_cond_1_peso_rosca),
            'Desp Cond 2 10% de Consumibles'    => $fmt($b->desp_cond_2_10_consumibles),
            'Desp Cond 3 Minima Operacional'    => $fmt($b->desp_cond_3_minima_operacional),
            'Desp Cond 4 50% de Consumibles'    => $fmt($b->desp_cond_4_50_consumibles),
            'Desp Cond 5 Optima Operacional'    => $fmt($b->desp_cond_5_optima_operacional),
            'Desp Cond 6 Zarpe Plena Carga'     => $fmt($b->desp_cond_6_zarpe_plena_carga),
        ];
    }


    private function mapearTecnicoDesdeRequest(Request $request): array
    {
        $t = $request->input('datos_sap_tecnico', []);

        $tecnicoDict = [
            'ESLORA'                        => $this->vf($t,'eslora'),
            'MANGA'                         => $this->vf($t,'manga'),
            'PUNTAL'                        => $this->vf($t,'puntal'),
            'Calado en Metros'              => $this->vf($t,'calado_metros'),
            'Altura Mastil'                 => $this->vf($t,'altura_mastil'),
            'Altura Maxima del Buque'       => $this->vf($t,'altura_maxima_buque'),
            'Tipo de Material Construccion' => $this->vf($t,'tipo_material_construccion'),
            'Sigla Internacional Unidad'    => $this->vf($t,'sigla_internacional_unidad'),
            'Plano Numero'                  => $this->vf($t,'plano_numero'),
            'Autonomia Millas Nauticas'     => $this->vf($t,'autonomia_millas_nauticas'),
            'Desp Cond 1 Peso en Rosca'         => $this->vf($t,'desp_cond_1_peso_rosca'),
            'Desp Cond 2 10% de Consumibles'    => $this->vf($t,'desp_cond_2_10_consumibles'),
            'Desp Cond 3 Minima Operacional'    => $this->vf($t,'desp_cond_3_minima_operacional'),
            'Desp Cond 4 50% de Consumibles'    => $this->vf($t,'desp_cond_4_50_consumibles'),
            'Desp Cond 5 Optima Operacional'    => $this->vf($t,'desp_cond_5_optima_operacional'),
            'Desp Cond 6 Zarpe Plena Carga'     => $this->vf($t,'desp_cond_6_zarpe_plena_carga'),
        ];

        $parseNum = fn($v) => (is_string($v) && ($v==='PENDIENTE' || $v==='N/A' || $v==='')) ? null : $v;

        // SOLO los campos técnicos de columnas;
        // NO incluir peso_buque / unidad_peso / tamano_dimension_buque aquí para no pisar los del form principal
        $scalar = [
            'eslora' => $parseNum($tecnicoDict['ESLORA']),
            'manga'  => $parseNum($tecnicoDict['MANGA']),
            'puntal' => $parseNum($tecnicoDict['PUNTAL']),
            'calado_metros' => $parseNum($tecnicoDict['Calado en Metros']),
            'altura_mastil' => $parseNum($tecnicoDict['Altura Mastil']),
            'altura_maxima_buque' => $parseNum($tecnicoDict['Altura Maxima del Buque']),
            'tipo_material_construccion' => $tecnicoDict['Tipo de Material Construccion'] ?: null,
            'sigla_internacional_unidad' => $tecnicoDict['Sigla Internacional Unidad'] ?: null,
            'plano_numero' => $tecnicoDict['Plano Numero'] ?: null,
            'autonomia_millas_nauticas' => $parseNum($tecnicoDict['Autonomia Millas Nauticas']),
            'desp_cond_1_peso_rosca' => $parseNum($tecnicoDict['Desp Cond 1 Peso en Rosca']),
            'desp_cond_2_10_consumibles' => $parseNum($tecnicoDict['Desp Cond 2 10% de Consumibles']),
            'desp_cond_3_minima_operacional' => $parseNum($tecnicoDict['Desp Cond 3 Minima Operacional']),
            'desp_cond_4_50_consumibles' => $parseNum($tecnicoDict['Desp Cond 4 50% de Consumibles']),
            'desp_cond_5_optima_operacional' => $parseNum($tecnicoDict['Desp Cond 5 Optima Operacional']),
            'desp_cond_6_zarpe_plena_carga' => $parseNum($tecnicoDict['Desp Cond 6 Zarpe Plena Carga']),
        ];

        // Si (y solo si) vinieran por error en el bloque técnico, los tomamos,
        // pero SIN pisar los del form principal (veremos el merge en store/update)
        foreach (['peso_buque','unidad_peso','tamano_dimension_buque'] as $k) {
            if (array_key_exists($k, $t)) {
                $scalar[$k] = $k === 'unidad_peso'
                    ? ($this->vf($t,$k) ?: null)
                    : $parseNum($this->vf($t,$k));
            }
        }

        return [$tecnicoDict, $scalar];
    }


    private function mapearDiccionarioPlano(array $pairs, array $labels): array
    {
        $out = [];
        foreach ($labels as $key => $label) {
            $val = data_get($pairs, "$key.valor_final", data_get($pairs, "$key.valor"));
            $out[$label] = $val;
        }
        return $out;
    }

// Marca como "PENDIENTE" los valores vacíos (null o string vacío). "0" no se toca.
private function marcarPendienteValoresVacios(array $dict): array
{
    foreach ($dict as $k => $v) {
        if (is_array($v)) {
            $dict[$k] = $this->marcarPendienteValoresVacios($v);
        } else {
            if ($v === null || (is_string($v) && trim($v) === '')) {
                $dict[$k] = 'PENDIENTE';
            }
        }
    }
    return $dict;
}


public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
        'numero_casco_cotecmar' => 'nullable|string|max:255',
        'numero_casco_armada' => 'nullable|string|max:255',
        'descripcion' => 'nullable|string',
        'etapa' => 'required|string',

        'autonomia_horas' => 'required|integer|min:1',
        'autonomia_millas_nauticas' => 'nullable|numeric|min:0',
        'vida_diseno_anios' => 'required|integer|min:1',
        'horas_navegacion_anio' => 'required|integer|min:1',
        'imagen' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',

        // 3 nuevos
        'peso_buque' => 'nullable|numeric|min:0',
        'unidad_peso' => 'nullable|string|max:20',
        'tamano_dimension_buque' => 'nullable|string|max:100',
    ]);

    if ($request->hasFile('imagen')) {
        $validated['imagen'] = $request->file('imagen')->store('public/buques');
    }

    // === TÉCNICO -> columnas + diccionario para JSON SAP
    [$tecnicoDict, $scalarTecnico] = $this->mapearTecnicoDesdeRequest($request);
    $validated = array_merge($scalarTecnico, $validated);

    // === LOG/HIST -> JSON
    $logLabels = [
        'cap_agua_gal'=>'Capacidad de Agua (gal)',
        'cap_mdo_gal'=>'Capacidad de M.D.O (gal)',
        'cap_gasolina_gal'=>'Capacidad de Gasolina (gal)',
        'cap_kerosene_gal'=>'Capacidad de Kerosene (gal)',
        'cap_jet_a1_gal'=>'Capacidad de JET-A1 (gal)',
        'cap_lubricante_gal'=>'Capacidad Lubricante (gal)',
        'cap_viveres_congelados_kg'=>'Cap. Víveres Congelados (kg)',
        'cap_viveres_secos_kg'=>'Cap. Víveres Secos (kg)',
        'cap_viveres_conserva_kg'=>'Cap. Víveres Conserva (kg)',
        'cap_produccion_agua'=>'Capacidad Producción de Agua',
        'consumo_kw_h_navegando'=>'Consumo kW·h (Navegando)',
        'consumo_kw_h_muelle'=>'Consumo kW·h (Muelle)',
        'consumo_comb_hora_vel_economica'=>'Consumo Comb/h a Vel. Económica',
        'consumo_comb_hora_vel_maxima'=>'Consumo Comb/h a Vel. Máxima',
        'consumo_comb_milla_vel_economica'=>'Consumo Comb/milla a Vel. Económica',
        'consumo_comb_milla_vel_maxima'=>'Consumo Comb/milla a Vel. Máxima',
        'tipo_grua_bordo'=>'Tipo de Grúa a bordo',
        'cap_grua_ext_100_ton'=>'Cap. Grúa extendida 100% (ton)',
        'cap_grua_ext_0_ton'=>'Cap. Grúa extendida 0% (ton)',
    ];
    $histLabels = [
        'numero_resolucion_alta'=>'Número de Resolución de Alta',
        'fecha_resolucion_alta'=>'Fecha Resolución Alta',
        'fecha_resolucion_baja'=>'Fecha Resolución Baja',
        'fecha_resolucion_traslado'=>'Fecha Resolución Traslado',
        'fecha_estimada_reemplazo'=>'Fecha Estimada de Reemplazo',
        'ultima_bajada_dique'=>'Última Bajada de Dique',
        'ultima_subida_dique'=>'Última Subida de Dique',
        'proxima_subida_dique'=>'Próxima Subida a Dique',
        'ciclo_vida_estimado_anios'=>'Ciclo de Vida Estimado (años)',
        'valor_adquisicion'=>'Valor de Adquisición',
        'fuerza'=>'Fuerza',
        'brigada_flotilla_comando'=>'Brigada / Flotilla / Comando',
    ];

    $logisticoDict = $this->mapearDiccionarioPlano($request->input('datos_sap_logistico', []), $logLabels);
    $historicoDict = $this->mapearDiccionarioPlano($request->input('datos_sap_historico', []), $histLabels);

    // 👇 Poner "PENDIENTE" a vacíos en las 3 secciones SAP
    $tecnicoPend   = $this->marcarPendienteValoresVacios($tecnicoDict);
    $logisticoPend = $this->marcarPendienteValoresVacios($logisticoDict);
    $historicoPend = $this->marcarPendienteValoresVacios($historicoDict);

    // Guardar JSON SAP (incluye técnico)
    $validated['datos_sap'] = [
        'tecnico'   => $tecnicoPend,
        'logistico' => $logisticoPend,
        'historico' => $historicoPend,
    ];

    $buque = Buque::create($validated);

    // === Payload a Flask: usa los dicts con "PENDIENTE" ===
    $datosSapPayload = [
        'tecnico'   => $tecnicoPend,
        'logistico' => $logisticoPend,
        'historico' => $historicoPend,
    ];

    $this->notificarActualizacionABackendFlask($buque, [
        'nombre_buque' => $buque->nombre,
        'numero_casco' => $buque->numero_casco_armada,
        'info_general' => [
            'peso_buque'             => $buque->peso_buque,
            'unidad_peso'            => $buque->unidad_peso,
            'tamano_dimension_buque' => $buque->tamano_dimension_buque,
        ],
        'datos_sap' => $datosSapPayload,
    ]);

    return redirect()->route('buques.edit', $buque->id)
        ->with('success', 'Buque creado exitosamente.');
}



public function update(Request $request, Buque $buque)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
        'numero_casco_cotecmar' => 'nullable|string|max:255',
        'numero_casco_armada' => 'nullable|string|max:255',
        'descripcion' => 'nullable|string',
        'etapa' => 'required|string',

        'autonomia_horas' => 'required|integer|min:1',
        'autonomia_millas_nauticas' => 'nullable|numeric|min:0',
        'vida_diseno_anios' => 'required|integer|min:1',
        'horas_navegacion_anio' => 'required|integer|min:1',
        'imagen' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',

        'peso_buque' => 'nullable|numeric|min:0',
        'unidad_peso' => 'nullable|string|max:20',
        'tamano_dimension_buque' => 'nullable|string|max:100',
    ]);


    logger()->debug('UPDATE: request->hasFile("imagen")', [
        'hasFile' => $request->hasFile('imagen'),
    ]);

    if ($request->hasFile('imagen')) {
        $file = $request->file('imagen');

        logger()->debug('UPDATE: detalles del archivo entrante', [
            'isValid'    => $file->isValid(),
            'original'   => $file->getClientOriginalName(),
            'mime'       => $file->getMimeType(),
            'ext'        => $file->getClientOriginalExtension(),
            'size_bytes' => $file->getSize(),
            'tmp_path'   => $file->getRealPath(),
        ]);

        try {
            // 1) Borra la anterior, PERO SIEMPRE en el disco 'public'
            if (!empty($buque->imagen)) {
                logger()->debug('UPDATE: intentando borrar imagen anterior', [
                    'old_rel_path' => $buque->imagen,
                    'exists'       => Storage::disk('public')->exists($buque->imagen),
                    'abs_path'     => Storage::disk('public')->path($buque->imagen),
                ]);

                Storage::disk('public')->delete($buque->imagen);
            }

            // 2) Guarda SIEMPRE en 'public' y SOLO 'buques/...'
            //    Queda un path RELATIVO como 'buques/archivo.jpg'
            $path = $file->store('buques', 'public');

            logger()->debug('UPDATE: imagen guardada', [
                'new_rel_path'   => $path,                                 // ej: buques/xxxx.jpg
                'new_abs_path'   => Storage::disk('public')->path($path),  // ruta absoluta real
                'url_served'     => Storage::disk('public')->url($path),    // ej: /storage/buques/xxxx.jpg
                'exists'         => Storage::disk('public')->exists($path),
                'public_is_writ' => is_writable(Storage::disk('public')->path('')),
            ]);

            // 3) Setea el valor que irá a DB (SIEMPRE relativo, sin 'public/')
            $validated['imagen'] = $path;

        } catch (\Throwable $e) {
            logger()->error('UPDATE: error guardando imagen', [
                'msg'   => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Si quieres, lanza back con error o ignora y sigue
            // return back()->withErrors(['imagen' => 'No se pudo guardar la imagen: '.$e->getMessage()]);
        }
    } else {
        logger()->debug('UPDATE: no llegó archivo de imagen en el request');
    }

    // TÉCNICO -> columnas + dict para JSON
    [$tecnicoDict, $scalarTecnico] = $this->mapearTecnicoDesdeRequest($request);
    $validated = array_merge($scalarTecnico, $validated);

    // LOG/HIST -> JSON (merge con existentes sin borrar valores no enviados)
    $logLabels = [
        'cap_agua_gal'=>'Capacidad de Agua (gal)',
        'cap_mdo_gal'=>'Capacidad de M.D.O (gal)',
        'cap_gasolina_gal'=>'Capacidad de Gasolina (gal)',
        'cap_kerosene_gal'=>'Capacidad de Kerosene (gal)',
        'cap_jet_a1_gal'=>'Capacidad de JET-A1 (gal)',
        'cap_lubricante_gal'=>'Capacidad Lubricante (gal)',
        'cap_viveres_congelados_kg'=>'Cap. Víveres Congelados (kg)',
        'cap_viveres_secos_kg'=>'Cap. Víveres Secos (kg)',
        'cap_viveres_conserva_kg'=>'Cap. Víveres Conserva (kg)',
        'cap_produccion_agua'=>'Capacidad Producción de Agua',
        'consumo_kw_h_navegando'=>'Consumo kW·h (Navegando)',
        'consumo_kw_h_muelle'=>'Consumo kW·h (Muelle)',
        'consumo_comb_hora_vel_economica'=>'Consumo Comb/h a Vel. Económica',
        'consumo_comb_hora_vel_maxima'=>'Consumo Comb/h a Vel. Máxima',
        'consumo_comb_milla_vel_economica'=>'Consumo Comb/milla a Vel. Económica',
        'consumo_comb_milla_vel_maxima'=>'Consumo Comb/milla a Vel. Máxima',
        'tipo_grua_bordo'=>'Tipo de Grúa a bordo',
        'cap_grua_ext_100_ton'=>'Cap. Grúa extendida 100% (ton)',
        'cap_grua_ext_0_ton'=>'Cap. Grúa extendida 0% (ton)',
    ];
    $histLabels = [
        'numero_resolucion_alta'=>'Número de Resolución de Alta',
        'fecha_resolucion_alta'=>'Fecha Resolución Alta',
        'fecha_resolucion_baja'=>'Fecha Resolución Baja',
        'fecha_resolucion_traslado'=>'Fecha Resolución Traslado',
        'fecha_estimada_reemplazo'=>'Fecha Estimada de Reemplazo',
        'ultima_bajada_dique'=>'Última Bajada de Dique',
        'ultima_subida_dique'=>'Última Subida de Dique',
        'proxima_subida_dique'=>'Próxima Subida a Dique',
        'ciclo_vida_estimado_anios'=>'Ciclo de Vida Estimado (años)',
        'valor_adquisicion'=>'Valor de Adquisición',
        'fuerza'=>'Fuerza',
        'brigada_flotilla_comando'=>'Brigada / Flotilla / Comando',
    ];

    $logReq  = $request->input('datos_sap_logistico', []);
    $histReq = $request->input('datos_sap_historico', []);

    // ⚠️ No filtramos: dejamos llaves y convertimos vacíos -> "PENDIENTE"
    $logNuevoRaw  = $this->mapearDiccionarioPlano($logReq,  $logLabels);
    $histNuevoRaw = $this->mapearDiccionarioPlano($histReq, $histLabels);

    $tecnicoPend   = $this->marcarPendienteValoresVacios($tecnicoDict);
    $logPend       = $this->marcarPendienteValoresVacios($logNuevoRaw);
    $historicoPend = $this->marcarPendienteValoresVacios($histNuevoRaw);

    // Merge con lo existente (solo sobrescribe lo que vino en el form)
    $datosSapActual = $buque->datos_sap ?? ['tecnico'=>[], 'logistico'=>[], 'historico'=>[]];
    $datosSapActual['tecnico']   = array_replace($datosSapActual['tecnico']   ?? [], $tecnicoPend);
    $datosSapActual['logistico'] = array_replace($datosSapActual['logistico'] ?? [], $logPend);
    $datosSapActual['historico'] = array_replace($datosSapActual['historico'] ?? [], $historicoPend);

    $validated['datos_sap'] = $datosSapActual;

    $buque->update($validated);

    // === Payload a Flask: enviar lo consolidado (con "PENDIENTE") ===
    $datosSapPayload = [
        'tecnico'   => $datosSapActual['tecnico']   ?? [],
        'logistico' => $datosSapActual['logistico'] ?? [],
        'historico' => $datosSapActual['historico'] ?? [],
    ];

    $this->notificarActualizacionABackendFlask($buque, [
        'nombre_buque' => $buque->nombre,
        'numero_casco' => $buque->numero_casco_armada,
        'info_general' => [
            'peso_buque'             => $buque->peso_buque,
            'unidad_peso'            => $buque->unidad_peso,
            'tamano_dimension_buque' => $buque->tamano_dimension_buque,
        ],
        'datos_sap' => $datosSapPayload,
    ]);

    return redirect()->route('buques.edit', $buque->id)
        ->with('success', 'Datos del buque actualizados exitosamente.');
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

    

public function saveSistemas(Request $request, Buque $buque)
{
    $validated = $request->validate([
        'sistemas' => 'array',
        'sistemas.*' => 'integer|exists:sistemas_suite,id',
    ]);

    // Sincronizar los sistemas seleccionados
    $buque->sistemas()->sync($validated['sistemas'] ?? []);

    if ($request->ajax()) {
        // ✅ No uses join aquí, solo select sobre la relación
        $sistemasActualizados = $buque->sistemas()
            ->select('sistemas_suite.id as id_sistema_ils', 'sistemas_suite.codigo', 'sistemas_suite.nombre')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Sistemas guardados exitosamente.',
            'sistemas_actualizados' => $sistemasActualizados
        ]);
    }

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
            'misiones.*.rpm' => 'nullable|integer|min:0', // ✅ nuevo campo
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
                'rpm' => $data['rpm'] ?? null, // ✅ se guarda el campo RPM
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

    public function modGresEquipo($id)
    {
        $buque = \App\Models\Buque::findOrFail($id);

        try {
            $this->sincronizarEquiposDesdeFlask($buque->id);
        } catch (\Throwable $e) {
            Log::error("Sync Flask error: ".$e->getMessage());
        }

        // GRES locales (clave: equipo_id = ID LSA)
        $gres = GresEquipo::where('buque_id', $buque->id)->get()->keyBy('equipo_id');

        // Traer equipos desde LSA
        $resp = Http::get(Config::get('api.flask_url_2') . "/api/equipos-buque?buque_id={$buque->id}");
        $raw = $resp->json() ?? [];

        // Filtrar/normalizar (acepta id o id_equipo)
        $lsaEquipos = collect($raw)->filter(function ($e) {
            if (is_array($e))  return isset($e['id']) || isset($e['id_equipo']);
            if (is_object($e)) return isset($e->id)   || isset($e->id_equipo);
            return false;
        })->values();

        // Construir lista final para la vista
        $equipos = $lsaEquipos->map(function ($e) use ($gres) {
            $arr   = (array)$e;
            $idLsa = (int)($arr['id'] ?? $arr['id_equipo'] ?? 0);

            $local = $idLsa > 0 ? $gres->get($idLsa) : null;

            return (object) [
                'id'             => $idLsa,                                // **ID LSA** usado por el front
                'id_equipo_info' => $idLsa,                                // alias útil si lo necesitas
                'sistema_id'     => $arr['id_sistema_ils'] ?? null,
                'codigo'         => $arr['cj'] ?? null,
                'nombre'         => $arr['nombre_equipo'] ?? 'Sin nombre',
                'mec'            => $local->mec ?? null,
                'diagrama'       => $local->diagrama ?? null,
                'observaciones'  => $local->observaciones ?? [],
                'created_at'     => $local->created_at ?? null,
                'updated_at'     => $local->updated_at ?? null,
            ];
        });

        return view('mod_gres_equipo', compact('buque', 'equipos'));
    }

    public function saveGresEquipo(Request $request, $buqueId)
    {
        try {
            Log::info('Datos recibidos saveGresEquipo:', $request->all());

            // Validar: equipo_id es el ID de LSA (Flask)
            $validated = $request->validate([
                'buque_id'      => 'required|integer|in:'.$buqueId,
                'equipo_id'     => 'required|integer',        // <- ID de LSA
                'sistema_id'    => 'nullable|integer',
                'mec'           => 'nullable|string|max:255',
                'diagrama'      => 'nullable|string|max:255',
                'observaciones' => 'nullable'                 // string|array
            ]);

            // Normalizar observaciones a array
            $obs = $request->input('observaciones');
            if (is_string($obs)) {
                $decoded = json_decode($obs, true);
                $obs = json_last_error() === JSON_ERROR_NONE ? $decoded : [$obs];
            } elseif (!is_array($obs)) {
                $obs = [];
            }

            // Asegura existencia del registro en gres_equipo (upsert por buque/equipo)
            $record = GresEquipo::updateOrCreate(
                ['buque_id' => $validated['buque_id'], 'equipo_id' => $validated['equipo_id']],
                [
                    // no pisamos datos no enviados
                    'sistema_id'    => $validated['sistema_id'] ?? GresEquipo::where('buque_id',$buqueId)->where('equipo_id',$validated['equipo_id'])->value('sistema_id'),
                    'mec'           => $validated['mec'] ?? GresEquipo::where('buque_id',$buqueId)->where('equipo_id',$validated['equipo_id'])->value('mec'),
                    'diagrama'      => $validated['diagrama'] ?? GresEquipo::where('buque_id',$buqueId)->where('equipo_id',$validated['equipo_id'])->value('diagrama'),
                    'observaciones' => $obs,
                ]
            );

            // Enviar a Flask el MEC como número + el ID de LSA
            preg_match_all('/\d+/', (string)($validated['mec'] ?? ''), $m);
            $mecNumber = isset($m[0]) && count($m[0]) ? (int) end($m[0]) : null;

            try {
                Http::post(Config::get('api.flask_url_2') . '/api/actualizar-gres', [
                    'equipo_id' => (int) $validated['equipo_id'], // ID LSA
                    'gres'      => $mecNumber,
                ]);
                Log::info('GRES enviado a Flask correctamente.');
            } catch (\Throwable $e) {
                Log::error('Error al enviar GRES a Flask: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'GRES guardado correctamente.',
                'data'    => $record
            ]);
        } catch (\Throwable $e) {
            Log::error('Error saveGresEquipo:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el GRES del equipo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sincroniza la tabla gres_equipo del buque con lo que devuelve LSA (Flask).
     * - Crea/actualiza registros (buque_id, equipo_id[LSA], sistema_id).
     * - NO pisa mec/diagrama/observaciones existentes.
     * - Elimina los de ese buque que ya no vienen desde LSA.
     */

    public function sincronizarEquiposDesdeFlask($buqueId)
    {
        Log::info("⏳ Sync GRES por buque {$buqueId} desde Flask");

        // 1) Obtener equipos LSA
        $resp = Http::withHeaders(['X-From-Laravel' => 'true'])
            ->get(Config::get('api.flask_url_2') . "/api/equipos-buque?buque_id={$buqueId}");

        if (!$resp->successful()) {
            Log::error("❌ Error Flask /api/equipos-buque status=".$resp->status());
            return ['created_updated' => 0, 'deleted' => 0, 'error' => 'No se pudieron obtener equipos desde Flask'];
        }

        $ls = collect($resp->json() ?? []);
        if (!$ls->count() || !isset($ls[0]['id'])) {
            Log::error("❌ Respuesta Flask inválida. Primera fila: ".json_encode($ls->first()));
            return ['created_updated' => 0, 'deleted' => 0, 'error' => 'Respuesta Flask inválida'];
        }

        $idsLsa = $ls->pluck('id')->map(fn($v)=>(int)$v)->toArray();
        $rowsUpserted = 0;

        // 2) Upsert por cada equipo LSA
        foreach ($ls as $row) {
            $equipoIdLsa = (int)$row['id']; // PK LSA
            $sistemaId   = $row['id_sistema_ils'] ?? null;

            $local = GresEquipo::where('buque_id', $buqueId)->where('equipo_id', $equipoIdLsa)->first();

            if ($local) {
                // actualizar solo sistema_id si cambia (no pisar mec/diagrama/obs)
                if ($local->sistema_id != $sistemaId) {
                    $local->sistema_id = $sistemaId;
                    $local->save();
                    $rowsUpserted++;
                    Log::info("🔄 GRES updated: buque={$buqueId} equipo_id={$equipoIdLsa} sistema_id={$sistemaId}");
                }
            } else {
                // crear nuevo registro con valores nulos de mec/diagrama/obs
                GresEquipo::create([
                    'buque_id'      => $buqueId,
                    'equipo_id'     => $equipoIdLsa, // **ID LSA**
                    'sistema_id'    => $sistemaId,
                    'mec'           => null,
                    'diagrama'      => null,
                    'observaciones' => [],
                ]);
                $rowsUpserted++;
                Log::info("➕ GRES created: buque={$buqueId} equipo_id={$equipoIdLsa}");
            }
        }

        // 3) Eliminar los que ya no vienen de LSA para este buque
        $toDelete = GresEquipo::where('buque_id', $buqueId)
            ->whereNotIn('equipo_id', $idsLsa)
            ->get();

        $deleted = 0;
        foreach ($toDelete as $r) {
            $r->delete();
            $deleted++;
            Log::info("🗑️ GRES deleted: buque={$buqueId} equipo_id={$r->equipo_id}");
        }

        Log::info("✅ Sync GRES done: upserts={$rowsUpserted}, deleted={$deleted}");
        return ['created_updated' => $rowsUpserted, 'deleted' => $deleted];
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
            $titulo = "Anexo GRES:\n{$buque->nombre}";

            // Agregar fecha de generación
            $fechaGeneracion = now()->format('d/m/Y');


            // Procesar el logo de la portada
            $logoPath = public_path('images/CotecmarLogoPDF.png');
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
                'defaultPaperSize' => 'letter',
                'defaultPaperOrientation' => 'portrait',
                'isFontSubsettingEnabled' => true
            ];

            // Crear instancia de PDF con configuración, incluyendo ambos logos
            $pdf = PDF::loadView('pdf.gres-export',
                compact('colaboradores', 'titulo', 'sistemas', 'logoBase64', 'headerLogoBase64', 'portadaBase64', 'fechaGeneracion'))
                ->setOptions($config)
                ->setPaper('letter', 'portrait');

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
        $flaskUrl = Config::get('api.flask_url');

        // Retornar la vista con la información completa
        return view('sistemas-buque', compact('buque', 'sistemas', 'misiones', 'datosPuertoBase', 'flaskUrl'));
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

        return redirect(Config::get('api.flask_url') . '/LSA?buqueId=' . $buqueId . '&mec=' . $mec);
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

        $flaskUrl = Config::get('api.flask_url');

        return view('buques.lsa', compact('buque', 'sistemasBuques', 'misiones', 'datosPuertoBase', 'flaskUrl'));
    }

    private function obtenerMisiones($buqueId)
    {
        return DB::table('buque_misiones')
            ->join('misiones', 'buque_misiones.mision_id', '=', 'misiones.id')
            ->select(
                'buque_misiones.id',
                'misiones.nombre as mision',
                'buque_misiones.porcentaje',
                'buque_misiones.descripcion',
                'buque_misiones.velocidad',
                'buque_misiones.num_motores',
                'buque_misiones.potencia',
                'buque_misiones.rpm' // ✅ RPM incluido en la consulta
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
                    'disponible_misiones_1',

                    'disponibilidad_mantenimiento_3',
                    'mant_basico_3',
                    'roh_3',
                    'disponible_misiones_3',

                    'disponibilidad_mantenimiento_5',
                    'mant_mayor_5 as mant_basico_5', // mapeo correcto
                    'roh_5',
                    'disponible_misiones_5',

                    'puerto_extranjero' // ✅ sin coma al final
                )
                ->where('buque_id', $buqueId)
                ->first();
        }

        return (object) [
            'disponibilidad_mantenimiento_1' => null,
            'mant_basico_1'                  => null,
            'roh_1'                          => null,
            'disponible_misiones_1'         => null,

            'disponibilidad_mantenimiento_3' => null,
            'mant_basico_3'                  => null,
            'roh_3'                          => null,
            'disponible_misiones_3'         => null,

            'disponibilidad_mantenimiento_5' => null,
            'mant_basico_5'                  => null, // mant_mayor_5 en base de datos
            'roh_5'                          => null,
            'disponible_misiones_5'         => null,

            'puerto_extranjero'             => null, // ✅ añadido
        ];
    }



public function saveCicloOperacional(Request $request, Buque $buque)
{
    // 1) Validar
    $validated = $request->validate([
        'disponibilidad_mantenimiento_1' => 'required|numeric',
        'mant_basico_1'                  => 'nullable|numeric',
        'roh_1'                          => 'required|numeric',
        'puerto_extranjero'              => 'nullable|numeric|min:0',
    ]);

    // 2) Cálculos
    $mantBasico1 = $validated['mant_basico_1'] ?? 0;
    $horasNavegacion = $buque->horas_navegacion_anio;
    $disponibleMisiones1 = 8760 - ($mantBasico1 + $validated['roh_1'] + $horasNavegacion);

    // 3) Upsert FUA
    DB::table('buque_fua')->updateOrInsert(
        ['buque_id' => $buque->id],
        [
            'disponibilidad_mantenimiento_1' => $validated['disponibilidad_mantenimiento_1'],
            'mant_basico_1'                  => $mantBasico1,
            'roh_1'                          => $validated['roh_1'],
            'disponible_misiones_1'          => $disponibleMisiones1,
            'puerto_extranjero'              => $validated['puerto_extranjero'] ?? null,
            'updated_at'                     => now(),
        ]
    );

    // 4) (Opcional) actualizar datos_sap si llegaron en esta request
    $existing = $buque->datos_sap ?? [];

    $labelsTecnico = [
        'eslora' => 'ESLORA',
        'manga' => 'MANGA',
        'puntal' => 'PUNTAL',
        'calado_metros' => 'Calado en Metros',
        'altura_mastil' => 'Altura Mastil',
        'altura_maxima_buque' => 'Altura Maxima del Buque',
        'tipo_material_construccion' => 'Tipo de Material Construccion',
        'sigla_internacional_unidad' => 'Sigla Internacional Unidad',
        'plano_numero' => 'Plano Numero',
        'autonomia_millas_nauticas' => 'Autonomia Millas Nauticas',
        'desp_cond_1_peso_rosca' => 'Desp Cond 1 Peso en Rosca',
        'desp_cond_2_10_consumibles' => 'Desp Cond 2 10% de Consumibles',
        'desp_cond_3_minima_operacional' => 'Desp Cond 3 Minima Operacional',
        'desp_cond_4_50_consumibles' => 'Desp Cond 4 50% de Consumibles',
        'desp_cond_5_optima_operacional' => 'Desp Cond 5 Optima Operacional',
        'desp_cond_6_zarpe_plena_carga' => 'Desp Cond 6 Zarpe Plena Carga',
    ];
    $logFields = [
        'cap_agua_gal' => 'Capacidad de Agua Galones',
        'cap_mdo_gal' => 'Capacidad de M.D.O Galones',
        'cap_gasolina_gal' => 'Capacidad de Gasolin Galones',
        'cap_kerosene_gal' => 'Capacidad de Kerosene Galones',
        'cap_jet_a1_gal' => 'Capacidad de JET-A1 Galones',
        'cap_lubricante_gal' => 'Capacidad Lubricante Galones',
        'cap_viveres_congelados_kg' => 'Capacidad Viveres Congelados Kg',
        'cap_viveres_secos_kg' => 'Capacidad Viveres Secos Kg',
        'cap_viveres_conserva_kg' => 'Capacidad Viveres Conserva Kg',
        'cap_produccion_agua' => 'Capacidad Produccion de Agua',
        'consumo_kw_h_navegando' => 'Consumo_kilo_Wats_Hora_Navegando',
        'consumo_kw_h_muelle' => 'Consumo_kilo_Wats_Hora_Muelle',
        'consumo_comb_hora_vel_economica' => 'Consumo Comb Hora Vel Economic',
        'consumo_comb_hora_vel_maxima' => 'Consumo Comb Hora Vel Maxima',
        'consumo_comb_milla_vel_economica' => 'Consumo Comb Milla Vel Economi',
        'consumo_comb_milla_vel_maxima' => 'Consumo Comb Milla Vel Maxima',
        'tipo_grua_bordo' => 'Tipo de Grua a bordo',
        'cap_grua_ext_100_ton' => 'Cap Grua Extendida 100% Ton',
        'cap_grua_ext_0_ton' => 'Cap Grua Extendida 0% Ton',
    ];
    $histFields = [
        'numero_resolucion_alta' => 'Número de Resolución de Alta',
        'fecha_resolucion_alta' => 'Feecha Resolucion Alta',
        'fecha_resolucion_baja' => 'Fecha Resolucion Baja',
        'fecha_resolucion_traslado' => 'Fecha  Resolucion Traslado',
        'fecha_estimada_reemplazo' => 'Fecha Estimada de Reemplazo',
        'ultima_bajada_dique' => 'Ultima Bajad de Dique',
        'ultima_subida_dique' => 'Ultima Subida de Dique',
        'proxima_subida_dique' => 'Proxima Subida a Dique',
        'ciclo_vida_estimado_anios' => 'Ciclo de Vida Estimado en Años',
        'valor_adquisicion' => 'ValorAdquisicion',
        'fuerza' => 'Fuerza',
        'brigada_flotilla_comando' => 'Brigada Flotilla Comando',
    ];

    $tecReq = (array) $request->input('datos_sap_tecnico', []);
    $logReq = (array) $request->input('datos_sap_logistico', []);
    $histReq = (array) $request->input('datos_sap_historico', []);

    $tecnico = $existing['DATO_TECNIC_BUQUE'] ?? [];
    foreach ($labelsTecnico as $key => $label) {
        $val = data_get($tecReq, "$key.valor_final");
        if ($val !== null) {
            $tecnico[$label] = $val;
        } elseif (!array_key_exists($label, $tecnico)) {
            $fallback = $buque->$key ?? null;
            if ($fallback !== null && $fallback !== '') {
                $tecnico[$label] = $fallback;
            }
        }
    }

    $logistico = $existing['DATO_LOGIST_BUQUE'] ?? [];
    foreach ($logFields as $key => $label) {
        $val = data_get($logReq, "$key.valor_final");
        if ($val !== null) {
            $logistico[$label] = $val;
        }
    }

    $historico = $existing['DATO_HISTOR_BUQUE'] ?? [];
    foreach ($histFields as $key => $label) {
        $val = data_get($histReq, "$key.valor_final");
        if ($val !== null) {
            $historico[$label] = $val;
        }
    }

    $buque->datos_sap = [
        'DATO_TECNIC_BUQUE' => $tecnico,
        'DATO_LOGIST_BUQUE' => $logistico,
        'DATO_HISTOR_BUQUE' => $historico,
    ];
    $buque->save();

     $misionesSeleccionadas = $this->obtenerMisiones($buque->id)->toArray();
    $datosPuertoBase = (array) $this->obtenerDatosPuertoBase($buque->id);

    // Payload hacia Flask: técnico desde columnas + log/hist desde JSON persistido
    $datosSapPayload = [
        'tecnico'   => $this->construirTecnicoParaPayload($buque),
        'logistico' => ($buque->datos_sap['logistico'] ?? []),
        'historico' => ($buque->datos_sap['historico'] ?? []),
    ];

    $this->notificarActualizacionABackendFlask($buque, [
        'nombre_buque'      => $buque->nombre,
        'misiones'          => $misionesSeleccionadas,
        'datos_puerto_base' => $datosPuertoBase,
        'info_general'      => [
            'peso_buque'             => $buque->peso_buque,
            'unidad_peso'            => $buque->unidad_peso,
            'tamano_dimension_buque' => $buque->tamano_dimension_buque,
        ],
        'datos_sap'         => $datosSapPayload,
    ]);
    
    // 6) Redirigir
    return redirect()
        ->route('buques.edit', $buque->id)
        ->with('success', 'Datos de ciclo operacional (Año 1) guardados correctamente.');
}


    public function modFua(Buque $buque)
    {
        $datosPuertoBase = $this->obtenerDatosPuertoBase($buque->id);
        $perfilMisionOperativa = $this->calcularPerfilMisionOperativa($buque, $datosPuertoBase);
        $misiones = $this->obtenerMisiones($buque->id);
        $sistemas = SistemaSuite::all();
        $flaskUrl = Config::get('api.flask_url');
    
        return view('mod_fua', compact('buque', 'perfilMisionOperativa', 'misiones', 'sistemas', 'datosPuertoBase', 'flaskUrl'));

    }
    

public function create()
{
    $buque = new \stdClass();

    // Identificación / básicos
    $buque->id                     = null;
    $buque->nombre                 = '';
    $buque->tipo                   = '';
    $buque->numero_casco_cotecmar  = '';
    $buque->numero_casco_armada    = '';
    $buque->etapa                  = '';

    // Métricas principales
    $buque->autonomia_horas            = '';
    $buque->autonomia_millas_nauticas  = '';
    $buque->vida_diseno_anios          = '';
    $buque->horas_navegacion_anio      = '';

    // Campos nuevos (peso / unidad / tamaño)
    $buque->peso_buque              = '';
    $buque->unidad_peso             = '';
    $buque->tamano_dimension_buque  = '';

    // Imagen y descripción
    $buque->imagen       = null;   // para el <img ...> condicional
    $buque->descripcion  = '';

    // Campos técnicos (los que renderizas en $tecnicoFields)
    $buque->eslora                         = '';
    $buque->manga                          = '';
    $buque->puntal                         = '';
    $buque->calado_metros                  = '';
    $buque->altura_mastil                  = '';
    $buque->altura_maxima_buque            = '';
    $buque->tipo_material_construccion     = '';
    $buque->sigla_internacional_unidad     = '';
    $buque->plano_numero                   = '';
    $buque->desp_cond_1_peso_rosca         = '';
    $buque->desp_cond_2_10_consumibles     = '';
    $buque->desp_cond_3_minima_operacional = '';
    $buque->desp_cond_4_50_consumibles     = '';
    $buque->desp_cond_5_optima_operacional = '';
    $buque->desp_cond_6_zarpe_plena_carga  = '';

    // Textos de “Plan de uso y mantenimiento UUP”
    $buque->mision_organizacion     = '';
    $buque->operaciones_tipo        = '';
    $buque->estandares_calidad      = '';
    $buque->estandares_ambientales  = '';
    $buque->estandares_seguridad    = '';
    $buque->lugar_operaciones       = '';
    $buque->intensidad_operaciones  = '';
    $buque->redundancia             = '';
    $buque->tareas_operacion        = '';
    $buque->repuestos               = '';
    $buque->demanda_repuestos       = '';

    // Relacionados/colecciones que la UI podría usar
    $buque->sistemas = collect(); // sin sistemas seleccionados

    // Estructura para SAP que usas en el Blade ($ds, $dsLog, $dsHist)
    $buque->datos_sap = [
        'tecnico'   => [],
        'logistico' => [],
        'historico' => [],
    ];

    // Resto de datos para la vista
    $misiones               = Mision::all();
    $misionesSeleccionadas  = collect();
    $grupos                 = GrupoConstructivo::with('sistemas')->get();
    $datosPuertoBase        = null;

    return view('editar-buque', compact(
        'buque',
        'misiones',
        'misionesSeleccionadas',
        'grupos',
        'datosPuertoBase'
    ));
}





public function guardarMisionesYCiclo(Request $request, Buque $buque)
{
    // === 1. Validar ===
    $request->validate([
        'disponibilidad_mantenimiento_1' => 'required|numeric',
        'mant_basico_1' => 'nullable|numeric',
        'roh_1' => 'required|numeric',

        'disponibilidad_mantenimiento_3' => 'nullable|numeric',
        'mant_basico_3' => 'nullable|numeric',
        'roh_3' => 'nullable|numeric',

        'disponibilidad_mantenimiento_5' => 'nullable|numeric',
        'mant_basico_5' => 'nullable|numeric',
        'roh_5' => 'nullable|numeric',

        'misiones' => 'nullable|array',
        'misiones.*.porcentaje' => 'nullable|numeric|min:0|max:100',
        'misiones.*.descripcion' => 'nullable|string|max:255',
        'misiones.*.velocidad' => 'nullable|string|max:255',
        'misiones.*.num_motores' => 'nullable|integer',
        'misiones.*.potencia' => 'nullable|integer|min:0|max:100',
        'misiones.*.rpm' => 'nullable|integer|min:0',
        'puerto_extranjero' => 'nullable|numeric|min:0',
    ]);

    // === 2. Cálculos ciclo operacional ===
    $horasNavegacion = $buque->horas_navegacion_anio;

    $mantBasico1 = $request->input('mant_basico_1', $request->input('disponibilidad_mantenimiento_1'));
    $disponibleMisiones1 = 8760 - ($mantBasico1 + $request->input('roh_1') + $horasNavegacion);

    $mantBasico3 = $request->input('mant_basico_3', $request->input('disponibilidad_mantenimiento_3'));
    $disponibleMisiones3 = ($mantBasico3 !== null && $request->input('roh_3') !== null)
        ? 8760 - ($mantBasico3 + $request->input('roh_3') + $horasNavegacion)
        : null;

    $mantBasico5 = $request->input('mant_basico_5', $request->input('disponibilidad_mantenimiento_5'));
    $disponibleMisiones5 = ($mantBasico5 !== null && $request->input('roh_5') !== null)
        ? 8760 - ($mantBasico5 + $request->input('roh_5') + $horasNavegacion)
        : null;

    // === 3. Guardar en tabla buque_fua ===
    DB::table('buque_fua')->updateOrInsert(
        ['buque_id' => $buque->id],
        [
            'disponibilidad_mantenimiento_1' => $request->input('disponibilidad_mantenimiento_1'),
            'mant_basico_1'                  => $mantBasico1,
            'roh_1'                          => $request->input('roh_1'),
            'disponible_misiones_1'          => $disponibleMisiones1,

            'disponibilidad_mantenimiento_3' => $request->input('disponibilidad_mantenimiento_3'),
            'mant_basico_3'                  => $mantBasico3,
            'roh_3'                          => $request->input('roh_3'),
            'disponible_misiones_3'          => $disponibleMisiones3,

            'disponibilidad_mantenimiento_5' => $request->input('disponibilidad_mantenimiento_5'),
            'mant_mayor_5'                   => $mantBasico5,
            'roh_5'                          => $request->input('roh_5'),
            'disponible_misiones_5'          => $disponibleMisiones5,

            'puerto_extranjero'              => $request->input('puerto_extranjero'),
            'updated_at'                     => now(),
        ]
    );

    // === 4. Guardar misiones con datos extendidos ===
    $buque->misiones()->detach();
    foreach ($request->input('misiones', []) as $misionId => $data) {
        $buque->misiones()->attach($misionId, [
            'porcentaje'   => $data['porcentaje'] ?? null,
            'descripcion'  => $data['descripcion'] ?? null,
            'velocidad'    => $data['velocidad'] ?? null,
            'num_motores'  => $data['num_motores'] ?? null,
            'potencia'     => $data['potencia'] ?? null,
            'rpm'          => $data['rpm'] ?? null,
        ]);
    }

    // === 5. Construir y guardar datos_sap (3 categorías anidadas) ===
    $labelsTecnico = [
        'eslora' => 'ESLORA',
        'manga' => 'MANGA',
        'puntal' => 'PUNTAL',
        'calado_metros' => 'Calado en Metros',
        'altura_mastil' => 'Altura Mastil',
        'altura_maxima_buque' => 'Altura Maxima del Buque',
        'tipo_material_construccion' => 'Tipo de Material Construccion',
        'sigla_internacional_unidad' => 'Sigla Internacional Unidad',
        'plano_numero' => 'Plano Numero',
        'autonomia_millas_nauticas' => 'Autonomia Millas Nauticas',
        'desp_cond_1_peso_rosca' => 'Desp Cond 1 Peso en Rosca',
        'desp_cond_2_10_consumibles' => 'Desp Cond 2 10% de Consumibles',
        'desp_cond_3_minima_operacional' => 'Desp Cond 3 Minima Operacional',
        'desp_cond_4_50_consumibles' => 'Desp Cond 4 50% de Consumibles',
        'desp_cond_5_optima_operacional' => 'Desp Cond 5 Optima Operacional',
        'desp_cond_6_zarpe_plena_carga' => 'Desp Cond 6 Zarpe Plena Carga',
    ];

    $logFields = [
        'cap_agua_gal' => 'Capacidad de Agua Galones',
        'cap_mdo_gal' => 'Capacidad de M.D.O Galones',
        'cap_gasolina_gal' => 'Capacidad de Gasolin Galones',
        'cap_kerosene_gal' => 'Capacidad de Kerosene Galones',
        'cap_jet_a1_gal' => 'Capacidad de JET-A1 Galones',
        'cap_lubricante_gal' => 'Capacidad Lubricante Galones',
        'cap_viveres_congelados_kg' => 'Capacidad Viveres Congelados Kg',
        'cap_viveres_secos_kg' => 'Capacidad Viveres Secos Kg',
        'cap_viveres_conserva_kg' => 'Capacidad Viveres Conserva Kg',
        'cap_produccion_agua' => 'Capacidad Produccion de Agua',
        'consumo_kw_h_navegando' => 'Consumo_kilo_Wats_Hora_Navegando',
        'consumo_kw_h_muelle' => 'Consumo_kilo_Wats_Hora_Muelle',
        'consumo_comb_hora_vel_economica' => 'Consumo Comb Hora Vel Economic',
        'consumo_comb_hora_vel_maxima' => 'Consumo Comb Hora Vel Maxima',
        'consumo_comb_milla_vel_economica' => 'Consumo Comb Milla Vel Economi',
        'consumo_comb_milla_vel_maxima' => 'Consumo Comb Milla Vel Maxima',
        'tipo_grua_bordo' => 'Tipo de Grua a bordo',
        'cap_grua_ext_100_ton' => 'Cap Grua Extendida 100% Ton',
        'cap_grua_ext_0_ton' => 'Cap Grua Extendida 0% Ton',
    ];

    $histFields = [
        'numero_resolucion_alta' => 'Número de Resolución de Alta',
        'fecha_resolucion_alta' => 'Feecha Resolucion Alta',
        'fecha_resolucion_baja' => 'Fecha Resolucion Baja',
        'fecha_resolucion_traslado' => 'Fecha  Resolucion Traslado',
        'fecha_estimada_reemplazo' => 'Fecha Estimada de Reemplazo',
        'ultima_bajada_dique' => 'Ultima Bajad de Dique',
        'ultima_subida_dique' => 'Ultima Subida de Dique',
        'proxima_subida_dique' => 'Proxima Subida a Dique',
        'ciclo_vida_estimado_anios' => 'Ciclo de Vida Estimado en Años',
        'valor_adquisicion' => 'ValorAdquisicion',
        'fuerza' => 'Fuerza',
        'brigada_flotilla_comando' => 'Brigada Flotilla Comando',
    ];

    $existing = $buque->datos_sap ?? [];

    // Técnico: usa valor_final si llega; si no, cae al valor en columnas del modelo
    $tecReq = (array) $request->input('datos_sap_tecnico', []);
    $tecnico = $existing['DATO_TECNIC_BUQUE'] ?? [];
    foreach ($labelsTecnico as $key => $label) {
        $val = data_get($tecReq, "$key.valor_final");
        if ($val === null) {
            // fallback a columnas del modelo (mantiene retro-compatibilidad)
            $fallback = $buque->$key ?? null;
            if ($fallback !== null && $fallback !== '') {
                $tecnico[$label] = $fallback;
            }
        } else {
            $tecnico[$label] = $val;
        }
    }

    // Logístico: solo lo que llegue (conserva existentes si no llegan)
    $logReq = (array) $request->input('datos_sap_logistico', []);
    $logistico = $existing['DATO_LOGIST_BUQUE'] ?? [];
    foreach ($logFields as $key => $label) {
        $val = data_get($logReq, "$key.valor_final");
        if ($val !== null) {
            $logistico[$label] = $val;
        }
    }

    // Histórico: solo lo que llegue (conserva existentes si no llegan)
    $histReq = (array) $request->input('datos_sap_historico', []);
    $historico = $existing['DATO_HISTOR_BUQUE'] ?? [];
    foreach ($histFields as $key => $label) {
        $val = data_get($histReq, "$key.valor_final");
        if ($val !== null) {
            $historico[$label] = $val;
        }
    }

    $buque->datos_sap = [
        'DATO_LOGIST_BUQUE' => $logistico,
        'DATO_HISTOR_BUQUE' => $historico,
    ];

    $buque->save(); // guarda el JSON

     $datosSapPayload = [
        'tecnico'   => $this->construirTecnicoParaPayload($buque),
        'logistico' => ($buque->datos_sap['logistico'] ?? []),
        'historico' => ($buque->datos_sap['historico'] ?? []),
    ];

    $this->notificarActualizacionABackendFlask($buque, [
        'nombre_buque'      => $buque->nombre,
        'misiones'          => $this->obtenerMisiones($buque->id)->toArray(),
        'datos_puerto_base' => (array) $this->obtenerDatosPuertoBase($buque->id),
        'info_general'      => [
            'peso_buque'             => $buque->peso_buque,
            'unidad_peso'            => $buque->unidad_peso,
            'tamano_dimension_buque' => $buque->tamano_dimension_buque,
        ],
        'datos_sap'         => $datosSapPayload,
    ]);

    // === 7. Retorno
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Misiones y ciclo operacional guardados correctamente.',
        ]);
    }

    return redirect()->route('buques.edit', $buque->id)
        ->with('success', 'Ciclo operacional y misiones guardados correctamente.');
}




    
    private function calcularPerfilMisionOperativa($buque, $datosPuertoBase)
    {
        // Horas al Año (siempre 8760)
        $horasAnio = 8760;

        // Horas de Mantenimiento al Año (desde buque_fua.disponibilidad_mantenimiento_1)
        $horasMantenimientoAnio = $datosPuertoBase->disponibilidad_mantenimiento_1 ?? 0;

        // Horas Disponibles al Año (disponible_misiones_1 + horas_navegacion_anio)
        $horasDisponiblesAnio = ($datosPuertoBase->disponible_misiones_1 ?? 0) + $buque->horas_navegacion_anio;

        // Máxima Misiones por Año (horas_disponibles_anio / autonomia_horas)
        $maxMisionesAnio = ceil($horasDisponiblesAnio / $buque->autonomia_horas);

        // Misiones acuerdo Plan de Uso y Mantenimiento (horas_navegacion_anio / autonomia_horas)
        $misionesPlanUso = ceil($buque->horas_navegacion_anio / $buque->autonomia_horas);

        // Días de Operación por Año (horas_navegacion_anio / 24)
        $diasOperacionAnio = ceil($buque->horas_navegacion_anio / 24);

        // Días por Misión (autonomia_horas / 24)
        $diasPorMision = ceil($buque->autonomia_horas / 24);

        // Días de Navegación por Misión (Días por Misión - 1)
        $diasNavegacionMision = $diasPorMision - 1;

        // Horas Operacionales por Misión (igual a la autonomía)
        $horasOperacionalesMision = $buque->autonomia_horas;

        // Horas Operacionales por Año (igual a horas de navegación por año)
        $horasOperacionalesAnio = $buque->horas_navegacion_anio;

        // Horas de Navegación por Misión (Autonomía - 24)
        $horasNavegacionMision = $buque->autonomia_horas - 24;

        return [
            'horas_anio' => $horasAnio,
            'horas_mantenimiento_anio' => ceil($horasMantenimientoAnio),
            'horas_disponibles_anio' => ceil($horasDisponiblesAnio),
            'max_misiones_anio' => $maxMisionesAnio,
            'misiones_plan_uso' => $misionesPlanUso,
            'dias_operacion_anio' => $diasOperacionAnio,
            'dias_por_mision' => $diasPorMision,
            'dias_navegacion_mision' => $diasNavegacionMision,
            'horas_operacionales_mision' => $horasOperacionalesMision,
            'horas_operacionales_anio' => $horasOperacionalesAnio,
            'horas_navegacion_mision' => $horasNavegacionMision
        ];
    }

    private function notificarActualizacionABackendFlask(Buque $buque, array $campos = [])
    {
        try {
            // Construcción del payload
            $payload = array_merge(['buque_id' => $buque->id], $campos);

            // ⬇️ Aplanar info_general porque Flask espera top-level
            if (isset($payload['info_general']) && is_array($payload['info_general'])) {
                $payload = array_merge($payload, $payload['info_general']);
                unset($payload['info_general']);
            }

            // ⬇️ Asegurar numero_casco: prioriza Cotecmar; si no, Armada
            if (empty($payload['numero_casco'])) {
                $payload['numero_casco'] = $buque->numero_casco_cotecmar ?: $buque->numero_casco_armada;
            }

            // (Opcional) Log para ver lo que sale hacia Flask
            // \Log::info('[notificarActualizacionABackendFlask] payload', $payload);

            Http::withHeaders([
                'X-From-Laravel' => 'true',
            ])->post(Config::get('api.flask_url_2') . '/actualizar_buque', $payload);

        } catch (\Exception $e) {
            Log::error('Error al enviar datos a Flask desde Laravel: ' . $e->getMessage());
        }
    }


}