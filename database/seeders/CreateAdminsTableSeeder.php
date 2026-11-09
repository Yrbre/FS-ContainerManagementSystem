<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            RoleEnum::ADMIN,
            RoleEnum::CHECKER,
            RoleEnum::SUPERVISOR,
            RoleEnum::MANAGER,
            RoleEnum::FINANCE,
            RoleEnum::FINANCESTAFF,
            RoleEnum::PURCHASING,
            RoleEnum::SITEMANAGER
        ];

        foreach ($roles as $role) {
            Admin::create([
                'name' => $role,
                'email' => str_replace(' ', '', strtolower($role)) . '@baracoal.com',
                'role' => $role,
                'username' => str_replace(' ', '_', strtolower($role)),
                'password' => Hash::make('1')
            ]);
        }

    }
}
