<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    //
    protected $fillable = [
		'email',
		'empresa_id',
	];

	public function empresa(){
		return $this->belongsTo('App\Model\Empresa');
	}
}
