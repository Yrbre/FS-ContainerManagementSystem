<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Company;
use App\Models\Container;
use App\Models\ContainerStatus;
use App\Models\Dashboard;
use App\Models\Location;
use App\Models\Vendor;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;

class MainSection extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $container;
    public $isModalVisible = false;
    public $labels = [];
    public $state;
    public $colors = [];
    public $isMaintenance = false; // New property to track maintenance mode

    public function showModal($location, $status, $repair_type = null)
    {
        $this->dispatchBrowserEvent('show-modal', []);
        $this->isMaintenance = false; // Reset maintenance mode
        $this->updateModalTableContent($location, $status, $repair_type);
    }

    public function showModalMaintenance($location, $status, $repair_type = null)
    {
        $this->dispatchBrowserEvent('show-modal', []);
        $this->isMaintenance = true; // Set maintenance mode
        $this->updateModalTableContent($location, $status, $repair_type);
    }

    public function closeModal()
    {
        $this->state['containers'] = null;
        $this->dispatchBrowserEvent('close-modal');
    }

    public function updateModalTableContent($location, $status, $repair_type = null)
    {
        $containers = Container::with('status', 'vendor', 'company', 'downLocation', 'upLocation', 'latestRepair', 'latestInspection', 'latestBastToVendor', 'latestBastFromVendor', 'latestDelegationFromVendorDetail', 'latestDailyActivityDetail');

        $containers->when($status, function ($query, $status) {
            return $query->status($status);
        });

        $containers->when($location, function ($query, $location) {
            return $query->where('down_location_id', $location);
        });

        if ($repair_type && $repair_type != 'CT-DT') {
            $containers->when($repair_type, function ($query, $repair_type) {
                return $query->where('last_type_maintenance', $repair_type);
            });
        }

        if (!$location) {
            $containers->whereNull('down_location_id');
        }

        $containers = $containers->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')->get();

        if ($repair_type == 'CT-DT') {
            $containers = $containers->filter(function ($container) {
                return $container->latestDailyActivityDetail && $container->latestDailyActivityDetail->type === 'CT-DT';
            });
        }

        $this->state['containers'] = $containers;
        $this->state['location'] = $location;
        $this->state['status'] = $status;
        if (!$this->isMaintenance) {
            $ct_dt = $containers->filter(function ($container) {
                return $container->latestDailyActivityDetail && $container->latestDailyActivityDetail->type === 'CT-DT';
            });
            $this->state['ct_dt'] = $ct_dt->count();
            $this->state['total_maintenance'] = $containers->where('last_type_maintenance', 'Maintenance')->count();
            $this->state['total_upgrade'] = $containers->where('last_type_maintenance', 'Upgrade & Repair')->count();
        }

        if ($this->isMaintenance) { // Check if in maintenance mode
            $this->isModalVisible = true;
        }
    }

    public function render()
    {
        $companies = Company::all();
        $vendors = Vendor::all();
        $locations = Location::all();
        $statuses = ContainerStatus::all();
        $records = Dashboard::orderBy('code', 'asc')->get();

        return view('livewire.dashboard.main-section', compact('records'));
    }
}