<?php

namespace App\Models\Traits\Relationships;

use App\Models\User;

trait AccountRelationship {

    /**
     * Retorna a marca de um produto.
     *
     * @return string
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}