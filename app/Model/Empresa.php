<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    //
    protected $fillable = [
		'nome',
		'actuacao',
		'nuit',
		'fax',
	];

	public function contas(){
		return $this->hasMany('App\Model\Conta');
	}

	public function enderecos(){
		return $this->hasMany('App\Model\Endereco');
	}

	public function telefones(){
		return $this->hasMany('App\Model\Telefone');
	}

	public function emails(){
		return $this->hasMany('App\Model\Email');
	}
}
