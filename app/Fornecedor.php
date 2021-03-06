<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Model\Produto;

class Fornecedor extends Model
{
    protected $fillable = [
		'nome',
		'telefone',
		'endereco',
		'email',
		'nuit',
		'rubrica',
		'activo'
	];
	public $timestamps = false;

    public function produtos(){

    	return $this->hasMany('App\Model\Produto');
    	
    }
}
