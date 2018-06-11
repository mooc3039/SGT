<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PagamentoEntrada extends Model
{
    //
    protected $fillable = [
		'forma_pagamento_id',
		'nr_documento_forma_pagamento',
		'remanescente',
		'entrada_id',
	];

	public function entrada(){

		return $this->belongsTo('App\Model\Entrada');
		
	}
	public function formaPagamento(){

		return $this->belongsTo('App\Model\FormaPagamento');
		
	}
}
