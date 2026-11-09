<?php

namespace App\Http\Livewire\ContainerDelegationToVendor;

use Livewire\Component;
use App\Models\Container;
use Livewire\WithFileUploads;
use App\Models\ContractDetail;
use App\Models\InspectionDetail;
use Illuminate\Support\Facades\Log;
use App\Models\ContainerDelegationDetail;
use App\Models\ContainerDelegationSubDetail;

class FormSubDetail extends Component
{
    use WithFileUploads;

    public $containerDelegationDetailId;
    public $contractDetail;
    public $inspectionDetail;

    public $images = [];
    public $material_size;
    public $qty;
    public $description;
    public $unit;
    public $unit_price;
    public $contract_detail_id;
    public $root_cause;
    public $damage_description;
    public $price_estimation;

    public $jobTypeOther;

    public function mount($containerDelegationDetailId)
    {
        $this->containerDelegationDetailId = $containerDelegationDetailId;
        
        // Container Delegation
        $containerDelegation = ContainerDelegationDetail::where('id', $this->containerDelegationDetailId)->first();

        // Inspection Detail
        $this->inspectionDetail = InspectionDetail::where('container_code', $containerDelegation->container_code)->get();

        // Contract Detail
        $contractDetailId = $containerDelegation->containerDelegation->contract_id;
        $this->contractDetail = ContractDetail::where('contract_id', $contractDetailId)->get();
    }

    public function updatedQty()
    {
        $this->price_estimation = (int) $this->qty * (int) $this->unit_price;
    }

    public function updatedUnitPrice()
    {
        $this->price_estimation = (int) $this->qty * (int) $this->unit_price;
    }

    public function updatedContractDetailId()
    {
        if ($this->contract_detail_id == 'Lainnya' || empty($this->contract_detail_id)) {
            $this->unit = '';
            $this->unit_price = (int) 0;

            $this->price_estimation = (int) $this->qty * (int) $this->unit_price;
        } else {
            $contractDetail = ContractDetail::where('id', $this->contract_detail_id)->first();

            $this->unit = $contractDetail->unit->name;
            $this->unit_price = (int) $contractDetail->price;

            $this->price_estimation = (int) $this->qty * (int) $this->unit_price;
        }
    }

    public function submit()
    {
        $this->validate([
            'qty' => 'required|integer|min:1',
            'unit' => 'required',
            'unit_price' => 'required|integer|min:1',
            'description' => 'required',
            'material_size' => 'nullable',
            'damage_description' => 'required|string',
            'contract_detail_id' => 'required',
            'images.*' => 'image'
        ]);

        try {
            $images = [];
            foreach ($this->images as $img) {
                array_push($images, $img->storePublicly('container-delegations/to-vendor/sub-detail/' .  $this->containerDelegationDetailId));
            }

            if ($this->contract_detail_id == 'Lainnya') {
                $jobType = $this->jobTypeOther;
                $contractDetailId = null;
            } else {
                $contractDetail = ContractDetail::where('id', $this->contract_detail_id)->first();
                $jobType = $contractDetail->job_type;
                $contractDetailId = $this->contract_detail_id;
            }
            
            $subDetail = new ContainerDelegationSubDetail;
            $subDetail->ct_delegation_detail_id = $this->containerDelegationDetailId;
            $subDetail->qty = $this->qty;
            $subDetail->unit = $this->unit;
            $subDetail->job_type = $jobType;
            $subDetail->root_cause = null;
            $subDetail->unit_price = $this->unit_price;
            $subDetail->description = $this->description;
            $subDetail->material_size = $this->material_size;
            $subDetail->damage_description = $this->damage_description;
            $subDetail->price_estimation = (int) $this->qty * (int) $this->unit_price;
            $subDetail->contract_detail_id = $contractDetailId;
            $subDetail->images = $images;
            $subDetail->save();
    
            return redirect(request()->header('Referer'))->with('success', 'Berhasil menginput data Sub Detail BAST ke Vendor');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menginput data Sub Detail BAST');
            Log::error($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.container-delegation-to-vendor.form-sub-detail');
    }
}