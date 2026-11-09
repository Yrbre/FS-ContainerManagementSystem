<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class CreateUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            [
                'name' => 'Meter',
                'symbol' => 'Cm'
            ]
        ];
        foreach($units as $u)
        {
            Unit::create($u);
        }
        
    }
}
