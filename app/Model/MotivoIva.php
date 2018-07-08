<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MotivoIva extends Model
{
    //
    protected $fillable = [
    	'motivo_nao_aplicacao'
    ];
    public $timestamps = false;

    public function cotacoes(){

        return $this->hasMany('App\Model\Cotacao');

    }

    public function saidas(){

        return $this->hasMany('App\Model\Saida');

    }

    public function vendas(){

        return $this->hasMany('App\Model\Venda');

    }
}
