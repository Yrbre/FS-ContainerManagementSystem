<?php

namespace App\Imports;

use App\Models\ContainerDailyActivityDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContainerDailyActivityDetailsImport implements ToCollection, WithHeadingRow
{
    protected $data = [];

    public function collection($rows)
    {
        foreach ($rows as $row) {
            $this->data[] = [
                'container_code' => $row['ct_no'],
                'container_source' => $row['container_source'],
                'carriage_number' => $row['carriage_number'],
                'type' => $row['type'],
            ];
        }
    }

    public function getData()
    {
        return $this->data;
    }
}