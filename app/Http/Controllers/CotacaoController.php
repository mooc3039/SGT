<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Produto;
use App\Model\Cliente;
use App\User;
use App\Model\Cotacao;

class CotacaoController extends Controller
{
    
    private $cotacao;
    private $produto;
    private $cliente;
    private $user;

    public function __construct(Cotacao $cotacao, Produto $produto, Cliente $cliente, User $user){

        $this->cotacao = $cotacao;
        $this->produto = $produto;
        $this->cliente = $cliente;
        $this->user = $user;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cotacoes = $this->cotacao->orderBy('data', 'asc')->paginate(10);
        
        return view('cotacoes.index_cotacao', compact('cotacoes'));

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
        $cotacao = $this->cotacao->with('itensCotacao.produto', 'cliente')->find($id); // Tras a saida. Tras os Itens da Saida e dentro da relacao ItensSaida eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na saida e sim na itensSaida, mas eh possivel ter os seus dados partido da saida como se pode ver.
        
        return view('cotacoes.show_cotacao', compact('cotacao'));
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

    public function reportGeralCotacoes(){

        $cotacoes = $this->cotacao->with('cliente')->orderBy('id', 'asc')->get();

        return view('reports.cotacoes.report_geral_cotacoes', compact('cotacoes', 'valor_total_saidas'));

    }
}
