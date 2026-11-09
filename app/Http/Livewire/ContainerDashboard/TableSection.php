<?php

namespace App\Http\Livewire\ContainerDashboard;

use Carbon\Carbon;
use App\Models\Vendor;
use Livewire\Component;
use App\Models\Container;
use App\Exports\CTStatusReport;
use App\Models\ContainerStatus;
use App\Enums\ContainerStatusEnum;
use App\Repositories\Console\CTCReportRepository;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TableSection extends Component
{
    public $filterStatus;
    public $status;
    public $color;
    public $ctStatus;
    public $state;
    public $isTSO = false;
    public $isSO = false;

    protected $containerReportRepository;

    public function __construct()
    {
        $this->containerReportRepository = app()->make(CTCReportRepository::class);
    }

    public function mount()
    {

        $this->color = [
            'O' => ContainerStatusEnum::COLOR_O,
            'TSO_M' => ContainerStatusEnum::COLOR_TSO_MAINTENANCE,
            'TSO_U' => ContainerStatusEnum::COLOR_TSO_UPGRADGE,
            'TSO' => ContainerStatusEnum::COLOR_TSO_GENERAL,
            'S' => ContainerStatusEnum::COLOR_S,
            'SO' => ContainerStatusEnum::COLOR_SO,
            'SOI' => ContainerStatusEnum::COLOR_SOI,
            'TSOI' => ContainerStatusEnum::COLOR_TSOI,
        ];

        $this->ctStatus = [
            'O' => ContainerStatusEnum::O,
            'TSO_M' => ContainerStatusEnum::TSO_MAINTENANCE,
            'TSO_U' => ContainerStatusEnum::TSO_UPGRADE,
            'TSO' => ContainerStatusEnum::COLOR_TSO_GENERAL,
            'S' => ContainerStatusEnum::S,
            'SO' => ContainerStatusEnum::SO,
            'SOI' => ContainerStatusEnum::SOI,
            'TSOI' => ContainerStatusEnum::TSOI,
        ];

        $this->state['bast_from_vendor'] = [];
    }

    public function updatedFilterStatus()
    {


        $this->status = $this->filterStatus;
    }

    public function export()
    {
        return Excel::download(new CTStatusReport($this->status), 'ctc_status_report.xlsx');
    }

    public function showModal(Container $container)
    {

        $this->dispatchBrowserEvent('show-modal', ['container' => $container]);
        $this->state = $container->toArray();
        $this->state['buy_date'] = $container->buy_date ? Carbon::parse($container->buy_date)->format('Y-m-d') : '-';
        // last maintenance date
        $this->state['last_maintenance_date'] = $container->last_maintenance_date ? Carbon::parse($container->last_maintenance_date)->format('Y-m-d') : '-';
        // last upgrade date
        $this->state['last_upgrade_date'] = $container->last_upgrade_date ? Carbon::parse($container->last_upgrade_date)->format('Y-m-d') : null;
        $this->state['last_upgrade_vendor_id'] = $container->lastUpgradeVendor->name;
        $this->state['last_maintenance_vendor_id'] = $container->lastMaintenanceVendor->name;
        $this->state['down_location_id'] = $container->down_location_id != null ? 'TSO: ' . $container->downLocation['code'] : 'TSO:-';
        $this->state['up_location_id'] = $container->up_location_id != null ? 'SO:' . $container->upLocation['code'] : 'SO:-';
        $this->state['container_status_id'] = $container->status->code;
        if ($container->status->code  == 'TSO' && isset($container->downLocation['code'])) {
            $this->isTSO = true;
        } elseif ($container->status->code  == 'SO' && isset($container->upLocation['code'])) {
            $this->isSO = true;
        }

        $this->state['bast_from_vendor'] = $container->delegationFromVendorDetail ? $container->delegationFromVendorDetail : [];

        
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-modal');
    }



    public function render()
    {
        $containerVendors = $this->containerReportRepository->getStatusDashboardQuery($this->status);

        return view('livewire.container-dashboard.table-section', compact('containerVendors'));
    }
}
