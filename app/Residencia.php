<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Residencia extends Model
{
    const RESIDENCIA_ACTIVO='1';
    const RESIDENCIA_INACTIVO='0';

    public $timestamps = false;

    protected $fillable=[
        'name','status','capacidad','ocupado'
    ];


    public function setNameAttribute($value)
    {
        $this->attributes['name']=strtoupper($value);
    }

    public function esActivo(){
        return $this->status==RESIDENCIA::RESIDENCIA_ACTIVO;
    }
}
