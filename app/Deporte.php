<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deporte extends Model
{
    const DEPORTE_ACTIVO='1';
    const DEPORTE_INACTIVO='0';

    public $timestamps = false;

    protected $fillable=[
        'name','status','description',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name']=strtoupper($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description']=strtoupper($value);
    }

//    public function esActivo(){
//        return $this->status==Deporte::DEPORTE_ACTIVO;
//    }

//    public function modalities()
//    {
//        return $this->hasMany('App\Modality');
//    }
}
