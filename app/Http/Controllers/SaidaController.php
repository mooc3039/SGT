<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\SaidaStoreUpdateFormRequest;
use App\Model\Saida;
use App\Model\ItenSaida;
use App\Model\Produto;
use App\Model\Cliente;
use App\User;
use DB;
use Session;
use PDF;

class SaidaController extends Controller
{

    private $saida;
    private $iten_saida;
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

        $saidas = $this->saida->with('itensSaida')->orderBy('data', 'desc')->paginate(10);

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
        $clientes = DB::table('clientes')->pluck('nome', 'id')->all();
        $tipos_cliente = DB::table('tipo_clientes')->pluck('tipo_cliente', 'id')->all();
        $produtos = $this->produto->select('id', 'descricao')->get();

        return view('saidas.create_edit_saida', compact('clientes', 'tipos_cliente' , 'produtos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaidaStoreUpdateFormRequest $request)
    {
        //
      if(request()->ajax()){


          $saida = new Saida;

          $saida->cliente_id = $request['cliente_id'];
          $saida->user_id = $request['user_id'];
          $saida->valor_total = 0; // Eh necessario que o valor total seja zero, uma vez que este campo na tabela cotacaos eh actualizado pelo trigger apos o "insert" bem como o "update" na tabela itens_cotacaos de acordo com o codigo da cotacao. Nao pode ser o valor_total vindo do formulario, pois este valor sera acrescido a cada insercao abaixo quando executar o iten_cotacao->save().

          // $salvar =1;

          DB::beginTransaction();

          try {


            if($saida->save()){

              $count = count($request->produto_id);

              $sai_id = array('0' => $saida->id); // Para inserir o cotacao_id no iten_cotacaos eh necessario converter este unico valor em array, o qual ira assumir o mesmo valor no loop da insercao como eh o mesmo id da cotacao para varios itens;
              //$cot_id = array('0' => '20');

              for($i=0; $i<$count; $i++){

                $saida_id[$i] = $sai_id[0]; // A cada iteracao o a variavel cotacao_id recebe o mesmo id transformado em array com um unico valor na posicao zero;

                $iten_saida =  new ItenSaida;

                $iten_saida->produto_id = $request['produto_id'][$i];
                $iten_saida->quantidade = $request['quantidade'][$i];
                $iten_saida->quantidade_rest = $request['quantidade'][$i];
                $iten_saida->valor = $request['valor'][$i];
                $iten_saida->valor_rest = $request['valor'][$i];
                $iten_saida->desconto = $request['desconto'][$i];
                $iten_saida->subtotal = $request['subtotal'][$i];
                $iten_saida->subtotal_rest = $request['subtotal'][$i];
                $iten_saida->saida_id = $saida_id[$i];

                $iten_saida->save();

            }

            DB::commit();

            $sucesso = "Saída cadastrada com sucesso!";
            Session::flash('success', $sucesso);
            return response()->json(['status'=>'success']);
              // return response()->json($request->all());

        }
        else {

          $erro = "Erro ao cadastrar a Saída!";
          Session::flash('error', $erro);
          return response()->json(['status'=>'error']);

      }

  } catch (QueryException $e){

    $erro = "Erro ao cadastrar a Cotacao! => Possível redundância de um item/produto à mesma cotação ou preenchimento incorrecto dos campos!";
    Session::flash('error', $erro);

    DB::rollback();

    return response()->json(['status'=>'error']);

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
        $produtos = DB::table('produtos')->pluck('descricao', 'id')->all();
        $saida = $this->saida->with('itensSaida.produto', 'cliente')->find($id); 
        // Tras a saida. Tras os Itens da Saida e dentro da relacao ItensSaida eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na saida e sim na itensSaida, mas eh possivel ter os seus dados partido da saida como se pode ver.

        return view('saidas.itens_saida.create_edit_itens_saida', compact('produtos', 'saida'));
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
        $saida = $this->saida->find($id);

        try {

          if($saida->delete()){

            $sucess = 'Saída removida com sucesso!';
            return redirect()->route('saida.index')->with('success', $sucess);

          }else{

            $error = 'Erro ao remover a Saída!';
            return redirect()->back()->with('error', $error);
          }


        } catch (QueryException $e) {

          $error = "Erro ao remover Saída. Possivelmente Registo em uso. Necessária a intervenção do Administrador da Base de Dados.!";
          return redirect()->back()->with('error', $error);

        }
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
