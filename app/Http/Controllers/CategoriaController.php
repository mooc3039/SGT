<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Model\Categoria;
use App\Http\Requests\CategoriaStoreUpdateFormRequest;


class CategoriaController extends Controller
{
    
    protected $categoria;

    public function __construct(Categoria $categoria){

        $this->categoria = $categoria;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categorias = $this->categoria->get();

        return view('parametrizacao.categoria.index_categoria', compact('categorias'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('parametrizacao.categoria.create_edit_categoria');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaStoreUpdateFormRequest $request)
    {
        //
        $dataForm = $request->all();

        $cadastro = $this->categoria->create($dataForm);

        if($cadastro){

            $success = "Categoria cadastrada com sucesso.";
            return redirect()->route('categoria.index')->with('success', $success);
        }
        else{

            $error = "Não foi possível cadastrar a Categoria.";
            return redirect()->route('categoria.index')->with('error', $error);
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
        $categoria = $this->categoria->find($id);

        return view('parametrizacao.categoria.create_edit_categoria', compact('categoria'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaStoreUpdateFormRequest $request, $id)
    {
        //
        $dataForm = $request->all();

        $categoria = $this->categoria->find($id);

        $update = $categoria->update($dataForm);

        if($update){

                $success = "Categoria actualizada com sucesso.";
                return redirect()->route('categoria.index')->with('success', $success);
            }
            else{

                $error = "Não foi possível actualizar a Categoria.";
                return redirect()->route('categoria.index')->with('error', $error);
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
        $categoria = $this->categoria->find($id);

          try{

            $delete = $categoria->delete();

            if($delete){

                $sucesso = "Removido com sucesso!";

                return redirect()->route('categoria.index')->with('success', $sucesso);
            }
            else{

                $erro = "Erro ao remover!";

                return redirect()->route('categoria.index')->with('error', $erro);
            }
        }catch (QueryException $e){

            $erro_fk = "Não foi possível remover o registo";

            if($e->getCode()==23000){

                $erro_fk = "Registo em uso! Não foi possível remover o registo!";

                // return view('parametrizacao.categoria.index_categoria')->with('error', $erro_fk);
                return redirect()->route('categoria.index')->with('error', $erro_fk);

            }
            else{
                $erro_fk = "Registo em uso! Não foi possível remover o registo!";
                //return view('parametrizacao.categoria.index_categoria')->with('error', $erro_fk);
                return redirect()->route('categoria.index')->with('error', $erro_fk);
            }
        }
    }

    public function storeRedirectBack(CategoriaStoreUpdateFormRequest $request)
    {

        $dataForm = $request->all();

        $cadastro = $this->categoria->create($dataForm);

        if($cadastro){

            $success = "Categoria cadastrada com sucesso.";
            return redirect()->back()->with('success', $success);
        }
        else{

            $error = "Não foi possível cadastrar a Categoria!";
            return redirect()->back()->with('error', $error);
        }

    }
}
