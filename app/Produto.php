<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Model\Categoria;
use App\Model\Fornecedor;
use App\Model\ItenEntrada;
use App\Model\ItenCotacao;

class Produto extends Model
{
  protected $table = 'produtos';
  protected $fillable = [
    'descricao',
    'preco_venda',
    'preco_aquisicao',
    'quantidade_dispo',
    'quantidade_min',
    'fornecedor_id',
    'categoria_id'];
  protected $primaryKey = 'id';
  public $timestamps=false;

      //
      public function categoria(){

        return $this->belongTo('App\Model\Categoria');
  
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
  
}
