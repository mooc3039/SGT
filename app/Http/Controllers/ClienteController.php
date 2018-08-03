<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\ClienteStoreUpdateFormRequest;
use Illuminate\Support\Facades\DB;
use App\Model\Cliente;
use App\Model\TipoCliente;
use PDF;
use Illuminate\Support\Facades\Gate;

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
        if (Gate::denies('listar_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


        $clientes = $this->cliente->all();
        return view('parametrizacao.cliente.index_cliente', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('criar_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


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
        if (Gate::denies('criar_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


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
    if (Gate::denies('criar_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


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
        if (Gate::denies('editar_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


        $tipos_cliente = DB::table('tipo_clientes')->pluck('tipo_cliente', 'id')->all();
        $cliente = $this->cliente->findOrFail($id);

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
        if (Gate::denies('editar_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


        $dataForm = $request->all();

        $cliente = $this->cliente->findOrFail($id);

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

    public function activos(){

      if (Gate::denies('listar_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');

      $clientes = $this->cliente->where('activo', 1)->get();
      
      return view('parametrizacao.cliente.index_cliente', compact('clientes'));
    }


    public function inactivos(){

        if (Gate::denies('listar_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');



        $clientes = $this->cliente->where('activo', 0)->get();

        return view('parametrizacao.cliente.index_cliente', compact('clientes'));
    }

    // Funcao para activar o Cliente
    public function activar($id){

        if (Gate::denies('activar_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


      DB::select('call SP_activar_cliente(?)', array($id));

      return redirect()->back();

  }

  public function desactivar($id){

    if (Gate::denies('desactivar_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');

      DB::select('call SP_desactivar_cliente(?)', array($id));

      return redirect()->back();

  }


  public function reportGeralCliente(){

    if (Gate::denies('relatorio_geral_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


    $acronimo_tipo_cliente = TipoCliente::select('id')->where('acronimo', 'publico')->firstOrFail();
    $acronimo_cli_publico_id = $acronimo_tipo_cliente->id;
    $array_acronimo_cli_publico_id = array('0', $acronimo_cli_publico_id);

    $clientes = $this->cliente->get();

    $total_cliente_todos = Cliente::count();
    $total_cliente_publico = Cliente::where('tipo_cliente_id', $acronimo_cli_publico_id)->count();
    $total_cliente_privado = Cliente::whereNotIn('tipo_cliente_id', $array_acronimo_cli_publico_id)->count();
    $privado = null;
    $publico = null;

    return view('reports.clientes.report_geral_clientes', compact('clientes', 'total_cliente_todos', 'total_cliente_publico', 'total_cliente_privado', 'privado', 'publico'));

}

public function pdf(){
        // $clientes = $this->cliente->orderBy('nome', 'asc')->get();
        // $pdf = PDF::loadView('reports.clientes.report_geral_clientes',compact('clientes'));
        // return $pdf->download('cliente.pdf');
}

public function indexClientePrivado(){

    if (Gate::denies('relatorio_geral_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


    $acronimo_tipo_cliente = TipoCliente::select('id')->where('acronimo', '<>', 'publico')->firstOrFail();
    $acronimo_cli_publico_id = $acronimo_tipo_cliente->id;
    $array_acronimo_cli_publico_id = array('0', $acronimo_cli_publico_id);

    $total_cliente_todos = Cliente::count();
    $total_cliente_publico = Cliente::where('tipo_cliente_id', $acronimo_cli_publico_id)->count();
    $total_cliente_privado = Cliente::whereNotIn('tipo_cliente_id', $array_acronimo_cli_publico_id)->count();
    $privado = 'Privados';
    $publico = null;

    $clientes = $this->cliente->with('tipo_cliente')->where('tipo_cliente_id', $acronimo_cli_publico_id)->get();
    return view('reports.clientes.report_geral_clientes', compact('clientes', 'total_cliente_todos', 'total_cliente_publico', 'total_cliente_privado', 'privado', 'publico'));
}

public function indexClientePublico(){

    if (Gate::denies('relatorio_geral_cliente'))
            // abort(403, "Sem autorizacao");
          return redirect()->route('noPermission');


    $acronimo_tipo_cliente = TipoCliente::select('id')->where('acronimo', 'publico')->firstOrFail();
    $acronimo_cli_publico_id = $acronimo_tipo_cliente->id;
    $array_acronimo_cli_publico_id = array('0', $acronimo_cli_publico_id);

    $clientes = $this->cliente->with('tipo_cliente')->where('tipo_cliente_id', $acronimo_cli_publico_id)->get();

    
    $total_cliente_todos = Cliente::count();
    $total_cliente_publico = Cliente::where('tipo_cliente_id', $acronimo_cli_publico_id)->count();
    $total_cliente_privado = Cliente::whereNotIn('tipo_cliente_id', $array_acronimo_cli_publico_id)->count();
    $privado = null;
    $publico = 'Instituições Públicas/Estado';
    return view('reports.clientes.report_geral_clientes', compact('clientes', 'total_cliente_todos', 'total_cliente_publico', 'total_cliente_privado', 'privado', 'publico'));
}
}
