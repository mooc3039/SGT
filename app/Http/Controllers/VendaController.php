<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\VendaStoreUpdateFormRequest;
use App\Http\Requests\PagamentoVendaStoreUpdateFormRequest;
use App\Model\Empresa;
use App\Model\Venda;
use App\Model\ItenVenda;
use App\Model\Produto;
use App\Model\Cliente;
use App\Model\FormaPagamento;
use App\Model\PagamentoVenda;
use App\User;
use DB;
use Session;
use PDF;

class VendaController extends Controller
{

  private $venda;
  private $iten_venda;
  private $produto;
  private $cliente;
  private $user;

  public function __construct(Venda $venda, ItenVenda $iten_venda, Produto $produto, Cliente $cliente, User $user){

    $this->venda = $venda;
    $this->iten_venda = $iten_venda;
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
      $clientes = DB::table('clientes')->pluck('nome', 'id')->all();
      $tipos_cliente = DB::table('tipo_clientes')->pluck('tipo_cliente', 'id')->all();
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();
      $produtos = $this->produto->select('id', 'descricao')->get();

      return view('vendas.create_edit_venda', compact('clientes', 'tipos_cliente', 'formas_pagamento' , 'produtos'));
    }

    public function createPagamentoVenda($id){
      // dd($id);
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
      // dd($request->all());
      $acronimo_forma_pagamento_naoaplicavel = FormaPagamento::select('id')->where('acronimo', 'naoaplicavel')->first();
      $acronimo_forma_pagamento_naoaplicavel_id = $acronimo_forma_pagamento_naoaplicavel->id;
        //dd($request->all());

      if($request->all()){


        $venda = new Venda;

        $venda->cliente_id = $request['cliente_id'];
        $venda->user_id = $request['user_id'];
        $venda->valor_total = 0; 
        $venda->valor_iva = 0; 
          // Eh necessario que o valor total seja zero, uma vez que este campo na tabela cotacaos eh actualizado pelo trigger apos o "insert" bem como o "update" na tabela itens_cotacaos de acordo com o codigo da cotacao. Nao pode ser o valor_total vindo do formulario, pois este valor sera acrescido a cada insercao abaixo quando executar o iten_cotacao->save().

        $pago = 0;
        $valor_pago = 0.00;
        $remanescente = 0.00;
        $forma_pagamento_id = $acronimo_forma_pagamento_naoaplicavel_id;
        $nr_documento_forma_pagamento = "Nao Aplicavel";

        if($request['pago'] == 0){

          $pago = $request['pago'];
          $valor_pago = 0.00;
          $remanescente = $request['valor_total_iva'];
          $forma_pagamento_id = $acronimo_forma_pagamento_naoaplicavel_id;
          $nr_documento_forma_pagamento = 'Nao Aplicavel';

        }else{

          $pago = $request['pago'];

          if(!empty($request['valor_pago'])){
            $valor_pago = $request['valor_pago'];
          }

          if(!empty($request['remanescente'])){
            $remanescente = $request['remanescente'];
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
                $iten_venda->quantidade = $request['quantidade'][$i];
                $iten_venda->valor = $request['valor'][$i];
                $iten_venda->desconto = $request['desconto'][$i];
                $iten_venda->subtotal = $request['subtotal'][$i];
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
      return $pdf->download('venda.pdf');
      
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
      $venda = $this->venda->with('itensVenda.produto', 'formaPagamento', 'cliente')->find($id); 
        // Tras a venda. Tras os Itens da venda e dentro da relacao Itensvenda eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na venda e sim na itensvenda, mas eh possivel ter os seus dados partido da venda como se pode ver.
      $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1);

      return view('vendas.itens_venda.create_edit_itens_venda', compact('produtos', 'venda', 'formas_pagamento', 'empresa'));
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

    public function pagamentoVenda(PagamentoVendaStoreUpdateFormRequest $request){
        //dd($request->all());
     $acronimo_forma_pagamento_naoaplicavel = FormaPagamento::select('id')->where('acronimo', 'naoaplicavel')->first();
     $acronimo_forma_pagamento_naoaplicavel_id = $acronimo_forma_pagamento_naoaplicavel->id;


     $venda_id = $request->venda_id;

     $pago = 0;
     $valor_pago = 0.00;
     $remanescente = 0.00;
     $forma_pagamento_id = $acronimo_forma_pagamento_naoaplicavel_id;
     $nr_documento_forma_pagamento = "Nao Aplicavel";


     

     $venda = $this->venda->find($venda_id);

     if($request['pago'] == 0){

      $pago = $pago;
      $valor_pago = $valor_pago;
      $remanescente = $request['valor_iva'];
      $forma_pagamento_id = $forma_pagamento_id;
      $nr_documento_forma_pagamento = $nr_documento_forma_pagamento;

    }else{

      $pago = $request['pago'];

      if(!empty($request['valor_pago'])){
        $valor_pago = $request['valor_pago'];
      }

      if(!empty($request['remanescente'])){
        $remanescente = $request['remanescente'];
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
      $venda = $this->venda->findOrFail($id);

      DB::beginTransaction();
      try {

        if($venda->itensVenda()->where('venda_id', $id)->delete()){

          $venda->pagamentosVenda()->where('venda_id', $id)->delete();
          $venda->delete();
          DB::commit();

          $success = "Venda eliminada com sucesso!";
          return redirect()->route('venda.index')->with('success', $success);

        }else{
          DB::rollback();
          $error = 'Erro ao remover a Venda!';
          return redirect()->back()->with('error', $error);
        }

      } catch (QueryException $e) {
        DB::rollback();
        $error = "Erro ao remover Venda.Necessária a intervenção do Administrador da Base de Dados.!";
        return redirect()->back()->with('error', $error);

      }

    }
  }
