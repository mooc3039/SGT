<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleStoreUpdateFormRequest;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Model\Role;
use App\Model\Permissao;
use DB;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    protected $role;
    protected $permissao;

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
        if (Gate::denies('listar_tipo_usuario'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


      $roles = $this->role->get();

      return view('configuracao.roles.index_role', compact('roles'));
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
      return view('configuracao.roles.create_edit_role', compact('permissoes'));
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreUpdateFormRequest $request)
    {
        if (Gate::denies('criar_tipo_usuario'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


      $dataForm = $request->all();


      $permissoes = $request->check_permissoes;

      try{

        $role = $this->role->create($dataForm);
        $role_id = $role->id;
        $role->permissoes()->attach($permissoes);

        $success = "Tipo de Usúario cadastrado com sucesso.";
        return redirect()->route('role.create')->with('success', $success);

    }catch(QueryException $e){
        $error = "Não foi possível cadastrar o Tipo de Usúario";
        return redirect()->route('role.create')->with('error', $error);
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
        if (Gate::denies('editar_tipo_usuario'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


      $role = $this->role->findOrFail($id);
      $permissoes = $this->permissao->orderBy('nome', 'asc')->get();

      return view('configuracao.roles.create_edit_role', compact('role', 'permissoes'));
  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleStoreUpdateFormRequest $request, $id)
    {
        if (Gate::denies('editar_tipo_usuario'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


      $dataForm = $request->all();
      $permissoes = $request->check_permissoes;

      $role = $this->role->findOrFail($id);



      DB::beginTransaction();

      try{

        $role->update($dataForm);
        $role->permissoes()->detach();
        $role->permissoes()->attach($permissoes);

        DB::commit();

        $success = "Tipo de Usúario actualizado com sucesso.";
        return redirect()->route('role.index')->with('success', $success);

    }catch(QueryException $e){
        DB::rollback();
        $error = "Não foi possível actualizar o Tipo de Usúario.";
        return redirect()->route('role.index')->with('error', $error);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('editar_tipo_usuario'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


      $role = $this->role->findOrFail($id);

      try{

        $delete = $role->delete();

        if($delete){

            $sucesso = "Removido com sucesso!";

            return redirect()->route('role.index')->with('success', $sucesso);
        }
        else{

            $erro = "Erro ao remover!";

            return redirect()->route('role.index')->with('error', $erro);
        }
    }catch (QueryException $e){

        $erro_fk = "Não foi possível remover o registo";

        if($e->getCode()==23000){

            $erro_fk = "Registo em uso! Não foi possível remover o registo!";

                // return view('parametrizacao.role.index_role')->with('error', $erro_fk);
            return redirect()->route('role.index')->with('error', $erro_fk);

        }
        else{
            $erro_fk = "Registo em uso! Não foi possível remover o registo!";
                //return view('parametrizacao.role.index_role')->with('error', $erro_fk);
            return redirect()->route('role.index')->with('error', $erro_fk);
        }
    }
}
}
