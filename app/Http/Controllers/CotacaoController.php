<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CotacaoStoreUpdateFormRequest;
use Illuminate\Database\QueryException;
use DB;
use Session;
use App\Model\Produto;
use App\Model\Cliente;
use App\User;
use App\Model\Cotacao;
use App\Model\TipoCotacao;
use App\Model\ItenCotacao;
use PDF;

class CotacaoController extends Controller
{

  private $cotacao;
  private $iten_cotacao;
  private $tipo_cotacao;
  private $produto;
  private $cliente;
  private $user;

  public function __construct(Cotacao $cotacao, TipoCotacao $tipo_cotacao, ItenCotacao $iten_cotacao, Produto $produto, Cliente $cliente, User $user){

    $this->cotacao = $cotacao;
    $this->iten_cotacao;
    $this->tipo_cotacao = $tipo_cotacao;
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
    $cotacoes = $this->cotacao->orderBy('data', 'desc')->paginate(10);

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
    $tipos_cliente = DB::table('tipo_clientes')->pluck('tipo_cliente', 'id')->all();
    $tipos_cotacao = DB::table('tipo_cotacaos')->pluck('nome', 'id')->all();
    $clientes = DB::table('clientes')->pluck('nome', 'id')->all();
    $produtos = $this->produto->select('id', 'descricao')->get();

    return view('cotacoes.create_edit_cotacao', compact('clientes', 'tipos_cotacao', 'produtos', 'tipos_cliente'));

  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(CotacaoStoreUpdateFormRequest $request)
  {
    //
    if(request()->ajax()){

      $cotacao = new Cotacao;

      $dataForm = $request->all();

      $cotacao->cliente_id = $request['cliente_id'];
      $cotacao->tipo_cotacao_id = $request['tipo_cotacao_id'];
      $cotacao->user_id = $request['user_id'];
      $cotacao->valor_total = 0; 
      $cotacao->valor_iva = 0; 
      // Eh necessario que o valor total seja zero, uma vez que este campo na tabela cotacaos eh actualizado pelo trigger apos o "insert" bem como o "update" na tabela itens_cotacaos de acordo com o codigo da cotacao. Nao pode ser o valor_total vindo do formulario, pois este valor sera acrescido a cada insercao abaixo quando executar o iten_cotacao->save().

      // $salvar =1;

      DB::beginTransaction();

      try {


        if($cotacao->save()){

          $count = count($request->produto_id);

          $cot_id = array('0' => $cotacao->id); // Para inserir o cotacao_id no iten_cotacaos eh necessario converter este unico valor em array, o qual ira assumir o mesmo valor no loop da insercao como eh o mesmo id da cotacao para varios itens;
          //$cot_id = array('0' => '20');

          for($i=0; $i<$count; $i++){

            $cotacao_id[$i] = $cot_id[0]; // A cada iteracao o a variavel cotacao_id recebe o mesmo id transformado em array com um unico valor na posicao zero;

            $iten_cotacao =  new ItenCotacao;

            $iten_cotacao->produto_id = $request['produto_id'][$i];
            $iten_cotacao->quantidade = $request['quantidade'][$i];
            $iten_cotacao->valor = $request['subtotal'][$i];
            $iten_cotacao->desconto = $request['desconto'][$i];
            $iten_cotacao->subtotal = $request['subtotal'][$i];
            $iten_cotacao->cotacao_id = $cotacao_id[$i];

            $iten_cotacao->save();

          }

          DB::commit();

          $sucesso = "Cotacao cadastrada com sucesso!";
          Session::flash('success', $sucesso);
          return response()->json(['status'=>'success']);
          // return response()->json($request->all());

        }
        else {

          $erro = "Erro ao cadastrar a Cotacao!";
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
    $cotacao = $this->cotacao->with('itensCotacao.produto', 'cliente')->find($id); // Tras a cotacao. Tras os Itens da cotacao e dentro da relacao Itenscotacao eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na cotacao e sim na itenscotacao, mas eh possivel ter os seus dados partido da cotacao como se pode ver.

    return view('cotacoes.show_cotacao', compact('cotacao'));
  }

  public function showRelatorio($id)
    {
        //
        $cotacao = $this->cotacao->with('itensCotacao.produto', 'cliente')->find($id); 
            // Tras a saida. Tras os Itens da Saida e dentro da relacao ItensSaida eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na saida e sim na itensSaida, mas eh possivel ter os seus dados partido da saida como se pode ver.
         $pdf = PDF::loadView('cotacoes.relatorio', compact('cotacao'));
         return $pdf->download('cotacao.pdf');
        
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
    $cotacao = $this->cotacao->with('itensCotacao.produto', 'cliente')->find($id); // Tras a cotacao. Tras os Itens da cotacao e dentro da relacao Itenscotacao eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na cotacao e sim na itenscotacao, mas eh possivel ter os seus dados partido da cotacao como se pode ver.

    return view('cotacoes.itens_cotacao.create_edit_itens_cotacao', compact('cotacao', 'produtos'));

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

    // }

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
    $cotacao = $this->cotacao->find($id);

        try {

          if($cotacao->delete()){

            $sucess = 'Cotação removida com sucesso!';
            return redirect()->route('cotacao.index')->with('success', $sucess);

          }else{

            $error = 'Erro ao remover a Cotação!';
            return redirect()->back()->with('error', $error);
          }


        } catch (QueryException $e) {

          $error = "Erro ao remover Cotação. Possivelmente Registo em uso. Necessária a intervenção do Administrador da Base de Dados.!";
          return redirect()->back()->with('error', $error);

        }
  }

  public function reportGeralCotacoes(){

    $cotacoes = $this->cotacao->with('cliente')->orderBy('id', 'asc')->get();

    return view('reports.cotacoes.report_geral_cotacoes', compact('cotacoes', 'valor_total_cotacaos'));

  }


}
