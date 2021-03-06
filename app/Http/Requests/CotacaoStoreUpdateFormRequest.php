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
          'validade' => 'required|numeric|min:0',
          // 'tipo_cotacao_id' => 'required',
          'produto_id' => 'required',
          'desconto' => 'required',
        ];
    }

    public function messages(){
        return [
            'cliente_id.required' => 'É necessário selecionar o Cliente!',
            'validade.required' => 'É informar informar a Validade em numero de dias!',
            'validade.numeric' => 'A Validade deve ser um valor numerico!',
            'validade.min' => 'A Validade deve ser um valor numerico maior que Zero!',
            // 'tipo_cotacao_id.required' => 'É necessário selecionar o tipo da Cotação!',
            'produto_id.required' => 'É necessário selecionar o Produto!',
            'desconto.required' => 'É necessário especificar o Desconto!',
        ];
    }
}
