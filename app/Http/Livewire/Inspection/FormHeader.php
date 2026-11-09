<?php

namespace App\Http\Livewire\Inspection;

use Livewire\Component;
use App\Models\Inspection;

class FormHeader extends Component
{

    public $fixing_job_type;
    public $inspectionId;

    public function mount($inspectionId) {
        $this->inspectionId = $inspectionId;
        $this->fixing_job_type = Inspection::find($inspectionId)->fixing_job_type;
    }

    public function updatedFixingJobType() {
        $this->updateInspection($this->fixing_job_type);
    }

    public function updateInspection($value) {
        // validation fixingJobType
        $this->validate([
            'fixing_job_type' => 'required'
        ]);

        $inspection = Inspection::find($this->inspectionId);
        $inspection->fixing_job_type = $value;
        $inspection->save();

        $this->fixing_job_type = $value;

        // flash
        session()->flash('message', 'Jenis perbaikan di ubah menjadi ' . $this->fixing_job_type);
    
    }

    public function render()
    {
        return view('livewire.inspection.form-header');
    }
}
