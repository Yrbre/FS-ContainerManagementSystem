<?php

namespace App\Http\Livewire\ContainerScrap;

use App\Enums\JobTypeEnum;
use App\Models\ContainerScrapDetail;
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
use App\Models\ContainerScrap;
use App\Models\ContainerDelegationFromVendorDetail;
use App\Repositories\Console\RootCauseListRepository;
use App\Models\ContainerDelegationFromVendorSubDetail;

class FormDetail extends Component
{
    use WithFileUploads;

    public $containers;
    public $selected_container;
    public $persentase;
    public $description;
    public $containerScrap;
    public $images = [];
    public $ctToVendor;
    public $upTSO = false;
    public $ctIsNotDone;

    public function mount($containerScrap)
    {
        $this->containerScrap = $containerScrap;
        $containerScrap = ContainerScrap::where('id', $this->containerScrap->id)->first();

        $this->ctToVendor = ContainerDelegation::where('status', '!=', StatusEnum::DRAFT)
            ->where('job_type', $containerScrap->job_type)
            ->where('vendor_id', $containerScrap->vendor_id)
            ->where('location_id', $containerScrap->location_id)
            ->whereHas('details', function ($query) {
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

        $this->containers = Container::query()->with('status')->statuses(['TSO'])->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')->get();

    }

    public function updatedSelectedContainer()
    {
        $container = Container::query()->where('code', $this->selected_container)->status('TSO')->first();
        if ($container) {
            $this->upTSO = true;

            // ct has_field is_done = 0 in container_delegation can't submit
            $this->ctIsNotDone = $container->delegationToVendorDetail()->where('is_done', 0)->count();

            if ($this->ctIsNotDone > 0) {
                session()->flash('error', 'CT ' . $this->selected_container . ' masih dalam proses BAST, dan tidak bisa discrap.');
            }

        } else {
            $this->ctIsNotDone = false;
            $this->upTSO = false;
        }
    }

    public function submit()
    {
        $this->validate([
            'selected_container' => [
                'required',
                Rule::unique('container_scrap_details', 'container_code')->where(function ($query) {
                    return $query->where('container_scrap_id', $this->containerScrap->id)
                        ->whereNull('deleted_at');
                })
            ],
            'images.*' => 'required|image',
            'persentase.*' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
        ]);

        if ($this->ctIsNotDone > 0) {
            session()->flash('error', 'Gagal menambah Detail Scrap, CT ' . $this->selected_container . ' masih belum selesai di BAST 1, dan tidak bisa di naikkan.');
            return;
        }

        $scrap = ContainerScrap::whereIn('status', ['DRAFT', 'POSTED'])->get();
        if ($scrap->count() > 0) {
            foreach ($scrap as $detail) {
                $det = $detail->details()->get();

                if ($det->count() > 0) {
                    foreach ($det as $sub) {
                        if ($sub->container_code == $this->selected_container) {
                            session()->flash('error', 'Gagal menambah Detail Scrap, CT ' . $this->selected_container . ' sudah dalam pengajuan scrap.');
                            return;
                        }
                    }
                }
            }
        }

        try {
            $container = Container::withTrashed()->where('code', $this->selected_container)->first();

            if ($container->status->code != 'TSO')
                throw new Exception('Status Kontainer Harus Tidak Siap Operasi');

            $images = [];
            foreach ($this->images as $img) {
                array_push($images, $img->storePublicly('container/scrap/detail/' . $this->containerScrap->id));
            }

            $detail = new ContainerScrapDetail;
            $detail->container_scrap_id = $this->containerScrap->id;
            $detail->container_code = $this->selected_container;
            $detail->persentase = $this->persentase;
            $detail->description = $this->description;
            $detail->images = $images;
            $detail->save();

            $this->emit('refresh-component');

            session()->flash('success', 'Berhasil menambah Detail Scrap');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menambah Detail Scrap');
        }
    }
    public function render()
    {
        return view('livewire.container-scrap.form-detail');
    }
}