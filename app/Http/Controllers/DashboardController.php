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
  
  $chart = Charts::create('line', 'highcharts')
      ->title('Facturações')
      ->elementLabel("Total")
      ->dimensions(1000, 500)
      ->responsive(false)
      //->labels($data->pluck('produto_id'))
      ->labels(['Carlos','Ossmane','Osório','Marcos'])
      ->values($data->pluck('quantidade'));

  return view('layouts.home.inicio', ['chart' => $chart], compact('total_facturacao','total_fornecedor','total_cliente','total_stock'));
}
public function paginaInicial()
{
  $data = ItenSaida::all();
  $total_facturacao = Saida::count();
  $total_fornecedor = Fornecedor::count();
  $total_cliente = Cliente::count();
  $total_stock = ItenEntrada::count();
  
  // $chart = Charts::create('line', 'highcharts')
  //     ->title('Facturações')
  //     ->elementLabel("Total")
  //     ->dimensions(1000, 500)
  //     ->responsive(false)
  //     //->labels($data->pluck('produto_id'))
  //     ->labels(['Carlos','Ossmane','Osório','Marcos'])
  //     ->values($data->pluck('quantidade'));

  return view('layouts.home.inicio',  compact('total_facturacao','total_fornecedor','total_cliente','total_stock'));
}
}
