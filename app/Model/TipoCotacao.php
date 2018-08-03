<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Cotacao;

class TipoCotacao extends Model
{
    //
    protected $fillable = [
      'nome',
      'descricao',
      'acronimo',
    ];

    public $timestamp = false;

    public function cotacoes(){

      return $this->hasMany('App\Model\Cotacao');

    }
}
