<?php

namespace App\Repositories\Console;

use App\Enums\ContainerStatusEnum;
use App\Models\Container;
use Illuminate\Support\Facades\DB;

class CTCReportRepository
{
    public function getColors()
    {
        return [
            'O' => ContainerStatusEnum::COLOR_O,
            // TODO : Check different by status
            'TSO_M' => ContainerStatusEnum::COLOR_TSO_MAINTENANCE,
            'TSO_U' => ContainerStatusEnum::COLOR_TSO_UPGRADGE,
            'TSO' => ContainerStatusEnum::COLOR_TSO_GENERAL,
            'S' => ContainerStatusEnum::COLOR_S,
            'SO' => ContainerStatusEnum::COLOR_SO,
            'SOI' => ContainerStatusEnum::COLOR_SOI,
            'TSOI' => ContainerStatusEnum::COLOR_TSOI,
        ];
    }

    public function getStatusDashboardQuery(?string $status)
    {
        $containerVendors = DB::table('vendors')
            ->selectRaw(
                "vendors.id, vendors.name, 
            COUNT(containers.code) as total,
            SUM(CASE WHEN container_statuses.code = 'O' THEN 1 ELSE 0 END) as container_status_o,
            SUM(CASE WHEN container_statuses.code = 'TSO' AND containers.last_type_maintenance IS NULL THEN 1 ELSE 0 END) as container_status_tso,
            SUM(CASE WHEN container_statuses.code = 'SO' THEN 1 ELSE 0 END) as container_status_so,
            SUM(CASE WHEN container_statuses.code = 'S' THEN 1 ELSE 0 END) as container_status_s,
            SUM(CASE WHEN container_statuses.code = 'SOI' THEN 1 ELSE 0 END) as container_status_soi,
            SUM(CASE WHEN container_statuses.code = 'TSOI' THEN 1 ELSE 0 END) as container_status_tsoi,
            SUM(CASE WHEN container_statuses.code = 'TSO' AND containers.last_type_maintenance = 'Maintenance' THEN 1 ELSE 0 END) as container_status_tso_m,
            SUM(CASE WHEN container_statuses.code = 'TSO' AND containers.last_type_maintenance = 'Upgrade & Repair' THEN 1 ELSE 0 END) as container_status_tso_u"
            )
            ->join('containers', 'vendors.id', '=', 'containers.vendor_id')
            ->join('container_statuses', 'containers.container_status_id', '=', 'container_statuses.id');


        $containerVendors->when($status, function($query, $status) {
            if($status == ContainerStatusEnum::TSO_MAINTENANCE 
            || $status == ContainerStatusEnum::TSO_UPGRADE ) {
                $query->where('containers.last_type_maintenance', $status);
                $status = ContainerStatusEnum::TSO;
            }
            return $query->where('container_statuses.code', $status);
        });


        $containerVendors = $containerVendors->groupBy('vendors.id', 'vendors.name')
            ->get()
            ->toArray();


        // instance model containers
        $containers = Container::with('status');

        $containers->when($status, function($query, $status) {

            if($status == ContainerStatusEnum::TSO_MAINTENANCE 
            || $status == ContainerStatusEnum::TSO_UPGRADE ) {
                $query->where('last_type_maintenance', $status);
                $status = ContainerStatusEnum::TSO;
            }

            return $query->status($status);
        });

        $containers = $containers->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')->get();

        foreach ($containerVendors as $key => $containerVendor) {
            foreach ($containers as $container) {
                if ($containerVendor->id == $container->vendor_id) {
                    // if($container->status->code == ContainerStatusEnum::TSO && $container->last_type_maintenance == null) {
                    //     continue;
                    // } else {
                    //     $containerVendor->containers[] = $container;
                    // }

                    $containerVendor->containers[] = $container;
                }
            }
        }

        return $containerVendors;
    }


    public function getFilteringContainerQuery(?array $filter)
    {
        $containers = Container::with('status', 'vendor', 'company', 'downLocation', 'upLocation', 'repairDetail', 'inspectionDetail', 'bastToVendor');

        $containers->when($filter['company'], function($query, $company) {
            return $query->where('company_id', $company);
        });

        $containers->when($filter['vendor_buy'], function($query, $vendor_buy) {
            return $query->where('vendor_id', $vendor_buy);
        });

        $containers->when($filter['vendor_repair'], function($query, $vendor_repair) {
            return $query->where('last_upgrade_vendor_id', $vendor_repair)->orWhere('last_maintenance_vendor_id', $vendor_repair);
        });

        $containers->when($filter['status'], function($query, $status) {
            return $query->status($status);
        });

        $containers->when($filter['location'], function($query, $location) {
            return $query->statuses(['SO','TSO'])->where('down_location_id', $location)->orWhere('up_location_id', $location);
        });

        $containers = $containers->orderBy(DB::raw('TRY_CAST(code as INT)'), 'ASC')->get();

        return $containers;
    }
}
