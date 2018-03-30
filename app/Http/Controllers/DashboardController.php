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
   $data = ItenSaida::all();
   $total_facturacao = Saida::count();
   $total_fornecedor = Fornecedor::count();
   $total_cliente = Cliente::count();
   $total_stock = ItenEntrada::count();





   return view('layouts.home.inicio',  compact('total_facturacao','total_fornecedor','total_cliente','total_stock'));
 }
 public function paginaInicial()
 {
  $mes = date('m');
  $data = ItenSaida::all();
  $total_facturacao = Saida::count();
  $total_fornecedor = Fornecedor::count();
  $total_stock = ItenEntrada::count();

  $valor_entrada = Entrada::whereMonth('created_at', $mes)->sum('valor_total');
  $valor_entrada_pago = PagamentoEntrada::whereMonth('created_at', $mes)->sum('valor_pago');

  $valor_saida = Saida::whereMonth('data', $mes)->sum('valor_iva');
  $valor_saida_pago = PagamentoSaida::whereMonth('created_at', $mes)->sum('valor_pago');

  $valor_venda = Venda::whereMonth('created_at', $mes)->sum('valor_iva');
  $valor_venda_pago = PagamentoVenda::whereMonth('created_at', $mes)->sum('valor_pago');

  $acronimo_cli_publico = TipoCliente::select('id')->where('acronimo', 'publico')->first();
  $acronimo_cli_publico_id = $acronimo_cli_publico->id;

  $acronimo_cli_nao_publico_id = array('0', $acronimo_cli_publico_id);

  $total_cliente_publico = Cliente::where('tipo_cliente_id', $acronimo_cli_publico_id)->count();
  $total_cliente_privado = Cliente::whereNotIn('tipo_cliente_id', $acronimo_cli_nao_publico_id)->count();
  
  
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
}
