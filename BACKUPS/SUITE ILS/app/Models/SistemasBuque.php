<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemasBuque extends Model
{
    use HasFactory;

    protected $table = 'sistemas_buque';

    protected $fillable = [
        'buque_id',
        'codigo',
        'nombre',
        'descripcion',
    ];

    // Si tienes la relación belongsTo existente, puedes comentarla o eliminarla
    // public function buque()
    // {
    //     return $this->belongsTo(Buque::class);
    // }

    // Nueva relación belongsToMany a través de la tabla pivote
    public function buques()
    {
        return $this->belongsToMany(Buque::class, 'buque_sistemas_buque', 'sistemas_buque_id', 'buque_id')
            ->withPivot('mec', 'titulo', 'image', 'observaciones', 'mision')
            ->withTimestamps();
    }
}
