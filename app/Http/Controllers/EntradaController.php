<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Produto;
use App\Model\Entrada;
use App\User;

class EntradaController extends Controller
{

    private $entrada;
    private $produto;
    private $user;

    public function __construct(Entrada $entrada, Produto $produto, User $user){

        $this->entrada = $entrada;
        $this->produto = $produto;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $entradas = $this->entrada->orderBy('data', 'asc')->paginate(10);
        
        return view('entradas.index_entrada', compact('entradas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $entrada = $this->entrada->with('itensEntrada.produto', 'user')->find($id); 
        
        return view('entradas.show_entrada', compact('entrada'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reportGeralEntradas(){

        $entradas = $this->entrada->with('user')->orderBy('id', 'asc')->get();

        return view('reports.entradas.report_geral_entradas', compact('entradas'));

    }
}
