<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'birth_date' => 'required|date_format:Y-m-d',
            'cpf' => 'required|numeric',
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
            'name.required' => 'O campo name é obrigatório',
            'birth_date.required' => 'O campo birth_date é obrigatório',
            'birth_date.date_format' => 'O campo birth_date deve está no formato "YYYY-MM-DD" ',
            'cpf.required' => 'O campo cpf é obrigatório',
            'cpf.numeric' => 'O campo cpf deve possuir apenas números',
        ];
    }
}
