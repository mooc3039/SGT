<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\PagamentoEntradaStoreUpdateFormRequest;
use App\Http\Requests\EntradaStoreUpdateFormRequest;
use App\Model\Empresa;
use App\Model\Ano;
use App\Model\Me;
use App\Model\Produto;
use App\Model\Entrada;
use App\Model\ItenEntrada;
use App\Model\PagamentoEntrada;
use App\Model\FormaPagamento;
use App\User;
use DB;
use Session;
use PDF;

class EntradaController extends Controller
{

  private $entrada;
  private $iten_entrada;
  private $produto;
  private $user;

  public function __construct(Entrada $entrada, ItenEntrada $iten_entrada,  Produto $produto, User $user){

    $this->entrada = $entrada;
    $this->iten_entrada = $iten_entrada;
    $this->produto = $produto;
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
      $entradas = $this->entrada->orderBy('created_at', 'asc')->paginate(10);
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();

      return view('entradas.index_entrada', compact('entradas', 'formas_pagamento'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
      $fornecedor =DB::table('fornecedors')->pluck('nome','id')->all();
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();
      $produtos = $this->produto->select('id', 'descricao')->get();

      return view('entradas.create_edit_entrada', compact('fornecedor', 'formas_pagamento' , 'produtos'));
    }

    public function createPagamentoEntrada($id){
     $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();
     $entrada = $this->entrada->with('pagamentosEntrada.formaPagamento')->where('id', $id)->first();
      // dd($entrada);

     return view('entradas.pagamentos.index_pagamentos_entrada', compact('formas_pagamento', 'entrada'));
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntradaStoreUpdateFormRequest $request)
    {
        //
        // dd($request->all());
      $acronimo_forma_pagamento_naoaplicavel = FormaPagamento::select('id')->where('acronimo', 'naoaplicavel')->first();
      $acronimo_forma_pagamento_naoaplicavel_id = $acronimo_forma_pagamento_naoaplicavel->id;
      $bad_symbols = array(",");
        //dd($request->all());

      if($request->all()){


        $entrada = new entrada;

        $entrada->fornecedor_id = $request['fornecedor_id'];
        $entrada->user_id = $request['user_id'];
        $entrada->valor_total = 0;
          // Eh necessario que o valor total seja zero, uma vez que este campo na tabela cotacaos eh actualizado pelo trigger apos o "insert" bem como o "update" na tabela itens_cotacaos de acordo com o codigo da cotacao. Nao pode ser o valor_total vindo do formulario, pois este valor sera acrescido a cada insercao abaixo quando executar o iten_cotacao->save().

        $pago = 0;
        $valor_pago = 0.00;
        $remanescente = 0.00;
        $forma_pagamento_id = $acronimo_forma_pagamento_naoaplicavel_id;
        $nr_documento_forma_pagamento = "Nao Aplicavel";

        if($request['pago'] == 0){

          $pago = $request['pago'];
          $valor_pago = str_replace($bad_symbols, "", $valor_pago);
          $remanescente = str_replace($bad_symbols, "", $request['valor_total']);
          $forma_pagamento_id = $acronimo_forma_pagamento_naoaplicavel_id;
          $nr_documento_forma_pagamento = 'Nao Aplicavel';

        }else{

          $pago = $request['pago'];

          if(!empty($request['valor_pago'])){
            $valor_pago = str_replace($bad_symbols, "", $request['valor_pago']);
          }

          if(!empty($request['remanescente'])){
            $remanescente = str_replace($bad_symbols, "", $request['remanescente']);
          }

          if(!empty($request['forma_pagamento_id'])){
            $forma_pagamento_id = $request['forma_pagamento_id'];
          }

          if(!empty($request['nr_documento_forma_pagamento'])){
            $nr_documento_forma_pagamento = $request['nr_documento_forma_pagamento'];
          }

        }

          // $salvar =1;

        DB::beginTransaction();

        try {

          $entrada->pago = $pago;


          if($entrada->save()){

            $count = count($request->produto_id);

            $entr = array('0' => $entrada->id);

              // Para inserir o cotacao_id no iten_cotacaos eh necessario converter este unico valor em array, o qual ira assumir o mesmo valor no loop da insercao como eh o mesmo id da cotacao para varios itens;
              //$cot_id = array('0' => '20');

            for($i=0; $i<$count; $i++){

                $entrada_id[$i] = $entr[0]; // A cada iteracao o a variavel cotacao_id recebe o mesmo id transformado em array com um unico valor na posicao zero;

                $iten_entrada =  new ItenEntrada;

                $iten_entrada->produto_id = $request['produto_id'][$i];
                $iten_entrada->quantidade = str_replace($bad_symbols, "", $request['quantidade'][$i]);
                $iten_entrada->valor = str_replace($bad_symbols, "", $request['valor'][$i]);
                $iten_entrada->desconto = str_replace($bad_symbols, "", $request['desconto'][$i]);
                $iten_entrada->subtotal = str_replace($bad_symbols, "", $request['subtotal'][$i]);
                $iten_entrada->entrada_id = $entrada_id[$i];

                $iten_entrada->save();

              }

              $pagamento_entrada = new PagamentoEntrada;
              $pagamento_entrada->entrada_id = $entrada->id;
              $pagamento_entrada->valor_pago = $valor_pago;
              $pagamento_entrada->forma_pagamento_id = $forma_pagamento_id;
              $pagamento_entrada->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;
              $pagamento_entrada->remanescente = $remanescente;
              $pagamento_entrada->save();

              DB::commit();

              $success = "Entrada cadastrada com sucesso!";
              return redirect()->route('entrada.index')->with('success', $success);

            }
            else {

              DB::rollback();
              $error = "Erro ao cadastrar a Entrada!";
              return redirect()->back()->with('error', $error);

            }

          } catch (QueryException $e){

            DB::rollback();
            $error = "Erro ao cadastrar a Entrada! => Possível redundância de um item/produto à mesma Entrada ou preenchimento incorrecto dos campos!";
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
      $entrada = $this->entrada->with('itensEntrada.produto', 'user')->find($id);
      $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1);

      return view('entradas.show_entrada', compact('entrada', 'empresa'));
    }
    public function showRelatorio($id)
    {
        //
      $entrada = $this->entrada->with('itensEntrada.produto', 'user')->find($id);
      $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1);
      $pdf = PDF::loadView('entradas.relatorio', compact('entrada','empresa'));
      return $pdf->download('entrada.pdf');

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
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();
      $entrada = $this->entrada->with('itensEntrada.produto', 'formaPagamento', 'fornecedor')->find($id);
        // Tras a entrada. Tras os Itens da entrada e dentro da relacao Itensentrada eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na entrada e sim na itensentrada, mas eh possivel ter os seus dados partido da entrada como se pode ver.
      $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1);

      return view('entradas.itens_entrada.create_edit_itens_entrada', compact('produtos', 'entrada', 'formas_pagamento', 'empresa'));
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

      DB::beginTransaction();
      try {

        $entrada = $this->entrada->findOrFail($id);

        if(empty($entrada->pagamentosEntrada()->where('entrada_id', $id)->get())){
          $entrada->delete();
          DB::commit();
          $sucess = 'Entrada removida com sucesso!';
          return redirect()->route('entrada.index')->with('success', $sucess);
        }else{
          $entrada->pagamentosEntrada()->where('entrada_id', $id)->delete();
          $entrada->delete();
          DB::commit();
          $sucess = 'Entrada removida com sucesso!';
          return redirect()->route('entrada.index')->with('success', $sucess);
        }

      } catch (QueryException $e) {
        DB::rollback();
        $error = "Erro ao remover Entrada. Possivel Registo em uso. Necessária a intervenção do Administrador da Base de Dados.!";
        return redirect()->back()->with('error', $error);

      }

    }

    public function pagamentoEntrada(PagamentoEntradaStoreUpdateFormRequest $request){
        //dd($request->all());

      $acronimo_forma_pagamento_naoaplicavel = FormaPagamento::select('id')->where('acronimo', 'naoaplicavel')->first();
      $acronimo_forma_pagamento_naoaplicavel_id = $acronimo_forma_pagamento_naoaplicavel->id;
      $bad_symbols = array(",");


      $entrada_id = $request->entrada_id;

      $pago = 0;
      $valor_pago = 0.00;
      $remanescente = 0.00;
      $forma_pagamento_id = $acronimo_forma_pagamento_naoaplicavel_id;
      $nr_documento_forma_pagamento = "Nao Aplicavel";




      $entrada = $this->entrada->find($entrada_id);

      if($request['pago'] == 0){

        $pago = $pago;
        $valor_pago = str_replace($bad_symbols, "", $valor_pago);
        $remanescente = str_replace($bad_symbols, "", $request['valor_total']);
        $forma_pagamento_id = $forma_pagamento_id;
        $nr_documento_forma_pagamento = $nr_documento_forma_pagamento;

      }else{

        $pago = $request['pago'];

        if(!empty($request['valor_pago'])){
          $valor_pago = str_replace($bad_symbols, "", $request['valor_pago']);
        }

        if(!empty($request['remanescente'])){
          $remanescente = str_replace($bad_symbols, "", $request['remanescente']);
        }

        if(!empty($request['forma_pagamento_id'])){
          $forma_pagamento_id = $request['forma_pagamento_id'];
        }

        if(!empty($request['nr_documento_forma_pagamento'])){
          $nr_documento_forma_pagamento = $request['nr_documento_forma_pagamento'];
        }

      }

      DB::beginTransaction();

      try{

        $entrada->pago = $pago;

        if($entrada->update()){

          if($pago == 0){

            $pagamento_entrada_ids = Pagamentoentrada::select('id')->where('entrada_id', $entrada->id)->get();

            if(sizeof($pagamento_entrada_ids)>0){

              for($i = 0; $i < sizeof($pagamento_entrada_ids); $i++){

                $pagamento_entrada = Pagamentoentrada::find($pagamento_entrada_ids[$i]->id);
                $pagamento_entrada->valor_pago = $valor_pago;
                $pagamento_entrada->forma_pagamento_id = $forma_pagamento_id;
                $pagamento_entrada->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;
                $pagamento_entrada->remanescente = $remanescente;
                $pagamento_entrada->delete();

              }

            }else{
              DB::rollback();
              $error = "Nao existem Pagamentos para esta Entrada!";
              return redirect()->back()->with('error', $error);
            }


          }else{
            $pagamento_entrada = new Pagamentoentrada;
            $pagamento_entrada->entrada_id = $entrada->id;
            $pagamento_entrada->valor_pago = $valor_pago;
            $pagamento_entrada->forma_pagamento_id = $forma_pagamento_id;
            $pagamento_entrada->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;
            $pagamento_entrada->remanescente = $remanescente;
            $pagamento_entrada->save();
          }

          DB::commit();
          $success = "Pagamento efectuado com sucesso!";
          return redirect()->route('entrada.index')->with('success', $success);

        }else{

          DB::rollback();
          $error = "Pagamento nao efectuado!!";
          return redirect()->back()->with('error', $error);

        }

      }catch(QueryException $e){
        DB::rollback();
        $error = 'Erro ao efectuar o pagamento! Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!';
        return redirect()->back()->with('error', $error);
      }
    }

    public function reportGeralEntradas(){

      // $entradas = $this->entrada->with('user')->orderBy('id', 'asc')->get();

      // return view('reports.entradas.report_geral_entradas', compact('entradas'));

      $valor_entrada = Entrada::sum('valor_total');
      $valor_entrada_pago = PagamentoEntrada::sum('valor_pago');
      $mes = null;
      $ano = null;

      $entradas = $this->entrada->with('itensEntrada', 'user', 'fornecedor')->get();
      $anos = DB::table('anos')->pluck('ano', 'id')->all();
      $meses = DB::table('mes')->pluck('nome', 'id')->all();

      return view('reports.entradas.report_geral_entradas', compact('entradas', 'valor_entrada', 'valor_entrada_pago', 'anos', 'meses', 'mes', 'ano'));

    }

    public function listarEntradaPorMes(Request $request){
      $mes_id = $request->mes_id;
      $mes_model = Me::select('nome')->where('id', $mes_id)->firstOrFail();
      $mes = $mes_model->nome;
      $ano = null;
      // dd($mes_id);


      $entradas = $this->entrada->with('itensEntrada', 'pagamentosEntrada', 'user', 'fornecedor')->whereMonth('created_at', $mes_id)->get();
      $valor_entrada = Entrada::whereMonth('created_at', $mes_id)->sum('valor_total');
      $valor_entrada_pago = 0;
      $anos = DB::table('anos')->pluck('ano', 'id')->all();
      $meses = DB::table('mes')->pluck('nome', 'id')->all();

      foreach ($entradas as $entrada) {
       foreach ($entrada->pagamentosEntrada as $pagamentos) {
         $valor_entrada_pago = $valor_entrada_pago + $pagamentos->valor_pago;
       }
     }

     return view('reports.entradas.report_geral_entradas', compact('entradas', 'valor_entrada', 'valor_entrada_pago', 'anos', 'meses', 'mes', 'ano'));

   }

   public function listarEntradaPorAno(Request $request){
       //dd($request->all());
     $ano_id = $request->ano_id;
     $ano_model = Ano::select('ano')->where('id', $ano_id)->firstOrFail();
     $ano = $ano_model->ano;
     $mes = null;


     $entradas = $this->entrada->with('itensEntrada', 'pagamentosEntrada', 'user', 'fornecedor')->whereYear('created_at', $ano)->get();
     $valor_entrada = Entrada::whereYear('created_at', $ano)->sum('valor_total');
     $valor_entrada_pago = 0;
     $anos = DB::table('anos')->pluck('ano', 'id')->all();
     $meses = DB::table('mes')->pluck('nome', 'id')->all();

     foreach ($entradas as $entrada) {
       foreach ($entrada->pagamentosEntrada as $pagamentos) {
         $valor_entrada_pago = $valor_entrada_pago + $pagamentos->valor_pago;
       }
     }


     return view('reports.entradas.report_geral_entradas', compact('entradas', 'valor_entrada', 'valor_entrada_pago', 'anos', 'meses', 'ano', 'mes'));
   }

   public function entradaTeste($id){
    echo "Teste";
  }
}
