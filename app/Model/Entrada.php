<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ItenEntrada;
use App\User;

class Entrada extends Model
{
    //

    protected $fillable = [
    	'fornecedor_id',
        'user_id',
    	'valor_total',
        'pago',
    	
    ];

    public function fornecedor(){

        return $this->belongsTo('App\Model\Fornecedor');
        
    }

    public function itensEntrada(){

    	return $this->hasMany('App\Model\ItenEntrada');

    }

    public function pagamentosEntrada(){

        return $this->hasMany('App\Model\PagamentoEntrada');

    }

    public function formaPagamento(){

        return $this->belongsTo('App\Model\FormaPagamento');
        
    }

    public function user(){

    	return $this->belongsTo('App\User');
    	
    }
}
