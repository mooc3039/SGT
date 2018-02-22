<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Cliente;
use App\User;
use App\Model\ItenSaida;
use App\Model\GuiaEntrega;

class Saida extends Model
{
    //

    protected $fillable = [
    	'data',
    	'cliente_id',
    	'user_id',
    	'valor_total'
    ];
    public $timestamps = false;

    public function cliente(){

    	return $this->belongsTo('App\Model\Cliente');
    	
    }

    public function user(){

        return $this->belongsTo('App\User');
        
    }

    public function itensSaida(){

        return $this->hasMany('App\Model\ItenSaida');
        
    }

    public function guiaEntrega(){

        return $this->hasMany('App\Model\GuiaEntrega');
        
    }
}
