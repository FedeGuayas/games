<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    const EVENTO_ACTIVO='1';
    const EVENTO_INACTIVO='0';

//    protected $dates = ['created_at', 'updated_at', 'date_start','date_end'];

    public $timestamps = false;

    protected $fillable=[
        'deporte_id','provincia_id','residencia_id','tipo','date_start','date_end','notes','status'
    ];

    public function activo(){
        return $this->status=Event::EVENTO_ACTIVO;
    }

    //obtener el tipo de evento de la bbdd
//    public function getTipoAttribute()
//    {
//        if  ($this->tipo=='H'){
//            return 'HOESPEDAJE';
//        }elseif ($this->tipo=='A'){
//            return 'ALMUERZO';
//        }elseif ($this->tipo=='D'){
//            return 'DESAYUNO';
//        }elseif ($this->tipo=='M'){
//            return 'MERIENDA';
//        }
//    }

    //guardar el tipo de evento de la bbdd
//    public function setTipoAttribute($value)
//    {
//        if  ($value=='H'){
//            $this->attributes['tipo']='HOSPEDAJE';
//        }elseif ($value=='A'){
//            $this->attributes['tipo']='ALIMENTACION';
//        }
//    }

}
