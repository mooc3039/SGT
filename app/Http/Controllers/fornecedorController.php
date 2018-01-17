<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fornecedor;

class fornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $fornecedores = Fornecedor::all();
        $fornecedores = Fornecedor::orderBy('nome','asc')->paginate(7);
        return view('parametrizacao.fornecedor.lista')->with('fornecedores',$fornecedores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('parametrizacao.fornecedor.novo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required',
            'contacto' => 'required | numeric',
            'email' => 'required | email',
            'produto' => 'required',
            'rubrica' => 'required',
            'descricao' => 'required'
          ]);
  
          //criar fornecdor
          $fornecedor = new Fornecedor;
          $fornecedor->nome = $request->input('nome');
          $fornecedor->contacto = $request->input('contacto');
          $fornecedor->email = $request->input('email');
          $fornecedor->produto = $request->input('produto');
          $fornecedor->rubrica = $request->input('rubrica');
          $fornecedor->descricao = $request->input('descricao');
          $fornecedor->save();
  
          return redirect('/fornecedores')->with('success', 'Fornecedor criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fornecedor = Fornecedor::find($id);
        return view('parametrizacao.fornecedor.editar')->with('fornecedor', $fornecedor);
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
        $this->validate($request, [
            'nome' => 'required',
            'contacto' => 'required | numeric',
            'email' => 'required | email',
            'produto' => 'required',
            'rubrica' => 'required',
            'descricao' => 'required'
          ]);
  
          //criar fornecdor
          $fornecedor = Fornecedor::find($id);
          $fornecedor->nome = $request->input('nome');
          $fornecedor->contacto = $request->input('contacto');
          $fornecedor->email = $request->input('email');
          $fornecedor->produto = $request->input('produto');
          $fornecedor->rubrica = $request->input('rubrica');
          $fornecedor->descricao = $request->input('descricao');
          $fornecedor->save();
  
          return redirect('/fornecedores')->with('success', 'Dados do Fornecedor Actualizados com Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //echo $id;
        $fornece = Fornecedor::find($id);
        $fornece->delete();
        return redirect('/fornecedores')->with('success', 'Fornecedor eliminado com sucesso!');
    }
}
