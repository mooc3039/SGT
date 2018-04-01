<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;

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
        $usuario = User::all();
        return view('parametrizacao.usuarios.usuario', compact('usuario')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
