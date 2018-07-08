<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Cliente;
use App\User;
use App\Model\ItenSaida;
use App\Model\GuiaEntrega;

class Saida extends Model
{
    //

    protected $fillable = [
    	'data',
    	'cliente_id',
    	'user_id',
        'valor_total',
        'iva',
    	'valor_iva',
        'pago',
        'valor_pago',
        'remanescente',
        'forma_pagamento_id',
        'nr_documento_forma_pagamento',
        'nr_referencia',
        'concurso_id',
        'aplicacao_motivo_iva',
        'motivo_iva_id',
    ];
    public $timestamps = false;

    public function cliente(){

    	return $this->belongsTo('App\Model\Cliente');
    	
    }

    public function user(){

        return $this->belongsTo('App\User');
        
    }

    public function itensSaida(){

        return $this->hasMany('App\Model\ItenSaida');
        
    }

    public function guiaEntrega(){

        return $this->hasMany('App\Model\GuiaEntrega');
        
    }

    public function pagamentosSaida(){

        return $this->hasMany('App\Model\PagamentoSaida');

    }

    public function motivoIva()
    {
      return $this->belongsTo('App\Model\MotivoIva');

    }
}
