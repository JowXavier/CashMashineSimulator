<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Scopes\TransactionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\Relationships\TransactionRelationship;

class Transaction extends Model
{
    use HasFactory, TransactionRelationship, TransactionScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'account_id',
        'operation_type_id',
        'value'
    ];
}
