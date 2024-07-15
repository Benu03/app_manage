<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAuthPersonal extends Model
{
    use HasFactory;

    protected $table = 'auth.v_auth_user_personal_show';
    protected $guarded = [];
    public $timestamps = false;

}
