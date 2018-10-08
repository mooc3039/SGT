<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItenNotaFalta extends Model
{
    protected $fillable = [
    	'nota_falta_id',
    	'produto_id',
    	'quantidade',
    	'valor',
        'desconto',
        'subtotal',
    ];
    public $timestamps = false;

    public function notaFalta(){

    	return $this->belongsTo('App\Model\NotaFalta');
    }

    public function produto(){

    	return $this->belongsTo('App\Model\Produto');
    }
}
