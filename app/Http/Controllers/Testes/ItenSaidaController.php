<?php

namespace App\Http\Controllers\Testes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ItenSaida;

class ItenSaidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $iten_saida;

    public function __construct(ItenSaida $iten_saida){
        $this->iten_saida = $iten_saida;
    }

    public function index()
    {
        //
        // MOSTRA OS ITENS DA SAIDA
        /*$itens_saida = $this->iten_saida->all();

        foreach ($itens_saida as $itens_sai) {
            # code...
            echo "<b>Iten da Saida:</b> $itens_sai->id <br>";
        }*/

        $itens_saida = $this->iten_saida->with('saida', 'produto')->get();

        foreach ($itens_saida as $iten) {
            # code...
            
            echo "<b>Codigo Saida:</b>".$iten->saida->id."<br>";
            echo "<b>Produto: </b>".$iten->produto->descricao."<br>";
            echo "<b>Iten-Quantidade: </b>".$iten->quantidade."<br>";
            echo "<b>Preco por Iten:</b>".$iten->valor."<br>";
            echo "<b>Saida:</b>".$iten->saida->valor_total."<br><br><br>";
        }
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
    public function update(Request $request, $id)
    {
        //
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
