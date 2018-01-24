<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Produto;//
use App\Model\Saida;
use App\Model\ItenSaida; //
use App\Model\Cliente;
use App\User;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::all();
        $cliente =DB::table('clientes')->pluck('nome','id')->all(); //quando usar laravelcolletive tem que usar o DB no form select
        return view('facturas.index', compact('produtos','cliente'));
    }

    //devolver o preço do produto
    public function findPrice(Request $request)
    {
      $data = Produto::select('preco_venda')->where('id',$request->id)->first();
      return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $produtos = Produto::all();
        $cliente =DB::table('clientes')->pluck('nome','id')->all(); //quando usar laravelcolletive tem que usar o DB no form select
        return view('facturas.index', compact('produtos','cliente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        //facturar
        $saida = new Saida;
        $saida->user_id = auth()->user()->id; 
        //$saida->valor_total = $request->geElementById('total');
        $saida->cliente_id = $request->input('nome');
        $saida->desconto = $request->input('desconto');
        $saida->subtotal = $request->input('subtotal');
   
       // $saida->save();
        if ($saida->save()) 
        {
            $id = $saida->id;
            $produtos = Produto::all();
            foreach($produtos as $pro=>$v)
            {
                $data = [
                    'saida_id'=>$id,
                    'produto_id'=>$v->id,
                    'quantidade'=>$request->quantidade,
                    'valor'=>$request->preco_venda,
                  ];
                  ItenSaida::insert($data);
                  return redirect('/facturas')->with('success', 'Cliente Facturado com sucesso');
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
}
