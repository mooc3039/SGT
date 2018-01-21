<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
