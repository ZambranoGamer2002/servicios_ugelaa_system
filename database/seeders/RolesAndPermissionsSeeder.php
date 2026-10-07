<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        \Spatie\Permission\Models\Permission::create(['name' => 'ver menus']);
        \Spatie\Permission\Models\Permission::create(['name' => 'crear usuarios']);
        \Spatie\Permission\Models\Permission::create(['name' => 'editar usuarios']);
        \Spatie\Permission\Models\Permission::create(['name' => 'eliminar usuarios']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = \Spatie\Permission\Models\Role::create(['name' => 'Usuario']);
        $role->givePermissionTo('ver menus');

        // or may be done by chaining
        $role = \Spatie\Permission\Models\Role::create(['name' => 'Administrador']);
        $role->givePermissionTo(\Spatie\Permission\Models\Permission::all());
    }
}
