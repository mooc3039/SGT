<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Cliente;
use App\Model\ItenGuiaentrega;
use App\Model\Saida;
use App\User;

class GuiaEntrega extends Model
{
    //
    protected $fillable = [
    	'saida_id',
    	'cliente_id',
    	'user_id',
    	'valor_total',
    ];

    public function cliente(){

    	return $this->belongsTo('App\Model\Cliente');
    	
    }

    public function user(){

        return $this->belongsTo('App\User');
        
    }

    public function itensGuiantrega(){

        return $this->hasMany('App\Model\ItenGuiaentrega');
        
    }

    public function saida(){

        return $this->belongsTo('App\Model\Saida');
        
    }
}
