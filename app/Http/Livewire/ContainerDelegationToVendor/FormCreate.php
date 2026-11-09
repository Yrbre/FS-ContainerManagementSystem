<?php

namespace App\Http\Livewire\ContainerDelegationToVendor;

use App\Models\Vendor;
use Livewire\Component;
use App\Models\Contract;
use App\Models\Location;
use App\Models\ContainerDelegation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FormCreate extends Component
{
    public $locations;
    public $vendors;
    public $contracts;

    public $location_id;
    public $action_date;
    public $vendor_id;
    public $contract_id;
    public $job_type;

    public function mount()
    {
        $this->locations = Location::all();
        $this->vendors = Vendor::all();
    }

    public function updatedJobType()
    {
        $this->loadContract();
    }

    public function updatedVendorId()
    {
        $this->loadContract();   
    }

    private function loadContract()
    {
        $this->contracts =  Contract::where('vendor_id', $this->vendor_id)->where('type', $this->job_type)->get();
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
            $delegation = new ContainerDelegation;
            $delegation->location_id = $this->location_id;
            $delegation->action_date = $this->action_date;
            $delegation->contract_id = $this->contract_id;
            $delegation->vendor_id = $this->vendor_id;
            $delegation->job_type = $this->job_type;
            $delegation->created_by = Auth::id();
            $delegation->save();

            return redirect()->route('console.delegation-to-vendor.detail', $delegation)->with('success', 'Berhasil membuat BAST CT ke Vendor');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal membuat BAST CT ke Vendor');
        }
    }

    public function render()
    {
        return view('livewire.container-delegation-to-vendor.form-create');
    }
}