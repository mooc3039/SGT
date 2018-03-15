<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VendaStoreUpdateFormRequest;

use App\Model\Venda;
use App\Model\ItenVenda;
use App\Model\Produto;
use App\Model\Cliente;
use App\User;
use DB;
use Session;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendaStoreUpdateFormRequest $request)
    {
        //dd($request->all());

        if($request->all()){


          $venda = new Venda;

          $venda->cliente_id = $request['cliente_id'];
          $venda->user_id = $request['user_id'];
          $venda->valor_total = 0; // Eh necessario que o valor total seja zero, uma vez que este campo na tabela cotacaos eh actualizado pelo trigger apos o "insert" bem como o "update" na tabela itens_cotacaos de acordo com o codigo da cotacao. Nao pode ser o valor_total vindo do formulario, pois este valor sera acrescido a cada insercao abaixo quando executar o iten_cotacao->save().
          $venda->pago = $request['pago'];
          $venda->valor_pago = $request['valor_pago'];
          $venda->troco = $request['troco'];

          // $salvar =1;

          DB::beginTransaction();

          try {


            if($venda->save()){

              $count = count($request->produto_id);

              $sai_id = array('0' => $venda->id); // Para inserir o cotacao_id no iten_cotacaos eh necessario converter este unico valor em array, o qual ira assumir o mesmo valor no loop da insercao como eh o mesmo id da cotacao para varios itens;
              //$cot_id = array('0' => '20');

              for($i=0; $i<$count; $i++){

                $venda_id[$i] = $sai_id[0]; // A cada iteracao o a variavel cotacao_id recebe o mesmo id transformado em array com um unico valor na posicao zero;

                $iten_venda =  new Itenvenda;

                $iten_venda->produto_id = $request['produto_id'][$i];
                $iten_venda->quantidade = $request['quantidade'][$i];
                $iten_venda->valor = $request['valor'][$i];
                $iten_venda->desconto = $request['desconto'][$i];
                $iten_venda->subtotal = $request['subtotal'][$i];
                $iten_venda->venda_id = $venda_id[$i];

                $iten_venda->save();

            }

            DB::commit();

            $success = "Venda cadastrada com sucesso!";
            return redirect()->route('venda.index')->with('success', $success);

        }
        else {

          $error = "Erro ao cadastrar a Venda!";
          return redirect()->back()->with('error', $error);

      }

  } catch (QueryException $e){

    $error = "Erro ao cadastrar a Venda! => Possível redundância de um item/produto à mesma venda ou preenchimento incorrecto dos campos!";
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
        // Tras a saida. Tras os Itens da Saida e dentro da relacao ItensSaida eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na saida e sim na itensSaida, mas eh possivel ter os seus dados partido da saida como se pode ver.

        return view('vendas.itens_venda.create_edit_itens_venda', compact('produtos', 'venda', 'formas_pagamento'));
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

    public function pagamentoVenda(Request $request){
        //dd($request->all());

        $dataForm = [
            'pago' => $request->pago,
            'valor_pago' => $request->valor_pago,
            'troco' => $request->troco,
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'nr_documento_forma_pagamento' => $request->nr_documento_forma_pagamento,
        ];

        $venda_id = $request->venda_id;


        try {

            $venda = $this->venda->find($venda_id);
            
            if($venda->update($dataForm)){

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
}
