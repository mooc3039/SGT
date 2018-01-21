<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Role;

class Permissao extends Model
{
    //
    protected $fillable = [
    	'nome'
    ];
    public $timestamp = false;

    public function roles(){

    	return $this->belongsToMany('App\Model\Role');

    }
    
}
