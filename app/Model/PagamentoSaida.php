<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PagamentoSaida extends Model
{
    //
	protected $fillable = [
		'forma_pagamento_id',
		'nr_documento_forma_pagamento',
		'remanescente',
		'saida_id',
	];

	public function saida(){

		return $this->belongsTo('App\Model\Saida');
		
	}
	public function formaPagamento(){

		return $this->belongsTo('App\Model\FormaPagamento');
		
	}
}
