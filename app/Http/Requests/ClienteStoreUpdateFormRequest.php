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
        $id = $this->get('cliente_id'); // Este id vem do formulario a partir de um input hidden

        return [
            //
            'nome' => 'required',
            'telefone' => 'required',
            'nuit' => 'unique:clientes,nuit,'.$id.',id',
            'email' => 'unique:clientes,email,'.$id.',id',
            'activo' => 'required',
            'tipo_cliente_id' => 'required',
        ];
    }

    public function messages(){
        return [
            'nome.required' => 'O nome do cliente é obrigatório.',
            'telefone.required' => 'O telefone é obrigatório.',
            'nuit.unique' => 'O NUIT informado já existe!',
            'email.unique' => 'O email já existe!',
            'activo.required' => 'O Cliente deve ser "Activo" ou "Inactivo"',
            'tipo_cliente_id.required' => 'O Tipo de Cliente é obrigatório',
        ];
    }
}
