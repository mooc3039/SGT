<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
  protected $table = 'produto';
  protected $fillable =['nome','tipo','preco','fornecedor','validade'];
  protected $primaryKey = 'produto_id';
  public $timestamps=false;
}
