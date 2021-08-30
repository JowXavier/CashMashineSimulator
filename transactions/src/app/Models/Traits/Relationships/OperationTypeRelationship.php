<?php

namespace App\Models\Traits\Relationships;

use App\Models\Transaction;

trait OperationTypeRelationship {

    /**
     * Retorna o tipo de operação de uma transação.
     *
     * @return string
     */
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}