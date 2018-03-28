<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagamentoEntradaStoreUpdateFormRequest extends FormRequest
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
      ];
    }

    public function messages(){
      return [
        'pago.required' => 'É necessário especificar se a Entrada foi Paga ou Nao!',
      ];
    }
}
