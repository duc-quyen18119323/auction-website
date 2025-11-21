<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    // DÙNG CHUNG BẢNG users
    protected $table = 'users';

    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];
}
