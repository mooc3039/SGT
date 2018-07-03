<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MotivoIva extends Model
{
    //
    protected $fillable = [
    	'motivo_nao_aplicacao'
    ];

    public function itensCotacao(){

        return $this->hasMany('App\Model\Cotacao');

    }
}
