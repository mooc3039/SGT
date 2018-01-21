<?php

namespace App\Http\Controllers\Testes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Saida;
use App\Model\Produto;
use App\Model\Cliente;
use App\User;

class SaidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $saida;
    private $produto;
    private $cliente;
    private $user;

    public function __construct(Saida $saida, Produto $produto, Cliente $cliente, User $user){
        $this->saida = $saida;
        $this->produto = $produto;
        $this->cliente = $cliente;
        $this->user = $user;
    }

    public function index()
    {
        //
        // SAIDAS
        /*$saidas = $this->saida->all();

        foreach ($saidas as $sai) {
            # code...
            echo "<b>Saida:</b> $sai->id <br>";
        }*/


        // ==== MOSTRA TODAS AS SAIDA JUNTAMENTE COM OS ITENS DE CADA UMA
       /* $saida = $this->saida->with('itensSaida')->get(); // Eager Loading = Tras as saidas juntamente com os itens da mesma;

        
        echo "<b><h1>Saidas</h1></b>";

        foreach ($saida as $sai) { // Percorre as saidas

            echo "<b><h2>Saida Numero:".$sai->id."</h2><b>";
            echo "<b><h3>Itens da Saida:</h3></b>";

            foreach ($sai->itensSaida as $iten) { // Em cada saida encontrada sao buscados os itens da mesma

                $produto = $this->produto->find($iten->produto_id);
                
                echo "Produto: $produto->descricao <br>";
                echo "Preco Unitario: $produto->preco_venda <br>";
                echo "Quantidade: $iten->quantidade <br>";
                echo "Valor: $iten->valor <br><br>";
                
            }
            echo "<h3><b>Valor Total: </b>".$sai->valor_total."</h3><br>=====================================";
            //dump($sai);
        }*/

        // ==== MOSTRA UMA SAIDA JUNTAMENTE COM OS SEUS ITENS
        $saida = $this->saida->with('itensSaida')->find(2);

        echo "<h1><b> Saida Numero: $saida->id </b></h1>";
        echo "<h2><b> Produtos: </b></h2>";

        foreach ($saida->itensSaida as $iten_saida) {

        
            $produto = $this->produto->find($iten_saida->produto_id);
            $cliente = $this->cliente->find($saida->cliente_id);
            $user = $this->user->find($saida->user_id);

            echo "Produto: $produto->descricao <br>";
            echo "Preco Unitario: $produto->preco_venda <br>";
            echo "Quantidade: $iten_saida->quantidade. <br>";
            echo "Valor: $iten_saida->valor. </br>";
            echo "Cliente: $cliente->nome </br>===============<br><br>";
            

        }

        echo "<h2><b> Sub-Total: $saida->subtotal </b></h2>";
        echo "<h2><b> Valor Total: $saida->valor_total </b></h2>";
        echo "Emitida por: $user->name </br>";
        
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
