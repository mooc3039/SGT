<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Cliente;

class Cotacao extends Model
{
    //
    protected $fillable = [
    	'data',
    	'cliente_id',
    	'user_id',
    	'subtotal',
    	'desconto',
    	'valor_total'
    ];
    public $timestamps = false;

    public function cliente(){

    	return $this->belongsTo('App\Model\Cliente');
    	
    }

}
