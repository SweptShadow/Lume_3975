<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Users extends Authenticatable
{
    protected $table = "users";

    protected $fillable = [
        "id",
        "username",
        "password",
        "firstname",
        "lastname",
        "is_admin"
    ];

    
}
