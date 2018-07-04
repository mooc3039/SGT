<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItenConcurso extends Model
{
    //
    protected $fillable = [
    	'concurso_id',
    	'produto_id',
        'quantidade',
        'quantidade_rest',
    	'preco_venda',
        'valor',
    	'valor_rest',
        'desconto',
        'subtotal',
        'subtotal_rest',
        'user_id',
    ];

    public function concurso(){

    	return $this->belongsTo('App\Model\Saida');
    }

    public function produto(){

    	return $this->belongsTo('App\Model\Produto');
    }
}
