<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'capacity',
    ];


    public function users()
    {
        return $this
            ->belongsToMany(User::class, 'users_server')
            ->withPivot('is_admin', 'created_at');
    }
}
