<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionAcademica extends Model
{
    use HasFactory;

    protected $table = 'gestiones_academicas';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    // Relación con horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'gestion_id');
    }

    // Obtener la gestión activa
    public static function activa()
    {
        return self::where('estado', 'Activa')->first();
    }
}