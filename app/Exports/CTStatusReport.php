<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Repositories\Console\CTCReportRepository;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CTStatusReport implements FromView, ShouldAutoSize, WithStyles
{
    protected CTCReportRepository $repository;
    protected $results;
    protected $colors;

    public function __construct(?string $status)
    {
        $this->repository = app()->make(CTCReportRepository::class);
        $this->results = $this->repository->getStatusDashboardQuery($status);
        $this->colors = $this->repository->getColors();
    }

    public function styles(Worksheet $sheet)
    {
        $styles = [
            // Styling an entire column.
            'K'  => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_TOP
                ]
            ],
            'A1'  => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_TOP
                ]
            ]
        ];
        $START_CELL_ALPHA = "A";
        $START_CELL = "1";
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('K1')->getFont()->setBold(true);
        foreach ($this->results as $key => $vendors) {
            $START_CELL_ALPHA = "A";
            $START_CELL += 1;
            foreach ($vendors->containers as $key2 => $container) {
                $hexColor = $this->colors[$container->status->code];
                $currentCell = sprintf("%s%s", $START_CELL_ALPHA, $START_CELL);

                $style = [
                    'ct' => $container->code,
                    'st' => $container->status->code,
                    'hx' => $hexColor,
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => str_replace("#", "", $hexColor)
                        ],
                    ]
                ];
                // if(in_array($currentCell, ["H31"])) {
                //     dump($currentCell, $style);
                // }
                // if(in_array($container->code, ["675"])) {
                //     dump($currentCell, $style);
                // }
                $styles[$currentCell] = $style;
                if (($key2 + 1) % 10 != 0) {
                    ++$START_CELL_ALPHA;
                } else {
                    if ($key2 != 0) {
                        $START_CELL_ALPHA = "A";
                        $START_CELL += 1;
                    } else {
                        ++$START_CELL_ALPHA;
                    }
                }
            }
        }

        // dd($styles);
        return $styles;
    }
    public function view(): View
    {
        $containerVendors = $this->results;
        $color = $this->repository->getColors();

        return view('exports.ctc_status_report', compact('containerVendors', 'color'));
    }
}
