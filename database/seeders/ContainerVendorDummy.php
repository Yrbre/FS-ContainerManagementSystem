<?php

namespace Database\Seeders;

use App\Models\Vendor;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Location;
use App\Models\Container;
use App\Models\ContainerStatus;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ContainerVendorDummy extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $vendor = Vendor::create([
            'erp_code' => Str::random($length = 10),
            'name' => 'Vendor ' . rand(1, 1000000),
            'address_1' => 'Vendor Address',
            'created_by' => 1,
        ]);
    
        $contract = Contract::create([
            'code' => 'CONTRACT ' . rand(1, 1000000) . '',
            'vendor_id' => $vendor->id,
            'subject' => 'Contract Subject',
            'type' => 'Vendor  Contract',
            'active_date_start' => '2021-01-01',
            'active_date_end' => '2021-12-31',
            'warranty_date_start' => '2021-01-01',
            'warranty_date_end' => '2021-12-31',
            'created_by' => 1,
        ]);

     
        for($i = 201; $i < 300; $i++) {
            
            $code = $i;

            if($i < 10 ) {
                $code = '00' . $i;
            } else if($i < 100) {
                $code = '0' . $i;
            } else {
                $code =  $i;
            }

            $container = Container::create([
                'code' => $code,
                'container_status_id' => ContainerStatus::all()->random()->id,
                'fixed_asset_number' => date('Y') . '000' . $i,
                'buy_date' => '2021-01-01',
                'last_upgrade_vendor_id' => $vendor->id,
                'last_upgrade_vendor_id' => $vendor->id,
                'last_maintenance_vendor_id' => $vendor->id,
                'vendor_id' => $vendor->id,
                'contract_id' => $contract->id,
                'length' => rand(1, 3),
                'width' => rand(1, 3),
                'height' => rand(1, 3),
                'created_by' => 1,
                'last_upgrade_date' => '2021-01-01',
                'last_maintenance_date' => '2021-01-01',
                'warranty_date_start' => '2021-01-01',
                'warranty_date_end' => '2021-12-31',
                'company_id' => Company::all()->random()->id,
                'description' => 'Container Description',
            ]);

        }
    
        
    }
}
