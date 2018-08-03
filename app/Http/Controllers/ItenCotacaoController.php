<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\ItenCotacaoStoreUpdateFormRequest;
use App\Model\ItenCotacao;
use Illuminate\Support\Facades\Gate;

class ItenCotacaoController extends Controller
{

  private $iten_cotacao;

  public function __construct(ItenCotacao $iten_cotacao){

    $this->iten_cotacao = $iten_cotacao;
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
    //
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(ItenCotacaoStoreUpdateFormRequest $request)
  {
    if (Gate::denies('editar_cotacao'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');


    $bad_symbols = array(",");
    $iten_cotacao = new ItenCotacao;

    $iten_cotacao->cotacao_id = $request['cotacao_id'];
    $iten_cotacao->produto_id = $request['produto_id'];
    $iten_cotacao->quantidade = str_replace($bad_symbols, "", $request['quantidade']);
    $iten_cotacao->valor = str_replace($bad_symbols, "", $request['valor']);
    $iten_cotacao->desconto = str_replace($bad_symbols, "", $request['desconto']);
    $iten_cotacao->subtotal = str_replace($bad_symbols, "", $request['subtotal']);

    try {

      if($iten_cotacao->save()){

        $sucess = 'Item inserido com sucesso!';
        return redirect()->back()->with('success', $sucess);

      }else{

        $error = 'Erro ao inserir o Item!';
        return redirect()->back()->with('error', $error);

      }


    } catch (QueryException $e) {

      $error = "Erro ao inserir o Item! => Possível redundância do item/produto à mesma cotação ($request->cotacao_id).";
      return redirect()->back()->with('error', $error);

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
  public function update(ItenCotacaoStoreUpdateFormRequest $request, $id)
  {
    if (Gate::denies('editar_cotacao'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');

    
    $bad_symbols = array(",");
    $cotacao_id = $request->cotacao_id;
    $produto_id = $request->produto_id;

    try {

      $iten_cotacao = ItenCotacao::where('cotacao_id', $cotacao_id)->where('produto_id', $produto_id)->first();

      $iten_cotacao->cotacao_id = $request['cotacao_id'];
      $iten_cotacao->produto_id = $request['produto_id'];
      $iten_cotacao->quantidade = str_replace($bad_symbols, "", $request['quantidade']);
      $iten_cotacao->valor = str_replace($bad_symbols, "", $request['valor']);
      $iten_cotacao->desconto = str_replace($bad_symbols, "", $request['desconto']);
      $iten_cotacao->subtotal = str_replace($bad_symbols, "", $request['subtotal']);

      if($iten_cotacao->update()){

        $sucess = 'Item actualizado com sucesso!';
        return redirect()->back()->with('success', $sucess);

      }else{

        $error = 'Erro ao actualizar o Item!';
        return redirect()->back()->with('error', $error);

      }


    } catch (QueryException $e) {

      $error = 'Erro ao actualizar o Item! Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!';
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
    if (Gate::denies('editar_cotacao'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');

    
    $iten_cotacao = $this->iten_cotacao->findOrFail($id);

    try {

      if($iten_cotacao->delete()){

        $sucess = 'Item removido com sucesso!';
        return redirect()->back()->with('success', $sucess);

      }else{

        $error = 'Erro ao remover o Item!';
        return redirect()->back()->with('error', $error);

      }

    } catch (QueryException $e) {

      $error = "Erro ao remover o Item! Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!";
      return redirect()->back()->with('error', $error);

    }

  }
}
