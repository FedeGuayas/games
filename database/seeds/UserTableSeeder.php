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
        DB::table('users')->insert([
            'name' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'System',
            'email' => 'admin@mail.com',
            'password' => bcrypt('11111111'),
        ]);
        DB::table('users')->insert([
            'name' => 'gestor',
            'first_name' => 'Gestor',
            'last_name' => 'Sistema',
            'email' => 'gestor@mail.com',
            'password' => bcrypt('111111'),
        ]);

    }
}
