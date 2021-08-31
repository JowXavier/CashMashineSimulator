<?php

namespace App\Models\Traits\Scopes;

Trait TransactionScope
{
    /**
     * Scope a query to only include Extract Transactions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfExtract($query, $filter)
    {
        $query->orWhere('operation_type_id', $filter['operation_type_id']);
        $query->orWhere('value', $filter['value']);
        $query->orWhere('created_at', $filter['datetime']);

        return $query;
    }
}