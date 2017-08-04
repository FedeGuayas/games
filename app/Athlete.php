<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    protected $fillable = [
        'codigo','event', 'place', 'date_ins', 'procedencia', 'sport', 'document', 'last_name', 'name', 'gen', 'birth_date', 'federator_num', 'notes', 'provincia', 'funcion', 'image'
];
}
