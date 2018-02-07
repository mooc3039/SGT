<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facturacao;
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
  $chart = Charts::create('donut', 'highcharts')
      ->title('Facturações')
      ->elementLabel("Total")
      ->dimensions(1000, 500)
      ->responsive(false)
      ->labels($data->pluck('produto_id'))
      ->values($data->pluck('quantidade'));

  return view('layouts.home.inicio', ['chart' => $chart]);
}
public function paginaInicial()
{
  $data = Facturacao::all();
        $chart = Charts::create('donut', 'highcharts')
            ->title('Facturações')
            ->elementLabel("Total")
            ->dimensions(1000, 500)
            ->responsive(false)
            ->labels($data->pluck('produto_id'))
            ->values($data->pluck('quantidade'));

  return view('layouts.home.inicio', ['chart' => $chart]);
}
}
