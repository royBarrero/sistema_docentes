<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
   public function index()
{
    // Cargar la relación con usuario para acceder al nombre
    $docentes = Docente::with('usuario')
                       ->orderBy('ci')
                       ->paginate(10);
    
    return view('docentes.index', compact('docentes'));
}

    public function create()
    {
        return view('docentes.create');
    }

    public function store(Request $request)
    {
      $request->validate([
    'ci' => 'required|numeric|unique:docentes,ci',
    'nombre' => 'required|string|max:100',
    'apellidos' => 'required|string|max:100',
    'titulo' => 'nullable|string|max:100',
    'especialidad' => 'nullable|string|max:120',
    'correo_institucional' => 'required|email|unique:docentes,correo_institucional',
    'telefono' => 'nullable|string|max:30',
    'estado' => 'required|string|max:20',
]);


    // 1️⃣ Crear usuario asociado
    $usuario = Usuario::create([
        'nombre_completo' => $request->nombre . ' ' . $request->apellidos,
    'email' => $request->correo_institucional,
    'telefono' => $request->telefono ?? '00000000',
    'password_hash' => Hash::make('docente123'),
    'estado' => 'Activo',
    'role_id' => 3,
    ]);

    // 2️⃣ Crear docente y asociarlo
    Docente::create([
    'usuario_id' => $usuario->id,
    'ci' => $request->ci,
    'nombre' => $request->nombre,
    'apellidos' => $request->apellidos,
    'titulo' => $request->titulo,
    'especialidad' => $request->especialidad,
    'correo_institucional' => $request->correo_institucional,
    'telefono' => $request->telefono,
    'estado' => $request->estado,
]);

    return redirect()->route('docentes.index')
        ->with('success', 'Docente y usuario creados correctamente.');
    }

    public function edit(Docente $docente)
    {
        return view('docentes.edit', compact('docente'));
    }

    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'ci' => 'required|numeric|unique:docentes,ci,' . $docente->id,
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'correo_institucional' => 'required|email|unique:docentes,correo_institucional,' . $docente->id,
            'especialidad' => 'nullable|string|max:120',
            'titulo' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:30',
            'estado' => 'required|string|max:20',
        ]);

        $docente->update($request->all());

        return redirect()->route('docentes.index')
            ->with('success', 'Docente actualizado correctamente.');
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();
        return redirect()->route('docentes.index')
            ->with('success', 'Docente eliminado correctamente.');
    }
}
