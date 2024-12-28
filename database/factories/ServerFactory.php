<?php

namespace Database\Factories;

use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ServerFactory extends Factory
{
    protected $model = Server::class;

    public function definition()
    {
// Generate a random created_at date within the past year
        $createdAt = $this->faker->dateTimeBetween('-1 year', 'now');

        // Ensure updated_at is always after or equal to created_at
        $updatedAt = $this->faker->dateTimeBetween($createdAt, 'now');

        return [
            // discord server name with several words
            'name' => ucfirst($this->faker->unique()->word()) . ' ' . ucfirst($this->faker->word()) . ' ' . ucfirst($this->faker->word()),
            'capacity' => $this->faker->randomNumber(2),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
