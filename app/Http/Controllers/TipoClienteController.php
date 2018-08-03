<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\TipoClienteStoreUpdateFormRequest;
use App\Model\TipoCliente;
use Illuminate\Support\Facades\Gate;

class TipoClienteController extends Controller
{
    private $tipo_cliente;

    public function __construct(TipoCliente $tipo_cliente){
        $this->tipo_cliente = $tipo_cliente;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('listar_tipo_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


        $tipos_cliente = $this->tipo_cliente->get();
        return view('parametrizacao.cliente.tipos_cliente.index_tipos_cliente', compact('tipos_cliente'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('criar_tipo_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


        return view ('parametrizacao.cliente.tipos_cliente.create_edit_tipos_cliente');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoClienteStoreUpdateFormRequest $request)
    {
        // dd($request->all());
        if (Gate::denies('criar_tipo_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


        $dataForm = $request->all();

        try {

          if($this->tipo_cliente->create($dataForm)){

            $sucess = 'Tipo de Cliente cadastrado com sucesso!';
            return redirect()->route('tipo_cliente.index')->with('success', $sucess);

          }else{

            $error = 'Erro ao cadastrar o Tipo de Cliente!';
            return redirect()->back()->with('error', $error);

          }


        } catch (QueryException $e) {

          $error = "Erro ao cadastrar o Tipo de Cliente. Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!";
          return redirect()->back()->with('error', $error);

        }

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
        if (Gate::denies('editar_tipo_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


        $tipo_cliente = $this->tipo_cliente->findOrFail($id);
        return view('parametrizacao.cliente.tipos_cliente.create_edit_tipos_cliente', compact('tipo_cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoClienteStoreUpdateFormRequest $request, $id)
    {
        if (Gate::denies('editar_tipo_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


        $dataForm = $request->all();
        $tipo_cliente = $this->tipo_cliente->findOrFail($id);

        try {

          if($tipo_cliente->update($dataForm)){

            $sucess = 'Tipo de Cliente actualizado com sucesso!';
            return redirect()->route('tipo_cliente.index')->with('success', $sucess);

          }else{

            $error = 'Erro ao remover o Tipo de Cliente!';
            return redirect()->back()->with('error', $error);
          }


        } catch (QueryException $e) {

          $error = "Erro ao actualizar o Tipo de Cliente. Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!";
          return redirect()->back()->with('error', $error);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('apagar_tipo_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


        $tipo_cliente = $this->tipo_cliente->findOrFail($id);

        try {

          if($tipo_cliente->delete()){

            $sucess = 'Tipo de Cliente removido com sucesso!';
            return redirect()->route('tipo_cliente.index')->with('success', $sucess);

          }else{

            $error = 'Erro ao remover o Tipo de Cliente!';
            return redirect()->back()->with('error', $error);
          }


        } catch (QueryException $e) {

          $error = "Erro ao remover o Tipo de Cliente. Possivelmente <b>Registo em uso</b>. Necessária a intervenção do Administrador da Base de Dados.!";
          return redirect()->back()->with('error', $error);

        }
    }
}
