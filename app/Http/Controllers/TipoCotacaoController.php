<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\TipoCotacaoStoreUpdateFormRequest;
use App\Model\TipoCotacao;

class TipoCotacaoController extends Controller
{

  private $tipo_cotacao;

  public function __construct(TipoCotacao $tipo_cotacao){
    $this->tipo_cotacao = $tipo_cotacao;
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tipos_cotacao = $this->tipo_cotacao->orderBy('nome', 'desc')->paginate(10);
        return view('cotacoes.tipos_cotacao.index_tipo_cotacao', compact('tipos_cotacao'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view ('cotacoes.tipos_cotacao.create_edit_tipos_cotacao');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoCotacaoStoreUpdateFormRequest $request)
    {
        //
        $dataForm = $request->all();

        try {

          if($this->tipo_cotacao->create($dataForm)){

            $sucess = 'Tipo de Cotação cadastrado com sucesso!';
            return redirect()->route('tipo_cotacao.index')->with('success', $sucess);

          }else{

            $error = 'Erro ao cadastrar o Tipo de Cotação!';
            return redirect()->back()->with('error', $error);

          }


        } catch (QueryException $e) {

          $error = "Erro ao cadastrar o Tipo de Cotacao. Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!";
          return redirect()->route('tipo_cotacao.index')->with('error', $error);

        }
    }


    public function storeRedirectBack(TipoCotacaoStoreUpdateFormRequest $request)
    {

      //
      $dataForm = $request->all();

      try {

        if($this->tipo_cotacao->create($dataForm)){

          $sucess = 'Tipo de Cotação cadastrado com sucesso!';
          return redirect()->back()->with('success', $sucess);

        }else{

          $error = 'Erro ao cadastrar o Tipo de Cotação!';
          return redirect()->back()->with('error', $error);

        }


      } catch (QueryException $e) {

        $error = "Erro ao cadastrar o Tipo de Cotacao. Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!";
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
        $tipo_cotacao = $this->tipo_cotacao->find($id);
        return view('cotacoes.tipos_cotacao.create_edit_tipos_cotacao', compact('tipo_cotacao'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoCotacaoStoreUpdateFormRequest $request, $id)
    {
        //
        $dataForm = $request->all();
        $tipo_cotacao = $this->tipo_cotacao->find($id);

        try {

          if($tipo_cotacao->update($dataForm)){

            $sucess = 'Tipo de Cotação actualizado com sucesso!';
            return redirect()->route('tipo_cotacao.index')->with('success', $sucess);

          }else{

            $sucess = 'Tipo de Cotação actualizado com sucesso!';
            return redirect()->back()->with('success', $sucess);
          }


        } catch (QueryException $e) {

          $error = "Erro ao actualizar o Tipo de Cotacao. Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!";
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
        //
        $tipo_cotacao = $this->tipo_cotacao->find($id);

        try {

          if($tipo_cotacao->delete()){

            $sucess = 'Tipo de Cotação removido com sucesso!';
            return redirect()->route('tipo_cotacao.index')->with('success', $sucess);

          }else{

            $sucess = 'Tipo de Cotação removido com sucesso!';
            return redirect()->back()->with('success', $sucess);
          }


        } catch (QueryException $e) {

          $error = "Erro ao remover o Tipo de Cotacao. Possivelmente <b>Registo em uso</b>. Necessária a intervenção do Administrador da Base de Dados.!";
          return redirect()->back()->with('success', $sucess);

        }

    }
}
