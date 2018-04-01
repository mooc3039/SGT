<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    //
    protected $fillable = [
		'banco',
		'numero',
		'empresa_id',
	];

	public function empresa(){
		return $this->belongsTo('App\Model\Empresa');
	}
}
