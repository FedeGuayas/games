<?php

use Illuminate\Database\Seeder;

class ResidenciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('residencias')->insert([
            'name' => 'PISCINA OLIMPICA',
            'status' => \App\Residencia::RESIDENCIA_ACTIVO,
        ]);
        DB::table('residencias')->insert([
            'name' => 'ESTADIO MODELO',
            'status' => \App\Residencia::RESIDENCIA_ACTIVO,
        ]);
        DB::table('residencias')->insert([
            'name' => '4 MOSQUETEROS',
            'status' => \App\Residencia::RESIDENCIA_ACTIVO,
        ]);
        DB::table('residencias')->insert([
            'name' => 'ROBERTO GILBERT',
            'status' => \App\Residencia::RESIDENCIA_ACTIVO,
        ]);
        DB::table('residencias')->insert([
            'name' => 'CEAR',
            'status' => \App\Residencia::RESIDENCIA_ACTIVO,
        ]);
        DB::table('residencias')->insert([
            'name' => 'HOTEL',
            'status' => \App\Residencia::RESIDENCIA_ACTIVO,
        ]);
        DB::table('residencias')->insert([
            'name' => 'JUDO',
            'status' => \App\Residencia::RESIDENCIA_ACTIVO,
        ]);
    }
}
