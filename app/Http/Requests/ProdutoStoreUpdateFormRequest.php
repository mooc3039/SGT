<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoStoreUpdateFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'descricao' => 'required',
            'preco_venda' => 'required|numeric ',
            'preco_aquisicao' => 'required | numeric',
            'quantidade_dispo' => 'required|numeric',
            'quantidade_min' => 'numeric', 
            'fornecedor_id' => 'required',
            'categoria_id' => 'required',
        ];
    }

    public function messages(){
        return [
            'descricao.required' => 'A Descrição é obrigatória!',
            'preco_venda.required' => 'O Preço de Venda é obrigatório!',
            'preco_venda.numeric' => 'Apenas valores númericos permitidos para o Preço de Venda!',
            'preco_aquisicao.required' => 'O Preço de Aquisição é obrigatório!',
            'preco_aquisicao.numeric' => 'Apenas valores númericos permitidos para o Preço de Aquisição!',
            'quantidade_dispo.required' => 'A Quantidade Disponível é obrigatória!',
            'quantidade_dispo.numeric' => 'Apenas valores númericos permitidos para a Quantidade Disponível',
            'quantidade_min.numeric' => 'Apenas valores númericos permitidos para a Quantidade Miníma!', 
            'fornecedor_id.required' => 'É necessário selecionar o Fornecedor!',
            'categoria_id.required' => 'É necessário selecionar a Categoria!',
        ];
    }
}
