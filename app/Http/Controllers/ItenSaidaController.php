<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\ItenSaidaStoreUpdateFormRequest;
use App\Model\ItenSaida;
use App\Model\GuiaEntrega;
use App\Model\ItenGuiaentrega;
use DB;

class ItenSaidaController extends Controller
{
    private $iten_saida;
    private $guia_entrega;
    private $iten_guiaentrega;

    public function __construct(ItenSaida $iten_saida, GuiaEntrega $guia_entrega, ItenGuiaentrega $iten_guiaentrega){
        $this->iten_saida = $iten_saida;
        $this->guia_entrega = $guia_entrega;
        $this->iten_guiaentrega = $iten_guiaentrega;
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

        if($request->quantidade > $request->new_qtd_referencial){

            $error = "Excedeu a quantidade! Quantidade disponivel para este item = ".$request->new_qtd_referencial;
            return redirect()->back()->with('error', $error);

        }else{

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
    public function update(ItenSaidaStoreUpdateFormRequest $request, $id)
    {//dd($request->all());
        $new_quantidade = $request->quantidade;
        $old_quantidade = $request->old_quantidade;
        $qtd_mais = 0;
        $qtd_menos = 0;
        
        $dataForm = [
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
            'valor' => $request->valor,
            'desconto' => $request->desconto,
            'subtotal' => $request->subtotal,
            'saida_id' => $request->saida_id,
            // 'quantidade_rest' => $request->quantidade_rest,
            // 'valor_rest' => $request->valor_rest,
            // 'subtotal_rest' => $request->subtotal_rest,
        ];
        
        $saida_id = $request->saida_id;
        $produto_id = $request->produto_id;

        DB::beginTransaction();

        try {

            if($request->quantidade > $request->qtd_referencial || $request->quantidade < $request->qtd_referencial_min_iten_saida){
                // Validar a qtd esecificada de acordo cm a min e max para o item.

                DB::rollback();
                $error = 'Quantidade Minima para este item: '.$request->qtd_referencial_min_iten_saida.' Quantidade Maxima para este item: '.$request->qtd_referencial;
                return redirect()->back()->with('error', $error);

            }else{
                $iten_saida = ItenSaida::where('saida_id', $saida_id)->where('produto_id', $produto_id)->first();

                if($iten_saida->update($dataForm)){

                    if($new_quantidade > $old_quantidade)
                    {
                        $qtd_mais = $new_quantidade - $old_quantidade;
                        DB::select('call SP_incrementar_rest_iten_saidas(?, ?, ?)', array($qtd_mais, $saida_id, $produto_id));

                        DB::commit();
                        $sucess = 'Item actualizado com sucesso!';
                        return redirect()->back()->with('success', $sucess);

                    }elseif($new_quantidade <= $old_quantidade)
                    {

                        $qtd_menos = $old_quantidade - $new_quantidade;
                        DB::select('call SP_decrementar_rest_iten_saidas(?, ?, ?)', array($qtd_menos, $saida_id, $produto_id));

                        DB::commit();
                        $sucess = 'Item actualizado com sucesso!';
                        return redirect()->back()->with('success', $sucess);

                    }



                }else{
                    DB::rollback();
                    $error = 'Erro ao actualizar o Item!';
                    return redirect()->back()->with('error', $error);


                }

            }
        } catch (QueryException $e) {
            DB::rollback();
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
