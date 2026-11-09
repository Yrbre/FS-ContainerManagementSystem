<?php

namespace App\Http\Livewire\Report\ContainerReport;

use App\Models\Vendor;
use App\Models\Company;
use Livewire\Component;
use App\Models\Location;
use App\Exports\CTReport;
use App\Models\Container;
use Livewire\WithPagination;
use App\Models\ContainerStatus;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TableSection extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    

    public $company;
    public $location;
    public $vendor_buy;
    public $status;
    public $vendor_repair;


    public function export() {

        $filter = [
            'company' => $this->company,
            'location' => $this->location,
            'vendor_buy' => $this->vendor_buy,
            'status' => $this->status,
            'vendor_repair' => $this->vendor_repair,
        ];

        return Excel::download(new CTReport($filter), 'ctc_report.xlsx');
    }


    public function render()
    {

        $companies = Company::all();
        $vendors = Vendor::all();
        $locations = Location::all();
        $statuses = ContainerStatus::all();


        // $containers = Container::with('status', 'vendor', 'company', 'downLocation', 'upLocation', 'repairDetail', 'inspectionDetail', 'bastToVendor', 'latestInspection');
        $containers = Container::with('status', 'vendor', 'company', 'downLocation', 'upLocation', 'latestRepair', 'latestInspection', 'latestBastToVendor');


        $containers->when($this->company, function($query, $company) {
            return $query->where('company_id', $company);
        });

        $containers->when($this->vendor_buy, function($query, $vendor_buy) {
            return $query->where('vendor_id', $vendor_buy);
        });

        $containers->when($this->vendor_repair, function($query, $vendor_repair) {
            $query->where(function($q) use ($vendor_repair) {
                $q->where('last_upgrade_vendor_id', $vendor_repair)
                ->orWhere('last_maintenance_vendor_id', $vendor_repair);
            });
        });

        $containers->when($this->status, function($query, $status) {
            return $query->status($status);
        });

        $containers->when($this->location, function($query, $location) {
            return $query->where('down_location_id', $location);            
        });
    
        $containers = $containers->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')
                    ->paginate(50);


        return view('livewire.report.container-report.table-section', compact('companies', 'vendors', 'locations', 'statuses', 'containers'));
    }
}
