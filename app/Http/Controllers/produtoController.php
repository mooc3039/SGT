<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\ProdutoStoreUpdateFormRequest;
use DB;
use App\Model\Produto;
use App\Model\Fornecedor;
use App\Model\Categoria;

class produtoController extends Controller
{
    private $produto;
    private $fornecedor;
    private $categoria;

    public function __construct(Produto $produto, Fornecedor $fornecedor, Categoria $categoria){

        $this->produto = $produto;
        $this->fornecedor = $fornecedor;
        $this->categoria = $categoria;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = $this->produto->with('categoria', 'fornecedor')->get();

        return view('parametrizacao.produto.index_produto', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoria =DB::table('categorias')->pluck('nome','id')->all();
        $fornecedor =DB::table('fornecedors')->pluck('nome','id')->all();
        return view('parametrizacao.produto.create_edit_produto',compact('fornecedor','categoria'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdutoStoreUpdateFormRequest $request)
    {
        // dd($request->all());
        $dataForm = $request->all();

        $cadastro = $this->produto->create($dataForm);

        if($cadastro){

            $success = "Produto cadastrado com sucesso.";
            return redirect()->route('produtos.index')->with('success', $success);
        }
        else{

            $error = "Não foi possível cadastrar o Produto!";
            return redirect()->route('produtos.index')->with('error', $error);
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
        //echo $id;
        $produto = Produto::findOrFail($id);
        $categoria =DB::table('categorias')->pluck('nome','id')->all();
        $fornecedor =DB::table('fornecedors')->pluck('nome','id')->all();
        return view('parametrizacao.produto.create_edit_produto', compact('categoria','fornecedor'))->with('produto', $produto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProdutoStoreUpdateFormRequest $request, $id)
    {

      $dataForm = $request->all();

      $produto = $this->produto->findOrFail($id);

      $update = $produto->update($dataForm);

      $dataForm = $request->all();

      if($update){

        $success = "Produto actualizado com sucesso.";
        return redirect()->route('produtos.index')->with('success', $success);
    }
    else{

        $error = "Não foi possível actualizar o Produto.";
        return redirect()->route('produtos.index')->with('error', $error);
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

        $produto = Produto::findOrFail($id);
        // $produto->delete();
        // return redirect('/produtos')->with('success', 'Produto eliminado com sucesso!');

        try {

          if($produto->delete()){

            $sucess = 'Produto removido com sucesso!';
            return redirect()->back()->with('success', $sucess);

        }else{

            $error = 'Erro ao remover o Produto!';
            return redirect()->back()->with('error', $error);

        }

    } catch (QueryException $e) {

      $error = "Erro ao remover o Produto! Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!";
      return redirect()->back()->with('error', $error);

  }
}

public function listarTodos()
{

    $produtos = $this->produto->with('categoria', 'fornecedor')->get();

    $categorias = DB::table('categorias')->select('nome', 'id')->get();

    $fornecedores = DB::table('fornecedors')->select('nome', 'id')->get();

    return view('reports.produtos.report_geal_produto', compact('produtos','fornecedores', 'categorias'));
}


public function listarPorCategoria($id){

    $produtos = $this->produto->with('fornecedor', 'categoria')->where('categoria_id', $id)->orderBy('descricao', 'asc')->get();

    return response()->json($produtos);

}


public function listarPorFornecedor($id){

    $produtos = $this->produto->with('fornecedor', 'categoria')->where('fornecedor_id', $id)->orderBy('descricao', 'asc')->get();

    return response()->json($produtos);

}

public function findPrice(Request $request)
{
  $data = Produto::select('preco_venda', 'preco_aquisicao', 'quantidade_dispo', 'quantidade_min')->where('id',$request->id)->first();
  return response()->json($data);
}


}
