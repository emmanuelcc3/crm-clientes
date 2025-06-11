<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles.ver')->only('index');
        $this->middleware('permission:roles.crear')->only(['create', 'store']);
        $this->middleware('permission:roles.editar')->only(['edit', 'update']);
        $this->middleware('permission:roles.eliminar')->only('destroy');
    }

    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name|not_in:admin',
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name',
        ], [
            'name.not_in' => 'No puedes crear un rol llamado admin.',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Rol creado con permisos.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'admin') {
            return redirect()->route('roles.index')->with('error', 'No puedes editar el rol admin.');
        }

        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'admin') {
            return redirect()->route('roles.index')->with('error', 'No puedes actualizar el rol admin.');
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . '|not_in:admin',
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'admin') {
            return redirect()->route('roles.index')->with('error', 'No puedes eliminar el rol admin.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado.');
    }
}
