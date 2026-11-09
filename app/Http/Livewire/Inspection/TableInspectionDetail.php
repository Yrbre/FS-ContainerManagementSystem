<?php

namespace App\Http\Livewire\Inspection;

use App\Models\Inspection;
use App\Repositories\Console\RootCauseListRepository;
use Livewire\Component;

class TableInspectionDetail extends Component
{   

    public $inspection;
    public $rootCauseList;
    public $inspectionList = [];

    protected $listeners = ['inspectionUpdated' => 'fetchData'];

    public function mount($inspectionId)
    {
        $this->fetchData($inspectionId);
    }

    public function fetchData($inspectionId)
    {
        $this->inspection = Inspection::find($inspectionId);
        $this->inspectionList = $this->inspection->details;
        $this->rootCauseList = new RootCauseListRepository();
        $this->rootCauseList = $this->rootCauseList->rootCauseList;
    }

    public function render()
    {
        return view('livewire.inspection.table-inspection-detail');
    }
}
