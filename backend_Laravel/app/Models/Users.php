<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    protected $table = "users";
    public $timestamps = false;

    protected $fillable = [
        'username', 
        'password', 
        'email', 
        'IsApproved', 
        'Role'
    ];

}
