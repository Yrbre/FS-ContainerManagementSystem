<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class CreateLocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::create([
            'code' => 'PLB',
            'name' => 'Palembang',
            'address' => 'Palembang',
            'created_by' => 1
        ]);
    }
}
