<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BastListExport implements FromView, ShouldAutoSize
{
    public $data;
    protected $type;

    public function __construct($data, $type = "Maintenance")
    {
        $this->data = $data;
        $this->type = $type;
    }

    public function view(): View
    {
        $results = $this->data;

        return view($this->type == "Maintenance" ? 'exports.bast_list_report' : 'exports.bast_list_upgrade_report', compact('results'));
    }
}
