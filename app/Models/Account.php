<?php

namespace App\Models;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

class Account extends Model implements AuthenticatableContract

{
    use \Illuminate\Auth\Authenticatable;
        protected $table = 'accounts';

    protected $fillable = [
        'name',
        'password',
        'role'
    ];
}
