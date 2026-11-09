<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'condition_id' => 1,
            'address_id' => 1,
            'category_id' => Category::inRandomOrder()->get()->first()->id,
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'status' => 0,
            'published_at' => now()
        ];
    }
}
