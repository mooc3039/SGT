<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Saida;
use App\Model\Produto;
use App\Model\ItenGuiaentrega;

class ItenSaida extends Model
{
    //

     protected $fillable = [
    	'saida_id',
    	'produto_id',
    	'quantidade',
    	'valor',
        'desconto',
        'subtotal',
        'quantidade_rest',
        'valor_rest',
        'subtotal_rest'
    ];
    public $timestamps = false;

    public function saida(){

    	return $this->belongsTo('App\Model\Saida');
    }

    public function produto(){

    	return $this->belongsTo('App\Model\Produto');
    }

    public function itenSaidarestante(){

        return $this->belongsTo('App\Model\ItenSaidarestante');

    }

    public function itenGuiaentrega(){

        return $this->hasOne('App\Model\ItenGuiaentrega');

    }
}
