<?php

// En app/Models/GresSistema.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GresSistema extends Model
{
    protected $table = 'gres_sistema';

    protected $fillable = [
        'buque_id',
        'sistema_id',
        'mec',
        'diagrama',
        'observaciones'
    ];

    protected $casts = [
        'observaciones' => 'array'
    ];

    public function sistema()
    {
        return $this->belongsTo(SistemaSuite::class, 'sistema_id');
    }

    public function buque()
    {
        return $this->belongsTo(Buque::class);
    }
}
