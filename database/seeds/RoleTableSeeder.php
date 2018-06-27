<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_usuario = new \App\Role();
        $role_usuario->name = 'usuario';
        $role_usuario->description = 'Usuario limitado';
        $role_usuario->save();

        $role_admin = new \App\Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'Usuario administrador';
        $role_admin->save();
    }
}
