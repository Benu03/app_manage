<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAuth extends Model
{
    use HasFactory;

    protected $table = 'auth.auth_users';
    protected $guarded = [];
    public $timestamps = false;

  
}
