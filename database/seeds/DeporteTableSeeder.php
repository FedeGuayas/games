<?php

use Illuminate\Database\Seeder;

class DeporteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deportes')->insert([
            'name' => 'AGUAS ABIERTAS',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'AJEDREZ',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'ATLETISMO',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'BALONCESTO',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'BOXEO',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'CICLISMO BMX',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'CICLISMO PISTA Y RUTA',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'ESCALADA DEPORTIVA',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'FUTBOL',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'GIMNASIA ARTISTICA',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'GIMNASIA RITMICA',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'LEVANTAMIENTO DE PESAS',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'JUDO',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'KARATE DO',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'LUCHA',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'NATACION',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'PATINAJE',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'POOMSAE',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'TAE KWON DO',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'TENIS DE MESA',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'TRIATLON',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'VOLEIBOL',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
        DB::table('deportes')->insert([
            'name' => 'VOLEIBOL PLAYA',
            'description'=>null,
            'status' => \App\Deporte::DEPORTE_ACTIVO,
        ]);
    }
}
