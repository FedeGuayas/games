<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsProvinciaResidenciaTipoTableEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('provincia_id')->after('deporte_id')->unsigned();
            $table->integer('residencia_id')->after('provincia_id')->unsigned();
            $table->string('tipo')->after('residencia_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['provincia_id', 'residencia_id','tipo']);
        });
    }
}
