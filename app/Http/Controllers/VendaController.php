<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\VendaStoreUpdateFormRequest;
use App\Http\Requests\PagamentoVendaStoreUpdateFormRequest;
use App\Model\Empresa;
use App\Model\Ano;
use App\Model\Me;
use App\Model\Venda;
use App\Model\ItenVenda;
use App\Model\Produto;
use App\Model\MotivoIva;
use App\Model\Cliente;
use App\Model\FormaPagamento;
use App\Model\PagamentoVenda;
use App\User;
use DB;
use Session;
use PDF;
use Illuminate\Support\Facades\Gate;

class VendaController extends Controller
{

  private $venda;
  private $iten_venda;
  private $produto;
  private $motivo_iva;
  private $cliente;
  private $user;

  public function __construct(Venda $venda, ItenVenda $iten_venda, Produto $produto, MotivoIva $motivo_iva, Cliente $cliente, User $user){

    $this->venda = $venda;
    $this->iten_venda = $iten_venda;
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
      if (Gate::denies('listar_venda'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');

      $vendas = $this->venda->with('itensVenda')->orderBy('created_at', 'desc')->paginate(10);
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();

      return view('vendas.index_venda', compact('vendas', 'formas_pagamento'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
      if (Gate::denies('criar_venda'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');

      $clientes = DB::table('clientes')->pluck('nome', 'id')->all();
      $tipos_cliente = DB::table('tipo_clientes')->pluck('tipo_cliente', 'id')->all();
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();
      $produtos = $this->produto->select('id', 'descricao')->get();
      $motivos_iva = $this->motivo_iva->select('id', 'motivo_nao_aplicacao')->get();

      return view('vendas.create_edit_venda', compact('clientes', 'tipos_cliente', 'formas_pagamento' , 'produtos', 'motivos_iva'));
    }

    public function createPagamentoVenda($id){
      // dd($id);
      if (Gate::denies('efectuar_pagamento_venda'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');


      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();
      $venda = $this->venda->with('pagamentosVenda.formaPagamento')->where('id', $id)->first();
      // dd($venda);

      return view('vendas.pagamentos.index_pagamentos_venda', compact('formas_pagamento', 'venda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendaStoreUpdateFormRequest $request)
    {
      if (Gate::denies('criar_venda'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');

      // dd($request->all());
      $acronimo_forma_pagamento_naoaplicavel = FormaPagamento::select('id')->where('acronimo', 'naoaplicavel')->first();
      $acronimo_forma_pagamento_naoaplicavel_id = $acronimo_forma_pagamento_naoaplicavel->id;
      $bad_symbols = array(",");
        //dd($request->all());

      if($request->all()){


        $venda = new Venda;

        $venda->cliente_id = $request['cliente_id'];
        $venda->user_id = $request['user_id'];
        $venda->aplicacao_motivo_iva = $request['aplicacao_motivo_iva'];
        $venda->motivo_iva_id = $request['motivo_iva_id'];
        $venda->valor_total = 0; 
        $venda->valor_iva = 0; 
        $venda->iva = 0; 
          // Eh necessario que o valor total seja zero, uma vez que este campo na tabela cotacaos eh actualizado pelo trigger apos o "insert" bem como o "update" na tabela itens_cotacaos de acordo com o codigo da cotacao. Nao pode ser o valor_total vindo do formulario, pois este valor sera acrescido a cada insercao abaixo quando executar o iten_cotacao->save().

        $pago = 0;
        $valor_pago = 0.00;
        $remanescente = 0.00;
        $forma_pagamento_id = $acronimo_forma_pagamento_naoaplicavel_id;
        $nr_documento_forma_pagamento = "Nao Aplicavel";

        if($request['aplicacao_motivo_iva'] == 1){
          $remanescente = str_replace($bad_symbols, "", $request['subtotal_sem_iva']);
        }
        else{
          $remanescente = str_replace($bad_symbols, "", $request['valor_total_iva']);
        }

        if($request['pago'] == 0){

          $pago = $request['pago'];
          $valor_pago = str_replace($bad_symbols, "", $valor_pago);
          $remanescente = str_replace($bad_symbols, "", $request['valor_total_iva']);
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

          $venda->pago = $pago;


          if($venda->save()){

            $count = count($request->produto_id);

            $vend = array('0' => $venda->id); 

              // Para inserir o cotacao_id no iten_cotacaos eh necessario converter este unico valor em array, o qual ira assumir o mesmo valor no loop da insercao como eh o mesmo id da cotacao para varios itens;
              //$cot_id = array('0' => '20');

            for($i=0; $i<$count; $i++){

                $venda_id[$i] = $vend[0]; // A cada iteracao o a variavel cotacao_id recebe o mesmo id transformado em array com um unico valor na posicao zero;

                $iten_venda =  new ItenVenda;

                $iten_venda->produto_id = $request['produto_id'][$i];
                $iten_venda->quantidade = str_replace($bad_symbols, "", $request['quantidade'][$i]);
                $iten_venda->valor = str_replace($bad_symbols, "", $request['valor'][$i]);
                $iten_venda->desconto = str_replace($bad_symbols, "", $request['desconto'][$i]);
                $iten_venda->subtotal = str_replace($bad_symbols, "", $request['subtotal'][$i]);
                $iten_venda->venda_id = $venda_id[$i];

                $iten_venda->save();

              }

              $pagamento_venda = new PagamentoVenda;
              $pagamento_venda->venda_id = $venda->id;
              $pagamento_venda->valor_pago = $valor_pago;
              $pagamento_venda->forma_pagamento_id = $forma_pagamento_id;
              $pagamento_venda->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;
              $pagamento_venda->remanescente = $remanescente;
              $pagamento_venda->save();

              DB::commit();

              $success = "Venda cadastrada com sucesso!";
              
              return redirect()->route('venda.index')->with('success', $success);

            }
            else {

              DB::rollback();
              $error = "Erro ao cadastrar a Venda!";
              return redirect()->back()->with('error', $error);

            }

          } catch (QueryException $e){

            DB::rollback();
            $error = "Erro ao cadastrar a Venda! => Possível redundância de um item/produto à mesma venda ou preenchimento incorrecto dos campos!";
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
      if (Gate::denies('visualizar_venda'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');

      $venda = $this->venda->with('itensVenda.produto', 'cliente')->find($id);
      $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1);
      return view('vendas.show_venda', compact('venda', 'empresa'));
    }

    public function showRelatorio($id)
    {
      //
      $venda = $this->venda->with('itensVenda.produto', 'cliente')->find($id); 
      $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1);
          // Tras a saida. Tras os Itens da Saida e dentro da relacao ItensSaida eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na saida e sim na itensSaida, mas eh possivel ter os seus dados partido da saida como se pode ver.
      $pdf = PDF::loadView('vendas.relatorio', compact('venda','empresa'));
      return $pdf->download('venda-'.$venda->codigo.'.pdf');
      
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
      if (Gate::denies('editar_venda'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');

      $produtos = DB::table('produtos')->pluck('descricao', 'id')->all();
      $motivos_iva = DB::table('motivo_ivas')->pluck('motivo_nao_aplicacao', 'id')->all();
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();
      $venda = $this->venda->with('itensVenda.produto', 'formaPagamento', 'cliente')->find($id); 
        // Tras a venda. Tras os Itens da venda e dentro da relacao Itensvenda eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na venda e sim na itensvenda, mas eh possivel ter os seus dados partido da venda como se pode ver.
      $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1);

      return view('vendas.itens_venda.create_edit_itens_venda', compact('produtos', 'motivos_iva', 'venda', 'formas_pagamento', 'empresa'));
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
      if (Gate::denies('editar_venda'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');


      $venda = $this->venda->findOrFail($id);

      $venda->aplicacao_motivo_iva = $request->aplicacao_motivo_iva;
      $venda->motivo_iva_id = $request->motivo_iva_id;

      if($venda->update()){

        $sucess = 'Venda actualizada com sucesso!';
        return redirect()->back()->with('success', $sucess);

      }else{

        $error = 'Erro ao actualizar a Venda!';
        return redirect()->back()->with('error', $error);

      }
    }

    public function motivoNaoAplicacaoImposto(Request $request){
    // dd($request->all());
      $venda_id = $request->venda_id;

      $dataForm = [
        'motivo_justificativo_nao_iva' => $request->motivo_justificativo_nao_iva,
      ];

      $venda_motivo_justificativo = $this->venda->findOrFail($venda_id);

      if($venda_motivo_justificativo->update($dataForm)){

        $sucess = 'Motivo Justificativo da não aplicação de imposto actualizado com sucesso!';
        return redirect()->back()->with('success', $sucess);


      }else{
        $error = 'Erro ao actualizar o Motivo Justificativo da não aplicação de imposto!';
        return redirect()->back()->with('error', $error);


      }
    }

    public function pagamentoVenda(PagamentoVendaStoreUpdateFormRequest $request){
        // dd($request->all());

      if (Gate::denies('efectuar_pagamento_venda'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');


     $acronimo_forma_pagamento_naoaplicavel = FormaPagamento::select('id')->where('acronimo', 'naoaplicavel')->first();
     $acronimo_forma_pagamento_naoaplicavel_id = $acronimo_forma_pagamento_naoaplicavel->id;
     $bad_symbols = array(",");


     $venda_id = $request->venda_id;

     $pago = 0;
     $valor_pago = 0.00;
     $remanescente = 0.00;
     $forma_pagamento_id = $acronimo_forma_pagamento_naoaplicavel_id;
     $nr_documento_forma_pagamento = "Nao Aplicavel";


     

     $venda = $this->venda->find($venda_id);

     if($request['pago'] == 0){

      $pago = $pago;
      $valor_pago = str_replace($bad_symbols, "", $valor_pago);;
      $remanescente = str_replace($bad_symbols, "", $request['valor_total']);;
      $forma_pagamento_id = $forma_pagamento_id;
      $nr_documento_forma_pagamento = $nr_documento_forma_pagamento;

    }else{

      $pago = $request['pago'];

      if(!empty($request['valor_pago'])){
        $valor_pago = str_replace($bad_symbols, "", $request['valor_pago']);;
      }

      if(!empty($request['remanescente'])){
        $remanescente = str_replace($bad_symbols, "", $request['remanescente']);;
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

      $venda->pago = $pago;

      if($venda->update()){

        if($pago == 0){

          $pagamento_venda_ids = Pagamentovenda::select('id')->where('venda_id', $venda->id)->get();

          if(sizeof($pagamento_venda_ids)>0){

            for($i = 0; $i < sizeof($pagamento_venda_ids); $i++){

              $pagamento_venda = Pagamentovenda::find($pagamento_venda_ids[$i]->id);
              $pagamento_venda->valor_pago = $valor_pago;
              $pagamento_venda->forma_pagamento_id = $forma_pagamento_id;
              $pagamento_venda->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;
              $pagamento_venda->remanescente = $remanescente;
              $pagamento_venda->delete();

            }

          }else{
            DB::rollback();
            $error = "Nao existem Pagamentos para esta Venda!";
            return redirect()->back()->with('error', $error);
          }


        }else{
          $pagamento_venda = new Pagamentovenda;
          $pagamento_venda->venda_id = $venda->id;
          $pagamento_venda->valor_pago = $valor_pago;
          $pagamento_venda->forma_pagamento_id = $forma_pagamento_id;
          $pagamento_venda->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;
          $pagamento_venda->remanescente = $remanescente;
          $pagamento_venda->save();
        }

        DB::commit();
        $success = "Pagamento efectuado com sucesso!";
        return redirect()->route('venda.index')->with('success', $success);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
      if (Gate::denies('apagar_venda'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');



      DB::beginTransaction();
      try {

        $venda = $this->venda->findOrFail($id);

        if(empty($venda->pagamentosVenda()->where('venda_id', $id)->get())){
          $venda->delete();
          DB::commit();
        }else{
          $venda->pagamentosVenda()->where('venda_id', $id)->delete();
          $venda->delete();
          DB::commit();
          $success = "Venda eliminada com sucesso!";
          return redirect()->route('venda.index')->with('success', $success);
        }

      } catch (QueryException $e) {
        DB::rollback();
        $error = "Erro ao remover Venda. Possivel Registo em uso. Necessária a intervenção do Administrador da Base de Dados.!";
        return redirect()->back()->with('error', $error);

      }

    }

    public function reportGeralVendas(){
      if (Gate::denies('relatorio_geral_venda'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');


      // $valor_venda = Venda::sum('valor_iva');
      $valor_venda_pago = PagamentoVenda::sum('valor_pago');
      $mes = null;
      $ano = null;

      $vendas = $this->venda->with('itensVenda', 'user', 'cliente')->get();
      $valor_venda_sem_iva = $this->venda->where('aplicacao_motivo_iva', 1)->sum('valor_total');
      $valor_venda_com_iva = $this->venda->where('aplicacao_motivo_iva', 0)->sum('valor_iva');
     $valor_venda = $valor_venda_sem_iva + $valor_venda_com_iva;

      $anos = DB::table('anos')->pluck('ano', 'id')->all();
      $meses = DB::table('mes')->pluck('nome', 'id')->all();
      
      return view('reports.vendas.report_geral_vendas', compact('vendas', 'valor_venda', 'valor_venda_pago', 'anos', 'meses', 'mes', 'ano'));

    }

    public function listarVendaPorMes(Request $request){
      if (Gate::denies('relatorio_geral_venda'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');


      $mes_id = $request->mes_id;
      $mes_model = Me::select('nome')->where('id', $mes_id)->firstOrFail();
      $mes = $mes_model->nome;
      $ano = null;
      // dd($mes_id);


      $vendas = $this->venda->with('itensVenda', 'pagamentosVenda', 'user', 'cliente')->whereMonth('created_at', $mes_id)->get();
      $valor_venda_sem_iva = Venda::whereMonth('created_at', $mes_id)->where('aplicacao_motivo_iva', 1)->sum('valor_total');
      $valor_venda_com_iva = Venda::whereMonth('created_at', $mes_id)->where('aplicacao_motivo_iva', 0)->sum('valor_iva');
      $valor_venda = $valor_venda_sem_iva + $valor_venda_com_iva;
      $valor_venda_pago = 0;
      $anos = DB::table('anos')->pluck('ano', 'id')->all();
      $meses = DB::table('mes')->pluck('nome', 'id')->all();

      foreach ($vendas as $venda) {
       foreach ($venda->pagamentosVenda as $pagamentos) {
         $valor_venda_pago = $valor_venda_pago + $pagamentos->valor_pago;
       }
     }

     return view('reports.vendas.report_geral_vendas', compact('vendas', 'valor_venda', 'valor_venda_pago', 'anos', 'meses', 'mes', 'ano'));
     
   }

   public function listarVendaPorAno(Request $request){
       //dd($request->all());
    if (Gate::denies('relatorio_geral_venda'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');


     $ano_id = $request->ano_id;
     $ano_model = Ano::select('ano')->where('id', $ano_id)->firstOrFail();
     $ano = $ano_model->ano;
     $mes = null;


     $vendas = $this->venda->with('itensVenda', 'pagamentosVenda', 'user', 'cliente')->whereYear('created_at', $ano)->get();
     $valor_venda_sem_iva = Venda::whereYear('created_at', $ano)->where('aplicacao_motivo_iva', 1)->sum('valor_total');
     $valor_venda_com_iva = Venda::whereYear('created_at', $ano)->where('aplicacao_motivo_iva', 0)->sum('valor_iva');
     $valor_venda = $valor_venda_sem_iva + $valor_venda_com_iva;
     $valor_venda_pago = 0;
     $anos = DB::table('anos')->pluck('ano', 'id')->all();
     $meses = DB::table('mes')->pluck('nome', 'id')->all();

     foreach ($vendas as $venda) {
       foreach ($venda->pagamentosVenda as $pagamentos) {
         $valor_venda_pago = $valor_venda_pago + $pagamentos->valor_pago;
       }
     }
     


     return view('reports.vendas.report_geral_vendas', compact('vendas', 'valor_venda', 'valor_venda_pago', 'anos', 'meses', 'ano', 'mes'));
   }
 }
