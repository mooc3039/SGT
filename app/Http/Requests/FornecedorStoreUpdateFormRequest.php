<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FornecedorStoreUpdateFormRequest extends FormRequest
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
        $id = $this->get('fornecedor_id');

        return [
            //
            'nome' => 'required',
            'telefone' => 'required',
            'email' => 'unique:fornecedors,email,'.$id.',id',
            'nuit' => 'required|unique:fornecedors,nuit,'.$id.',id',
            'activo' => 'required',
        ];

    }

    public function messages(){

        return [
            'nome.required' => 'O nome do Fornecedor é obrigatório.',
            'telefone.required' => 'O Telefone é obrigatório.',
            'email.unique' => 'O Email já existe!',
            'nuit.required' => 'O NUIT é obrigatório.',
            'nuit.unique' => 'O NUIT já existe!',
            'activo.required' => 'O Fornecedor deve ser Activo ou Inactivo.',
        ];
        
    }
}
