<?php

namespace App\Models\Traits\Relationships;

use App\Models\Account;
use App\Models\OperationType;

trait TransactionRelationship {

    /**
     * Retorna o tipo de operação de uma transação.
     *
     * @return string
     */
    public function operationType()
    {
        return $this->belongsTo(OperationType::class);
    }

    /**
     * Retorna a conta de uma transação.
     *
     * @return string
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}