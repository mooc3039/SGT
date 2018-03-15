<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ItenSaida;

class ItenSaidarestante extends Model
{
    //

    protected $fillable = [
    	'quantidade',
    	'valor',
        'subtotal'
    ];

    public $timestamps = false;

    public function itensSaida(){

    	return $this->hasOne('App\Model\ItenSaida');

    }
}
