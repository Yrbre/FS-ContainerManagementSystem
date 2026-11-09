<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;
use App\Models\Contract;
use App\Models\Location;
use App\Models\Vendor;

class InspectionReport extends Component
{
    public $vendor;
    public $contract;
    public $startDate;
    public $endDate;
    public $filterType;
    public $location;
    public $exportable = "no";

    public function mount()
    {
        $params = request()->all();
        $this->startDate = isset($params['from']) ? $params['from'] : null;
        $this->endDate = isset($params['to']) ? $params['to'] : null;
        $this->location = isset($params['by_location']) ? $params['by_location'] : null;
        $this->filterType = isset($params['by_type']) ? $params['by_type'] : null;
    }
    public function render()
    {
        $vendors = Vendor::all();
        $locations = Location::all();
        return view('livewire.report.inspection-report', compact('vendors', 'locations'));
    }
}
