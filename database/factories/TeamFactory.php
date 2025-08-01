<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'description' => $this->faker->paragraph(2),
            'image' => $this->faker->imageUrl(640, 480, 'business', true, 'Team'),
            'user_id' => 1, // You might want to create or reference a user here
            'status' => 'active',
        ];
    }
}
