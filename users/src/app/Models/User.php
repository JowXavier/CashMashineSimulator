<?php

namespace App\Models;

use App\Models\Traits\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Relationships\UserRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory, UserRelationship, UserScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'birth_date',
        'cpf'
    ];
}
