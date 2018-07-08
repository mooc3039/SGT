<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MotivoNaoAplicacaoIvaStoreUpdateFormRequest extends FormRequest
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
        $id = $this->get('motivo_nao_aplicacao_iva_id'); // Este id vem do formulario a partir de um input hidden

        return [
            'motivo_nao_aplicacao' => 'required|unique:motivo_ivas,motivo_nao_aplicacao,'.$id.',id',
        ];
    }

    public function messages(){
        return [
            'motivo_nao_aplicacao.required' => 'O Motivo da Não aplicação do IVA é obrigatório!',
            'motivo_nao_aplicacao.unique' => 'O Motivo da Não aplicação do IVA já existe!',
        ];
    }
}
