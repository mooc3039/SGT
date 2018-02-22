<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItenSaidaStoreUpdateFormRequest extends FormRequest
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
          'quantidade' => 'required',
          'valor' => 'required',
          'produto_id' => 'required',
          'desconto' => 'required',
          'subtotal' => 'required',
        ];
    }

    public function messages(){
        return [
            'quantidade.required' => 'A Quantidade é obrigatória!',
            'valor.required' => 'O Valor é obrigatória!',
            'produto_id.required' => 'É necessário especificar o Produto!',
            'desconto.required' => 'É necessário especificar o desconto!',
            'subtotal.required' => 'É necessário especificar o Subtotal/Valor a Pagar pela quantidade!',
        ];
    }
}
