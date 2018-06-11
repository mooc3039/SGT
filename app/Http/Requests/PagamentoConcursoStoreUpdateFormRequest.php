<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagamentoConcursoStoreUpdateFormRequest extends FormRequest
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
        'pago' => 'required',
        'valor_pago' => 'required',
        'forma_pagamento_id' => 'required',
        'nr_documento_forma_pagamento' => 'required',
    ];
}

public function messages(){
  return [
    'pago.required' => 'É necessário informar se a Saida foi Paga ou Nao!',
    'valor_pago.required' => 'É necessário informar o Valor Pago!',
    'forma_pagamento_id.required' => 'É necessário informar a Forma de pagamento!',
    'nr_documento_forma_pagamento.required' => 'É necessário indicar o nurmero do documento da forma de pagamento!',
];
}
}
