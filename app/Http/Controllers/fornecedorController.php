<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Model\Fornecedor;
use App\Http\Requests\FornecedorStoreUpdateFormRequest;
use Illuminate\Support\Facades\Gate;

class fornecedorController extends Controller
{

  private $fornecedor;

  public function __construct(Fornecedor $fornecedor){

    $this->fornecedor = $fornecedor;

  }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (Gate::denies('listar_fornecedor'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $fornecedores = $this->fornecedor->all();
      return view('parametrizacao.fornecedor.lista', compact('fornecedores'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      if (Gate::denies('criar_fornecedor'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


     return view('parametrizacao.fornecedor.create_edit_fornecedor');
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FornecedorStoreUpdateFormRequest $request)
    {
      if (Gate::denies('criar_fornecedor'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $dataForm = $request->all();

      $cadastro = $this->fornecedor->create($dataForm);
      
      if($cadastro){

            $success = "Fornecedor cadastrado com sucesso.";
            return redirect()->route('fornecedores.index')->with('success', $success);
        }
        else{

            $error = "Não foi possível cadastrar o Fornecedor.";
            return redirect()->route('fornecedores.index')->with('error', $error);
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

      if (Gate::denies('visualizar_fornecedor'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if (Gate::denies('editar_fornecedor'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $fornecedor = Fornecedor::findOrFail($id);
      return view('parametrizacao.fornecedor.create_edit_fornecedor', compact('fornecedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FornecedorStoreUpdateFormRequest $request, $id)
    {
      if (Gate::denies('editar_fornecedor'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      /*$this->validate($request, [
        'nome' => 'required',
        'endereco' => 'required',
        'email' => 'required | email',
        'telefone' => 'required | numeric',
        'rubrica' => 'required'   
      ]);*/

          //criar fornecdor
      /*$fornecedor = Fornecedor::find($id);
      $fornecedor->nome = $request->input('nome');
      $fornecedor->endereco = $request->input('endereco');
      $fornecedor->email = $request->input('email');
      $fornecedor->telefone = $request->input('telefone');
      $fornecedor->rubrica = $request->input('rubrica');
      $fornecedor->activo = $request->input('activo');
      $fornecedor->save();*/

      $dataForm = $request->all();

      $fornecedor = $this->fornecedor->findOrFail($id);

      $update = $fornecedor->update($dataForm);

      if($update){

                $success = "Fornecedor actualizado com sucesso.";
                return redirect()->route('fornecedores.index')->with('success', $success);
            }
            else{

                $error = "Não foi possível actualizar o Fornecedor.";
                return redirect()->route('fornecedores.index')->with('error', $error);
            }

      //return redirect('/fornecedores')->with('success', 'Dados do Fornecedor Actualizados com Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if (Gate::denies('apagar_fornecedor'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');


      $fornece = Fornecedor::findOrFail($id);
      $fornece->delete();
      return redirect('/fornecedores')->with('success', 'Fornecedor eliminado com sucesso!');
    }

    public function activos(){

      $fornecedores = $this->fornecedor->where('activo', 1)->get();
      
      return view('parametrizacao.fornecedor.lista', compact('fornecedores'));
    }

    public function inactivos(){

      $fornecedores = $this->fornecedor->where('activo', 0)->get();
      
      return view('parametrizacao.fornecedor.lista', compact('fornecedores'));
    }

    // Funcao para activar o Fornecedor
    public function activar($id){

      if (Gate::denies('activar_fornecedor'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');



      DB::select('call SP_activar_fornecedor(?)', array($id));

      return redirect()->back();

    }

    public function desactivar($id){

      if (Gate::denies('desactivar_fornecedor'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');

      DB::select('call SP_desactivar_fornecedor(?)', array($id));

      return redirect()->back();
      
    }

    public function reportGeralFornecedores(){

      if (Gate::denies('relatorio_geral_fornecedor'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');



        $fornecedores = $this->fornecedor->orderBy('nome', 'asc')->get();

        return view('reports.fornecedores.report_geral_fornecedores', compact('fornecedores'));

    }

    public function storeRedirectBack(FornecedorStoreUpdateFormRequest $request){

      if (Gate::denies('criar_fornecedor'))
            // abort(403, "Sem autorizacao");
        return redirect()->route('noPermission');



        $fornecedor = $this->fornecedor->all();

        $dataForm = $request->all();

        $cadastro = $this->fornecedor->create($dataForm);

        if($cadastro){

            $success = "Fornecedor cadastrado com sucesso.";
            return redirect()->back()->with('success', $success);
        }
        else{

            $error = "Não foi possível cadastrar o Fornecedor.";
            return redirect()->back()->with('error', $error);
        }

    }

  }
