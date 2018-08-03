<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Model\Role;
use App\Http\Requests\UsuarioRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Http\Requests\AlterarLoginRequest;
use Illuminate\Support\Facades\Gate;

class UsuarioController extends Controller
{
    private $usuario;

    public function __construct(User $usuario){

      $this->usuario = $usuario;

  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('listar_usuario'))
          return redirect()->route('noPermission');

      $usuarios = $this->usuario->all();
      return view('parametrizacao.usuarios.lista', compact('usuarios'));
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('criar_usuario'))
          return redirect()->route('noPermission');


        $roles = DB::table('roles')->pluck('nome', 'id')->all();
        return view('parametrizacao.usuarios.usuario', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioRequest $request)
    {
        if (Gate::denies('criar_usuario'))
          return redirect()->route('noPermission');


        $dataForm = $request->all();

        $cadastro = $this->usuario->create($dataForm);

        if($cadastro){

            $success = "Usuário cadastrado com sucesso.";
            return redirect()->route('usuarios.index')->with('success', $success);
        }
        else{

            $error = "Não foi possível cadastrar o Usuário.";
            return redirect()->route('usuarios.index')->with('error', $error);
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
        if (Gate::denies('editar_usuario'))
          return redirect()->route('noPermission');


        $usuario = User::findOrFail($id);
        $roles = DB::table('roles')->pluck('nome', 'id')->all();
        return view('parametrizacao.usuarios.usuario', compact('usuario','roles'));
    }

    public function createAlterarSenhUsuarioa($id)
    {
        // if (Gate::denies('editar_login'))
        //   return redirect()->route('noPermission');


        $usuario = User::findOrFail($id);
        return view('auth.passwords.alterar_senha_usuario', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioUpdateRequest $request, $id)
    {
        // dd($request->all());
        if (Gate::denies('editar_usuario'))
          return redirect()->route('noPermission');


        $dataForm = [
            'role_id'=>$request->role_id,
            'name'=>$request->name,
            'about'=>$request->about,
            'endereco'=>$request->endereco,
            'bday'=>$request->bday,
            'occupation'=>$request->occupation,
            'email'=>$request->email,
            'telefone'=>$request->telefone,
            'active'=>$request->active,
        ];

        $usuario = $this->usuario->findOrFail($id);

        $update = $usuario->update($dataForm);

        if($update){

          $success = "Usuário actualizado com sucesso.";
          return redirect()->route('usuarios.index')->with('success', $success);
      }
      else{

          $error = "Não foi possível actualizar o Usuário.";
          return redirect()->route('usuarios.index')->with('error', $error);
      }
  }

  public function AlterarSenhUsuarioa(AlterarLoginRequest $request, $id)
    {
        // if (Gate::denies('editar_login'))
        //   return redirect()->route('noPermission');

        $usuario = User::findOrFail($id);

        $dataForm = [
            'username' => $request->username,
            'password' => $request->senha,
        ];

        try{
            $usuario->update($dataForm);

            $success = "Senha alterada com sucesso.";
          return redirect()->route('dashboard')->with('success', $success);

        }catch(QueryException $e){
            $error = "Não foi possível alterar a senha.";
          return redirect()->back()->with('error', $error);
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
        if (Gate::denies('apagar_usuario'))
          return redirect()->route('noPermission');


        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/usuarios')->with('success', 'Usuario eliminado com sucesso!');
    }

    public function activos(){

      if (Gate::denies('listar_usuario'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');

      $usuarios = $this->usuario->where('active', 1)->get();
      
      return view('parametrizacao.usuarios.lista', compact('usuarios'));
    }

    public function inactivos(){

        $usuarios = $this->usuario->where('active', 0)->get();

        return view('parametrizacao.usuarios.lista', compact('usuarios'));
    }
        // Funcao para activar o Usuario
    public function activar($id){

        if (Gate::denies('activar_usuario'))
          return redirect()->route('noPermission');

        DB::select('call SP_activar_usuario(?)', array($id));

        return redirect()->back();

    }

    public function desactivar($id){

        if (Gate::denies('desactivar_usuario'))
          return redirect()->route('noPermission');

        DB::select('call SP_desactivar_usuario(?)', array($id));

        return redirect()->back();

    }

    public function storeRedirectBack(UsuarioRequest $request){

        if (Gate::denies('criar_usuario'))
          return redirect()->route('noPermission');

        $usuario = $this->usuario->all();

        $dataForm = $request->all();

        $cadastro = $this->usuario->create($dataForm);

        if($cadastro){

            $success = "Usuário cadastrado com sucesso.";
            return redirect()->back()->with('success', $success);
        }
        else{

            $error = "Não foi possível cadastrar o Usuário.";
            return redirect()->back()->with('error', $error);
        }

    }
}
