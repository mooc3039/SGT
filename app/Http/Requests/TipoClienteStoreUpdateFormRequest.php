<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoClienteStoreUpdateFormRequest extends FormRequest
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
        $id = $this->get('tipo_cliente_id'); // Este id vem do formulario a partir de um input hidden

        return [
            'tipo_cliente' => 'required|unique:tipo_clientes,tipo_cliente,'.$id.',id',
        ];
    }

    public function messages(){
        return [
            'tipo_cliente.required' => 'O nome do Tipo de Cliente é obrigatório!',
            'tipo_cliente.unique' => 'O nome do Tipo de Cliente já existe!',
        ];
    }
}
