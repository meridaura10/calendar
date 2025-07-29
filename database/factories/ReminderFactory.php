<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reminder>
 */
class ReminderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $recurrenceTypes = [
            "none",
            "daily",
            "days",
            "month",
            "yearly"
        ];

        $recurrenceType = $this->faker->randomElement($recurrenceTypes);

        $recurrence = ['type' => $recurrenceType];

        if ($recurrenceType === 'days') {

            $recurrence['data'] = $this->faker->randomElements([0, 1, 2, 3, 4, 5, 6], $this->faker->numberBetween(1, 4));
        } elseif ($recurrenceType === 'month') {

            $recurrence['data'] = $this->faker->numberBetween(1, 28);
        } elseif ($recurrenceType === 'yearly') {

            $recurrence['data'] = [
                'day' => $this->faker->numberBetween(1, 28),
                'month' => $this->faker->numberBetween(1, 12),
            ];
        }


        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'color' => $this->faker->hexColor(),
            'datetime' => $this->faker->dateTimeBetween('now', '+1 month'),
            'recurrence' => $recurrence,
            'is_completed' => $this->faker->boolean(20),
        ];
    }
}
