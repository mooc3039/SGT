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
      ];
    }

    public function messages(){
      return [
        'cliente_id.required' => 'É necessário selecionar o Cliente!',
        'produto_id.required' => 'É necessário selecionar o Produto!',
        'quantidade.required' => 'É necessário informar a quantidade!',
        'desconto.required' => 'É necessário informar o Desconto!',
        
        'pago.required' => 'É necessário informar se a Saida foi Paga ou Nao!',
      ];
    }
  }
