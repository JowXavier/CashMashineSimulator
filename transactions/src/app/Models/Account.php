<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\Relationships\AccountRelationship;

class Account extends Model
{
    use HasFactory, AccountRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'agency',
        'account',
        'type',
        'balance'
    ];
}
