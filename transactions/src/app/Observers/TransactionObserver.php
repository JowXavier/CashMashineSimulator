<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Support\Str;

class TransactionObserver
{
    /**
     * Handle the user "creating" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function creating(Transaction $transaction)
    {
        $transaction->uuid = Str::uuid();
    }
}
