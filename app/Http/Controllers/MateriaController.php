<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\GestionAcademica;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::with('gestion')->paginate(10);
        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        $gestiones = GestionAcademica::pluck('nombre', 'id');
        return view('materias.create', compact('gestiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:30|unique:materias,codigo,NULL,id,gestion_id,' . $request->gestion_id,
            'nombre' => 'required|string|max:120',
            'nivel' => 'nullable|string|max:30',
            'carrera' => 'nullable|string|max:120',
            'gestion_id' => 'required|exists:gestiones_academicas,id',
            'estado' => 'required|string|max:20',
        ]);

        Materia::create($request->all());

        return redirect()->route('materias.index')
            ->with('success', 'Materia registrada correctamente.');
    }

    public function edit(Materia $materia)
    {
        $gestiones = GestionAcademica::pluck('nombre', 'id');
        return view('materias.edit', compact('materia', 'gestiones'));
    }

    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'codigo' => 'required|string|max:30|unique:materias,codigo,' . $materia->id . ',id,gestion_id,' . $request->gestion_id,
            'nombre' => 'required|string|max:120',
            'nivel' => 'nullable|string|max:30',
            'carrera' => 'nullable|string|max:120',
            'gestion_id' => 'required|exists:gestiones_academicas,id',
            'estado' => 'required|string|max:20',
        ]);

        $materia->update($request->all());

        return redirect()->route('materias.index')
            ->with('success', 'Materia actualizada correctamente.');
    }

    public function destroy(Materia $materia)
    {
        $materia->delete();

        return redirect()->route('materias.index')
            ->with('success', 'Materia eliminada correctamente.');
    }
}
