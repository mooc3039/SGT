<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facturacao;
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
  $data = Facturacao::all();
  $total_facturacao = Facturacao::count();
  $total_fornecedor = Fornecedor::count();
  $total_cliente = Cliente::count();
  $total_stock = ItenEntrada::count();
  
  $chart = Charts::create('area', 'highcharts')
      ->title('Facturações')
      ->elementLabel("Total")
      ->dimensions(1000, 500)
      ->responsive(false)
      ->labels($data->pluck('produto_id'))
      ->values($data->pluck('quantidade'));

  return view('layouts.home.inicio', ['chart' => $chart], compact('total_facturacao','total_fornecedor','total_cliente','total_stock'));
}
public function paginaInicial()
{
  $data = Facturacao::all();
  $total_facturacao = Facturacao::count();
  $total_fornecedor = Fornecedor::count();
  $total_cliente = Cliente::count();
  $total_stock = ItenEntrada::count();
  
  $chart = Charts::create('area', 'highcharts')
      ->title('Facturações')
      ->elementLabel("Total")
      ->dimensions(1000, 500)
      ->responsive(false)
      ->labels($data->pluck('produto_id'))
      ->values($data->pluck('quantidade'));

  return view('layouts.home.inicio', ['chart' => $chart], compact('total_facturacao','total_fornecedor','total_cliente','total_stock'));
}
}
