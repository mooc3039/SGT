<?php

namespace App\Http\Controllers;

// use Illuminate\Database\QueryException;
use App\Http\Requests\ItenConcursoStoreUpdateFormRequest;
use Illuminate\Http\Request;
use App\Model\ItenConcurso;

class ItenConcursoController extends Controller
{
    private $iten_concurso;

    public function __construct(ItenConcurso $iten_concurso){
        $this->iten_concurso = $iten_concurso;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(ItenConcursoStoreUpdateFormRequest $request)
    {
        //
         // dd($request->all());
        $dataForm = [
            'concurso_id' => $request->concurso_id,
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
            'preco_venda' => $request->preco_venda,
            'valor' => $request->valor,
            'desconto' => $request->desconto,
            'subtotal' => $request->subtotal,
            'user_id' => $request->user_id,
        ];

        try {

          if($this->iten_concurso->create($dataForm)){

            $sucess = 'Item inserido com sucesso!';
            return redirect()->back()->with('success', $sucess);

        }else{

            $error = 'Erro ao inserir o Item!';
            return redirect()->back()->with('error', $error);

        }


    } catch (QueryException $e) {

        $error = "Erro ao inserir o Item! => Possível redundância do item/produto ao mesmo Concurso  ($request->codigo_concurso).";
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItenConcursoStoreUpdateFormRequest $request, $id)
    {
        //
        // dd($request->all());
        $dataForm = [
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
            'preco_venda' => $request->preco_venda,
            'valor' => $request->valor,
            'desconto' => $request->desconto,
            'subtotal' => $request->subtotal,
            'concurso_id' => $request->concurso_id,
            'user_id' => $request->user_id,
        ];
        
        $concurso_id = $request->concurso_id;
        $produto_id = $request->produto_id;


        try {

            $iten_concurso = ItenConcurso::where('concurso_id', $concurso_id)->where('produto_id', $produto_id)->first();

           if($iten_concurso->update($dataForm)){

            $sucess = 'Item actualizado com sucesso!';
            return redirect()->back()->with('success', $sucess);


        }else{
            $error = 'Erro ao actualizar o Item!';
            return redirect()->back()->with('error', $error);


        }

    } catch (QueryException $e) {
        //echo $e;
        $error = 'Erro ao actualizar o Item! Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados!';
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
        //
        $iten_concurso = $this->iten_concurso->find($id);

        try {

          if($iten_concurso->delete()){

            $sucess = 'Item removido com sucesso!';
            return redirect()->back()->with('success', $sucess);

        }else{

            $error = 'Erro ao remover o Item!';
            return redirect()->back()->with('error', $error);

        }

    } catch (QueryException $e) {

      $error = "Erro ao remover o Item! Erro relacionado ao DB. Necessária a intervenção do Administrador da Base de Dados.!";
      return redirect()->back()->with('error', $error);

  }
    }
}
