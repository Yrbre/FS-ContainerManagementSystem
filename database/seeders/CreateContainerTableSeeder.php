<?php

namespace Database\Seeders;

use App\Models\ContainerStatus;
use Illuminate\Database\Seeder;

class CreateContainerTableSeeder extends Seeder
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
                'code' => 'O',
                'description' => 'Operasional',
            ],
            [
                'code' => 'TSO',
                'description' => 'Tidak Siap Operasi',
            ],
            [
                'code' => 'SO',
                'description' => 'Siap Operasi',
            ],
            [
                'code' => 'S',
                'description' => 'Scrap',
            ],
            [
                'code' => 'SOI',
                'description' => 'Siap Operasi Isi',
            ],
            [
                'code' => 'TSOI',
                'description' => 'Tidak Siap Operasi Isi',
            ]
        ];

        foreach ($statuses as $key => $value) {
            ContainerStatus::create($value);
        }
    }
}
