<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apk extends Model
{
    use HasFactory;

    protected $table = 'auth.auth_version_apk';
    protected $guarded = [];
    public $timestamps = false;
}
