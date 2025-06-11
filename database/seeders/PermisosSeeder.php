<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosSeeder extends Seeder
{
    public function run()
    {
        $permisos = [
            // Roles
            'roles.ver',
            'roles.crear',
            'roles.editar',
            'roles.eliminar',

            // Usuarios
            'usuarios.ver',
            'usuarios.crear',
            'usuarios.editar',
            'usuarios.eliminar',
            'usuarios.restaurar',

            // Clientes
            'clientes.ver',
            'clientes.crear',
            'clientes.editar',
            'clientes.eliminar',
            'clientes.restaurar',
            'clientes.exportar',

            // Etiquetas
            'etiquetas.ver',
            'etiquetas.crear',
            'etiquetas.editar',
            'etiquetas.eliminar',
            'etiquetas.restaurar',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web',
            ]);
        }

        $rolAdmin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $rolAdmin->syncPermissions($permisos);
    }
}
