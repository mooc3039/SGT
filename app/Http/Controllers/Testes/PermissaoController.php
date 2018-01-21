<?php

namespace App\Http\Controllers\Testes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Permissao;

class PermissaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $permissao;

    public function __construct(Permissao $permissao){
        $this->permissao = $permissao;
    }


    public function index()
    {
        //
        // MOSTRA AS PERMISSOES CADASTRADAS NO SISTEMA
        $permissoes = $this->permissao->all();

        foreach ($permissoes as $per) {
            # code...
            echo "<b>Nome do cliente:</b> $per->nome <br>";
        }
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
}
