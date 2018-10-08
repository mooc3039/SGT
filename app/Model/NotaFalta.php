<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NotaFalta extends Model
{
    protected $fillable = ['user_id', 'cliente_id', 'valor_total', 'iva', 'valor_iva', 'motivo_iva_id', 'aplicacao_motivo_iva'];
    public $timestamps = false;

    public function cliente(){

    	return $this->belongsTo('App\Model\Cliente');
    	
    }

    public function user(){

        return $this->belongsTo('App\User');
        
    }

    public function saida(){

        return $this->belongsTo('App\Model\Saida');
        
    }

    public function itensNotaFalta(){

        return $this->hasMany('App\Model\ItenNotaFalta');
        
    }

    public function motivoIva()
    {
      return $this->belongsTo('App\Model\MotivoIva');

    }
}
