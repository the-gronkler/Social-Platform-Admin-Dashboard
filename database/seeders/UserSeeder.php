<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);

        // regular user
        User::factory()->create([
            'name' => 'user',
            'email' => 'user@user',
            'password' => bcrypt('user'),
            'role' => 'user'
        ]);


        User::factory()->count(20)->create();
        User::factory()->count(10)->admin()->create();
    }


}
