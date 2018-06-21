<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    const ATLETA_ACTIVO='A';
    const ATLETA_INACTIVO='I';
    const ATLETA_SUPLENTE='S';
    const ATLETA_ACREDITADO='1';
    const ATLETA_NO_ACREDITADO='0';

    protected $fillable = [
        'codigo','event', 'place', 'date_ins', 'procedencia', 'sport', 'document', 'last_name', 'name', 'gen', 'birth_date', 'federator_num', 'notes', 'provincia', 'funcion', 'image','status'
];

    public function activo(){
        return $this->status=Athlete::ATLETA_ACTIVO;
    }

    public function inactivo(){
        return $this->status=Athlete::ATLETA_INACTIVO;
    }

    public function suplente(){
        return $this->status=Athlete::ATLETA_SUPLENTE;
    }

    public function acreditado(){
        return $this->status=Athlete::ATLETA_ACREDITADO;
    }

    //un atleta pertenece a una provincia
    public function provincia(){
        return $this->belongsTo('App\Provincia');
    }

    public function deporte(){
        return $this->belongsTo('App\Deporte');
    }

    //obtener el genero de la bbdd
    public function getGenAttribute()
    {
        if  ($this->tipo=='F'){
            return 'FEMENINO';
        }elseif ($this->tipo=='M'){
            return 'MASCULINO';
        }else {
            return false;
        }
    }


}
