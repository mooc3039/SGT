<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
  protected $table = 'cliente';
  protected $fillable =['nome','tipo','contacto','email','concurso'];
  protected $primaryKey = 'cliente_id';
  public $timestamps=false;
}
