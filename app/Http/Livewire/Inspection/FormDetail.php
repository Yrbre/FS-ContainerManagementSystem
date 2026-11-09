<?php

namespace App\Http\Livewire\Inspection;

use App\Enums\ContainerStatusEnum;
use App\Enums\StatusEnum;
use App\Events\InspectionDetailCreated;
use App\Models\Container;
use App\Models\InspectionDetail;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class FormDetail extends Component
{
    use WithFileUploads;

    public $containers;
    public $selected_container;
    public $damage_description;
    public $location;
    public $damage_cause_description;
    public $images = [];
    public $inspection_id;
    public $iteration = 1;

    public function mount($inspectionId)
    {
        $this->inspection_id = $inspectionId;
        if($this->location == 'BJI' || $this->location == 'BBA') {
            $this->containers = Container::query()->with('status')->statuses(['SO', 'SOI', 'O'])->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')->get();
        } else {
            $this->containers = Container::query()->status(ContainerStatusEnum::O)->get();
        }
    }

    public function submit()
    {
        $this->validate([
            'selected_container' => 'required|exists:containers,code',
            'damage_description' => 'required',
            'damage_cause_description' => 'required',
            'images.*' => 'image'
        ]);

        // Validate container status
        $ct = Container::findOrFail($this->selected_container);
        if (!$this->location == 'BJI' && !$this->location == 'BBA') {
            if ($ct->status->code != ContainerStatusEnum::O) return session()->flash('error', "Container $ct->code tidak berstatus O");
        }

        $images = [];
        foreach ($this->images as $img) {
            array_push($images, $img->storePublicly('inspections/' . $this->inspection_id ));
        }
        $detail = new InspectionDetail;
        $detail->inspection_id = $this->inspection_id;
        $detail->container_code = $this->selected_container;
        $detail->damage_description = $this->damage_description;
        $detail->damage_cause_description = $this->damage_cause_description;
        $detail->images = $images;
        $detail->save();

        InspectionDetailCreated::dispatch($detail);

        // Reset form
        $this->damage_description = "";
        $this->damage_cause_description = "";
        $this->images = [];
        $this->iteration++;

        // TODO : refresh form belakang
        $this->emit('inspectionUpdated', $this->inspection_id);

        session()->flash('success', 'Berhasil menambahankan item inspeksi.');
    }

    public function render()
    {
        return view('livewire.inspection.form-detail');
    }
}
