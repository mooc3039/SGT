<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\ItenSaidaStoreUpdateFormRequest;
use App\Model\ItenSaida;

class ItenSaidaController extends Controller
{
    private $iten_saida;

    public function __construct(ItenSaida $iten_saida){
        $this->iten_saida = $iten_saida;
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
    public function store(ItenSaidaStoreUpdateFormRequest $request)
    {
        //
        $dataForm = [
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
            'valor' => $request->valor,
            'desconto' => $request->desconto,
            'subtotal' => $request->subtotal,
            'saida_id' => $request->saida_id,
            'quantidade_rest' => $request->quantidade,
            'valor_rest' => $request->valor,
            'subtotal_rest' => $request->subtotal,
        ];

        try {

          if($this->iten_saida->create($dataForm)){

            $sucess = 'Item inserido com sucesso!';
            return redirect()->back()->with('success', $sucess);

        }else{

            $error = 'Erro ao inserir o Item!';
            return redirect()->back()->with('error', $error);

        }


    } catch (QueryException $e) {

        $error = "Erro ao inserir o Item! => Possível redundância do item/produto à mesma cotação ($request->saida_id).";
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
    public function update(Request $request, $id)
    {
        //
        $dataForm = $request->all();
        $saida_id = $request->saida_id;
        $produto_id = $request->produto_id;

        try {

          $iten_saida = ItenSaida::where('saida_id', $saida_id)->where('produto_id', $produto_id)->first();

          if($iten_saida->update($dataForm)){

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
        //
        $iten_saida = $this->iten_saida->find($id);

        try {

          if($iten_saida->delete()){

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