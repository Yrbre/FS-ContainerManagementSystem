<?php

namespace Database\Factories;

use App\Models\District;
use MStaack\LaravelPostgis\Geometries\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'district_id' => District::inRandomOrder()->first()->id,
            'address' => $this->faker->address(),
            'postcode' => 43182,
            'location' => new Point($this->faker->latitude(), $this->faker->longitude()), 
        ];
    }
}
