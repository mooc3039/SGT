<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Saida;
use App\Model\Produto;
use App\Model\Cliente;
use App\User;
use PDF;

class SaidaController extends Controller
{

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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $saidas = $this->saida->all();

        return view('saidas.index_saida', compact('saidas'));

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

        $saida = $this->saida->with('itensSaida.produto', 'cliente')->find($id); // Tras a saida. Tras os Itens da Saida e dentro da relacao ItensSaida eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na saida e sim na itensSaida, mas eh possivel ter os seus dados partido da saida como se pode ver.
        
        return view('saidas.show_saida', compact('saida'));

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

    public function report($id){

        // Relatorio em pdf
        $saida = $this->saida->with('itensSaida.produto', 'cliente')->find($id);

        /*$view = view('reports.saidas.report_saida', compact('saida'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream('saida');*/

        //$products = Product::all();

        return \PDF::loadView('reports.saidas.report_saida', compact('saida'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
        ->stream();

        /*$pdf = PDF::loadView('reports.saidas.report_saida', compact('saida'));
        return $pdf->download('mypdf.pdf');
*/
    }

    public function reportGeralSaidas(){

        $saidas = $this->saida->orderBy('id', 'asc')->get();

        $valor_total_saidas = 0;

        foreach ($saidas as $saida) {
            
            $valor_total_saidas = $valor_total_saidas + $saida->valor_total;

        }

        return view('reports.saidas.report_geral_saidas', compact('saidas', 'valor_total_saidas'));

    }
}
