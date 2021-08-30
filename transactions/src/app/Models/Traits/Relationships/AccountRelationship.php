<?php

namespace App\Models\Traits\Relationships;

use App\Models\User;

trait AccountRelationship {

    /**
     * Retorna o usuário de uma conta.
     *
     * @return string
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}