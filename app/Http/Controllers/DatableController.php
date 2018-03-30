<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use Yajra\Datatables\Datatables;//yajira

class DatableController extends Controller
{
    public function index()
    {
        return view('teste.datatable');
    }

    public function get_datatable()
    {
        return Datatables::of(Produto::query())->make(true);
    }
}
