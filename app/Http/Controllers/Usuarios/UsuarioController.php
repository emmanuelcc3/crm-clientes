<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('permission:usuarios.ver')->only('index');
            $this->middleware('permission:usuarios.crear')->only(['create', 'store']);
            $this->middleware('permission:usuarios.editar')->only(['edit', 'update']);
            $this->middleware('permission:usuarios.eliminar')->only('destroy');
            $this->middleware('permission:usuarios.restaurar')->only('restaurar');

        }

    
    public function index(Request $request)
    {
        $filtro = $request->input('filtro', 'activos');

        if ($filtro === 'eliminados') {
            $usuarios = User::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        } elseif ($filtro === 'todos') {
            $usuarios = User::withTrashed()->orderBy('created_at', 'desc')->get();
        } else {
            $usuarios = User::orderBy('created_at', 'desc')->get(); // Activos
        }

        return view('usuarios.index', compact('usuarios', 'filtro'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $usuario = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Solo admin puede asignar rol personalizado
            if (auth()->user()->hasRole('admin') && $request->filled('rol')) {
                $usuario->assignRole($request->rol);
            } else {
                $usuario->assignRole('empleado'); // o el rol por defecto
            }

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado con éxito.');
        }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        // Validación base
        $rules = [
            'name' => 'required|string|max:255',
        ];

        $datos = ['name' => $request->name];

        // Solo el admin puede modificar correo y contraseña
        if (auth()->user()->hasRole('admin')) {
            if ($request->filled('email')) {
                $datos['email'] = $request->email;
            }

            if ($request->filled('password')) {
                $datos['password'] = Hash::make($request->password);
            }
        }

        $usuario->update($datos);

        // Solo admin puede modificar rol
        if (auth()->user()->hasRole('admin') && $request->filled('rol')) {
            $usuario->syncRoles([$request->rol]);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }


    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }

    public function restaurar($id)
{
    $usuario = User::onlyTrashed()->findOrFail($id);
    $usuario->restore();

    return redirect()->route('usuarios.index')->with('success', 'Usuario restaurado con éxito.');
}
}
