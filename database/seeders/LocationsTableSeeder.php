<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [ 
            [
            'code' => 'BDG',
            'name' => 'Bandung',
            'address' => 'Bandung',
            'created_by' => Admin::all()->random()->id,
 

            ], 
            [
            'code' => 'JKT',
            'name' => 'Jakarta',
            'address' => 'Jakarta',
            'created_by' => Admin::all()->random()->id,
 

            ], 
            [
            'code' => 'JOG',
            'name' => 'Yogyakarta',
            'address' => 'Yogyakarta',
            'created_by' => Admin::all()->random()->id,
 

            ], 
            [
            'code' => 'MLG',
            'name' => 'Malang',
            'address' => 'Malang',
            'created_by' => Admin::all()->random()->id,
 

            ], 
            [
            'code' => 'SMG',
            'name' => 'Semarang',
            'address' => 'Semarang',
            'created_by' => Admin::all()->random()->id,
 

            ], 
            [
            'code' => 'SML',
            'name' => 'Surabaya',
            'address' => 'Surabaya',
            'created_by' => Admin::all()->random()->id,
 

            ], 
            [
            'code' => 'TGR',
            'name' => 'Tangerang',
            'address' => 'Tangerang',
            'created_by' => Admin::all()->random()->id,
 

            ], 
            [
            'code' => 'TNG',
            'name' => 'Tanjung Pinang',
            'address' => 'Tanjung Pinang',
            'created_by' => Admin::all()->random()->id,
 

            ], 
            [
            'code' => 'TPE',
            'name' => 'Tipe',
            'address' => 'Tipe',
            'created_by' => Admin::all()->random()->id,


            ], 

        ];

        foreach($locations as $location) {
            \App\Models\Location::create($location);
        }

        
    }
}
