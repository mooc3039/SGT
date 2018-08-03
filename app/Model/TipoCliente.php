<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Cliente;

class TipoCliente extends Model
{
    //
    protected $fillable = [
    	'tipo_cliente',
      'descricao',
      'acronimo',
    ];
    public $timestamps = false;


    public function clientes(){

    	return $this->hasMany('App\Model\Cliente');

    }
}
