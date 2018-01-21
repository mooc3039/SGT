<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;

class produtoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::orderBy('descricao','asc')->paginate(7);
        return view('parametrizacao.produto.lista')->with('produtos',$produtos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parametrizacao.produto.novo');
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
            'tipo' => 'required ',
            'preco' => 'required | numeric',
            'fornecedor' => 'required',
            'validade' => 'required',
            
          ]);
  
          //criar fornecdor
          $produto = new Produto;
          $produto->nome = $request->input('nome');
          $produto->tipo = $request->input('tipo');
          $produto->preco = $request->input('preco');
          $produto->fornecedor = $request->input('fornecedor');
          $produto->validade = $request->input('validade');       
          $produto->save();
  
          return redirect('/produtos')->with('success', 'Produto criado com sucesso');
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
        //echo $id;
        $produto = Produto::find($id);
        return view('parametrizacao.produto.editar')->with('produto', $produto);
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
            'tipo' => 'required ',
            'preco' => 'required | numeric',
            'fornecedor' => 'required',
            'validade' => 'required',
            
          ]);
  
          //criar fornecdor
          $produto = Produto::find($id);
          $produto->nome = $request->input('nome');
          $produto->tipo = $request->input('tipo');
          $produto->preco = $request->input('preco');
          $produto->fornecedor = $request->input('fornecedor');
          $produto->validade = $request->input('validade');       
          $produto->save();
  
          return redirect('/produtos')->with('success', 'Produto actualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $produto = Produto::find($id);
        $produto->delete();
        return redirect('/produtos')->with('success', 'Produto eliminado com sucesso!');
    }
}
