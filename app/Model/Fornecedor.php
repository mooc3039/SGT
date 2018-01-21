<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    //
    public function produtos(){

    	return $this->hasMany('App\Model\Produto');
    	
    }
}
