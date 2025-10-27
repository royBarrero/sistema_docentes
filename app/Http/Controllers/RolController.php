<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;

class RolController extends Controller
{
    // Mostrar todos los roles
    public function index()
    {
        $roles = Rol::all();
        return view('roles.index', compact('roles'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('roles.create');
    }

    // Guardar nuevo rol
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Rol::create($request->all());

        return redirect()->route('roles.index')
            ->with('success', 'Rol creado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit(Rol $role)
    {
        return view('roles.edit', compact('role'));
    }

    // Actualizar rol existente
    public function update(Request $request, Rol $role)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $role->update($request->all());

        return redirect()->route('roles.index')
            ->with('success', 'Rol actualizado correctamente.');
    }

    // Eliminar rol
    public function destroy(Rol $role)
    {
        $role->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Rol eliminado correctamente.');
    }
}
