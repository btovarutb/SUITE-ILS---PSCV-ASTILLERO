<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;

    protected $table = 'colaboradores'; // Asegúrate de que esté usando la tabla correcta

    protected $fillable = [
        'buque_id',
        'col_cargo',
        'col_nombre',
        'col_entidad',
    ];

    public function buque() {
        return $this->belongsTo(Buque::class);
    }
}
