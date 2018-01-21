<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Saida;
use App\Model\Produto;

class ItenSaida extends Model
{
    //

     protected $fillable = [
    	'saida_id',
    	'produto_id',
    	'quantidade',
    	'valor_total'
    ];
    public $timestamps = false;

    public function saida(){

    	return $this->belongsTo('App\Model\Saida');
    }

    public function produto(){

    	return $this->belongsTo('App\Model\Produto');
    }
}
