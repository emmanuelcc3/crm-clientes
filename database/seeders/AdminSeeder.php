<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Crear permisos
        $permisos = [
            // Usuarios
            'usuarios.ver',
            'usuarios.crear',
            'usuarios.editar',
            'usuarios.eliminar',
            'usuarios.exportar',
            // Clientes
            'clientes.ver',
            'clientes.crear',
            'clientes.editar',
            'clientes.eliminar',
            'clientes.exportar',
            // Roles
            'roles.ver',
            'roles.crear',
            'roles.editar',
            'roles.eliminar',
            'roles.permisos',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Crear rol admin y asignar todos los permisos
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        // Crear usuario admin
        $user = User::firstOrCreate([
            'email' => 'admin@admin.com'
        ], [
            'name' => 'Administrador',
            'password' => Hash::make('12345678')
        ]);

        $user->assignRole($admin);
    }
}


