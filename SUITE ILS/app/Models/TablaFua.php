<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaFua extends Model
{
    use HasFactory;

    protected $table = 'tablas_fua';

    protected $fillable = [
        'buque_id',
        'vida_diseño',
        'horas_ano', // Cambiado aquí
        'horas_mant_año',
        'horas_disp_año',
        'max_mis_año',
        'mis_plan_mant',
        'dias_op_año',
        'dias_mision',
        'dias_nav_mision',
        'horas_op_mision',
        'horas_op_año',
        'horas_nav_mision',
    ];

    // Relación con buques
    public function buque()
    {
        return $this->belongsTo(Buque::class);
    }
}
