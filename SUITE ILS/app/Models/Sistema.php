<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sistema extends Model
{
    protected $fillable = ['grupo_constructivo', 'titulo'];

    public function buques()
    {
        return $this->belongsToMany(Buque::class)->withPivot('mec', 'image', 'observaciones', 'misiones');
    }
}

