<?php

namespace App\Http\Requests;

use App\Rules\AccountRule;
use App\Rules\TransactiontRule;
use App\Rules\OperationTypeRule;
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
        if ($this->segment(3)) {
            return [
                new TransactiontRule($this->segment(3))
            ];
        }

        return [
            'account_id' => [
                'required',
                new AccountRule()
            ],
            'operation_type_id' => [
                'required',
                new OperationTypeRule()
            ],
            'value' => 'required|integer',
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
            'value.integer' => 'O campo value deve possuir apenas números',
        ];
    }
}
