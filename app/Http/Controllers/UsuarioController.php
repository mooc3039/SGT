<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\Http\Requests\UsuarioRequest;

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
    
      $usuarios = User::where('active', 1)->orderBy('name','asc')->get();
      return view('parametrizacao.usuarios.lista')->with('usuarios',$usuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $papel =Role::all();
        return view('parametrizacao.usuarios.usuario', compact('papel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioRequest $request)
    {
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
        $usuario = User::find($id);
        $papel =Role::all();
      return view('parametrizacao.usuarios.usuario', compact('usuario','papel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioRequest $request, $id)
    {
        $dataForm = $request->all();

        $usuario = $this->usuario->find($id);
  
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/usuarios')->with('success', 'Usuario eliminado com sucesso!');
    }
        public function inactivos(){

            $usuarios = $this->usuario->where('active', 0)->get();
            
            return view('parametrizacao.usuarios.lista', compact('usuarios'));
        }
        // Funcao para activar o Usuario
        public function activar($id){

            DB::select('call SP_activar_usuario(?)', array($id));
      
            return redirect()->back();
      
          }
      
          public function desactivar($id){
      
            DB::select('call SP_desactivar_usuario(?)', array($id));
      
            return redirect()->back();
            
          }

          public function storeRedirectBack(UsuarioRequest $request){

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
