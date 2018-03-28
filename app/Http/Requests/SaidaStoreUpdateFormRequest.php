<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaidaStoreUpdateFormRequest extends FormRequest
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
          'produto_id' => 'required',
          'quantidade' => 'required',
          'desconto' => 'required',

          'pago' => 'required',
          'valor_pago' => 'required|numeric',
          'remanescente' => 'numeric|min:0',
          'forma_pagamento_id' => 'required',
          'nr_documento_forma_pagamento' => 'required',
      ];
  }

  public function messages(){
    return [
        'cliente_id.required' => 'É necessário selecionar o Cliente!',
        'produto_id.required' => 'É necessário selecionar o Produto!',
        'quantidade.required' => 'É necessário informar a quantidade!',
        'desconto.required' => 'É necessário informar o Desconto!',
        
        'pago.required' => 'É necessário informar se a Saida foi Paga ou Nao!',
        'valor_pago.required' => 'É necessário informar o Valor Pago!',
        'valor_pago.numeric' => 'O Valor Pago deve ser um valor numerico!',
        'remanescente.numeric' => 'O Remanescente deve ser um Valor Numerico!',
        'remanescente.min' => 'O Remanescente deve ser um Valor Numerico positivo! NB: O Valor Pago nao deve ser superior que o Remanescente!',
        'forma_pagamento_id.required' => 'É necessário informar a Forma de pagamento!',
        'nr_documento_forma_pagamento.required' => 'É necessário indicar o nurmero do documento da forma de pagamento!',
    ];
}
}
