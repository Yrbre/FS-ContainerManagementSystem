<?php

namespace App\Http\Livewire\ContainerDelegationToVendor;

use Livewire\Component;
use App\Enums\StatusEnum;
use App\Models\Container;
use App\Models\Inspection;
use Livewire\WithFileUploads;
use App\Models\ContractDetail;
use App\Models\InspectionDetail;
use Illuminate\Support\Facades\Log;
use App\Models\ContainerDelegationDetail;
use App\Models\ContainerDelegation;
use App\Models\ContainerDelegationSubDetail;
use Illuminate\Support\Facades\DB;
use Exception;

class FormDetail extends Component
{
    use WithFileUploads;

    public $containers;
    public $selected_container;
    public $container_damage;
    public $containerDelegationId;
    public $containerDelegation;
    public $images = [];
    public $isNotDown;

    public function mount($containerDelegationId)
    {
        $this->containerDelegationId = $containerDelegationId;

        $this->containers = Container::whereNotIn('code', function ($query) {
            $query->select(DB::raw('ISNULL(container_code, 0)'))->from('container_delegation_details')
                ->where('is_done', 0);
        })
            ->whereHas('inspectionDetail')
            // ->status('TSO')
            ->statuses(['TSO', 'TSOI']) // Include containers with TSO and TSOI status
            ->get();
        // $ctInspections = Inspection::where('status', StatusEnum::APPROVE)->get();


        // if ($ctInspections) {
        // foreach ($ctInspections as $ctInspection) {
        //     $inspectionDetail = $ctInspection->details()->get();

        //     if ($inspectionDetail->count() > 0) {
        //         foreach ($inspectionDetail  as $detail) {
        //             $code = $detail->pluck('container_code');

        //             $containerCode = $code->unique();
        //         }

        //         $this->containers = Container::whereIn('code', $containerCode)
        //             ->whereNotIn('code', function ($query) {
        //                 $query->select('container_code')->from('container_delegation_details')
        //                 ->where('is_done', 0);
        //             })
        //             ->status('TSO')
        //             ->get();
        //     }
        // }
        // }


    }

    public function updatedSelectedContainer()
    {
        $this->containerDelegation = ContainerDelegation::where('id', $this->containerDelegationId)->first();
        $this->isNotDown = Container::where('code', $this->selected_container)
            ->where(function ($query) {
                $query->whereNull('down_at')
                    ->orWhere('up_at', '>=', DB::raw('down_at'));
            })
            // ->where('down_location_id', $this->containerDelegation->location_id) //This line ambigue
            ->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')
            ->count();
    }

    public function submit()
    {
        $this->validate([
            'selected_container' => 'required|exists:containers,code',
            'container_damage' => 'required',
            'images.*' => 'required|image',
        ]);

        if ($this->isNotDown > 0) {
            return redirect()->route('console.delegation-to-vendor.detail', $this->containerDelegationId)->with('error', 'Gagal menambah Detail BAST1, CT ' . $this->selected_container . ' belum dilakukan aktivitas Turun Container.');
        }

        try {
            $container = Container::where('code', $this->selected_container)->first();

            $inspectionApprove = InspectionDetail::where('container_code', $this->selected_container)->get();

            if ($container->status->code != 'TSO' && $container->status->code != 'TSOI') {
                session()->flash('error', 'Status Kontainer Harus Tidak Siap Operasi');
            }

            $images = [];
            foreach ($this->images as $img) {
                array_push($images, $img->storePublicly('container-delegations/to-vendor/detail/' . $this->containerDelegationId));
            }

            $delegationDetail = new ContainerDelegationDetail;
            $delegationDetail->container_delegation_id = $this->containerDelegationId;
            $delegationDetail->container_code = $this->selected_container;
            $delegationDetail->container_damage = $this->container_damage;
            $delegationDetail->images = $images;
            $delegationDetail->save();

            $details = InspectionDetail::where('container_code', $container->code)
                ->whereHas('inspection', function ($query) {
                    $query->where('status', '!=', StatusEnum::DRAFT);
                })
                ->whereNotIn('id', function ($query) {
                    $query->select(DB::raw('ISNULL(inspection_detail_id, 0)'))->from('container_delegation_sub_details');
                })
                ->get();

            foreach ($details as $inspectionDetail) {
                $subdetail = new ContainerDelegationSubDetail;
                $subdetail->ct_delegation_detail_id = $delegationDetail->id;
                $subdetail->job_type = '-';
                $subdetail->material_size = null;
                $subdetail->description = '-';
                $subdetail->qty = 0;
                $subdetail->unit = '-';
                $subdetail->unit_price = 0;
                $subdetail->price_estimation = $subdetail->qty * $subdetail->unit_price;
                $subdetail->damage_description = $inspectionDetail->damage_description;
                $subdetail->root_cause = $inspectionDetail->root_cause;
                $subdetail->inspection_detail_id = $inspectionDetail->id;
                $subdetail->images = [];
                $subdetail->save();
            }

            return redirect()->route('console.delegation-to-vendor.sub-detail.index', [$delegationDetail->container_delegation_id, $delegationDetail])->with('success', 'Berhasil menginput Detail BAST ke Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Gagal menginput Detail BAST ke Vendor');
        }
    }

    public function render()
    {
        return view('livewire.container-delegation-to-vendor.form-detail');
    }
}