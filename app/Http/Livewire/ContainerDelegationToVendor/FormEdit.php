<?php

namespace App\Http\Livewire\ContainerDelegationToVendor;

use App\Models\Vendor;
use Livewire\Component;
use App\Models\Contract;
use App\Models\Location;
use App\Models\ContainerDelegation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FormEdit extends Component
{
    public $locations;
    public $vendors;
    public $contracts;

    public $location_id;
    public $action_date;
    public $vendor_id;
    public $contract_id;
    public $job_type;

    public $containerDelegation;

    public function mount(ContainerDelegation $containerDelegation)
    {
        $this->locations = Location::all();
        $this->vendors = Vendor::all();
        $this->containerDelegation = $containerDelegation;
        $this->location_id = $containerDelegation->location_id;
        $this->vendor_id = $containerDelegation->vendor_id;
        $this->contract_id = $containerDelegation->contract_id;
        $this->job_type = $containerDelegation->job_type;
        $this->action_date = $containerDelegation->action_date->format('Y-m-d H:i:s');
        $this->loadContract();
    }

    public function updatedJobType()
    {
        $this->contract_id = null;
        $this->loadContract();
    }

    public function updatedVendorId()
    {
        $this->contract_id = null;
        $this->loadContract();   
    }

    private function loadContract()
    {
        $this->contracts =  Contract::where('vendor_id', $this->vendor_id)->where('type', $this->job_type)->where('status', 'ACTIVE')->get();
    }

    public function submit()
    {
        $this->validate([
            'location_id' => 'required|exists:locations,id',
            'action_date' => 'required',
            'vendor_id' => 'required|exists:vendors,id',
            'contract_id' => 'required|exists:contracts,id',
            'job_type' => 'required|string'
        ]);

        try {
            $delegation = $this->containerDelegation;
            $delegation->location_id = $this->location_id;
            $delegation->action_date = $this->action_date;
            $delegation->contract_id = $this->contract_id;
            $delegation->vendor_id = $this->vendor_id;
            $delegation->job_type = $this->job_type;
            $delegation->last_updated_by = Auth::id();
            $delegation->save();

            return redirect()->route('console.delegation-to-vendor.index')->with('success', 'Berhasil mengupdate BAST ke VENDOR');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengupdate BAST CT ke Vendor');
        }
    }

    public function render()
    {
        return view('livewire.container-delegation-to-vendor.form-edit');
    }
}