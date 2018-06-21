<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    const HABITACION_ACTIVA='1';
    const HABITACION_INACTIVA='0';


    protected $table = 'habitaciones';

    protected $fillable=[
        'residencia_id','numero','piso','capacidad','status'
    ];


    public function activa(){
        return $this->status=Habitacion::HABITACION_ACTIVA;
    }

    public function inactiva(){
        return $this->status=Habitacion::HABITACION_INACTIVA;
    }
}
