<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'banner' => 'https://via.placeholder.com/640x480?text=Event+Banner',
            'description' => $this->faker->paragraph,
            'participant_limit' => $this->faker->numberBetween(50, 500),
            'registration_start' => Carbon::now(),
            'registration_end' => Carbon::now()->addWeeks($this->faker->numberBetween(1, 4)),
            'registration_status' => $this->faker->randomElement(['open', 'closed']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
