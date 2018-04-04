<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Me extends Model
{
    //
    protected $fillable = [
    	'nome',
    ];
    public $timestamps = false;
}
