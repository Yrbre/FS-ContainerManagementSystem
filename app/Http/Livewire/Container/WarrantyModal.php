<?php

namespace App\Http\Livewire\Container;

use App\Models\Container;
use App\Models\ContainerDelegationFromVendorDetail;
use App\Models\ContainerDelegationFromVendorSubDetail;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class WarrantyModal extends Component
{
    public $ctWarranty = "-";
    public $upgradeWarranty = "-";
    public $bastWarranty = [];
    public string $ct;

    public function mount(string $ct = "141")
    {
        $container = Container::findOrFail($ct);
        $this->ct = $ct;
        if ($container->warranty_date_start) {
            $this->ctWarranty = Carbon::parse($container->warranty_date_start)->format("d-m-Y") . " s/d " . Carbon::parse($container->warranty_date_end)->format("d-m-Y");
        }

        if ($container->upgrade_warranty_start_date) {
            $this->upgradeWarranty = Carbon::parse($container->upgrade_warranty_start_date)->format("d-m-Y") . " s/d " . Carbon::parse($container->upgrade_warranty_end_date)->format("d-m-Y");
        }

        $this->bastWarranty = ContainerDelegationFromVendorSubDetail::whereHas('detail', function ($query) use ($ct) {
            $query->where('container_code', $ct);
        })
        ->whereDate('warranty_start_date', '<=', now())
        ->whereDate('warranty_end_date', '>=', now())
        ->get();

    }

    public function render()
    {
        return view('livewire.container.warranty-modal');
    }
}
