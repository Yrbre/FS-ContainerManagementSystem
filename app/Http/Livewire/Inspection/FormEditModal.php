<?php

namespace App\Http\Livewire\Inspection;

use Livewire\Component;
use App\Models\Container;
use App\Models\InspectionDetail;
use App\Events\InspectionDetailCreated;
use Livewire\WithFileUploads;


class FormEditModal extends Component
{

    use WithFileUploads;


    public $selected_container;
    public $inspectionDetail;
    public $detailId;
    public $containers;
    public $damage_description;
    public $damage_cause_description;
    public $oldImages = [];
    public $images = [];


    public function mount(string $detailId) {
        $this->detailId = $detailId;
        $this->inspectionDetail = InspectionDetail::find($detailId);
        $this->selected_container = $this->inspectionDetail->container_code;
        $this->containers = Container::all();
        $this->damage_description = $this->inspectionDetail->damage_description;
        $this->damage_cause_description = $this->inspectionDetail->damage_cause_description;
        $this->oldImages = $this->inspectionDetail->images;
    }

    public function updatedSelectedContainer() {
        if($this->selected_container == '') {
            $this->selected_container = $this->inspectionDetail->container_code;
        } else {
            $this->selected_container = $this->selected_container;
        }
    }

    public function submit() {

        $this->validate([
            'selected_container' => 'required|exists:containers,code',
            'damage_description' => 'required',
            'damage_cause_description' => 'required',
            'images.*' => 'image'
        ]);

        $images = [];
        foreach ($this->images as $img) {
            array_push($images, $img->storePublicly('inspections/' . $this->inspectionDetail->inspection_id ));
        }

        if(count($images) > 0) {
            foreach ($this->oldImages as $img) {
                if(file_exists(storage_path('app/' . $img))) {
                    unlink(storage_path('app/' . $img));
                }
            }
        }else {
            $images = $this->oldImages;
        }

        $this->inspectionDetail->container_code = $this->selected_container;
        $this->inspectionDetail->damage_description = $this->damage_description;
        $this->inspectionDetail->damage_cause_description = $this->damage_cause_description;
        // $this->inspectionDetail->images = array_merge($this->oldImages, $images);
        $this->inspectionDetail->images = $images;

        $this->inspectionDetail->save();
 
        session()->flash('success', 'Detail inspeksi berhasil di ubah.');
        return redirect(request()->header('Referer'));
        
    }

    public function render()
    {
        return view('livewire.inspection.form-edit-modal');
    }
}
