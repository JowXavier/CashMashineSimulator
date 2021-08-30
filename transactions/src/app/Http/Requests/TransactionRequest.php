<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'account_id' => 'required',
            'operation_type_id' => 'required',
            'value' => 'required|numeric',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'account_id.required' => 'O campo account_id é obrigatório',
            'operation_type_id.required' => 'O campo operation_type_id é obrigatório',
            'value.required' => 'O campo value é obrigatório',
            'value.numeric' => 'O campo value deve possuir apenas números',
        ];
    }
}
