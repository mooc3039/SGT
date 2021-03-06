<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\ItenGuiaEntregaStoreUpdateFormRequest;
use App\Model\ItenGuiaentrega;
use Illuminate\Support\Facades\Gate;

class ItenGuiaEntregaController extends Controller
{
    private $iten_guia_entrega;

    public function __construct(ItenGuiaentrega $iten_guia_entrega){
        $this->iten_guia_entrega = $iten_guia_entrega;
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
    public function update(ItenGuiaEntregaStoreUpdateFormRequest $request, $id)
    {
        if (Gate::denies('editar_guia_entrega'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


      $bad_symbols = array(",");

      $dataForm = [
        'quantidade' => $request->quantidade,
        'valor' => str_replace($bad_symbols, "", $request->valor),
        'desconto' => str_replace($bad_symbols, "", $request->desconto),
        'subtotal' => str_replace($bad_symbols, "", $request->subtotal),
    ];


    $guia_entrega_id = $request->guia_entrega_id;
    $produto_id = $request->produto_id;

    try {

        if($request->quantidade > $request->qtd_referencial){
            // Validar a qtd esecificada de acordo cm a max para o item.

            $error = 'A quantidade especificada excedeu o limite!';
            return redirect()->back()->with('error', $error);

        }else{

            $iten_guia_entrega = ItenGuiaentrega::where('guia_entrega_id', $guia_entrega_id)->where('produto_id', $produto_id)->first();

            if($iten_guia_entrega->update($dataForm)){

                $sucess = 'Item actualizado com sucesso!';
                return redirect()->back()->with('success', $sucess);

            }else{

                $error = 'Erro ao actualizar o Item!';
                return redirect()->back()->with('error', $error);

            }
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
    }
}
