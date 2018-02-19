<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Saida;
use App\Model\Cotacao;

class Cliente extends Model
{
    //
	protected $table = 'clientes';
    protected $fillable = [
		'nome',
		'endereco',
		'telefone',
		'email',
		'nuit',
		'activo',
		'tipo_cliente_id'
	];
	public $timestamps = false;

	public function saidas(){

		return $this->hasMany('App\Model\Saida');

	}

	public function cotacoes(){

		return $this->hasMany('App\Model\Cotacao');

	}

	public function tipo_cliente(){

		return $this->belongsTo('App\Model\TipoCliente');

	}
}
