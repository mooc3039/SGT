<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Cotacao;
use App\Model\Produto;

class ItenCotacao extends Model
{
    //

    protected $fillable = [
    	'cotacao_id',
    	'produto_id',
    	'quantidade',
    	'valor'
    ];

    public function cotacao(){

    	return $this->belongsTo('App\Model\Cotacao');

    }

    public function produto(){

    	return $this->belongsTo('App\Model\Produto');
    	
    }
}
