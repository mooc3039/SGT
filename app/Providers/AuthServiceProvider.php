<?php

namespace App\Providers;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Model\Permissao;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    // protected $policies = [
    //     'App\Model' => 'App\Policies\ModelPolicy',
    // ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        // Gate::before(function(User $user, $ability){
        //     if($user->hasRole('Administrador'))
        //         return true;
        // });

        $permissoes = Permissao::with('roles')->get();

        foreach ($permissoes as $permissao) {
            // dd($permissao);
            Gate::define($permissao->nome, function(User $user) use ($permissao){
                return $user->hasAccess($permissao);
            });
        }
    }
}
