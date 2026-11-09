<?php

namespace Database\Factories;

use App\Models\Rank;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->name(),
            'rank_id' => Rank::inRandomOrder()->first()->id,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => str_replace('+', '', $this->faker->e164PhoneNumber()),
            'last_login' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            // Create profile
            $user->profileStatus()->create([
                'change_name_count' => 0,
                'change_phone_count' => 0
            ]);

            // Create status
            $user->userStatus()->create([
                'give_count' => 0,
                'receive_count' => 0,
                'peanute_count' => 0
            ]);
        });
    }
}
