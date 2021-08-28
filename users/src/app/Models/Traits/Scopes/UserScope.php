<?php

namespace App\Models\Traits\Scopes;

Trait UserScope
{
    /**
     * Scope a query to only include filter users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfFilter($query, $filter)
    {
        $query->orWhere('name', 'like', "%{$filter}%");
        $query->orWhere('birth_date', 'like', "%{$filter}%");
        $query->orWhere('cpf', 'like', "%{$filter}%");

        return $query;
    }
}