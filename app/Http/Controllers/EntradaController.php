<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\PagamentoEntradaStoreUpdateFormRequest;
use App\Http\Requests\EntradaStoreUpdateFormRequest;
use App\Model\Produto;
use App\Model\Entrada;
use App\Model\ItenEntrada;
use App\User;
use DB;
use Session;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntradaStoreUpdateFormRequest $request)
    {
        //
        //dd($request->all());

        if($request->all()){


          $entrada = new Entrada;

          $entrada->fornecedor_id = $request['fornecedor_id'];
          $entrada->user_id = $request['user_id'];
          $entrada->valor_total = 0; // Eh necessario que o valor total seja zero, uma vez que este campo na tabela cotacaos eh actualizado pelo trigger apos o "insert" bem como o "update" na tabela itens_cotacaos de acordo com o codigo da cotacao. Nao pode ser o valor_total vindo do formulario, pois este valor sera acrescido a cada insercao abaixo quando executar o iten_cotacao->save().

          if($request['pago'] == 0){

            $entrada->pago = $request['pago'];
            $entrada->valor_pago = 0.00;
            $entrada->troco = 0.00;
            $entrada->forma_pagamento_id = 1;
            $entrada->nr_documento_forma_pagamento = 'Nao Aplicavel';

          }else{

            $entrada->pago = $request['pago'];

            if(empty($request['valor_pago'])){
              $entrada->valor_pago = 0.00;
            }else{
              $entrada->valor_pago = $request['valor_pago'];
            }

            if(empty($request['troco'])){
              $entrada->troco = 0.00;
            }else{
              $entrada->troco = $request['troco'];
            }

            if(empty($request['forma_pagamento_id'])){
              $entrada->forma_pagamento_id = 1;
            }else{
              $entrada->forma_pagamento_id = $request['forma_pagamento_id'];
            }

            if(empty($request['nr_documento_forma_pagamento'])){
              $entrada->nr_documento_forma_pagamento = 'Nao Aplicavel';
            }else{
              $entrada->nr_documento_forma_pagamento = $request['nr_documento_forma_pagamento'];
            }

          }

          // $salvar =1;

          DB::beginTransaction();

          try {


            if($entrada->save()){

              $count = count($request->produto_id);

              $entr_id = array('0' => $entrada->id); // Para inserir o cotacao_id no iten_cotacaos eh necessario converter este unico valor em array, o qual ira assumir o mesmo valor no loop da insercao como eh o mesmo id da cotacao para varios itens;
              //$cot_id = array('0' => '20');

              for($i=0; $i<$count; $i++){

                $entrada_id[$i] = $entr_id[0]; // A cada iteracao o a variavel cotacao_id recebe o mesmo id transformado em array com um unico valor na posicao zero;

                $iten_entrada =  new ItenEntrada;

                $iten_entrada->produto_id = $request['produto_id'][$i];
                $iten_entrada->quantidade = $request['quantidade'][$i];
                $iten_entrada->valor = $request['valor'][$i];
                $iten_entrada->desconto = $request['desconto'][$i];
                $iten_entrada->subtotal = $request['subtotal'][$i];
                $iten_entrada->entrada_id = $entrada_id[$i];

                $iten_entrada->save();

            }

            DB::commit();

            $success = "Entrada cadastrada com sucesso!";
            return redirect()->route('entrada.index')->with('success', $success);

        }
        else {

          $error = "Erro ao cadastrar a entrada!";
          return redirect()->back()->with('error', $error);

      }

  } catch (QueryException $e){

    $error = "Erro ao cadastrar a Entrada! => Possível redundância de um item/produto à mesma entrada ou preenchimento incorrecto dos campos!";
    //Session::flash('error', $erro);

    DB::rollback();

    //return response()->json(['status'=>'error']);
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
        
        return view('entradas.show_entrada', compact('entrada'));
    }
    public function showRelatorio($id)
    {
        //
        $entrada = $this->entrada->with('itensEntrada.produto', 'user')->find($id); 
            // Tras a saida. Tras os Itens da Saida e dentro da relacao ItensSaida eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na saida e sim na itensSaida, mas eh possivel ter os seus dados partido da saida como se pode ver.
         $pdf = PDF::loadView('entradas.relatorio', compact('entrada'));
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

      return view('entradas.itens_entrada.create_edit_itens_entrada', compact('produtos', 'entrada', 'formas_pagamento'));
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
        $entrada = $this->entrada->find($id);

        try {

          if($entrada->delete()){

            $sucess = 'Entrada removida com sucesso!';
            return redirect()->route('entrada.index')->with('success', $sucess);

          }else{

            $error = 'Erro ao remover a Entrada!';
            return redirect()->back()->with('error', $error);
          }


        } catch (QueryException $e) {

          $error = "Erro ao remover Entrada. Possivelmente Registo em uso. Necessária a intervenção do Administrador da Base de Dados.!";
          return redirect()->back()->with('error', $error);

        }
    }

    public function pagamentoEntrada(PagamentoEntradaStoreUpdateFormRequest $request){
        //dd($request->all());

        $entrada_id = $request->entrada_id;


        try {

            $entrada = $this->entrada->find($entrada_id);

            if($request['pago'] == 0){

            $entrada->pago = $request['pago'];
            $entrada->valor_pago = 0.00;
            $entrada->troco = 0.00;
            $entrada->forma_pagamento_id = 1;
            $entrada->nr_documento_forma_pagamento = 'Nao Aplicavel';

          }else{

            $entrada->pago = $request['pago'];

            if(empty($request['valor_pago'])){
              $entrada->valor_pago = 0.00;
            }else{
              $entrada->valor_pago = $request['valor_pago'];
            }

            if(empty($request['troco'])){
              $entrada->troco = 0.00;
            }else{
              $entrada->troco = $request['troco'];
            }

            if(empty($request['forma_pagamento_id'])){
              $entrada->forma_pagamento_id = 1;
            }else{
              $entrada->forma_pagamento_id = $request['forma_pagamento_id'];
            }

            if(empty($request['nr_documento_forma_pagamento'])){
              $entrada->nr_documento_forma_pagamento = 'Nao Aplicavel';
            }else{
              $entrada->nr_documento_forma_pagamento = $request['nr_documento_forma_pagamento'];
            }

          }
            
            if($entrada->update()){

                $success = "Pagamento efectuado com sucesso!";
                return redirect()->back()->with('success', $success);

            }else{

                $error = "Pagamento nao efectuado!!";
                return redirect()->back()->with('error', $error);

            }

        } catch (QueryException $e) {
        //echo $e;
            $error = 'Erro ao efectuar o pagamento! Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!';
            return redirect()->back()->with('error', $error);

        }
    }

    public function reportGeralEntradas(){

        $entradas = $this->entrada->with('user')->orderBy('id', 'asc')->get();

        return view('reports.entradas.report_geral_entradas', compact('entradas'));

    }

    public function entradaTeste($id){
        echo "Teste";
    }
}
