<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Event;

class EventUserFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'event_id' => 1, 
            'user_id' => User::factory(),   
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
