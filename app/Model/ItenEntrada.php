<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Entrada;
use App\Model\Produto;

class ItenEntrada extends Model
{
    //

    protected $fillable = [
    	'entrada_id',
    	'produto_id',
    	'quantidade',
    	'valor',
        'desconto',
        'subtotal',
    ];

    public function entrada(){

    	return $this->belongsTo('App\Model\Entrada');
    }

    public function produto(){

    	return $this->belongsTo('App\Model\Produto');
    }
}
