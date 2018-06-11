<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use App\Http\Requests\ItenEntregaStoreUpdateFormRequest;
use Illuminate\Http\Request;
use App\Model\Produto;
use App\Model\ItenEntrada;
use DB;

class ItenEntradaController extends Controller
{
    private $iten_entrada;
    private $produto;

    public function __construct(ItenEntrada $iten_entrada, Produto $produto){
        $this->iten_entrada = $iten_entrada;
        $this->produto = $produto;
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
    public function store(ItenEntregaStoreUpdateFormRequest $request)
    {
        //
        //dd($request->all());
        $dataForm = [
            'entrada_id' => $request->entrada_id,
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
            'valor' => $request->valor,
            'desconto' => $request->desconto,
            'subtotal' => $request->subtotal,
        ];


        try {

          if($this->iten_entrada->create($dataForm)){

            $sucess = 'Item inserido com sucesso!';
            return redirect()->back()->with('success', $sucess);

        }else{

            $error = 'Erro ao inserir o Item!';
            return redirect()->back()->with('error', $error);

        }


    } catch (QueryException $e) {

        $error = "Erro ao inserir o Item! => Possível redundância do item/produto à mesma Entrega ($request->entrega_id).";
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
    public function update(ItenEntregaStoreUpdateFormRequest $request, $id)
    {
        //
        //dd($request->all());

        $dataForm = [
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
            'valor' => $request->valor,
            'desconto' => $request->desconto,
            'subtotal' => $request->subtotal,
            'entrada_id' => $request->entrada_id,
        ];
        
        $entrada_id = $request->entrada_id;
        $produto_id = $request->produto_id;


        try {

            if($request->quantidade_dispo < $request->qtd_dispo_referencial){

                $error = 'Quantidade Disponivel resultante desta operacao:'.$request->quantidade_dispo.' nao pode ser menor do que a Quantidade dispnivel na Base de Dados: '.$request->qtd_dispo_referencial;
                return redirect()->back()->with('error', $error);

            }else{

                $iten_entrada = ItenEntrada::where('entrada_id', $entrada_id)->where('produto_id', $produto_id)->first();

                if($iten_entrada->update($dataForm)){

                    $sucess = 'Item actualizado com sucesso!';
                    return redirect()->back()->with('success', $sucess);


                }else{
                    $error = 'Erro ao actualizar o Item!';
                    return redirect()->back()->with('error', $error);


                }
            }
        } catch (QueryException $e) {
        //echo $e;
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
        $iten_entrada = $this->iten_entrada->find($id);
        $qtd_iten_entrada = $iten_entrada->quantidade;

        $id_iten_entrada_produto = $iten_entrada->produto->id;
        $produto = $this->produto->find($id_iten_entrada_produto);
        $qtd_total_produto = $produto->quantidade_dispo;
        $qtd_min_produto = $produto->quantidade_min;

        $qtd_produto_disonivel = $qtd_total_produto - $qtd_min_produto;
        $qtd_apos_eliminar = $qtd_produto_disonivel - $qtd_iten_entrada; // A qtd apos eliminar depende da quantidade disponivel do produto e da quantidade a se eliminar que eh do item em causa. caso a qtd deste item faca com que o stock fique negativo, passa a nao ser possivel eliminat este item com esta quantidade.

        try {

            if($qtd_apos_eliminar < 0){

                $error = 'Nao e possivel eliminar esta quantidade! Apos eliminar resta uma quantidade negativa no Stock: '. $qtd_apos_eliminar;
                return redirect()->back()->with('error', $error);

            }else{

                if($iten_entrada->delete()){

                    $sucess = 'Item removido com sucesso!';
                    return redirect()->back()->with('success', $sucess);

                }else{

                    $error = 'Erro ao remover o Item!';
                    return redirect()->back()->with('error', $error);

                }
            }



        } catch (QueryException $e) {

          $error = "Erro ao remover o Item! Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!";
          return redirect()->back()->with('error', $error);

      }
  }
}
