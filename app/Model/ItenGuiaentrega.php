<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\GuiaEntrega;
use App\Model\Produto;
use App\Model\ItenSaida;

class ItenGuiaentrega extends Model
{
    //
    protected $fillable = [
    	'guia_entrega_id',
    	'produto_id',
    	'quantidade',
    	'valor',
    	'desconto',
        'subtotal',
    ];

    public function guiaEntrega(){

    	return $this->belongsTo('App\Model\GuiaEntrega');
    }

    public function produto(){

    	return $this->belongsTo('App\Model\Produto');
    }

    public function itenSaida(){

        return $this->belongsTo('App\Model\ItenSaida');
    }
}
