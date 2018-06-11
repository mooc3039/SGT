<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Categoria;
use App\Model\Fornecedor;
use App\Model\ItenEntrada;
use App\Model\ItenSaida;
use App\Model\ItenCotacao;
use App\Model\ItenGuiaentrega;

class Produto extends Model
{
    protected $fillable = [
        'descricao',
        'quantidade_dispo',
        'quantidade_min',
        'preco_venda',
        'preco_aquisicao',
        'fornecedor_id',
        'categoria_id'
    ];
    public $timestamps = false;

    //
    public function categoria(){

    	return $this->belongsTo('App\Model\Categoria');

    }

    public function fornecedor(){

    	return $this->belongsTo('App\Model\Fornecedor');

    }

    public function itenEntrada(){

    	return $this->hasOne('App\Model\ItenEntrada');

    }

    public function ItenCotacao(){

        return $this->hasOne('App\Model\ItenCotacao');

    }

    public function ItenSaida(){

        return $this->hasOne('App\Model\ItenSaida');

    }

    public function ItenGuiaentrega(){

        return $this->hasOne('App\Model\ItenGuiaentrega');

    }


}
