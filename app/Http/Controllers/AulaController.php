<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function index()
    {
        $aulas = Aula::paginate(10);
        return view('aulas.index', compact('aulas'));
    }

    public function create()
    {
        return view('aulas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:aulas,codigo',
            'capacidad' => 'required|integer|min:1',
            'ubicacion' => 'nullable|string|max:120',
            'tipo' => 'nullable|string|max:50',
            'estado' => 'required|string|max:20',
        ], [
            'codigo.unique' => 'Ya existe un aula registrada con este código.',
            'capacidad.min' => 'La capacidad debe ser al menos 1.',
        ]);

        Aula::create($request->all());

        return redirect()->route('aulas.index')->with('success', 'Aula registrada correctamente.');
    }

    public function edit(Aula $aula)
    {
        return view('aulas.edit', compact('aula'));
    }

    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:aulas,codigo,' . $aula->id,
            'capacidad' => 'required|integer|min:1',
            'ubicacion' => 'nullable|string|max:120',
            'tipo' => 'nullable|string|max:50',
            'estado' => 'required|string|max:20',  
        ], [
            'codigo.unique' => 'Ya existe otro aula con ese código.',
            'capacidad.min' => 'La capacidad debe ser al menos 1.',
        ]);

        $aula->update($request->all());

        return redirect()->route('aulas.index')->with('success', 'Aula actualizada correctamente.');
    }

    public function destroy(Aula $aula)
    {
        $aula->delete();
        return redirect()->route('aulas.index')->with('success', 'Aula eliminada correctamente.');
    }
}
