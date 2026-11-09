<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Seeder;

class ContractCreateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $many = 1;

        for ($i = 0; $i < $many; $i++) {
            Contract::create([
                'code' => 'CONTRACT-000' . $i,
                'subject' => 'Contract Subject',
                'vendor_id' => 1,
                'created_by' => 1,
                'active_date_start' => '2021-01-01',
                'active_date_end' => '2021-12-31',
                'warranty_date_start' => '2021-01-01',
                'warranty_date_end' => '2021-12-31',
            ]);
        }
    }
}
