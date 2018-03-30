<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntradaStoreUpdateFormRequest extends FormRequest
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
        'fornecedor_id' => 'required',
        'produto_id' => 'required',
        'quantidade' => 'required',
        'desconto' => 'required',
        'pago' => 'required',
      ];
    }

    public function messages(){
      return [
        'fornecedor_id.required' => 'É necessário selecionar o Fornecedor!',
        'produto_id.required' => 'É necessário selecionar o Produto!',
        'quantidade.required' => 'É necessário especificar a quantidade!',
        'desconto.required' => 'É necessário especificar o Desconto!',
        'pago.required' => 'É necessário especificar se foi Pago ou Nao!',
      ];
    }
}
