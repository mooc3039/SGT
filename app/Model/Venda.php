<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    //
    protected $fillable = [
    	'created_at',
    	'updated_at',
    	'cliente_id',
    	'user_id',
        'valor_total',
        'valor_iva',
    	'iva',
        'pago',
        'valor_pago',
        'remanescente',
        'forma_pagamento_id',
    	'nr_documento_forma_pagamento',
        'aplicacao_motivo_iva',
        'motivo_iva_id',
    ];

    public function cliente(){

    	return $this->belongsTo('App\Model\Cliente');
    	
    }

    public function user(){

        return $this->belongsTo('App\User');
        
    }

    public function itensVenda(){

        return $this->hasMany('App\Model\ItenVenda');
        
    }

    public function pagamentosVenda(){

        return $this->hasMany('App\Model\PagamentoVenda');

    }
    public function formaPagamento(){

        return $this->belongsTo('App\Model\FormaPagamento');
        
    }

    public function motivoIva()
    {
      return $this->belongsTo('App\Model\MotivoIva');

    }
}
