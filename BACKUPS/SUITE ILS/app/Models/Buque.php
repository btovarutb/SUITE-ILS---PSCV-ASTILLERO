<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Buque extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre_proyecto',
        'tipo_buque',
        'descripcion_proyecto',
        'autonomia_horas',
        'horas_navegacion_anual',
        'image_path',
        'col_cargo',
        'col_nombre',
        'col_entidad',
        'misiones',
        'vida_diseno', // Agregar esta línea
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sistemasEquipos() {
        return $this->belongsToMany(SistemasEquipos::class, 'buque_sistemas_equipos')
                    ->withPivot('mec', 'titulo', 'diagrama_id', 'image', 'observaciones')
                    ->withTimestamps();
    }

    public function sistemas()
    {
        return $this->belongsToMany(Sistema::class)->withPivot('mec', 'image', 'observaciones', 'misiones');
    }

    public function colaboradores() {
        return $this->hasMany(Colaborador::class);
    }

    public function buqueMisiones()
    {
        return $this->hasMany(BuqueMision::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return Storage::disk('public')->url($this->image_path);
        }
        return asset('storage/images/imagenullbuque.png');
    }


    public function sistemasBuqueDirect()
    {
        return $this->hasMany(SistemasBuque::class);
    }

    public function sistemasBuques()
    {
        return $this->belongsToMany(SistemasBuque::class, 'buque_sistemas_buque', 'buque_id', 'sistemas_buque_id')
            ->withPivot('mec', 'titulo', 'image', 'observaciones', 'mision')
            ->withTimestamps();
    }

    public function fua()
    {
        return $this->hasOne(BuqueFua::class);
    }

    public function tablaFua()
    {
        return $this->hasOne(TablaFua::class);
    }

}

