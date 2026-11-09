<?php
namespace App\Http\Livewire\Dashboard;

use App\Models\Container;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;
use App\Services\Helper;
use Illuminate\Support\Facades\DB;

class LivewireCharts extends Component
{
    public $types = [];
    public $vendor;
    public $colors = [
        '1' => '#f6ad55',
        '2' => '#fc8181',
        '3' => '#90cdf4',
        '4' => '#66DA26',
        '5' => '#cbd5e0',
    ];
    public $firstRun = true;
    protected $listeners = [
        'onPointClick' => 'handleOnPointClick',
        'onSliceClick' => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
    ];
    public function handleOnPointClick($point)
    {
        dd($point);
    }
    public function handleOnSliceClick($slice)
    {
        dd($slice);
    }
    public function handleOnColumnClick($column)
    {
        dd($column);
    }
    public function mount(){
        $this->vendor = DB::table('v_ct_bast_rekap')->distinct()->pluck('name');
        $this->types = $this->vendor;
    }
    public function render()
    {   
        $vendor = $this->vendor;
        $ct = DB::table('v_ct_bast_rekap')->whereIn('name', $this->types)->get();
        $columnChartModel = $ct->groupBy('job_type')
            ->reduce(
                function (ColumnChartModel $columnChartModel, $data) {
                    $helper = new Helper;
                    $type = $data->first()->job_type;
                    $value = $data->count('name');
                    return $columnChartModel->addColumn($type, $value, $helper->rand_color());
                }, (new ColumnChartModel())
                    ->setTitle('CT Maintenance Record')
                    ->setAnimated($this->firstRun)
                    ->withoutDataLabels()
                    ->withoutLegend()
            );
        $this->firstRun = false;
        return view('livewire.dashboard.livewire-charts')
            ->with(['columnChartModel' => $columnChartModel, 'vendor' => $vendor]);
    }
}