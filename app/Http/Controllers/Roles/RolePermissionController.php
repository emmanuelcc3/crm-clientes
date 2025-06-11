<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function edit(Role $role)
    {
        $permisos = Permission::all()->groupBy(function ($permiso) {
            return explode('.', $permiso->name)[0]; // Agrupa por módulo
        });

        return view('roles.permisos', compact('role', 'permisos'));
    }

    public function update(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions ?? []);
        return redirect()->route('roles.permisos.edit', $role)->with('success', 'Permisos actualizados.');
    }
}
