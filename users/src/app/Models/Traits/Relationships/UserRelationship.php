<?php

namespace App\Models\Traits\Relationships;

use App\Models\Account;

trait UserRelationship {

    /**
     * Retorna a conta de um usuário.
     *
     * @return string
     */
    public function account()
    {
        return $this->hasMany(Account::class);
    }
}