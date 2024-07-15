<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevModel extends Model
{
    use HasFactory;

    protected $table = 'portal.mobile_development_url';
    protected $guarded = [];
    public $timestamps = false;
}
