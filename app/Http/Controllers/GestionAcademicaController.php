<?php

namespace App\Http\Controllers;

use App\Models\GestionAcademica;
use Illuminate\Http\Request;

class GestionAcademicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gestiones = GestionAcademica::orderBy('fecha_inicio', 'desc')->paginate(10);
        return view('gestiones.index', compact('gestiones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gestiones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:gestiones_academicas,nombre',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estado' => 'required|in:Activa,Planificada,Cerrada',
        ], [
            'nombre.unique' => 'Ya existe una gestión académica con ese nombre.',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
        ]);

        // Si se marca como Activa, desactivar las demás
        if ($request->estado == 'Activa') {
            GestionAcademica::where('estado', 'Activa')->update(['estado' => 'Planificada']);
        }

        GestionAcademica::create($request->all());

        return redirect()->route('gestiones.index')
                       ->with('success', 'Gestión académica creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GestionAcademica $gestione)
    {
        $gestione->load('horarios');
        return view('gestiones.show', compact('gestione'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GestionAcademica $gestione)
    {
        return view('gestiones.edit', compact('gestione'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GestionAcademica $gestione)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:gestiones_academicas,nombre,' . $gestione->id,
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estado' => 'required|in:Activa,Planificada,Cerrada',
        ], [
            'nombre.unique' => 'Ya existe una gestión académica con ese nombre.',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
        ]);

        // Si se marca como Activa, desactivar las demás
        if ($request->estado == 'Activa' && $gestione->estado != 'Activa') {
            GestionAcademica::where('estado', 'Activa')
                           ->where('id', '!=', $gestione->id)
                           ->update(['estado' => 'Planificada']);
        }

        $gestione->update($request->all());

        return redirect()->route('gestiones.index')
                       ->with('success', 'Gestión académica actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GestionAcademica $gestione)
    {
        // Verificar si tiene horarios asignados
        if ($gestione->horarios()->count() > 0) {
            return redirect()->route('gestiones.index')
                           ->with('error', 'No se puede eliminar una gestión con horarios asignados.');
        }

        $gestione->delete();

        return redirect()->route('gestiones.index')
                       ->with('success', 'Gestión académica eliminada exitosamente.');
    }

    /**
     * Activar una gestión académica
     */
    public function activar($id)
    {
        $gestion = GestionAcademica::findOrFail($id);

        // Desactivar todas las demás
        GestionAcademica::where('estado', 'Activa')->update(['estado' => 'Planificada']);

        // Activar la seleccionada
        $gestion->update(['estado' => 'Activa']);

        return redirect()->route('gestiones.index')
                       ->with('success', 'Gestión académica activada exitosamente.');
    }
}