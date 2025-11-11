<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'materia_id',
        'nombre',
        'estado',
    ];

    // Relación con Materia
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    // Relación con Horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'grupo_id');
    }

    // Nombre completo del grupo (ej: "Programación Web - Grupo A")
    public function getNombreCompletoAttribute()
    {
        return $this->materia->nombre . ' - Grupo ' . $this->nombre;
    }
}