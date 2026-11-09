<?php

namespace App\Http\Livewire\ContainerDailyActivity;

use App\Enums\StatusEnum;
use App\Imports\ContainerDailyActivityDetailsImport;
use App\Models\Container;
use App\Models\ContainerDailyActivity;
use App\Models\ContainerDailyActivityDetail;
use App\Models\Inspection;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Repositories\Console\ContainerDailyActivityRepository;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormDetail extends Component
{
    use WithFileUploads;
    public $containers;
    public $selected_container;
    public $carriage_number;
    public $container_source;
    public $trainset_number;
    public $containerDailyActivityId;
    public $location;
    public $containerDailyActivity;
    public $type;
    public $upTSO = false;
    public $ctIsNotDone;

    public $openModalActivity;
    public $openModalUpload;
    public $file;

    protected $listeners = [
        'openModal',
        'closeModal',
        'openModalUpload',
        'closeModalUpload'
    ];

    public function mount($containerDailyActivityId)
    {
        $this->trainset_number = '-';
        // modal
        $this->openModalActivity = false;

        $this->containerDailyActivityId = $containerDailyActivityId;

        // containerDailyActivity
        $this->containerDailyActivity = ContainerDailyActivity::where('id', $this->containerDailyActivityId)->first();
    }

    public function openModal()
    {
        $this->openModalActivity = true;
    }

    public function closeModal()
    {
        $this->openModalActivity = false;
    }

    public function openModalUpload()
    {
        $this->openModalUpload = true;
    }

    public function closeModalUpload()
    {
        $this->openModalUpload = false;
    }

    public function updatedType()
    {
        if ($this->type == 'Turun Container') {
            // $inspections = Inspection::where('status', '!=', StatusEnum::DRAFT)->get();
            // $inspections = Container::query()->with('status')->statuses(['O', 'TSO'])->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')->get();
            // // dd($inspections);

            // if ($inspections) {
            //     foreach ($inspections as $inspection) {
            //         $inspectionDetail = $inspection->details()->get();
            //         if ($inspectionDetail->count() > 0) {
            //             foreach ($inspectionDetail as $detail) {
            //                 $code = $detail->pluck('container_code');

            //                 $containerCode = $code->unique();
            //             }

            //             if (!$containerCode) { 
            //                 session()->flash('error', 'Tidak Ada data CT Inspection yang statusnya APPROVE / POSTED');
            //             }

            // O -> SO only in BBA or BJI
            $location = $this->location;
            if ($location != 'BBA' && $location != 'BJI' ) {
                $this->containers = Container::query()->with('status')->statuses(['TSO'])
                    ->whereNotIn('code', function ($q) {
                        $q->select(DB::raw('ISNULL(detail.container_code, 0)'))
                            ->from('container_daily_activity_details as detail')
                            ->join('container_daily_activities as header', 'header.id', '=', 'detail.ct_daily_activity_id')
                            ->where('header.status', StatusEnum::DRAFT);
                    })
                    // ->whereNull('down_location_id')
                    // ->where('up_at', '>=', DB::raw('down_at'))
                    ->where(function ($query) {
                        $query->whereNull('down_at')
                            ->orWhere('up_at', '>=', DB::raw('down_at'));
                    })
                    ->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')
                    ->get();
            } else {
                $this->containers = Container::query()->with('status')->statuses(['O', 'TSO'])
                    ->whereNotIn('code', function ($q) {
                        $q->select(DB::raw('ISNULL(detail.container_code, 0)'))
                            ->from('container_daily_activity_details as detail')
                            ->join('container_daily_activities as header', 'header.id', '=', 'detail.ct_daily_activity_id')
                            ->where('header.status', StatusEnum::DRAFT);
                    })
                    // ->whereNull('down_location_id')
                    // ->where('up_at', '>=', DB::raw('down_at'))
                    ->where(function ($query) {
                        $query->whereNull('down_at')
                            ->orWhere('up_at', '>=', DB::raw('down_at'));
                    })
                    ->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')
                    ->get();
            }
            //         }
            //     }
            // }
        } elseif ($this->type == 'Naik Container') {
            $this->containers = Container::query()->with('status')->statuses(['SO', 'TSO', 'SOI'])->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')->get();
        } elseif ($this->type == 'Putus Gerbong') {
            $this->containers = Container::query()->status('O')->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')->get();
            // Tambahan aktivitas harian di BJI 
        } elseif ($this->type == 'CT-DT') {
            $this->containers = Container::query()->with('status')->statuses(['SO', 'O'])->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')->get();
        } elseif ($this->type == 'Truck Unloading') {
            $this->containers = Container::query()->status('SO')->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')->get();
        } elseif ($this->type == 'Container Uplift') {
            $this->containers = Container::query()->status('SO')->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')->get();
        } elseif ($this->type == 'Container Unloading') {
            $this->containers = Container::query()->status('TSOI')->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')->get();
        }
    }

    public function updatedSelectedContainer()
    {
        if ($this->type == 'Naik Container') {
            $container = Container::query()->where('code', $this->selected_container)->status('TSO')->first();
            if ($container) {
                $this->upTSO = true;

                // ct has_field is_done = 0 in container_delegation can't submit
                $this->ctIsNotDone = $container->delegationToVendorDetail()->where('is_done', 0)->count();

                if ($this->ctIsNotDone > 0) {
                    session()->flash('error', 'CT ' . $this->selected_container . ' masih belum selesai di BAST 1, dan tidak bisa di naikkan.');
                }

            } else {
                $this->ctIsNotDone = false;
                $this->upTSO = false;
            }
        }
    }

    public function submit()
    {
        $this->validate([
            'type' => 'required|string',
            'selected_container' => [
                'required',
                Rule::unique('container_daily_activity_details', 'container_code')->where(function ($query) {
                    return $query->where('ct_daily_activity_id', $this->containerDailyActivityId);
                }),
            ],
            'carriage_number' => 'required|string',
            'trainset_number' => 'required|string',
            'container_source' => 'required|string'
        ]);

        if ($this->ctIsNotDone > 0) {
            session()->flash('error', 'Gagal menambah Detail Aktivitas, CT ' . $this->selected_container . ' masih belum selesai di BAST 1, dan tidak bisa di naikkan.');
            return;
        }

        try {
            $detail = new ContainerDailyActivityDetail;
            $detail->ct_daily_activity_id = $this->containerDailyActivityId;
            $detail->type = $this->type;
            $detail->container_code = $this->selected_container;
            $detail->carriage_number = $this->carriage_number;
            $detail->container_source = $this->container_source;
            $detail->trainset_number = $this->trainset_number;
            $detail->save();

            $this->emit('refresh-component');

            session()->flash('success', 'Berhasil menambah Detail Aktivitas');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menambah Detail Aktivitas');
        }
    }

    public function render()
    {
        return view('livewire.container-daily-activity.form-detail');
    }


    //UPLOAD FILE DETAIL ACTIVITY
    public function upload()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $data = $this->processFile($this->file);
        $this->storeData($data);
        $this->emit('refresh-component');
        $this->file = null;
    }

    private function processFile($file)
    {
        $originalFilename = $this->file->getClientOriginalName();
        $extension = $this->file->getClientOriginalExtension();

        $currentDate = Carbon::now()->format('Ymd');

        $filename = $currentDate . '_' . $originalFilename;
        $filePath = $this->file->storeAs('bba-activity-files', $filename);
        $import = new ContainerDailyActivityDetailsImport();
        Excel::import($import, $filePath);

        return $import->getData();
    }

    private function storeData($data)
    {
        try {
            foreach ($data as $row) {
                if (!empty($row['container_code']) && !empty($row['type']) && !empty($row['carriage_number']) && !empty($row['container_source'])) {
                    ContainerDailyActivityDetail::create([
                        'ct_daily_activity_id' => $this->containerDailyActivityId,
                        'container_code' => $row['container_code'],
                        'type' => $row['type'],
                        'carriage_number' => $row['carriage_number'],
                        'container_source' => $row['container_source'],
                    ]);
                }
            }
            session()->flash('success', 'Berhasil menambah Detail Aktivitas');
        } catch (\Exception $e) {
            ContainerDailyActivityDetail::where('ct_daily_activity_id', $this->containerDailyActivityId)->delete();
            session()->flash('error', 'Gagal menambah Detail Aktivitas, terdapat No. Container yang salah.');
        }
    }
}