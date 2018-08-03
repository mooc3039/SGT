<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioUpdateRequest extends FormRequest
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
        $id = $this->get('usuario_id');

        return [
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'unique:users,email,'.$id.',id',
            'occupation' => 'required',
            'active' => 'required',
        ];
    }

    public function messages(){

        return [
            'role_id.required' => 'O Tipo do Usuário é obrigatório',
            'name.required' => 'O nome do Usuário é obrigatório.',
            'email.unique' => 'O Email já existe!',
            'occupation.required' => 'A ocupação é obrigatório.',
            'active.required' => 'O usuário deve ser Activo ou Inactivo.',
        ];
        
    }
}
