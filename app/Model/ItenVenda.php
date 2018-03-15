<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItenVenda extends Model
{
    //
    protected $fillable = [
    	'venda_id',
    	'produto_id',
    	'quantidade',
    	'valor',
        'desconto',
        'subtotal',
        'created_at',
        'updated_at',
    ];

    public function venda(){

    	return $this->belongsTo('App\Model\Venda');
    }

    public function produto(){

    	return $this->belongsTo('App\Model\Produto');
    }
}
