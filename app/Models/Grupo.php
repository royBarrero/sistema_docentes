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

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
