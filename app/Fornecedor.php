<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
  protected $table = 'fornecedor';
  protected $fillable =['nome','contacto','email','produto','rubrica','descricao'];
  protected $primaryKey = 'fornecedor_id';
  public $timestamps=false;
}
