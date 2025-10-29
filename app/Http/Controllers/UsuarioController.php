<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::with('rol')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Rol::all();
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:120',
            'email' => 'required|email|unique:usuarios,email|max:120',
            'telefono' => 'nullable|string|max:30',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'estado' => 'required|in:Activo,Inactivo,Suspendido',
        ]);

        Usuario::create([
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password_hash' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'estado' => $request->estado,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        $roles = Rol::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:120',
            'email' => ['required', 'email', 'max:120', Rule::unique('usuarios')->ignore($usuario->id)],
            'telefono' => 'nullable|string|max:30',
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'estado' => 'required|in:Activo,Inactivo,Suspendido',
        ]);

        $data = [
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'role_id' => $request->role_id,
            'estado' => $request->estado,
        ];

        // Solo actualizar password si se proporciona uno nuevo
        if ($request->filled('password')) {
            $data['password_hash'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente');
    }
}