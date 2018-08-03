<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\Role;
use App\Model\Permissao;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'active', 'role_id','bday','occupation','about',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function setPasswordAttribute($password)
    {   
        $this->attributes['password'] = bcrypt($password);
    }

    public function role()
  {
    return $this->belongsTo('App\Model\Role');
  }

  public function hasAccess(Permissao $permission){
    return $this->hasRole($permission->roles);
  }

  public function hasRole($roles){
    // dd($roles);
    // Verifica se a Role do Usuario logado esta no conjunto $roles
    if($roles->count() > 0){

      if(is_array($roles) || is_object($roles)){

      foreach ($roles as $role) {

        if($this->role()->where('nome', $role->nome)->first()){
          return true;
        }

      }

      return false;
    }

    }else{

      return false;

    }
    
  }

}
 