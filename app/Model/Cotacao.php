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
    	'cliente_id',
    	'user_id',
        'valor_total',
        'valor_iva',
        'iva',
        'validade',
        'aplicacao_motivo_iva',
    	'motivo_iva_id',
    ];
    public $timestamps = true;

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

    public function motivoIva()
    {
      return $this->belongsTo('App\Model\MotivoIva');

    }

}
