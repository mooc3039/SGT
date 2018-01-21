<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ItenEntrada;
use App\Model\User;

class Entrada extends Model
{
    //

    protected $fillable = [
    	'data',
    	'valor',
    	'user_id'
    ];
    public $timestamps = false;

    public function itensEntrada(){

    	return $this->hasMany('App\Model\ItenEntrada');

    }

    public function user(){

    	return $this->belongsTo('App\Model\User');
    	
    }
}
