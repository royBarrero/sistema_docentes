<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Materia;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with('materia')->paginate(10);
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        $materias = Materia::pluck('nombre', 'id');
        return view('grupos.create', compact('materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'nombre' => 'required|string|max:50|unique:grupos,nombre,NULL,id,materia_id,' . $request->materia_id,
            'estado' => 'required|string|max:20',
        ], [
            'nombre.unique' => 'La materia seleccionada ya tiene un grupo con el mismo nombre.',
        ]);

        Grupo::create($request->all());

        return redirect()->route('grupos.index')->with('success', 'Grupo creado correctamente.');
    }

    public function edit(Grupo $grupo)
    {
        $materias = Materia::pluck('nombre', 'id');
        return view('grupos.edit', compact('grupo', 'materias'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'nombre' => 'required|string|max:50|unique:grupos,nombre,' . $grupo->id . ',id,materia_id,' . $request->materia_id,
            'estado' => 'required|string|max:20',
        ], [
            'nombre.unique' => 'La materia seleccionada ya tiene un grupo con el mismo nombre.',
        ]);

        $grupo->update($request->all());

        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado correctamente.');
    }

    public function destroy(Grupo $grupo)
    {
        $grupo->delete();
        return redirect()->route('grupos.index')->with('success', 'Grupo eliminado correctamente.');
    }
}
