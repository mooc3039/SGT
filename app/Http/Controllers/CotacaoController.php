<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CotacaoStoreUpdateFormRequest;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Illuminate\Database\QueryException;
use DB;
use Session;
use App\Model\Produto;
use App\Model\MotivoIva;
use App\Model\Cliente;
use App\User;
use App\Model\Cotacao;
use App\Model\TipoCotacao;
use App\Model\ItenCotacao;
use App\Model\Empresa;
use App\Model\Endereco;
use App\Model\Telefone;
use App\Model\Conta;
use App\Model\Email;
use PDF;
use Yajra\Datatables\Datatables;//yajira

class CotacaoController extends Controller
{

  private $cotacao;
  private $iten_cotacao;
  private $tipo_cotacao;
  private $produto;
  private $motivo_iva;
  private $cliente;
  private $user;

  public function __construct(Cotacao $cotacao, TipoCotacao $tipo_cotacao, ItenCotacao $iten_cotacao, Produto $produto, MotivoIva $motivo_iva , Cliente $cliente, User $user){

    $this->cotacao = $cotacao;
    $this->iten_cotacao;
    $this->tipo_cotacao = $tipo_cotacao;
    $this->produto = $produto;
    $this->motivo_iva = $motivo_iva;
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
    $cotacoes = $this->cotacao->get();

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
    $motivos_iva = $this->motivo_iva->select('id', 'motivo_nao_aplicacao')->get();
    $clientes = DB::table('clientes')->pluck('nome', 'id')->all();
    $produtos = $this->produto->select('id', 'descricao')->get();

    return view('cotacoes.create_edit_cotacao', compact('clientes', 'tipos_cotacao', 'produtos', 'tipos_cliente', 'motivos_iva'));

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
    // dd($request->all());
    $bad_symbols = array(",");

    if($request->all()){

      $cotacao = new Cotacao;

      $dataForm = $request->all();

      $cotacao->cliente_id = $request['cliente_id'];
      $cotacao->validade = $request['validade'];
      $cotacao->user_id = $request['user_id'];
      $cotacao->aplicacao_motivo_iva = $request['aplicacao_motivo_iva'];
      $cotacao->motivo_iva_id = $request['motivo_iva_id'];      
      $cotacao->valor_total = 0; 
      $cotacao->valor_iva = 0; 
      $cotacao->iva = 0; 
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
            $iten_cotacao->quantidade = str_replace($bad_symbols, "", $request['quantidade'][$i]);
            $iten_cotacao->valor = str_replace($bad_symbols, "", $request['valor'][$i]);
            $iten_cotacao->desconto = str_replace($bad_symbols, "", $request['desconto'][$i]);
            $iten_cotacao->subtotal = str_replace($bad_symbols, "", $request['subtotal'][$i]);
            $iten_cotacao->cotacao_id = $cotacao_id[$i];

            $iten_cotacao->save();

          }

          DB::commit();

          $success = "Cotacao cadastrada com sucesso!";
          return redirect()->route('cotacao.index')->with('success', $success);

        }
        else {
          DB::rollback();
          $error = "Erro ao cadastrar a Cotacao!";
          return redirect()->back()->with('error', $error);

        }

      } catch (QueryException $e){

        $error = "Erro ao cadastrar a Cotacao! => Possível redundância de um item/produto à mesma cotação ou preenchimento incorrecto dos campos!";

        DB::rollback();

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
    $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1);
    $cotacao = $this->cotacao->with('itensCotacao.produto', 'motivoIva', 'cliente')->findOrFail($id); // Tras a cotacao. Tras os Itens da cotacao e dentro da relacao Itenscotacao eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na cotacao e sim na itenscotacao, mas eh possivel ter os seus dados partido da cotacao como se pode ver.

    return view('cotacoes.show_cotacao', compact('cotacao', 'empresa'));
  }

  public function showRelatorio($id)
  {
        //
    $cotacao = $this->cotacao->with('itensCotacao.produto', 'cliente')->findOrFail($id); 
    $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1); 
    $pdf = PDF::loadView('cotacoes.relatorio', compact('cotacao','empresa'));
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
   $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1);
   $produtos = DB::table('produtos')->pluck('descricao', 'id')->all();
   $motivos_iva = DB::table('motivo_ivas')->pluck('motivo_nao_aplicacao', 'id')->all();
    $cotacao = $this->cotacao->with('itensCotacao.produto', 'cliente')->findOrFail($id); // Tras a cotacao. Tras os Itens da cotacao e dentro da relacao Itenscotacao eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na cotacao e sim na itenscotacao, mas eh possivel ter os seus dados partido da cotacao como se pode ver.

    return view('cotacoes.itens_cotacao.create_edit_itens_cotacao', compact('cotacao', 'produtos', 'motivos_iva', 'empresa'));

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
    // dd($request->all());
    $cotacao = $this->cotacao->findOrFail($id);

    $cotacao->aplicacao_motivo_iva = $request->aplicacao_motivo_iva;
    $cotacao->motivo_iva_id = $request->motivo_iva_id;

    if($cotacao->update()){

        $sucess = 'Cotação actualizada com sucesso!';
        return redirect()->back()->with('success', $sucess);

      }else{

        $error = 'Erro ao actualizar a Cotação!';
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
    $cotacao = $this->cotacao->findOrFail($id);

    DB::beginTransaction();
    try {


      $cotacao->delete();
      DB::commit();

      $sucess = 'Cotação removida com sucesso!';
      return redirect()->route('cotacao.index')->with('success', $sucess);

    } catch (QueryException $e) {
      DB::rollback();
      $error = "Erro ao remover Cotação. Possivelmente Registo em uso. Necess�ria a interven��o do Administrador da Base de Dados.!";
      return redirect()->back()->with('error', $error);
    }
    
    //
/*     $cotacao = $this->cotacao->findOrFail($id);

    DB::beginTransaction();
    try {

      if($cotacao->itensCotacao()->where('cotacao_id', $id)->delete()){

        $cotacao->delete();
        DB::commit();

        $sucess = 'Cotação removida com sucesso!';
        return redirect()->route('cotacao.index')->with('success', $sucess);

      }else{
        DB::rollback();
        $error = 'Erro ao remover a Cotação!';
        return redirect()->back()->with('error', $error);
      }

    } catch (QueryException $e) {
      DB::rollback();
      $error = "Erro ao remover Cotação. Possivelmente Registo em uso. Necessária a intervenção do Administrador da Base de Dados.!";
      return redirect()->back()->with('error', $error);
    } */
  }

  public function motivoNaoAplicacaoImposto(Request $request){
    // dd($request->all());
    $cotacao_id = $request->cotacao_id;

    $dataForm = [
      'motivo_justificativo_nao_iva' => $request->motivo_justificativo_nao_iva,
    ];

    $cotacao_motivo_justificativo = $this->cotacao->findOrFail($cotacao_id);

    if($cotacao_motivo_justificativo->update($dataForm)){

      $sucess = 'Motivo Justificativo da não aplicação de imposto actualizado com sucesso!';
      return redirect()->back()->with('success', $sucess);


    }else{
      $error = 'Erro ao actualizar o Motivo Justificativo da não aplicação de imposto!';
      return redirect()->back()->with('error', $error);


    }
  }

  public function reportGeralCotacoes(){

    $cotacoes = $this->cotacao->with('cliente')->orderBy('id', 'asc')->get();

    return view('reports.cotacoes.report_geral_cotacoes', compact('cotacoes', 'valor_total_cotacaos'));

  }


}
