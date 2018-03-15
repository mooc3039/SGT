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
        'pago',
        'valor_pago',
        'troco',
        'forma_pagamento_id',
    	'nr_documento_forma_pagamento',
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
    public function formaPagamento(){

        return $this->belongsTo('App\Model\FormaPagamento');
        
    }
}
