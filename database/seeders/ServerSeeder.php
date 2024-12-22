<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Server;

class ServerSeeder extends Seeder
{
    public function run()
    {
        // Create 10 servers
        Server::factory()->count(10)->create();
    }
}
