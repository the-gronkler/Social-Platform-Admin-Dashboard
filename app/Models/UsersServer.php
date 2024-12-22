<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UsersServer extends Pivot
{
//    use HasFactory;
    protected $table = 'users_server';


    protected $fillable = [
        'users_id',
        'server_id',
        'is_admin',
        'created_at',
    ];

    public $timestamps = false;
}
