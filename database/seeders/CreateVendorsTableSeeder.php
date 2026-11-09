<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class CreateVendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $v = Vendor::create([
            'erp_code' => '001',
            'name' => 'PT. XYZ',
            'created_by' => 1
        ]);

        // Dummy Contact
        Contract::create([
            'code' => '2022/XYX/2021/XS2',
            'vendor_id' => $v->id,
            'subject' => 'Test Kontrak',
            'type' => 'Maintenance',
            'active_date_start' => now(),
            'active_date_end' => now(),
            'warranty_date_start' => now(),
            'warranty_date_end' => now(),
            'created_by' => 1,
        ]);
    }
}
