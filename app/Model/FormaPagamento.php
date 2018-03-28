<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Venda;

class FormaPagamento extends Model
{
    //
    protected $fillable = [
      'descricao',
    ];

    public function vendas(){

      return $this->hasMany('App\Model\Venda');

    }

    public function pagamentosSaida(){

      return $this->hasMany('App\Model\PagamentoSaida');

    }
}
