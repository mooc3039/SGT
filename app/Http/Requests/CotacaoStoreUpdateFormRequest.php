<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotacaoStoreUpdateFormRequest extends FormRequest
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
          'cliente_id' => 'required',
          'tipo_cotacao_id' => 'required',
          'produto_id' => 'required',
        ];
    }

    public function messages(){
        return [
            'cliente_id.required' => 'É necessário selecionar o Cliente!',
            'tipo_cotacao_id.required' => 'É necessário selecionar o tipo da Cotação!',
            'produto_id.required' => 'É necessário selecionar o Produto!',
        ];
    }
}
