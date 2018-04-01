<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    //
    protected $fillable = [
		'endereco',
		'empresa_id',
	];

	public function empresa(){
		return $this->belongsTo('App\Model\Empresa');
	}
}
