<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //Un role es compartido por varios usuarios
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
