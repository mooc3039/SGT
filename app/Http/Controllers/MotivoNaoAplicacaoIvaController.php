<?php

namespace App\Http\Controllers;

// use Illuminate\Database\QueryException;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\MotivoNaoAplicacaoIvaStoreUpdateFormRequest;
use App\Model\MotivoIva;

class MotivoNaoAplicacaoIvaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $motivo_nao_aplicacao_iva;

    public function __construct(MotivoIva $motivo_nao_aplicacao_iva){
        $this->motivo_nao_aplicacao_iva = $motivo_nao_aplicacao_iva;
    }

    public function index()
    {
        //
        $motivos_nao_aplicacao_iva = $this->motivo_nao_aplicacao_iva->get();
        return view('parametrizacao.nao_aplicacao_iva.index_nao_aplicacao_iva', compact('motivos_nao_aplicacao_iva'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view ('parametrizacao.nao_aplicacao_iva.create_edit_nao_aplicacao_iva');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MotivoNaoAplicacaoIvaStoreUpdateFormRequest $request)
    {
        //
        $dataForm = $request->all();

        try {

          if($this->motivo_nao_aplicacao_iva->create($dataForm)){

            $sucess = 'Motivo da Não aplicação do IVA cadastrado com sucesso!';
            return redirect()->route('motivo_nao_aplicacao_iva.index')->with('success', $sucess);

          }else{

            $error = 'Erro ao cadastrar o Tipo de Cliente!';
            return redirect()->back()->with('error', $error);

          }


        } catch (QueryException $e) {

          $error = "Erro ao cadastrar o Motivo da Não aplicação do IVA. Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!";
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
        $motivo_nao_aplicacao_iva = $this->motivo_nao_aplicacao_iva->findOrFail($id);
        return view('parametrizacao.nao_aplicacao_iva.create_edit_nao_aplicacao_iva', compact('motivo_nao_aplicacao_iva'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MotivoNaoAplicacaoIvaStoreUpdateFormRequest $request, $id)
    {
        //
        $dataForm = $request->all();
        $motivo_nao_aplicacao_iva = $this->motivo_nao_aplicacao_iva->findOrFail($id);

        try {

          if($motivo_nao_aplicacao_iva->update($dataForm)){

            $sucess = 'Motivo da Não aplicação do IVA actualizado com sucesso!';
            return redirect()->route('motivo_nao_aplicacao_iva.index')->with('success', $sucess);

          }else{

            $error = 'Erro ao cadastrar o Motivo da Não aplicação!';
            return redirect()->back()->with('error', $error);
          }


        } catch (QueryException $e) {

          $error = "Erro ao actualizar o Motivo da Não aplicação do IVA. Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!";
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
        $motivo_nao_aplicacao_iva = $this->motivo_nao_aplicacao_iva->findOrFail($id);

        try {

          if($motivo_nao_aplicacao_iva->delete()){

            $sucess = 'Motivo da Não aplicação do IVA removido com sucesso!';
            return redirect()->route('motivo_nao_aplicacao_iva.index')->with('success', $sucess);

          }else{

            $error = 'Erro ao remover o Motivo da Não aplicação do IVA!';
            return redirect()->back()->with('error', $error);
          }


        } catch (QueryException $e) {

          $error = "Erro ao remover o Motivo da Não aplicação do IVA. Possivelmente <b>Registo em uso</b>. Necessária a intervenção do Administrador da Base de Dados.!";
          return redirect()->back()->with('error', $error);

        }
    }
}
