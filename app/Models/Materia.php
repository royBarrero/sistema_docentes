<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $fillable = [
        'codigo',
        'nombre',
        'nivel',
        'carrera',
        'gestion_id',
        'estado',
    ];

    public function gestion()
    {
        return $this->belongsTo(GestionAcademica::class, 'gestion_id');
    }
}
