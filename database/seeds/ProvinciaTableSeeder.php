<?php

use Illuminate\Database\Seeder;

class ProvinciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provincias')->insert([
            'code' => '01',
            'province'=>'AZUAY',
        ]);
        DB::table('provincias')->insert([
            'code' => '02',
            'province'=>'BOLIVAR',
        ]);
        DB::table('provincias')->insert([
            'code' => '03',
            'province'=>'CAÑAR',
        ]);
        DB::table('provincias')->insert([
            'code' => '04',
            'province'=>'CARCHI',
        ]);
        DB::table('provincias')->insert([
            'code' => '05',
            'province'=>'COTOPAXI',
        ]);
        DB::table('provincias')->insert([
            'code' => '06',
            'province'=>'CHIMBORAZO',
        ]);
        DB::table('provincias')->insert([
            'code' => '07',
            'province'=>'EL ORO',
        ]);
        DB::table('provincias')->insert([
            'code' => '08',
            'province'=>'ESMERALDAS',
        ]);
        DB::table('provincias')->insert([
            'code' => '09',
            'province'=>'GUAYAS',
        ]);
        DB::table('provincias')->insert([
            'code' => '10',
            'province'=>'IMBABURA',
        ]);
        DB::table('provincias')->insert([
            'code' => '11',
            'province'=>'LOJA',
        ]);
        DB::table('provincias')->insert([
            'code' => '12',
            'province'=>'LOS RIOS',
        ]);
        DB::table('provincias')->insert([
            'code' => '13',
            'province'=>'MANABI',
        ]);
        DB::table('provincias')->insert([
            'code' => '14',
            'province'=>'MORONA SANTIAGO',
        ]);
        DB::table('provincias')->insert([
            'code' => '15',
            'province'=>'NAPO',
        ]);
        DB::table('provincias')->insert([
            'code' => '16',
            'province'=>'PASTAZA',
        ]);
        DB::table('provincias')->insert([
            'code' => '17',
            'province'=>'PICHINCHA',
        ]);
        DB::table('provincias')->insert([
            'code' => '18',
            'province'=>'TUNGURAHUA',
        ]);
        DB::table('provincias')->insert([
            'code' => '19',
            'province'=>'ZAMORA CHINCHIPE',
        ]);
        DB::table('provincias')->insert([
            'code' => '20',
            'province'=>'GALAPAGOS',
        ]);
        DB::table('provincias')->insert([
            'code' => '21',
            'province'=>'SUCUMBIOS',
        ]);
        DB::table('provincias')->insert([
            'code' => '22',
            'province'=>'ORELLANA',
        ]);
        DB::table('provincias')->insert([
            'code' => '23',
            'province'=>'SANTO DOMINGO DE LOS TSACHILAS',
        ]);
        DB::table('provincias')->insert([
            'code' => '24',
            'province'=>'SANTA ELENA',
        ]);
        DB::table('provincias')->insert([
            'code' => '90',
            'province'=>'ZONAS NO DELIMITADAS',
        ]);
    }
}
