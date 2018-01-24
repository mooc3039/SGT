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

    public function insert(Request $req)
    {
      if($req->ajax()){
        $count = count($req->id);
        for($i=0; $i<$count; $i++){
            $d = new Saida;
            $d->cliente_id = $req->nome[$i];
            $d->user_id = auth()->user()->id;
            $d->desconto = $req->desconto[$i];
            $d->subtotal = $req->subtotal[$i];
            $d->save();
        }
        return response()->json($req->all());
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
