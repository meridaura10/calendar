<?php

namespace Database\Factories;

use App\Enums\EventTypeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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
        $start = $this->faker->dateTimeBetween('now', '+1 month');
        $end = Carbon::instance($start)->addHours($this->faker->numberBetween(1, 3))->addDays($this->faker->numberBetween(0,3));

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'color' => $this->faker->hexColor(),
            'start_datetime' => $start,
            'end_datetime' => $end,
            'is_completed' => $this->faker->boolean(20),
        ];
    }
}
