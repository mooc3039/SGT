<?php

namespace App\Http\Controllers;

// use Illuminate\Database\QueryException;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\SaidaStoreUpdateFormRequest;
use App\Http\Requests\PagamentoSaidaStoreUpdateFormRequest;
use App\Model\Empresa;
use App\Model\Ano;
use App\Model\Me;
use App\Model\Saida;
use App\Model\NotaFalta;
use App\Model\Concurso;
use App\Model\ItenConcurso;
use App\Model\TipoCliente;
use App\Model\ItenSaida;
use App\Model\ItenNotaFalta;
use App\Model\PagamentoSaida;
use App\Model\FormaPagamento;
use App\Model\Produto;
use App\Model\MotivoIva;
use App\Model\Cliente;
use App\User;
use DB;
use Session;
use PDF;
use Illuminate\Support\Facades\Gate;

class SaidaController extends Controller
{

  private $saida;
  private $pagamento_saida;
  private $nota_falta;
  private $iten_saida;
  private $concurso;
  private $iten_concurso;
  private $produto;
  private $motivo_iva;
  private $cliente;
  private $tipo_cliente;
  private $user;

  public function __construct(Saida $saida, Concurso $concurso, ItenConcurso $iten_concurso, NotaFalta $nota_falta, Produto $produto, MotivoIva $motivo_iva, Cliente $cliente, TipoCliente $tipo_cliente, User $user){

    $this->saida = $saida;
    $this->concurso = $concurso;
    $this->iten_concurso = $iten_concurso;
    $this->nota_falta = $nota_falta;
    $this->produto = $produto;
    $this->motivo_iva = $motivo_iva;
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
      if (Gate::denies('listar_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $saidas = $this->saida->with('itensSaida', 'pagamentosSaida')->get();
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();

      return view('saidas.index_saida', compact('saidas', 'formas_pagamento'));

    }

    public function IndexSaidaNormal()
    {
      if (Gate::denies('listar_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $saidas = $this->saida->with('itensSaida', 'pagamentosSaida')->where('concurso_id', 0)->get();
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();

      return view('saidas.index_saida', compact('saidas', 'formas_pagamento'));

    }

    public function IndexSaidaDeConcurso()
    {
      if (Gate::denies('listar_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $saidas = $this->saida->with('itensSaida', 'pagamentosSaida')->where('concurso_id', '!=', 0)->get();
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();

      return view('saidas.index_saida', compact('saidas', 'formas_pagamento'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if (Gate::denies('criar_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $acronimo = TipoCliente::select('id')->where('acronimo', 'publico')->first();
      $acronimo_id = $acronimo->id;

      $clientes = DB::table('clientes')->whereNotIn('tipo_cliente_id', [$acronimo_id])->pluck('nome', 'id')->all();
      $tipos_cliente = DB::table('tipo_clientes')->pluck('tipo_cliente', 'id')->all();
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();
      $produtos = $this->produto->select('id', 'descricao')->get();
      $motivos_iva = $this->motivo_iva->select('id', 'motivo_nao_aplicacao')->get();

      return view('saidas.create_edit_saida', compact('clientes', 'tipos_cliente', 'formas_pagamento' , 'produtos', 'motivos_iva'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaidaStoreUpdateFormRequest $request)
    {
      if (Gate::denies('criar_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $acronimo_forma_pagamento_naoaplicavel = FormaPagamento::select('id')->where('acronimo', 'naoaplicavel')->first();
      $acronimo_forma_pagamento_naoaplicavel_id = $acronimo_forma_pagamento_naoaplicavel->id;
      $bad_symbols = array(",");

      if($request->all()){


        $pago = 0;
        $valor_pago = 0.00;
        $remanescente = 0.00;
        $forma_pagamento_id = $acronimo_forma_pagamento_naoaplicavel_id;
        $nr_documento_forma_pagamento = "Nao Aplicavel";
        $nr_referencia = "Nao Aplivael";
        $concurso_id = 0;

        if($request['aplicacao_motivo_iva'] == 1){
          $remanescente = str_replace($bad_symbols, "", $request['subtotal_sem_iva']);
        }
        else{
          $remanescente = str_replace($bad_symbols, "", $request['valor_total_iva']);
        }


        if($request['pago'] == 0){

          $pago = $pago;
          $valor_pago = str_replace($bad_symbols, "", $valor_pago);
          $remanescente = $remanescente;
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

          // Referencia e Concurso
        if(!empty($request['nr_referencia'])){
          $nr_referencia = $request['nr_referencia'];
        }

        if(!empty($request['concurso_id'])){
          $concurso_id = $request['concurso_id'];
        }



        DB::beginTransaction();

        try {

          $cliente_id = $request['cliente_id'];
          $user_id = $request['user_id'];
          $aplicacao_motivo_iva = $request['aplicacao_motivo_iva'];
          $motivo_iva_id = $request['motivo_iva_id'];
          $valor_total = 0; 
          $valor_iva = 0;
          $iva = 0;

          $saida = new Saida;
          $nota_falta = new NotaFalta;

          $saida->cliente_id = $cliente_id;
          $saida->user_id = $user_id;
          $saida->aplicacao_motivo_iva = $aplicacao_motivo_iva;
          $saida->motivo_iva_id = $motivo_iva_id;
          $saida->valor_total = $valor_total; 
          $saida->valor_iva = $valor_iva;
          $saida->iva = $iva;
          // Eh necessario que o valor total seja zero, uma vez que este campo na tabela saidas eh actualizado pelo trigger apos o "insert" bem como o "update" na tabela itens_saidas de acordo com o codigo da saida. Nao pode ser o valor_total vindo do formulario, pois este valor sera acrescido a cada insercao abaixo quando executar o iten_cotacao->save().

          $saida->pago = $pago;
          $saida->nr_referencia = $nr_referencia;
          $saida->concurso_id = $concurso_id;

          if($saida->save()){

            // Nota de Falta
            $nota_falta->cliente_id = $cliente_id;
            $nota_falta->user_id = $user_id;
            $nota_falta->aplicacao_motivo_iva = $aplicacao_motivo_iva;
            $nota_falta->motivo_iva_id = $motivo_iva_id;
            $nota_falta->valor_total = $valor_total; 
            $nota_falta->valor_iva = $valor_iva;
            $nota_falta->iva = $iva;
            $nota_falta->saida_id = $saida->id; // pega o id da saida apos ter-se salvo a saida;

            // Salva a nota de falta com os mesmos dados da saida
            $nota_falta->save();

            $count = count($request->produto_id);

              $sai_id = array('0' => $saida->id); // Para inserir o cotacao_id no iten_cotacaos eh necessario converter este unico valor em array, o qual ira assumir o mesmo valor no loop da insercao como eh o mesmo id da cotacao para varios itens;
              $nota_f_id = array('0' => $nota_falta->id);

              for($i=0; $i<$count; $i++){

                $array_saida_id[$i] = $sai_id[0]; // A cada iteracao o a variavel cotacao_id recebe o mesmo id transformado em array com um unico valor na posicao zero;
                $array_nota_falta_id[$i] = $nota_f_id[0];

                $produto_id = $request['produto_id'][$i];
                $quantidade = str_replace($bad_symbols, "", $request['quantidade'][$i]);
                $quantidade_rest = str_replace($bad_symbols, "", $request['quantidade'][$i]);
                $valor = str_replace($bad_symbols, "", $request['valor'][$i]);
                $valor_rest = str_replace($bad_symbols, "", $request['valor'][$i]);
                $desconto = str_replace($bad_symbols, "", $request['desconto'][$i]);
                $subtotal = str_replace($bad_symbols, "", $request['subtotal'][$i]);
                $subtotal_rest = str_replace($bad_symbols, "", $request['subtotal'][$i]) ;
                $saida_id = $array_saida_id[$i];
                $nota_falta_id = $array_nota_falta_id[$i];

                $iten_nota_falta =  new ItenNotaFalta;
                $iten_saida =  new ItenSaida;

                $iten_nota_falta->produto_id = $produto_id;
                $iten_nota_falta->quantidade = 0;
                $iten_nota_falta->valor = 0.0;
                $iten_nota_falta->desconto = 0.0;
                $iten_nota_falta->subtotal = 0.0;
                $iten_nota_falta->nota_falta_id = $nota_falta_id;

                $iten_saida->produto_id = $produto_id;
                $iten_saida->quantidade = $quantidade;
                $iten_saida->quantidade_rest = $quantidade_rest;
                $iten_saida->valor = $valor;
                $iten_saida->valor_rest = $valor_rest;
                $iten_saida->desconto = $desconto;
                $iten_saida->subtotal = $subtotal;
                $iten_saida->subtotal_rest = $subtotal_rest;
                $iten_saida->saida_id = $saida_id;


                $iten_nota_falta->save();
                $iten_saida->save();
                

                if(isset($request->salvar_saida_concurso)){
                  $concu_id = array('0' => $request->concurso_id);
                }

                if(isset($request->salvar_saida_concurso)){
                  $array_concurso_id[$i] = $concu_id[0];

                  DB::select('call SP_decrementar_rest_iten_concursos(?,?,?)', array(
                    $request['quantidade'][$i],
                    $array_concurso_id[$i],
                    $request['produto_id'][$i]
                  )
                );
                }

              }

              // Pagamento da Saida
              $pagamento_saida = new PagamentoSaida;
              $pagamento_saida->saida_id = $saida->id;
              $pagamento_saida->valor_pago = $valor_pago;
              $pagamento_saida->forma_pagamento_id = $forma_pagamento_id;
              $pagamento_saida->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;
              $pagamento_saida->remanescente = $remanescente;
              $pagamento_saida->save();


              DB::commit();

              $success = "Saída cadastrada com sucesso!";
              return redirect()->route('saida.index')->with('success', $success);

            }
            else {
              DB::rollback();
              $error = "Erro ao cadastrar a Saída!";
              return redirect()->back()->with('error', $error);

            }

          } catch (QueryException $e){

            $error = "Erro ao cadastrar a Cotacao! => Possível redundância de um item/produto à mesma Factura ou preenchimento incorrecto dos campos!";
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
      if (Gate::denies('visualizar_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


        $saida = $this->saida->with('itensSaida.produto', 'cliente')->findOrFail($id); // Tras a saida. Tras os Itens da Saida e dentro da relacao ItensSaida eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na saida e sim na itensSaida, mas eh possivel ter os seus dados partido da saida como se pode ver.
        $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1); 
        
        return view('saidas.show_saida', compact('saida', 'empresa'));

      }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if (Gate::denies('editar_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $produtos = DB::table('produtos')->pluck('descricao', 'id')->all();
      $motivos_iva = DB::table('motivo_ivas')->pluck('motivo_nao_aplicacao', 'id')->all();
      $saida = $this->saida->with('itensSaida.produto', 'cliente')->findOrFail($id); 
        // Tras a saida. Tras os Itens da Saida e dentro da relacao ItensSaida eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na saida e sim na itensSaida, mas eh possivel ter os seus dados partido da saida como se pode ver.
      $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1);

      return view('saidas.itens_saida.create_edit_itens_saida', compact('produtos', 'motivos_iva', 'saida', 'empresa'));
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
      if (Gate::denies('editar_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $saida = $this->saida->findOrFail($id);
      $nota_falta = $this->nota_falta->where('saida_id', $saida->id)->firstOrFail(); // Existe apenas uma Nota de Falta para cada Saida;

      $aplicacao_motivo_iva = $request->aplicacao_motivo_iva;
      $motivo_iva_id = $request->motivo_iva_id;

      // Actualizar motivo da nao aplicacao do iva na Saida
      $saida->aplicacao_motivo_iva = $aplicacao_motivo_iva;
      $saida->motivo_iva_id = $motivo_iva_id;

      // Actualizar motivo da nao aplicacao do iva na Nota de Falta
      $nota_falta->aplicacao_motivo_iva = $aplicacao_motivo_iva;
      $nota_falta->motivo_iva_id = $motivo_iva_id;

      DB::beginTransaction();

      try{
        $saida->update();
        $nota_falta->update();

        DB::commit();
        $sucess = 'Saída actualizada com sucesso!';
        return redirect()->back()->with('success', $sucess);

      }catch(QueryException $e){
        DB::rollback();
        $error = 'Erro ao actualizar a Saída!';
        return redirect()->back()->with('error', $error);
      }
    }

    public function motivoNaoAplicacaoImposto(Request $request){

      if (Gate::denies('editar_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $saida_id = $request->saida_id;

      $dataForm = [
        'motivo_justificativo_nao_iva' => $request->motivo_justificativo_nao_iva,
      ];

      $saida_motivo_justificativo = $this->saida->findOrFail($saida_id);

      if($saida_motivo_justificativo->update($dataForm)){

        $sucess = 'Motivo Justificativo da não aplicação de imposto actualizado com sucesso!';
        return redirect()->back()->with('success', $sucess);


      }else{
        $error = 'Erro ao actualizar o Motivo Justificativo da não aplicação de imposto!';
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
      if (Gate::denies('apagar_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      DB::beginTransaction();
      try {

        $saida = $this->saida->findOrFail($id);

        if(empty($saida->pagamentosSaida()->where('saida_id', $id)->get())){
          $saida->delete();
          DB::commit();
          $sucess = 'Factura removida com sucesso!';
          return redirect()->route('saida.index')->with('success', $sucess);
        }else{
          $saida->pagamentosSaida()->where('saida_id', $id)->delete();
          $saida->delete();
          DB::commit();
          $sucess = 'Factura removida com sucesso!';
          return redirect()->route('saida.index')->with('success', $sucess);
        }

      } catch (QueryException $e) {
        DB::rollback();
        $error = "Erro ao remover Factura. Possivel Registo em uso. Necessária a intervenção do Administrador da Base de Dados.!";
        return redirect()->back()->with('error', $error);

      }
    }

    public function saidaPublicoCreate(){

      if (Gate::denies('criar_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $acronimo = TipoCliente::select('id')->where('acronimo', 'publico')->first();
      $acronimo_id = $acronimo->id;

      $clientes = DB::table('clientes')->where('tipo_cliente_id', $acronimo_id)->pluck('nome', 'id')->all();
      $tipos_cliente = DB::table('tipo_clientes')->pluck('tipo_cliente', 'id')->all();
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();
      $produtos = $this->produto->select('id', 'descricao')->get();
      $motivos_iva = $this->motivo_iva->select('id', 'motivo_nao_aplicacao')->get();

      return view('saidas.publicos.create_edit_saida_publico', compact('clientes', 'tipos_cliente', 'formas_pagamento' , 'produtos', 'motivos_iva'));
    }

    public function saidaConcursoCreate(){

      if (Gate::denies('criar_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      // $concurso_valor_zero_id = Concurso::select('id')->where('valor_total', 0)->get();
      $concurso_id_qtd_rest_zero = ItenConcurso::select('concurso_id')->where('quantidade_rest','>', 0)->distinct()->get();
      $array_concurso_id = array();

      if(sizeof($concurso_id_qtd_rest_zero)>0){
        for($i=0;$i<sizeof($concurso_id_qtd_rest_zero); $i++){
          $array_concurso_id[] = $concurso_id_qtd_rest_zero[$i]->concurso_id;
        }
      }
      
      $clientes = DB::table('clientes')->pluck('nome', 'id')->all();
      $concursos = DB::table('concursos')->whereIn('id', $array_concurso_id)->pluck('codigo_concurso', 'id')->all();
      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();
      // $concurso = $this->concurso->with('itensConcurso.produto', 'cliente')->find($id);

      return view('saidas.concursos.create_edit_saida_concurso', compact('concursos', 'clientes', 'formas_pagamento'));
    }

    public function pagamentoSaida(PagamentoSaidaStoreUpdateFormRequest $request){

      if (Gate::denies('efectuar_pagamento_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $acronimo_forma_pagamento_naoaplicavel = FormaPagamento::select('id')->where('acronimo', 'naoaplicavel')->first();
      $acronimo_forma_pagamento_naoaplicavel_id = $acronimo_forma_pagamento_naoaplicavel->id;
      $bad_symbols = array(",");

      $saida_id = $request->saida_id;

      $pago = 0;
      $valor_pago = 0.00;
      $remanescente = 0.00;
      $forma_pagamento_id = $acronimo_forma_pagamento_naoaplicavel_id;
      $nr_documento_forma_pagamento = "Nao Aplicavel";

      

      $saida = $this->saida->findOrFail($saida_id);

      if($request['pago'] == 0){
// dd($request->all());
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

      try {

        $saida->pago = $pago;
        // $saida->valor_pago = $valor_pago;
        // $saida->remanescente = $remanescente;
        // $saida->forma_pagamento_id = $forma_pagamento_id;
        // $saida->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;


        if($saida->update()){

          if($pago == 0){

            $pagamento_saida_ids = PagamentoSaida::select('id')->where('saida_id', $saida->id)->get();

            if(sizeof($pagamento_saida_ids)>0){

              for($i = 0; $i < sizeof($pagamento_saida_ids); $i++){

                $pagamento_saida = PagamentoSaida::findOrFail($pagamento_saida_ids[$i]->id);
                $pagamento_saida->valor_pago = $valor_pago;
                $pagamento_saida->forma_pagamento_id = $forma_pagamento_id;
                $pagamento_saida->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;
                $pagamento_saida->remanescente = $remanescente;
                $pagamento_saida->delete();

              }

            }else{
              DB::rollback();
              $error = "Nao existem Pagamentos para esta Factura!";
              return redirect()->back()->with('error', $error);
            }
            

          }else{
            $pagamento_saida = new PagamentoSaida;
            $pagamento_saida->saida_id = $saida->id;
            $pagamento_saida->valor_pago = $valor_pago;
            $pagamento_saida->forma_pagamento_id = $forma_pagamento_id;
            $pagamento_saida->nr_documento_forma_pagamento = $nr_documento_forma_pagamento;
            $pagamento_saida->remanescente = $remanescente;
            $pagamento_saida->save();
          }

          DB::commit();
          $success = "Pagamento efectuado com sucesso!";
          return redirect()->route('saida.index')->with('success', $success);

        }else{

          DB::rollback();
          $error = "Pagamento nao efectuado!!";
          return redirect()->back()->with('error', $error);

        }

      } catch (QueryException $e) {
        DB::rollback();
        $error = 'Erro ao efectuar o pagamento! Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!';
        return redirect()->back()->with('error', $error);

      }
    }

    public function createPagamentoSaida($id){

      if (Gate::denies('efectuar_pagamento_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $formas_pagamento = DB::table('forma_pagamentos')->pluck('descricao', 'id')->all();
      $saida = $this->saida->with('pagamentosSaida.formaPagamento')->where('id', $id)->first();
      // dd($saida);

      return view('saidas.pagamentos.index_pagamentos_saida', compact('formas_pagamento', 'saida'));
    }

    public function report($id){

        // Relatorio em pdf
      $saida = $this->saida->with('itensSaida.produto', 'cliente')->findOrFail($id);

      $view = view('reports.saidas.report_saida', compact('saida'));
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($view);

      return $pdf->stream('saida');

        //$products = Product::all();

        // return \PDF::loadView('reports.saidas.report_saida', compact('saida'))
        //         // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
        // ->stream();

        /*$pdf = PDF::loadView('reports.saidas.report_saida', compact('saida'));
        return $pdf->download('mypdf.pdf');
*/
      }

      public function showRelatorio($id)
      {
        if (Gate::denies('imprimir_factura'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


        $saida = $this->saida->with('itensSaida.produto', 'cliente')->findOrFail($id); 
        $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1);
        $pdf = PDF::loadView('saidas.relatorio', compact('saida','empresa'));
        return $pdf->download('factura-'.$saida->codigo.'.pdf');
        
      }

      public function notaDeFalta($id){

        if (Gate::denies('visualizar_nota_de_falta'))
          return redirect()->route('noPermission');


        // Existe apenas uma Nota de Falta para esta Saida na DB
        $saida = $this->saida->findOrFail($id);
        $nota_falta = $this->nota_falta->with('itensNotaFalta.produto', 'cliente')->where('saida_id', $saida->id)->firstOrFail();
        $empresa = Empresa::with('enderecos', 'telefones', 'emails', 'contas')->findOrFail(1); 
        
        return view('saidas.nota_de_falta_saida', compact('saida', 'nota_falta', 'empresa'));
      }

      public function reportGeralSaidas(){

        if (Gate::denies('relatorio_geral_factura'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');

        $valor_saida_sem_iva = $this->saida->where('concurso_id', 0)->where('aplicacao_motivo_iva', 1)->sum('valor_total');
        $valor_saida_com_iva = $this->saida->where('concurso_id', 0)->where('aplicacao_motivo_iva', 0)->sum('valor_iva');
        $valor_saida = $valor_saida_sem_iva + $valor_saida_com_iva;
        $valor_saida_pago = PagamentoSaida::whereIn('saida_id', function($query){
          $query->select('id')->from('saidas')->where('concurso_id', 0);
        })->sum('valor_pago');
        $mes = null;
        $ano = null;

        $saidas = $this->saida->with('itensSaida', 'user', 'cliente')->where('concurso_id', 0)->get();
        $anos = DB::table('anos')->pluck('ano', 'id')->all();
        $meses = DB::table('mes')->pluck('nome', 'id')->all();

        return view('reports.saidas.report_geral_saidas', compact('saidas', 'valor_saida', 'valor_saida_pago', 'anos', 'meses', 'mes', 'ano'));

      }

      public function reportGeralSaidasDeConcurso(){

        if (Gate::denies('relatorio_geral_factura'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


        $valor_saida_sem_iva = $this->saida->where('concurso_id', '!=', 0)->where('aplicacao_motivo_iva', 1)->sum('valor_total');
        $valor_saida_com_iva = $this->saida->where('concurso_id', '!=', 0)->where('aplicacao_motivo_iva', 0)->sum('valor_iva');
        $valor_saida = $valor_saida_sem_iva + $valor_saida_com_iva;
        $valor_saida_pago = PagamentoSaida::WhereIn('saida_id', function($query){
          $query->select('id')->from('saidas')->where('concurso_id', '!=', 0);
        })->sum('valor_pago');
        $mes = null;
        $ano = null;

        $saidas = $this->saida->with('itensSaida', 'user', 'cliente')->where('concurso_id', '!=', 0)->get();
        $anos = DB::table('anos')->pluck('ano', 'id')->all();
        $meses = DB::table('mes')->pluck('nome', 'id')->all();

        return view('reports.saidas.report_geral_saidas_concursos', compact('saidas', 'valor_saida', 'valor_saida_pago', 'anos', 'meses', 'mes', 'ano'));

      }

      public function listarSaidaPorMes(Request $request){

        if (Gate::denies('relatorio_geral_factura'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


        $mes_id = $request->mes_id;
        $mes_model = Me::select('nome')->where('id', $mes_id)->firstOrFail();
        $mes = $mes_model->nome;
        $ano = null;
      // dd($mes_id);


        $saidas = $this->saida->with('itensSaida', 'pagamentosSaida', 'user', 'cliente')->where('concurso_id', 0)->whereMonth('data', $mes_id)->get();
        $valor_saida_sem_iva = $this->saida->where('concurso_id', 0)->where('aplicacao_motivo_iva', 1)->whereMonth('data', $mes_id)->sum('valor_total');
        $valor_saida_com_iva = $this->saida->where('concurso_id', 0)->where('aplicacao_motivo_iva', 0)->whereMonth('data', $mes_id)->sum('valor_iva');
        $valor_saida = $valor_saida_sem_iva + $valor_saida_com_iva;
        $valor_saida_pago = 0;
        $anos = DB::table('anos')->pluck('ano', 'id')->all();
        $meses = DB::table('mes')->pluck('nome', 'id')->all();

        foreach ($saidas as $saida) {
         foreach ($saida->pagamentosSaida as $pagamentos) {
           $valor_saida_pago = $valor_saida_pago + $pagamentos->valor_pago;
         }
       }

       return view('reports.saidas.report_geral_saidas', compact('saidas', 'valor_saida', 'valor_saida_pago', 'anos', 'meses', 'mes', 'ano'));

     }

     public function listarSaidaDeConcursoPorMes(Request $request){

      if (Gate::denies('relatorio_geral_factura'))
        return redirect()->route('noPermission');


      $mes_id = $request->mes_id;
      $mes_model = Me::select('nome')->where('id', $mes_id)->firstOrFail();
      $mes = $mes_model->nome;
      $ano = null;


      $saidas = $this->saida->with('itensSaida', 'pagamentosSaida', 'user', 'cliente')->where('concurso_id', '!=', 0)->whereMonth('data', $mes_id)->get();
      $valor_saida_sem_iva = $this->saida->where('concurso_id', '!=', 0)->where('aplicacao_motivo_iva', 1)->whereMonth('data', $mes_id)->sum('valor_total');
      $valor_saida_com_iva = $this->saida->where('concurso_id', '!=',  0)->where('aplicacao_motivo_iva', 0)->whereMonth('data', $mes_id)->sum('valor_iva');
      $valor_saida = $valor_saida_sem_iva + $valor_saida_com_iva;
      $valor_saida_pago = 0;
      $anos = DB::table('anos')->pluck('ano', 'id')->all();
      $meses = DB::table('mes')->pluck('nome', 'id')->all();

      foreach ($saidas as $saida) {
        foreach ($saida->pagamentosSaida as $pagamentos) {
          $valor_saida_pago = $valor_saida_pago + $pagamentos->valor_pago;
        }
      }

      return view('reports.saidas.report_geral_saidas_concursos', compact('saidas', 'valor_saida', 'valor_saida_pago', 'anos', 'meses', 'mes', 'ano'));

    }

    public function listarSaidaPorAno(Request $request){

      if (Gate::denies('relatorio_geral_factura'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


       //dd($request->all());
      $ano_id = $request->ano_id;
      $ano_model = Ano::select('ano')->where('id', $ano_id)->firstOrFail();
      $ano = $ano_model->ano;
      $mes = null;


      $saidas = $this->saida->with('itensSaida', 'pagamentosSaida', 'user', 'cliente')->where('concurso_id', 0)->whereYear('data', $ano)->get();
      $valor_saida_sem_iva = $this->saida->where('concurso_id', 0)->where('aplicacao_motivo_iva', 1)->whereYear('data', $ano)->sum('valor_total');
      $valor_saida_com_iva = $this->saida->where('concurso_id', 0)->where('aplicacao_motivo_iva', 0)->whereYear('data', $ano)->sum('valor_iva');
      $valor_saida = $valor_saida_sem_iva + $valor_saida_com_iva;
      $valor_saida_pago = 0;
      $anos = DB::table('anos')->pluck('ano', 'id')->all();
      $meses = DB::table('mes')->pluck('nome', 'id')->all();

      foreach ($saidas as $saida) {
       foreach ($saida->pagamentosSaida as $pagamentos) {
         $valor_saida_pago = $valor_saida_pago + $pagamentos->valor_pago;
       }
     }


     return view('reports.saidas.report_geral_saidas', compact('saidas', 'valor_saida', 'valor_saida_pago', 'anos', 'meses', 'ano', 'mes'));
   }

   public function listarSaidaDeConcursoPorAno(Request $request){

    if (Gate::denies('relatorio_geral_factura'))
            // abort(403, "Sem autorizacao");
      return redirect()->route('noPermission');


       //dd($request->all());
    $ano_id = $request->ano_id;
    $ano_model = Ano::select('ano')->where('id', $ano_id)->firstOrFail();
    $ano = $ano_model->ano;
    $mes = null;


    $saidas = $this->saida->with('itensSaida', 'pagamentosSaida', 'user', 'cliente')->where('concurso_id', '!=',  0)->whereYear('data', $ano)->get();
    $valor_saida_sem_iva = $this->saida->where('concurso_id', '!=',  0)->where('aplicacao_motivo_iva', 1)->whereYear('data', $ano)->sum('valor_total');
    $valor_saida_com_iva = $this->saida->where('concurso_id', '!=',  0)->where('aplicacao_motivo_iva', 0)->whereYear('data', $ano)->sum('valor_iva');
    $valor_saida = $valor_saida_sem_iva + $valor_saida_com_iva;
    $valor_saida_pago = 0;
    $anos = DB::table('anos')->pluck('ano', 'id')->all();
    $meses = DB::table('mes')->pluck('nome', 'id')->all();

    foreach ($saidas as $saida) {
      foreach ($saida->pagamentosSaida as $pagamentos) {
       $valor_saida_pago = $valor_saida_pago + $pagamentos->valor_pago;
     }
   }


   return view('reports.saidas.report_geral_saidas_concursos', compact('saidas', 'valor_saida', 'valor_saida_pago', 'anos', 'meses', 'ano', 'mes'));
 }

 public function findConcursoDados(Request $request)
 {
  $concurso = $this->concurso->with('itensConcurso.produto', 'pagamentosConcurso.formaPagamento', 'cliente', 'formaPagamento')->findOrFail($request->id);
  return response()->json($concurso);
}
}
