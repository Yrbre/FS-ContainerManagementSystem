<?php

namespace App\Http\Livewire\Inspection;

use App\Models\InspectionDetail;
use Livewire\Component;

class FormRootCause extends Component
{
    public $rootCauseList;
    public $causeValue;
    public $inspectionDetailId;
    public $root_cause;

    public function mount($rootCause, $detailsId, $root_cause) {
        $this->rootCauseList = $rootCause; 
        $this->inspectionDetailId = $detailsId;
        $this->root_cause = $root_cause;
    }

    public function updatedCauseValue() {
        $this->updateRootCause($this->causeValue);
    }

    public function updateRootCause($value) {
        // validation rootCause
        $this->validate([
            'causeValue' => 'required'
        ]);

        InspectionDetail::find($this->inspectionDetailId)->update([
            'root_cause' => $value
        ]);

        $this->root_cause = $value;

        // flash
        session()->flash('message', 'Root cause di terapkan');

    }

    public function render()
    {
        return view('livewire.inspection.form-root-cause');
    }
}
