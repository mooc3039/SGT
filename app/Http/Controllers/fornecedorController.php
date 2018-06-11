<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Fornecedor;
use App\Http\Requests\FornecedorStoreUpdateFormRequest;

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
      //  $fornecedores = Fornecedor::all(); 
      $fornecedores = Fornecedor::where('activo', 1)->orderBy('nome','asc')->get();
      return view('parametrizacao.fornecedor.lista')->with('fornecedores',$fornecedores);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $fornecedor = Fornecedor::find($id);
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

      $fornecedor = $this->fornecedor->find($id);

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
        //echo $id;
      $fornece = Fornecedor::find($id);
      $fornece->delete();
      return redirect('/fornecedores')->with('success', 'Fornecedor eliminado com sucesso!');
    }

    public function inactivos(){

      $fornecedores = $this->fornecedor->where('activo', 0)->get();
      
      return view('parametrizacao.fornecedor.lista', compact('fornecedores'));
    }

    // Funcao para activar o Fornecedor
    public function activar($id){

      DB::select('call SP_activar_fornecedor(?)', array($id));

      return redirect()->back();

    }

    public function desactivar($id){

      DB::select('call SP_desactivar_fornecedor(?)', array($id));

      return redirect()->back();
      
    }

    public function reportGeralFornecedores(){

        $fornecedores = $this->fornecedor->orderBy('nome', 'asc')->get();

        return view('reports.fornecedores.report_geral_fornecedores', compact('fornecedores'));

    }

    public function storeRedirectBack(FornecedorStoreUpdateFormRequest $request){

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
