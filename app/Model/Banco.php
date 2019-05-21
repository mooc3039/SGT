<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    //
    protected $fillable = [
    	'nome'
    ];

    public $timestamps = false;

    public function pagamentosSaida(){
    	return $this->hasMany('App\Model\PagamentoSaida');
    }
}
