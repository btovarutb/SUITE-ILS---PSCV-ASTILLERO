<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GresEquipo extends Model
{
    use HasFactory;

    protected $table = 'gres_equipo';

    protected $fillable = [
        'buque_id',
        'sistema_id',
        'equipo_id',
        'mec',
        'diagrama',
        'observaciones'
    ];

    protected $casts = [
        'observaciones' => 'array',
        'sistema_id' => 'integer'
    ];

    public function buque()
    {
        return $this->belongsTo(Buque::class);
    }

    public function sistema()
    {
        return $this->belongsTo(SistemaSuite::class, 'sistema_id');
    }

    public function equipo()
    {
        return $this->belongsTo(EquipoSuite::class, 'equipo_id');
    }
} 