<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fornecedor;

class paginasController extends Controller
{
  public function __construct()
  {
    $this->middleware('web');
  }
  //Paginas de Facturação
    public function indexFacturacao()
    {
      return view('facturas.index_facturas');
    }
  //Paginas de Sock
  public function indexStock()
    {
      return view('stock.index_stock');
    }
  //Paginas de Parametrização
  

      public function indexUsuario()
        {
          return view('parametrizacao.usuarios');
        }
        public function indexCliente()
          {
            return view('parametrizacao.cliente');
          }
}
