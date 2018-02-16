<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\ClienteStoreUpdateFormRequest;
use Illuminate\Support\Facades\DB;
use App\Model\Cliente;

class ClienteController extends Controller
{

    private $cliente;

    public function __construct(Cliente $cliente){
        $this->cliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clientes = $this->cliente->with('tipo_cliente')->where('activo', 1)->orderBy('nome', 'asc')->paginate(7);
        return view('parametrizacao.cliente.index_cliente', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tipos_cliente = DB::table('tipo_clientes')->pluck('tipo_cliente', 'id')->all();
        return view('parametrizacao.Cliente.create_edit_cliente', compact('tipos_cliente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteStoreUpdateFormRequest $request)
    {
        //
        $dataForm = $request->all();

        try {

          if($this->cliente->create($dataForm)){

              $success = "Cliente cadastrado com sucesso.";
              return redirect()->route('cliente.index')->with('success', $success);
          }
          else{

              $error = "Não foi possível cadastrar o Cliente.";
              return redirect()->route('cliente.index')->with('error', $error);
          }

        } catch (QueryException $e) {

          $error = 'Erro ao cadastrar o Cliente! Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!';
          return redirect()->route('cliente.index')->with('error', $error);

        }

    }

    public function storeRedirectBack(ClienteStoreUpdateFormRequest $request)
    {
        $dataForm = $request->all();

      try {

        if($this->cliente->create($dataForm)){

            $success = "Cliente cadastrado com sucesso.";
            return redirect()->back()->with('success', $success);
        }
        else{

            $error = "Não foi possível cadastrar o Cliente.";
            return redirect()->back()->with('error', $error);
        }

      } catch (QueryException $e) {

        $error = 'Erro ao cadastrar o Cliente! Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!';
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
        //
        $tipos_cliente = DB::table('tipo_clientes')->pluck('tipo_cliente', 'id')->all();
        $cliente = $this->cliente->find($id);

        return view('parametrizacao.cliente.create_edit_cliente', compact('cliente', 'tipos_cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteStoreUpdateFormRequest $request, $id)
    {
        //

            $dataForm = $request->all();

            $cliente = $this->cliente->find($id);

            $update = $cliente->update($dataForm);

            if($update){

                $success = "Cliente actualizado com sucesso.";
                return redirect()->route('cliente.index')->with('success', $success);
            }
            else{

                $error = "Não foi possível actualizar o Cliente.";
                return redirect()->route('cliente.index')->with('error', $error);
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
        //
    }

    public function inactivos(){

        $clientes = $this->cliente->where('activo', 0)->orderBy('nome', 'asc')->paginate(7);

        return view('parametrizacao.cliente.index_cliente', compact('clientes'));
    }

    // Funcao para activar o Cliente
    public function activar($id){

      DB::select('call SP_activar_cliente(?)', array($id));

      return redirect()->back();

    }

    public function desactivar($id){

      DB::select('call SP_desactivar_cliente(?)', array($id));

      return redirect()->back();

    }


    public function reportGeralCliente(){

        $clientes = $this->cliente->orderBy('nome', 'asc')->get();

        return view('reports.clientes.report_geral_clientes', compact('clientes'));

    }
}
