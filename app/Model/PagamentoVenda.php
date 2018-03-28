<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PagamentoVenda extends Model
{
    //
	protected $fillable = [
		'forma_pagamento_id',
		'nr_documento_forma_pagamento',
		'remanescente',
		'venda_id',
	];

	public function venda(){

		return $this->belongsTo('App\Model\Venda');
		
	}
	public function formaPagamento(){

		return $this->belongsTo('App\Model\FormaPagamento');
		
	}
}
