<?php

namespace App\Rules;

use App\Models\OperationType;
use Illuminate\Contracts\Validation\Rule;

class OperationTypeRule implements Rule
{
    protected $value;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->value = $value;
        $operationType = OperationType::find($value);
        if (empty($operationType)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Não existe a operação {$this->value}";
    }
}
