<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlterarLoginRequest extends FormRequest
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
            'username' => 'required|unique:users,username,'.$id.',id',
            'senha' => 'required|confirmed',
        ];
    }

    public function messages(){

        return [
            'username.required' => 'O Usuário é obrigatório.',
            'username.unique' => 'O Usuário indicado já existe.',
            'senha.required' => 'A Senha é obrigatória.',
            'senha.confirmed' => 'As Senhas não são compatíveis.',
        ];
        
    }

    
}
