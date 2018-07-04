<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    //
    protected $fillable = [
		'telefone',
		'empresa_id',
	];

	public function empresa(){
		return $this->belongsTo('App\Model\Empresa');
	}
}
