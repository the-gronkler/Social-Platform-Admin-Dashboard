<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Server;

class UsersServerSeeder extends Seeder
{
    public function run()
    {
        // Fetch all users and servers
        $users = User::all();
        $servers = Server::all();

        // Iterate through servers and associate users
        foreach ($servers as $server) {
            $remainingCapacity = $server->maxCapacity - $server->users()->count();
            if ($remainingCapacity > 0) {
                // Randomly assign between 5 and [20/remaining capacity] users to each server
                foreach ($users->random(min(rand(5, 20), $remainingCapacity)) as $user) {
                    $assCreatedAfter = max($server->created_at, $user->created_at);

                    // Random date after user creation and server creation, but before now
                    $randomCreatedAt = $assCreatedAfter->copy()
                        ->addSeconds(rand(0, now()->diffInSeconds($assCreatedAfter)));

                    // Attach the user to the server with the random created_at
                    $server->users()->attach($user->id, [
                        'is_admin' => rand(1, 100) < 15, // 15% chance of being an admin
                        'created_at' => $randomCreatedAt,
                    ]);
                }
            }
        }

        // for each server with 0 admins make the earliest user an admin
        foreach ($servers as $server) {
            if ($server->users()->wherePivot('is_admin', true)->count() == 0
                && $server->users()->count() > 0)
            {
                $server->users()->orderBy('created_at')->first()
                    ->pivot->update(['is_admin' => true]);
            }
        }


    }
}
