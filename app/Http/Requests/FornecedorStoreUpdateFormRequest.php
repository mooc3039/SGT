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
        return [
            //
            'nome' => 'required',
            'telefone' => 'required',
            'email' => 'unique:clientes',
            'activo' => 'required',
        ];
    }

    public function messages(){
        return [
            'nome.required' => 'O nome do Fornecedor é obrigatório.',
            'telefone.required' => 'O telefone é obrigatório.',
            'email.unique' => 'O email já existe!',
            'acivo.required' => 'O Activo é obrigatório.',
        ];
    }
}
