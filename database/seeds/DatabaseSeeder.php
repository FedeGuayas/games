<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        \App\Role::truncate();
        \App\User::truncate();
        \App\Residencia::truncate();
        \App\Provincia::truncate();
        \App\Deporte::truncate();


        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ProvinciaTableSeeder::class);
        $this->call(DeporteTableSeeder::class);
        $this->call(ResidenciaTableSeeder::class);

    }
}
