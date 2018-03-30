<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\GuiaEntregaStoreUpdateFormRequest;
use App\Model\GuiaEntrega;
use App\Model\ItenGuiaentrega;
use App\Model\Saida;
use App\Model\ItenSaida;
use App\Model\Produto;
use App\Model\Cliente;
use App\User;
use DB;
use Session;
use PDF;
 
class GuiaEntregaController extends Controller
{
    private $guia_entrega;
    private $iten_guiaentrega;
    private $saida;
    private $iten_saida;
    private $produto;
    private $cliente;
    private $user;

    public function __construct(GuiaEntrega $guia_entrega, ItenGuiaentrega $iten_guiaentrega, Saida $saida, ItenSaida $iten_saida, Produto $produto, Cliente $cliente, User $user){

        $this->guia_entrega = $guia_entrega;
        $this->iten_guiaentrega = $iten_guiaentrega;
        $this->saida = $saida;
        $this->iten_saida = $iten_saida;
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
        $guias_entrega = $this->guia_entrega->orderBy('created_at', 'desc')->paginate(10);
        return view('guias_entrega.index_guias_entrega', compact('guias_entrega'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuiaEntregaStoreUpdateFormRequest $request)
    {
        //
        if($request->all()){

          $guia_entrega = new GuiaEntrega;

          $guia_entrega->cliente_id = $request['cliente_id'];
          $guia_entrega->saida_id = $request['saida_id'];
          $guia_entrega->user_id = $request['user_id'];
          $guia_entrega->valor_total = 0; 
        // Eh necessario que o valor total seja zero, uma vez que este campo na tabela guia_entregas eh actualizado pelo trigger apos o "insert" bem como o "update" na tabela itens_guia_entregas de acordo com o codigo da guia_entrega. Nao pode ser o valor_total vindo do formulario, pois este valor sera acrescido a cada insercao abaixo quando executar o iten_guia_entrega->save().

      // $salvar =1;

          DB::beginTransaction();

          try {


            if($guia_entrega->save()){

              $count = count($request->produto_id);

              $guia_id = array('0' => $guia_entrega->id); 
                 // Para inserir o guia_entrega_id no iten_guia_entregas eh necessario converter este unico valor em array, o qual ira assumir o mesmo valor no loop da insercao como eh o mesmo id da guia_entrega para varios itens;
                //$cot_id = array('0' => '20');

              for($i=0; $i<$count; $i++){

                $guia_entrega_id[$i] = $guia_id[0]; 
                    // A cada iteracao o a variavel guia_entrega_id recebe o mesmo id transformado em array com um unico valor na posicao zero;
                $iten_guiaentrega = new ItenGuiaentrega;

                $iten_guiaentrega->produto_id = $request['produto_id'][$i];
                $iten_guiaentrega->quantidade = $request['quantidade'][$i];
                $iten_guiaentrega->valor = $request['subtotal'][$i];
                $iten_guiaentrega->desconto = $request['desconto'][$i];
                $iten_guiaentrega->subtotal = $request['subtotal'][$i];
                $iten_guiaentrega->guia_entrega_id = $guia_entrega_id[$i];
                $iten_guiaentrega->iten_saida_id = $request['iten_saida_id'][$i];

                $iten_guiaentrega->save();

            }

            DB::commit();

            $sucesso = "Guia de Entrega cadastrada com sucesso!";
            Session::flash('success', $sucesso);
            return redirect()->route('saida.index')->with('success', $sucesso);
          // return response()->json($request->all());

        }
        else {

          $error = "Erro a Guia de Entrega!";
          Session::flash('error', $error);
          return redirect()->back()->with('error', $error);

      }

  } catch (QueryException $e){

    $error = "Erro ao cadastrar a Guia de Entrega! => Possível preenchimento incorrecto dos campos!";
    Session::flash('error', $error);

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
        $guia_entrega = $this->guia_entrega->with('itensGuiantrega.produto', 'cliente')->find($id); 
            // Tras a saida. Tras os Itens da Saida e dentro da relacao ItensSaida eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na saida e sim na itensSaida, mas eh possivel ter os seus dados partido da saida como se pode ver.
        
        return view('guias_entrega.show_guia_entrega', compact('guia_entrega'));
    }

    public function showRelatorio($id)
    {
        //
        $guia_entrega = $this->guia_entrega->with('itensGuiantrega.produto', 'cliente')->find($id); 
            // Tras a saida. Tras os Itens da Saida e dentro da relacao ItensSaida eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na saida e sim na itensSaida, mas eh possivel ter os seus dados partido da saida como se pode ver.
         $pdf = PDF::loadView('guias_entrega.relatorio', compact('guia_entrega'));
         return $pdf->download('guia_entrega.pdf');
        // return view('guias_entrega.relatorio', compact('guia_entrega'));
        
    }

    public function showGuiasEntrega($saida_id){

        $guias_entrega = $this->guia_entrega->where('saida_id', $saida_id)->orderBy('created_at', 'desc')->paginate(10);
        return view('guias_entrega.index_saida_guias_entrega', compact('guias_entrega'));

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
        $guia_entrega = $this->guia_entrega->where('id', $id)->first();
        $saida_id = $guia_entrega->saida_id;


        $produtos = DB::table('produtos')->pluck('descricao', 'id')->all();
        $guia_entrega = $this->guia_entrega->with('itensGuiantrega.itenSaida.produto', 'saida.itensSaida', 'cliente')->find($id);
        //dd($guia_entrega);
        // Tras a saida. Tras os Itens da Saida e dentro da relacao ItensSaida eh possivel pegar a relacao Prodtuo atraves do dot ou ponto. NOTA: a relacao produto nao esta na saida e sim na itensSaida, mas eh possivel ter os seus dados partido da saida como se pode ver.

        return view('guias_entrega.itens_guiaentrega.create_edit_itens_guia_entrega', compact('produtos', 'guia_entrega'));
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

            if($this->iten_guiaentrega->where('guia_entrega_id', $id)->delete()){

                $guia_entrega = $this->guia_entrega->find($id);



                if($guia_entrega->delete()){

                    DB::commit();

                    $sucess = 'Guia de Entrega Cancelada!';
                    return redirect()->route('guia_entrega.index')->with('success', $sucess);

                }else{

                    DB::rollback();
                    $error = 'Erro ao Cancelar a Guia de Entrega!';
                    return redirect()->back()->with('error', $error);
                }


            } else{

                    DB::rollback();
                    $error = 'Erro ao Cancelar a Guia de Entrega!';
                    return redirect()->back()->with('error', $error);
                }

        }catch (QueryException $e) {
            DB::rollback();
            $error = "Erro ao Cancelar a Guia de Entrega. Possivelmente possui itens. Necessária a intervenção do Administrador da Base de Dados.!";
            return redirect()->back()->with('error', $error);

        }

    }

    public function createGuia($id){

        $saida = $this->saida->with('itensSaida.produto', 'cliente')->find($id);
        return view('guias_entrega.create_edit_guias_entrega', compact('saida'));
    }
}
