<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CreateCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'BAU',
            'address' => 'Jl. Jakarta',
            'phone_number' => '08123',
            'created_by' => 1
        ]);
    }
}
