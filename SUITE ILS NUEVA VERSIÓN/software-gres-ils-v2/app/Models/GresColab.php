<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GresColab extends Model
{
    use HasFactory;

    protected $table = 'gres_colab';

    protected $fillable = [
        'buque_id',
        'cargo',
        'nombre',
        'apellido',
        'entidad',
    ];

    /**
     * Relación con el modelo Buque.
     */
    public function buque()
    {
        return $this->belongsTo(Buque::class);
    }
}
