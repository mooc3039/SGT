<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\GuiaEntrega;
use App\Model\Produto;

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
        'quantidade_rest_iten_saida',
    ];

    public function guiaEntrega(){

    	return $this->belongsTo('App\Model\GuiaEntrega');
    }

    public function produto(){

    	return $this->belongsTo('App\Model\Produto');
    }
}
