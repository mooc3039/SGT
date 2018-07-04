<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PagamentoConcurso extends Model
{
    //
	protected $fillable = [
		'forma_pagamento_id',
		'nr_documento_forma_pagamento',
		'remanescente',
		'concurso_id',
	];

	public function concurso(){

		return $this->belongsTo('App\Model\Venda');
		
	}
	public function formaPagamento(){

		return $this->belongsTo('App\Model\FormaPagamento');
		
	}
}
