<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $fillable = [
        'code', 'province',
    ];

    //una provincia tiene muchos atletas
    public function atletas(){
        return $this->hasMany('App\Athlete');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
