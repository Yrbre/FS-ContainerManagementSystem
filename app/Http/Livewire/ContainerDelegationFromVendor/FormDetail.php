<?php

namespace App\Http\Livewire\ContainerDelegationFromVendor;

use App\Enums\JobTypeEnum;
use Livewire\Component;
use App\Enums\StatusEnum;
use App\Models\Container;
use Livewire\WithFileUploads;
use App\Models\ContractDetail;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\ContainerDelegation;
use Illuminate\Support\Facades\Log;
use App\Models\ContainerRepairDetail;
use App\Models\ContainerDelegationDetail;
use App\Models\ContainerDelegationSubDetail;
use App\Models\ContainerDelegationFromVendor;
use App\Models\ContainerDelegationFromVendorDetail;
use App\Repositories\Console\RootCauseListRepository;
use App\Models\ContainerDelegationFromVendorSubDetail;
use Exception;

class FormDetail extends Component
{
    use WithFileUploads;

    // public $containerDelegationFromVendor;
    // public $containerDelegationFromVendorDetail;
    // public $from_vendor_details;
    // public $containers;
    // public $toVendorSubDetail;

    // public $selectedDetail = [];
    // public $groupData = [];
    // public $from_vendor_id = [];
    // public $delegation_to_vendor_date = [];
    // public $container_code = [] ;
    // public $progress = [];
    // public $images = [];
    // public $imagesInput = [];
    // public $filtered = [];
    // public $rowKey;

    // public $subDetails;
    // public $subDetail;
    // public $detailId;

    // public $code;
    // public $contractDetail;
    // public $material_size;
    // public $qty;
    // public $description;
    // public $unit;
    // public $unit_price;
    // public $contract_detail_id;
    // public $root_cause;
    // public $damage_description;
    // public $price_estimation;

    // public $openModalSubDetail = false;
    // public $openModalAddSubDetail = false;

    // public $rootCauseList;
    // public $jobTypeOther;
    // public $subDetailId;

    public $containers;
    public $selected_container;
    public $containerDelegationFromVendor;
    public $images = [];
    public $ctToVendor;

    // protected $listeners = [
    //     'openModalSubDetail',
    //     'closeModalSubDetail',
    //     'listChecked',
    //     'openModalAddSubDetail',
    //     'closeModalAddSubDetail',
    // ];

    // protected $rules = [
    //     'from_vendor_details.*.delegation_to_vendor_date' => 'nullable',
    //     'from_vendor_details.*.container_code' => 'required',
    //     'images.*' => 'image',
    //     'from_vendor_details.*.progress' => 'required',
    //     'from_vendor_details.*.from_vendor_id' => 'required'
    // ];

    public function mount($containerDelegationFromVendor)
    {
        $this->containerDelegationFromVendor = $containerDelegationFromVendor;
        $containerDelegationFromVendor = ContainerDelegationFromVendor::where('id', $this->containerDelegationFromVendor->id)->first();

        $this->ctToVendor = ContainerDelegation::where('status', '!=', StatusEnum::DRAFT)
            ->where('job_type', $containerDelegationFromVendor->job_type)
            ->where('vendor_id', $containerDelegationFromVendor->vendor_id)
            ->where('location_id', $containerDelegationFromVendor->location_id)
            ->whereHas('details', function($query){
                $query->where('is_done', 0);
            })
            ->get();
        
        
        $containerCode = [];

        if ($this->ctToVendor->count() > 0) {
            foreach ($this->ctToVendor as $toVendor) {
                $toVendorDetails = $toVendor->details()->get();


                if ($toVendorDetails->count() > 0) {
                    foreach ($toVendorDetails as $toVendorDetail) {
                        array_push($containerCode, $toVendorDetail->container_code);
                    }
                }
            }
        }

        $this->containers = Container::withTrashed()->whereIn('code', $containerCode)
            ->whereNotIn('code', function ($query) {
                $query->select(DB::raw('ISNULL(container_code, 0)'))
                      ->from('container_delegation_from_vendor_details', 'detail')
                      ->join('container_delegation_from_vendors as header', 'header.id' , '=', 'detail.from_vendor_id')
                      ->whereIn('header.status', [StatusEnum::DRAFT, StatusEnum::POSTED])
                    //   where condition get container_code has been deleted
                      ->where('detail.deleted_at', '=', null);
            })            
            // ->status('TSO')
            ->statuses(['TSO', 'TSOI']) // Include containers with TSO and TSOI status
            ->get();

        
    }

    public function submit()
    {
        $this->validate([
            'selected_container' => [
                'required',
                Rule::unique('container_delegation_from_vendor_details', 'container_code')->where(function ($query) {
                    return $query->where('from_vendor_id', $this->containerDelegationFromVendor->id)
                        ->whereNull('deleted_at');
                })
            ],
            'images.*' => 'required|image'
        ]);

        try {
            $container = Container::withTrashed()->where('code', $this->selected_container)->first();

            if ($container->status->code != 'TSO' && $container->status->code != 'TSOI') throw new Exception('Status Kontainer Harus Tidak Siap Operasi');

            $images = [];
            foreach ($this->images as $img) {
                array_push($images, $img->storePublicly('container-delegations/from-vendor/detail/' . $this->containerDelegationFromVendor->id));
            }

            $toVendorDetail = $container->delegationToVendorDetail()->where('is_done', 0)->orderBy('created_at', 'desc')->first();

            // Container Repair
            $repairDetail = [];

            $repairDetail = $container->repairDetail;

            if (!$repairDetail || $repairDetail == []) throw new Exception('Belum ada progress perbaikan untuk Container ini.');

            $repairDetailCode = ContainerRepairDetail::where('container_code', $container->code)
                ->whereHas('repair', function ($q) {
                    $q->where('status', '!=', StatusEnum::DRAFT);
                })
                ->orderBy('created_at', 'desc')->first();
            
            if (!$repairDetailCode) throw new Exception('Belum ada progress yang statusnya POSTED untuk container ini');
            

            DB::beginTransaction();
            
            $delegationDetail = new ContainerDelegationFromVendorDetail;
            $delegationDetail->from_vendor_id = $this->containerDelegationFromVendor->id;
            $delegationDetail->container_code = $this->selected_container;
            $delegationDetail->container_damage = $toVendorDetail->container_damage;
            $delegationDetail->delegation_to_vendor_date = $toVendorDetail->containerDelegation->action_date;
            $delegationDetail->progress = $repairDetailCode->progress;
            $delegationDetail->container_delegation_detail_id = $toVendorDetail->id;
            $delegationDetail->images = $images;
            $delegationDetail->save();

            if ($delegationDetail) {
                $toVendorSubDetails = ContainerDelegationSubDetail::where('ct_delegation_detail_id', $delegationDetail->container_delegation_detail_id)->get();

                if (!$toVendorSubDetails) throw new Exception('Belum ada data Container di Sub Detail BAST ke Vendor, dari vendor yang diinputkan');

                if ($toVendorSubDetails) {
                    $subDetail = [];
                    foreach ($toVendorSubDetails as $toVendorSubDetail) {
                        $subDetail = new ContainerDelegationFromVendorSubDetail;
                        $subDetail->ct_from_vendor_detail_id = $delegationDetail->id;
                        $subDetail->job_type = $toVendorSubDetail->job_type;
                        $subDetail->material_size = $toVendorSubDetail->material_size;
                        $subDetail->description = $toVendorSubDetail->description;
                        $subDetail->qty = $toVendorSubDetail->qty;
                        $subDetail->unit = $toVendorSubDetail->unit;
                        $subDetail->unit_price = $toVendorSubDetail->unit_price;
                        $subDetail->price_estimation = $toVendorSubDetail->price_estimation;
                        $subDetail->images = $toVendorSubDetail->images;
                        $subDetail->contract_detail_id = $toVendorSubDetail->contract_detail_id;
                        $subDetail->root_cause = $toVendorSubDetail->root_cause;
                        $subDetail->damage_description = $toVendorSubDetail->damage_description;
                        $subDetail->images_after = null;
                        $subDetail->save();
                    }

                    if ($this->containerDelegationFromVendor->job_type == JobTypeEnum::MAINTENANCE) {
                        if (!$subDetail) throw new Exception('Gagal menginput Detail BAST dari Vendor. BAST ini tidak mempunyai Sub Detail Perkerjaan');
                    }
                }
            }

            DB::commit();

            // Kalo type nya upgrade & repair, maka redirect nya refresh aja
            if ($this->containerDelegationFromVendor->job_type == JobTypeEnum::MAINTENANCE) {
                return redirect()->route('console.delegation-from-vendor.sub-detail.index', [$delegationDetail->from_vendor_id, $delegationDetail])->with('success', 'Berhasil menginput Detail BAST dari Vendor');
            }

            return redirect()->route('console.delegation-from-vendor.detail', $this->containerDelegationFromVendor)->with('success', 'Berhasil menginput Detail BAST dari Vendor');
        } catch (\Exception $e) {
            Log::error($e);
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.container-delegation-from-vendor.form-detail');
    }
}
