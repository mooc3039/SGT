<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Saida;
use App\Model\ItenSaida;
use App\Fornecedor;
use App\Model\Cliente;
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
  $data = ItenSaida::all();
  $total_facturacao = Saida::count();
  $total_fornecedor = Fornecedor::count();
  $total_cliente = Cliente::count();
  $total_stock = ItenEntrada::count();
  
  
  return view('layouts.home.inicio',  compact('total_facturacao','total_fornecedor','total_cliente','total_stock')); }
}
