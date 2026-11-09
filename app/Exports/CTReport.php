<?php

namespace App\Exports;

use App\Repositories\Console\CTCReportRepository;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CTReport implements FromView, WithStyles, ShouldAutoSize
{   
    protected CTCReportRepository $repository;
    protected $results;

    public function __construct(?array $filter)
    {
        $this->repository = app()->make(CTCReportRepository::class);
        $this->results = $this->repository->getFilteringContainerQuery($filter);
    
    }

    public function styles(Worksheet $worksheet) {

    }

    public function view(): View {
        $containers = $this->results;

        return view('exports.ct_report', compact('containers'));
    }
}
