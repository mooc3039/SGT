<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoCotacaoStoreUpdateFormRequest extends FormRequest
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
      $id = $this->get('tipo_cotacao_id'); // Este id vem do formulario a partir de um input hidden

        return [
            'nome' => 'required|unique:tipo_cotacaos,nome,'.$id.',id',
        ];
    }

    public function messages(){
        return [
            'nome.required' => 'O nome do Tipo de Cotação é obrigatório!',
            'nome.unique' => 'O nome do Tipo de Cotação informado já existe!',
        ];
    }
}
