<?php

namespace App\Rules;

use App\Models\Transaction;
use Illuminate\Contracts\Validation\Rule;

class TransactiontRule implements Rule
{
    protected $id;
    protected $value;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id = 0)
    {
        $this->id = $id;
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
        $transaction = Transaction::find($this->id);
        if (empty($transaction)) {
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
        return "Não existe o registro {$this->value}";
    }
}
