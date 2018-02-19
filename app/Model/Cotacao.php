<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Cliente;
use App\Model\ItenCotacao;
use App\Model\TipoCotacao;


class Cotacao extends Model
{
    //
    protected $fillable = [
    	'tipo_cotacao_id',
    	'data',
    	'cliente_id',
    	'user_id',
    	'valor_total'
    ];
    public $timestamps = false;

    public function cliente(){

    	return $this->belongsTo('App\Model\Cliente');

    }

    public function itensCotacao(){

        return $this->hasMany('App\Model\ItenCotacao');

    }

    public function tipoCotacao()
    {
      return $this->belongsTo('App\Model\TipoCotacao');

    }

}
