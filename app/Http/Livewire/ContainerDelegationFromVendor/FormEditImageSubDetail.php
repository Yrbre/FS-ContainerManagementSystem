<?php

namespace App\Http\Livewire\ContainerDelegationFromVendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use App\Models\ContainerDelegationFromVendorSubDetail;

class FormEditImageSubDetail extends Component
{
    use WithFileUploads;

    public $openModalEditImage;
    public $subDetail;
    public $images = [];
    public $ctFromVendorSubDetailId;

    protected $listeners = [
        'openModalEditImage', 'closeModalEditImage'
    ];

    public function openModalEditImage()
    {
        $this->openModalEditImage = true;
    }

    public function closeModalEditImage()
    {
        $this->openModalEditImage = false;
    }

    public function mount($ctFromVendorSubDetailId)
    {
        $this->openModalEditImage = false;
        $this->ctFromVendorSubDetailId = $ctFromVendorSubDetailId;

        $this->subDetail = ContainerDelegationFromVendorSubDetail::where('id', $this->ctFromVendorSubDetailId)->first();
    }

    public function saveImage()
    {
        $this->validate([
            'images.*' => 'image'
        ]);

        try {
            $images = [];
            foreach ($this->images as $img) {
                array_push($images, $img->storePublicly('container-delegations/from-vendor/sub-detail/' .  $this->ctFromVendorSubDetailId));
            }

            $this->subDetail->images_after  = $images;
            $this->subDetail->save();

            return redirect(request()->header('Referer'))->with('success', 'Berhasil mengupdate gambar Sub Detail BAST dari Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Gagal mengupdate gambar Sub Detail BAST dari Vendor');
        }
    }

    public function render()
    {
        return view('livewire.container-delegation-from-vendor.form-edit-image-sub-detail');
    }
}
