<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_usuario = \App\Role::where('name', 'usuario')->first();
        $role_admin  = \App\Role::where('name', 'admin')->first();

        $admin = new \App\User();
        $admin->name = 'Admin';
        $admin->first_name = 'Administrador';
        $admin->last_name = 'Fedeguayas';
        $admin->email = 'admin@mail.com';
        $admin->password = bcrypt('QeChsL8P4Fs4pZFM');
        $admin->save();
        $admin->roles()->attach($role_admin);

        $usuario = new \App\User();
        $usuario->name = 'Gestor';
        $usuario->first_name = 'Usuario';
        $usuario->last_name = 'Gestor';
        $usuario->email = 'usuario@mail.com';
        $usuario->password = bcrypt('DJNqeloEbzAltZfb');
        $usuario->save();
        $usuario->roles()->attach($role_usuario);

    }
}
