<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleStoreUpdateFormRequest extends FormRequest
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
        $id = $this->get('role_id');

        return [
            'nome'=>'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'nome.required'=>'O Tipo de Usúario é obrigatório!',
            // 'nome.alpha'=>'O Tipo de Usúario deve conter apenas caracteres alfabéticos!',
            'nome.min'=>'O Tipo de Usúario deve conter no mínimo três carateres!',
        ];
    }
}
