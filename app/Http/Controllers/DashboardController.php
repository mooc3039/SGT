<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Saida;
use App\Model\ItenSaida;
use App\Model\PagamentoSaida;
use App\Model\Entrada;
use App\Model\PagamentoEntrada;
use App\Model\Venda;
use App\Model\PagamentoVenda;
use App\Fornecedor;
use App\Model\Cliente;
use App\Model\TipoCliente;
use App\Model\ItenEntrada;
use Charts;

class DashboardController extends Controller
{
  public function __construct()
  {
    $this->middleware('web');
  }


  public function dashboard()
  {
   $mes = date('m');
   $data = ItenSaida::all();
   $total_facturacao = Saida::count();
   $total_fornecedor = Fornecedor::count();
   $total_stock = ItenEntrada::count();

   $entradas = Entrada::with('pagamentosEntrada')->whereMonth('created_at', $mes)->get();
   $valor_entrada = Entrada::whereMonth('created_at', $mes)->sum('valor_total');
   $valor_entrada_pago = 0;

   foreach ($entradas as $entrada) {
       foreach ($entrada->pagamentosEntrada as $pagamentos) {
         $valor_entrada_pago = $valor_entrada_pago + $pagamentos->valor_pago;
       }
     }

   // SAIDA
   $saidas = Saida::whereMonth('data', $mes)->where('concurso_id', '=', 0)->get();
   $valor_saida = Saida::with('pagamentosSaida')->whereMonth('data', $mes)->where('concurso_id', '=', 0)->sum('valor_iva');
  //  $saida_ids_concurso_zero = Saida::where('concurso_id', '=', 0)->get();

  //  $array_saida_id = array();

  //  if(sizeof($saida_ids_concurso_zero)>0){
  //   for($i=0;$i<sizeof($saida_ids_concurso_zero); $i++){
  //     $array_saida_id[] = $saida_ids_concurso_zero[$i]->id;
  //   }
  // }

  // $valor_saida_pago = PagamentoSaida::whereMonth('updated_at', $mes)->whereIn('saida_id', $array_saida_id)->sum('valor_pago');
   $valor_saida_pago = 0;

  foreach ($saidas as $saida) {
       foreach ($saida->pagamentosSaida as $pagamentos) {
         $valor_saida_pago = $valor_saida_pago + $pagamentos->valor_pago;
       }
     }
  // FIM SAIDA

  $vendas = Venda::whereMonth('created_at', $mes)->get();
  $valor_venda = Venda::whereMonth('created_at', $mes)->sum('valor_iva');
  // $valor_venda_pago = PagamentoVenda::whereMonth('updated_at', $mes)->sum('valor_pago');
  $valor_venda_pago = 0;

  foreach ($vendas as $venda) {
       foreach ($venda->pagamentosVenda as $pagamentos) {
         $valor_venda_pago = $valor_venda_pago + $pagamentos->valor_pago;
       }
     }

  $acronimo_cli_publico = TipoCliente::select('id')->where('acronimo', 'publico')->first();
  $acronimo_cli_publico_id = $acronimo_cli_publico->id;

  $array_acronimo_cli_publico_id = array('0', $acronimo_cli_publico_id);

  $total_cliente_publico = Cliente::where('tipo_cliente_id', $acronimo_cli_publico_id)->count();
  $total_cliente_privado = Cliente::whereNotIn('tipo_cliente_id', $array_acronimo_cli_publico_id)->count();
  
  
  return view('layouts.home.inicio',  compact(
    'total_facturacao',
    'total_fornecedor',
    'total_cliente',
    'total_stock',
    'valor_entrada',
    'valor_entrada_pago',
    'valor_saida',
    'valor_saida_pago',
    'valor_venda',
    'valor_venda_pago',
    'total_cliente_publico',
    'total_cliente_privado')); 
}
public function paginaInicial()
{

}
}
