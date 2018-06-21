<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AthleteEvent extends Model
{
    protected $table='athlete_event';

    protected $fillable=[
        'athlete_id','event_id'
    ];

    public $timestamps=false;

}
