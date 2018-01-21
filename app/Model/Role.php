<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Model\Permissao;

class Role extends Model
{
    //
    protected $fillable = [
    	'nome'
    ];
    public $timestamps = false;


    public function useres(){

    	return $this->hasMany('App\Model\User'); // A role esta para varios usuarios

    }

    public function permissoes(){

    	return $this->belongsToMany('App\Model\Permissao'); // Existem varias permissoes para a role e vice-versa

    }
}
