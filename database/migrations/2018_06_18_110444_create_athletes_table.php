<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAthletesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('athletes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->nullable();//cod
            $table->string('event')->nullable();//evento
            $table->string('place')->nullable();//lugar
            $table->date('date_ins')->nullable();//fecha inscripcion
            $table->string('procedencia')->nullable();//participa por
//            $table->string('sport');//deporte
            $table->integer('deporte_id')->unsigned()->nullable();//deporte
            $table->char('document');//ci
            $table->string('last_name');//apellidos
            $table->string('name');//nombres
            $table->char('gen', 1)->nullable();//genero
            $table->date('birth_date')->nullable();//fecha nacimiento
            $table->string('federator_num')->nullable();//numero federador
            $table->string('notes')->nullable();//observaciones
//            $table->string('provincia');//provincia
            $table->integer('provincia_id')->unsigned();//provincia
            $table->string('funcion');//Deportista, Entrenador
            $table->string('image');//foto del atleta=ci.jpg
            $table->string('status')->default(\App\Athlete::ATLETA_ACTIVO);
            $table->string('acreditado')->default(\App\Athlete::ATLETA_NO_ACREDITADO);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('athletes');
    }
}
