<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Produto;

class Fornecedor extends Model
{
    //

	protected $fillable = [
		'nome',
		'telefone',
		'endereco',
		'email',
		'rubrica',
		'activo',
		'nuit'
	];
	public $timestamps = false;

    public function produtos(){

    	return $this->hasMany('App\Model\Produto');
    	
    }
}
