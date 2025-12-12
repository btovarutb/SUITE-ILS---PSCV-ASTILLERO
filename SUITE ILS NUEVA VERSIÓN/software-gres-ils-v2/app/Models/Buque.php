<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buque extends Model
{
    use HasFactory;

    // Propiedades del modelo
    protected $fillable = [
        'nombre','tipo','numero_casco_cotecmar','numero_casco_armada','descripcion','etapa',
        'autonomia_horas','autonomia_millas_nauticas','vida_diseno_anios','horas_navegacion_anio','imagen',

        // técnicos clásicos (se seguirán llenando desde valor_final)
        'eslora','manga','puntal','calado_metros','altura_mastil','altura_maxima_buque',
        'tipo_material_construccion','sigla_internacional_unidad','plano_numero',
        'desp_cond_1_peso_rosca','desp_cond_2_10_consumibles','desp_cond_3_minima_operacional',
        'desp_cond_4_50_consumibles','desp_cond_5_optima_operacional','desp_cond_6_zarpe_plena_carga',

        // nuevos
        'peso_buque','unidad_peso','tamano_dimension_buque',

        // JSON SAP anidado
        'datos_sap',

        // existentes
        'mision_organizacion','operaciones_tipo','estandares_calidad','estandares_ambientales',
        'estandares_seguridad','lugar_operaciones','intensidad_operaciones','redundancia',
        'tareas_operacion','repuestos','demanda_repuestos',
    ];

    protected $casts = [
        'autonomia_horas' => 'integer',
        'vida_diseno_anios' => 'integer',
        'horas_navegacion_anio' => 'integer',
        'autonomia_millas_nauticas' => 'decimal:2',

        'eslora' => 'decimal:2',
        'manga' => 'decimal:2',
        'puntal' => 'decimal:2',
        'calado_metros' => 'decimal:2',
        'altura_mastil' => 'decimal:2',
        'altura_maxima_buque' => 'decimal:2',

        'desp_cond_1_peso_rosca' => 'decimal:3',
        'desp_cond_2_10_consumibles' => 'decimal:3',
        'desp_cond_3_minima_operacional' => 'decimal:3',
        'desp_cond_4_50_consumibles' => 'decimal:3',
        'desp_cond_5_optima_operacional' => 'decimal:3',
        'desp_cond_6_zarpe_plena_carga' => 'decimal:3',

        // nuevos
        'peso_buque' => 'decimal:3',
        'datos_sap'  => 'array',
    ];


    public function misiones()
    {
        return $this->belongsToMany(Mision::class, 'buque_misiones')
            ->withPivot('porcentaje', 'descripcion', 'velocidad', 'num_motores', 'potencia', 'rpm') // ✅ rpm agregado
            ->withTimestamps();
    }

    // En el modelo Buque.php
    public function sistemas()
    {
        return $this->belongsToMany(SistemaSuite::class, 'buque_sistema', 'buque_id', 'sistema_id');
    }

    public function colaboradores()
    {
        return $this->hasMany(GresColab::class, 'buque_id');
    }
}
