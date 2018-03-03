<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Facturacao;
use App\Produto;
use App\Model\Cliente;
use App\TipoCliente;
use App\User;
use PDF;

class FacturacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $produtos = Produto::all();
        $tipo_clientes =TipoCliente::all();
        $cliente = Cliente::all();
        return view('facturas.index', compact('produtos','tipo_clientes','cliente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produtos = Produto::all();
        $tipo_clientes =TipoCliente::all();
        $cliente = Cliente::all();
        return view('facturas.index', compact('produtos','tipo_clientes','cliente','sub_kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $input)
    {
     
        

        if(request()->ajax()){
            $count = count($input->subtotal);
            for($i=0; $i < $count; $i++){
                $d = new Facturacao;
 //               $d->cliente_id = $input['nome'][$i];
              //  $d->user_id = auth()->user()->id;
                $d->produto_id = $input['descricao'][$i];
                $d->quantidade = $input['quantidade'][$i];
                $d->preco_venda = $input['preco_venda'][$i];
                $d->desconto = $input['desconto'][$i];
                $d->subtotal = $input['subtotal'][$i];
                $d->save();
               // Facturacao::insert($d); // Eloquent approach
               // DB::table('facturacoes')->insert($d); // Query Builder approach
             }
               return response()->json($input->all());
            }
           // return response('Facturado com sucesso');
           
        
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
    }
    //devolver o preço do produto
    public function findPrice(Request $request)
    {
      $data = Produto::select('preco_venda', 'quantidade_dispo', 'quantidade_min')->where('id',$request->id)->first();
      return response()->json($data);
    }
    //trabalhando na dependencia dos combos
    public function subKategori(Request $req)
    {
        $data = Cliente::select('nome','id')->where('tipo_cliente_id',$req->id)->take(100)->get();
        return response()->json($data);
        
    }
}
