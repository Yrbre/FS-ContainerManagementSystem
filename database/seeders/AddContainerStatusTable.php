<?php

namespace Database\Seeders;

use App\Models\ContainerStatus;
use Illuminate\Database\Seeder;

class AddContainerStatusTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'code' => 'SOI',
                'description' => 'Siap Operasi Isi',
            ],
            [
                'code' => 'TSOI',
                'description' => 'Tidak Siap Operasi Isi',
            ],
        ];

        foreach ($statuses as $key => $value) {
            ContainerStatus::create($value);
        }
    }
}