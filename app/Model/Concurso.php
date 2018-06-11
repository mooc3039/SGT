<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Concurso extends Model
{
    //
    protected $fillable = [
    	'cliente_id',
    	'user_id',
    	'valor_total',
        'valor_iva',
        'pago',
        'valor_pago',
        'remanescente',
        'forma_pagamento_id',
        'nr_documento_forma_pagamento',
        'codigo_concurso',
    ];

    public function cliente(){

    	return $this->belongsTo('App\Model\Cliente');
    	
    }

    public function user(){

        return $this->belongsTo('App\User');
        
    }

    public function itensConcurso(){

        return $this->hasMany('App\Model\ItenConcurso');
        
    }

    public function pagamentosConcurso(){

        return $this->hasMany('App\Model\PagamentoConcurso');

    }

    public function formaPagamento(){

        return $this->belongsTo('App\Model\FormaPagamento');
        
    }
}
