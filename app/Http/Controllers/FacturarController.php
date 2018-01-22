<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Produto;//referente ao model que mexe com a tabela produtos
use App\Model\Saida;
use App\Model\ItenSaida; //
use App\Model\Cliente;
use App\User;

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
      
      $saidas=new Saida;
      //$saidas->valor_total=$request->valor_total;
      $saidas->user_id = auth()->user()->id;   
      $saidas->cliente_id=$request->nome;
      $saidas->desconto=$request->desconto;
      $saidas->subtotal=$request->subtotal;
      
     

      if ($saidas->save()) {
        $id = $saidas->id;
        foreach ($request->descricao as $key=> $v)
        {
          $data = [
            'saida_id'=>$id,
            'produto_id'=>$v,
            'quantidade'=>$request->quantidade [$key],
            'valor'=>$request->valor_total [$key],
          ];
          ItenSaida::insert($data);
          return redirect('/facturas/index')->with('success', 'Cliente Facturado com sucesso');
          
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
