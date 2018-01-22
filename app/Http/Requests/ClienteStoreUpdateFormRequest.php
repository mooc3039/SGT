<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteStoreUpdateFormRequest extends FormRequest
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
        ];
    }

    public function messages(){
        return [
            'nome.required' => 'O nome do cliente é obrigatório.',
            'telefone.required' => 'O telefone é obrigatório.',
            'email.unique' => 'O email já existe!',
        ];
    }
}
