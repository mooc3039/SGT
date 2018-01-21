<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Produto;

class Categoria extends Model
{
    //

    protected $fillable = [
    	'nome'
    ];

    
    public function produtos(){

    	return $this->hasMany('App\Model\Produto');
    }

}
