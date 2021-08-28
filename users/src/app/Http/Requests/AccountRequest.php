<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'user_id' => 'required',
            'agency' => 'required',
            'account' => 'required',
            'type' => 'required',
            'balance' => 'required',
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
            'user_id.required' => 'O campo user_id é obrigatório',
            'agency.required' => 'O campo agency é obrigatório',
            'account.required' => 'O campo account é obrigatório',
            'type.required' => 'O campo type é obrigatório',
            'balance.required' => 'O campo balance é obrigatório',
        ];
    }
}
