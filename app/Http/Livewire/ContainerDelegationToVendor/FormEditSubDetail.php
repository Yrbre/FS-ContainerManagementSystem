<?php

namespace App\Http\Livewire\ContainerDelegationToVendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ContractDetail;
use Illuminate\Support\Facades\Log;
use App\Models\ContainerDelegationDetail;
use App\Models\ContainerDelegationSubDetail;
use App\Repositories\Console\RootCauseListRepository;

class FormEditSubDetail extends Component
{
    use WithFileUploads;

    public $delegationDetailId;
    public $subDetailId;
    public $contractDetail;

    public $qty;
    public $unit;
    public $root_cause;
    public $unit_price;
    public $description;
    public $material_size;
    public $damage_description;
    public $contract_detail_id;
    public $images = [];
    public $price_estimation;

    public $sub_detail_edit_id;

    public $openEditSubDetailModal = false;

    public $rootCauseList;
    public $causeValue;
    public $jobTypeOther;

    protected $listeners = [
        'closeEditSubDetailModal', 'openEditSubDetailModal'
    ];

    public function mount($delegationDetailId, $subDetailId)
    {
        $this->rootCauseList = new RootCauseListRepository();
        $this->rootCauseList = $this->rootCauseList->rootCauseList;
        $this->delegationDetailId = $delegationDetailId;
        $this->subDetailId = $subDetailId;

        // Container Delegation
        $containerDelegation = ContainerDelegationDetail::where('id', $this->delegationDetailId)->first();
        
        // Contract Detail
        $contractDetailId = $containerDelegation->containerDelegation->contract_id;
        $this->contractDetail = ContractDetail::where('contract_id', $contractDetailId)->get();
    }

    public function updatedCauseValue()
    {
        $this->updateRootCause($this->causeValue);
    }

    public function updateRootCause($value)
    {
        $this->validate([
            'causeValue' => 'required'
        ]);

        $subDetail = ContainerDelegationSubDetail::where('id', $this->subDetailId)->first();

        $subDetail->update([
            'root_cause' => $value
        ]);

        return redirect(request()->header('Referer'))->with('success', 'Root Cause di terapkan');
        // session()->flash('success', 'Root Cause di terapkan');
    }

    public function updatedJobTypeOther()
    {
        $this->validate([
            'jobTypeOther' => 'required'
        ]);

        $subDetail = ContainerDelegationSubDetail::where('id', $this->subDetailId)->first();

        $subDetail->update([
            'job_type' => $this->jobTypeOther
        ]);

        session()->flash('success', 'Jenis Perbaikan di terapkan');
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

    public function updatedQty()
    {
        $this->price_estimation = (int) $this->qty * (int) $this->unit_price;
    }

    public function updatedUnitPrice()
    {
        $this->price_estimation = (int) $this->qty * (int) $this->unit_price;
    }

    public function openEditSubDetailModal()
    {
        $this->openEditSubDetailModal = true;
    }

    public function closeEditSubDetailModal()
    {
        $this->openEditSubDetailModal = false;
    }

    public function editSubDetail($id)
    {
        $this->openEditSubDetailModal();

        $subDetail = ContainerDelegationSubDetail::where('id', $id)->first();

        $this->sub_detail_edit_id = $subDetail->id;
        $this->delegationDetailId = $subDetail->ct_delegation_detail_id ;
        $this->qty = $subDetail->qty;
        $this->unit = $subDetail->unit;
        $this->root_cause = $subDetail->root_cause;
        $this->unit_price = (int) $subDetail->unit_price;
        $this->description = $subDetail->description;
        $this->material_size = $subDetail->material_size;
        $this->damage_description = $subDetail->damage_description;
        $this->contract_detail_id = $subDetail->contract_detail_id;
    }

    public function updateSubDetailData()
    {
        $this->validate([
            'qty' => 'required|integer|min:1',
            'root_cause' => 'nullable|string',
            'unit_price' => 'required|integer|min:1',
            'description' => 'required',
            'material_size' => 'nullable',
            'damage_description' => 'required|string',
            'unit' => 'required',
            'contract_detail_id' => 'required',
            'images.*' => 'image'
        ]);

        try {
            $images = [];
            foreach ($this->images as $img) {
                array_push($images, $img->storePublicly('container-delegations/to-vendor/sub-detail/' .  $this->subDetailId));
            }

            if ($this->contract_detail_id == 'Lainnya') {
                $jobType = $this->jobTypeOther;
                $contractDetailId = null;
            } else {
                $contractDetail = ContractDetail::where('id', $this->contract_detail_id)->first();
                $jobType = $contractDetail->job_type;
                $contractDetailId = $this->contract_detail_id;
            }
    
            $subDetail =  ContainerDelegationSubDetail::where('id', $this->sub_detail_edit_id)->first();
            $subDetail->ct_delegation_detail_id = $this->delegationDetailId;
            $subDetail->qty = $this->qty;
            $subDetail->unit = $this->unit;
            $subDetail->job_type = $jobType;
            $subDetail->root_cause = $this->root_cause;
            $subDetail->unit_price = $this->unit_price;
            $subDetail->description = $this->description;
            $subDetail->material_size = $this->material_size;
            $subDetail->damage_description = $this->damage_description;
            $subDetail->price_estimation = (int) $this->qty * (int) $this->unit_price;
            $subDetail->contract_detail_id = $contractDetailId;
            $subDetail->images = $images;
            $subDetail->save();

            
            return redirect(request()->header('Referer'))->with('success', 'Berhasil mengupdate Sub Detail BAST ke Vendor');
            $this->closeEditSubDetailModal();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Gagal mengupdate Sub Detail BAST ke Vendor');
        }
    }

    public function render()
    {
        return view('livewire.container-delegation-to-vendor.form-edit-sub-detail');
    }
}