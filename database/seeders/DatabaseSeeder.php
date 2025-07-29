<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Reminder;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()->count(10)->create();

        $admin = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);

        $users->push($admin);

        $users->each(function ($user) {
            Event::factory()
                ->count(fake()->numberBetween(1, 2))
                ->create(['user_id' => $user->id]);

            Reminder::factory()
                ->count(fake()->numberBetween(1, 2))
                ->create(['user_id' => $user->id]);
        });

    }
}
