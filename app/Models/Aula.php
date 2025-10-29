<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $table = 'aulas';

    protected $fillable = [
        'codigo',
        'capacidad',
        'ubicacion',
        'tipo',
        'estado',
        'telefono',
    ];

    // Relación con Horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'aula_id');
    }
}