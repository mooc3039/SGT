<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Produto;//referente ao model que mexe com a tabela produtos
use App\Saida; //
use App\Model\Cliente;

class FacturarController extends Controller
{
    public function index()
    {

        $produtos = Produto::all();
        $cliente =DB::table('clientes')->pluck('nome','id')->all(); //quando usar laravelcolletive tem que usar o DB no form select
        return view('facturas.index', compact('produtos','cliente'));
    }

    public function insert(Request $request)
    {
      $clientes=new Cliente;
      $clientes->nome=$request->nomefn;
      $clientes->endereco=$request->endereco;
      $clientes->email=$request->email;
      $clientes->telefone=$request->telefone;
      $clientes->nuit=$request->nuit;

      if ($clientes->save()) {
        $id = $clientes->id;
        foreach ($request->descricao as $key=> $v)
        {
          $data = [
            'cliente_id'=>$id,
            'user_id'=>$v,
            'qty'=>$request->qty [$key],
            'price'=>$request->price [$key],
            'desconto'=>$request->dis [$key],
            'subtotal'=>$request->amount [$key]
          ];
          Saida::insert($data);
        }
      }
      return back();
    }
    //devolver o preço do produto
    public function findPrice(Request $request)
    {
      $data = Produto::select('preco_venda')->where('id',$request->id)->first();
      return response()->json($data);
    }
    
}
