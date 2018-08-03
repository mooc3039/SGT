<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ItenVendaStoreUpdateFormRequest;
use Illuminate\Http\Request;
use App\Model\ItenVenda;
use DB;
use Illuminate\Support\Facades\Gate;

class ItenVendaController extends Controller
{

    private $iten_venda;

    public function __construct(ItenVenda $iten_venda){
        $this->iten_venda = $iten_venda;
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
    public function store(ItenVendaStoreUpdateFormRequest $request)
    {
        if (Gate::denies('editar_venda'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


      $bad_symbols = array(",");

      $dataForm = [
        'venda_id' => $request->venda_id,
        'produto_id' => $request->produto_id,
        'quantidade' => $request->quantidade,
        'valor' => str_replace($bad_symbols, "", $request->valor),
        'desconto' => str_replace($bad_symbols, "", $request->desconto),
        'subtotal' => str_replace($bad_symbols, "", $request->subtotal),
    ];

    if($request->quantidade > $request->new_qtd_dispo_referencial){

        $error = "Excedeu a quantidade! Quantidade disponivel = ".$request->new_qtd_dispo_referencial;
        return redirect()->back()->with('error', $error);

    }else{

        try {

          if($this->iten_venda->create($dataForm)){

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
    public function update(ItenVendaStoreUpdateFormRequest $request, $id)
    {
        if (Gate::denies('editar_venda'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


      $bad_symbols = array(",");

      $dataForm = [
        'produto_id' => $request->produto_id,
        'quantidade' => $request->quantidade,
        'valor' => str_replace($bad_symbols, "", $request->valor),
        'desconto' => str_replace($bad_symbols, "", $request->desconto),
        'subtotal' => str_replace($bad_symbols, "", $request->subtotal),
        'venda_id' => $request->venda_id,
    ];

    $venda_id = $request->venda_id;
    $produto_id = $request->produto_id;

    DB::beginTransaction();

    try {

        if($request->quantidade > $request->qtd_dispo_referencial){
                // Validar a qtd esecificada de acordo cm a min e max para o item.

            DB::rollback();
            $error = 'Quantidade Maxima para este item: '.$request->qtd_dispo_referencial;
            return redirect()->back()->with('error', $error);

        }else{
            $iten_venda = ItenVenda::where('venda_id', $venda_id)->where('produto_id', $produto_id)->first();

            if($iten_venda->update($dataForm)){

                DB::commit();
                $sucess = 'Item actualizado com sucesso!';
                return redirect()->back()->with('success', $sucess);


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
        if (Gate::denies('editar_venda'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');

      
        $iten_venda = $this->iten_venda->findOrFail($id);

        try {

          if($iten_venda->delete()){

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
