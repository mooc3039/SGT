<?php

namespace App\Http\Controllers;

// use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\ConcursoStoreUpdateFormRequest;
use App\Http\Requests\PagamentoConcursoStoreUpdateFormRequest;
use App\User;
use App\Model\Empresa;
use App\Model\Concurso;
use App\Model\TipoCliente;
use App\Model\Itenconcurso;
use App\Model\FormaPagamento;
use App\Model\PagamentoConcurso;
use App\Model\Produto;
use App\Model\Cliente;
use DB;
use Session;

class ConcursoController extends Controller
{
  private $concurso;
  private $iten_concurso;
  private $produto;
  private $cliente;
  private $tipo_cliente;
  private $user;

  public function __construct(Concurso $concurso, ItenConcurso $iten_concurso, Produto $produto, Cliente $cliente, TipoCliente $tipo_cliente, User $user){

    $this->concurso = $concurso;
    $this->iten_concurso = $iten_concurso;
    $this->produto = $produto;
    $this->cliente = $cliente;
    $this->tipo_cliente = $tipo_cliente;
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
      $concursos = $this->concurso->with('itensConcurso')->orderBy('created_at', 'desc')->paginate(10);
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();

      return view('concursos.index_concurso', compact('concursos', 'formas_pagamento'));
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

      return view('concursos.create_edit_concurso', compact('clientes', 'tipos_cliente', 'formas_pagamento' , 'produtos'));
    }

    public function createPagamentoConcurso($id){
      // dd($id);
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();
      $concurso = $this->concurso->with('pagamentosConcurso.formaPagamento')->where('id', $id)->first();
      // dd($concurso);

      return view('concursos.pagamentos.index_pagamentos_concurso', compact('formas_pagamento', 'concurso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConcursoStoreUpdateFormRequest $request)
    {
        //
      // dd($request->all());
      $acronimo_forma_pagamento_naoaplicavel = FormaPagamento::select('id')->where('acronimo', 'naoaplicavel')->first();
      $acronimo_forma_pagamento_naoaplicavel_id = $acronimo_forma_pagamento_naoaplicavel->id;

        // dd($request->all());
      if($request->all()){

        $pago = 0;
        $valor_pago = 0.00;
        $remanescente = $request['remanescente'];
        $forma_pagamento_id = $acronimo_forma_pagamento_naoaplicavel_id;
        $nr_documento_forma_pagamento = "Nao Aplicavel";
        $codigo_concurso = $request['codigo_concurso'];


        if($request['pago'] == 0){

          $pago = $pago;
          $valor_pago = $valor_pago;
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



        DB::beginTransaction();

        try {

          $concurso = new Concurso;

          $concurso->cliente_id = $request['cliente_id'];
          $concurso->user_id = $request['user_id'];
          $concurso->valor_total = 0; 
          $concurso->valor_iva = 0; 

          $concurso->pago = $pago;
          $concurso->codigo_concurso = $codigo_concurso;


          if($concurso->save()){

            $count = count($request->produto_id);

            $u_id = array('0'=> $request['user_id']); 
              $conc_id = array('0' => $concurso->id); // Para inserir o cotacao_id no iten_cotacaos eh necessario converter este unico valor em array, o qual ira assumir o mesmo valor no loop da insercao como eh o mesmo id da cotacao para varios itens;
              //$cot_id = array('0' => '20');

              for($i=0; $i<$count; $i++){

                $usr_id[$i] = $u_id[0];
                $concurso_id[$i] = $conc_id[0]; // A cada iteracao o a variavel cotacao_id recebe o mesmo id transformado em array com um unico valor na posicao zero;

                $iten_concurso =  new ItenConcurso;

                $iten_concurso->produto_id = $request['produto_id'][$i];
                $iten_concurso->quantidade = $request['quantidade'][$i];
                $iten_concurso->quantidade_rest = $request['quantidade'][$i];
                $iten_concurso->preco_venda = $request['preco_venda'][$i];
                $iten_concurso->valor = $request['valor'][$i];
                $iten_concurso->valor_rest = $request['valor'][$i];
                $iten_concurso->desconto = $request['desconto'][$i];
                $iten_concurso->subtotal = $request['subtotal'][$i];
                $iten_concurso->subtotal_rest = $request['subtotal'][$i];
                $iten_concurso->concurso_id = $concurso_id[$i];
                $iten_concurso->user_id = $usr_id[$i];

                $iten_concurso->save();

              }

              $pagamento_concurso = new PagamentoConcurso;
              $pagamento_concurso->concurso_id = $concurso->id;
              $pagamento_concurso->valor_pago = $valor_pago;
              $pagamento_concurso->forma_pagamento_id = $forma_pagamento_id;
              $pagamento_concurso->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;
              $pagamento_concurso->remanescente = $remanescente;
              $pagamento_concurso->save();

              DB::commit();

              $success = "Concurso cadastrado com sucesso!";
              return redirect()->route('concurso.index')->with('success', $success);

            }
            else {

              $error = "Erro ao cadastrar o Concurso!";
              return redirect()->back()->with('error', $error);

            }

          } catch (QueryException $e){

            $error = "Erro ao cadastrar o Concurso! => Possível redundância de um item/produto à mesma concurso ou preenchimento incorrecto dos campos!";

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
      $concurso = $this->concurso->with('itensConcurso.produto', 'cliente')->find($id);
      $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1); 

      return view('concursos.show_concurso', compact('concurso', 'empresa'));
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
      $concurso = $this->concurso->with('itensConcurso.produto', 'formaPagamento', 'cliente')->find($id); 
        // Tras a concurso. Tras os Itens da concurso e dentro da relacao Itensconcurso eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na concurso e sim na itensconcurso, mas eh possivel ter os seus dados partido da concurso como se pode ver.

      return view('concursos.itens_concurso.create_edit_itens_concurso', compact('produtos', 'concurso', 'formas_pagamento'));
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
      $concurso = $this->concurso->find($id);

      try {

        if($concurso->delete()){

          $sucess = 'Concurso removido com sucesso!';
          return redirect()->route('concurso.index')->with('success', $sucess);

        }else{

          $error = 'Erro ao remover o Concurso!';
          return redirect()->back()->with('error', $error);
        }


      } catch (QueryException $e) {

        $error = "Erro ao remover o Concurso. Possivelmente Registo em uso. Necessária a intervenção do Administrador da Base de Dados.!";
        return redirect()->back()->with('error', $error);

      }
    }

    public function pagamentoConcurso(PagamentoConcursoStoreUpdateFormRequest $request){
        //dd($request->all());
      $acronimo_forma_pagamento_naoaplicavel = FormaPagamento::select('id')->where('acronimo', 'naoaplicavel')->first();
      $acronimo_forma_pagamento_naoaplicavel_id = $acronimo_forma_pagamento_naoaplicavel->id;

      $concurso_id = $request->concurso_id;

      $pago = 0;
      $valor_pago = 0.00;
      $remanescente = 0.00;
      $forma_pagamento_id = $acronimo_forma_pagamento_naoaplicavel_id;
      $nr_documento_forma_pagamento = "Nao Aplicavel";


      

      $concurso = $this->concurso->find($concurso_id);

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

      try {

        $concurso->pago = $pago;

        if($concurso->update()){

          if($pago == 0){

            $pagamento_concurso_ids = PagamentoConcurso::select('id')->where('concurso_id', $concurso->id)->get();

            if(sizeof($pagamento_concurso_ids)>0){

              for($i = 0; $i < sizeof($pagamento_concurso_ids); $i++){

                $pagamento_concurso = PagamentoConcurso::find($pagamento_concurso_ids[$i]->id);
                $pagamento_concurso->valor_pago = $valor_pago;
                $pagamento_concurso->forma_pagamento_id = $forma_pagamento_id;
                $pagamento_concurso->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;
                $pagamento_concurso->remanescente = $remanescente;
                $pagamento_concurso->delete();

              }

            }else{
              DB::rollback();
              $error = "Nao existem Pagamentos para esta Factura!";
              return redirect()->back()->with('error', $error);
            }
            

          }else{

            $pagamento_concurso = new PagamentoConcurso;
            $pagamento_concurso->concurso_id = $concurso->id;
            $pagamento_concurso->valor_pago = $valor_pago;
            $pagamento_concurso->forma_pagamento_id = $forma_pagamento_id;
            $pagamento_concurso->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;
            $pagamento_concurso->remanescente = $remanescente;
            $pagamento_concurso->save();

          }

          DB::commit();
          $success = "Pagamento efectuado com sucesso!";
          return redirect()->route('concurso.index')->with('success', $success);

        }else{

          DB::rollback();
          $error = "Pagamento nao efectuado!!";
          return redirect()->back()->with('error', $error);

        }

      } catch (QueryException $e) {
        //echo $e;
        $error = 'Erro ao efectuar o pagamento! Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!';
        return redirect()->back()->with('error', $error);

      }
    }
  }
