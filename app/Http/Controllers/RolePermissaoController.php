<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Role;
use App\Model\Permissao;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Gate;

class RolePermissaoController extends Controller
{
    private $role;
    private $permissao;

    public function __construct(Role $role, Permissao $permissao){
        $this->role = $role;
        $this->permissao = $permissao;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('criar_tipo_usuario'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


      $permissoes = $this->permissao->orderBy('nome', 'asc')->get();
      $roles = DB::table('roles')->whereNotIn('id', function($query){
        $query->select('role_id')->from('permissao_role');
    })->pluck('nome', 'id')->all();

      return view('configuracao.roles_permissoes.create_edit_role_permissao', compact('permissoes', 'roles'));

  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('criar_tipo_usuario'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


      $role_id = $request->role_id;
      $permissoes = $request->check_permissoes;

      $role = $this->role->findOrFail($role_id);

      try{

        $cadastro = $role->permissoes()->attach($permissoes);

        $success = "Permissões atribuidas ao Tipo de Usúario $role->nome com sucesso.";
        return redirect()->route('role_permissao.create')->with('success', $success);

    }catch(QueryException $e){
        $error = "Não foi possível atribuir as Permissões ao Tipo de Usúario $role->nome";
        return redirect()->route('role_permissao.create')->with('error', $error);
    }


}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
