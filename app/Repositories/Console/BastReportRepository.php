<?php

namespace App\Repositories\Console;

use Illuminate\Support\Facades\DB;

class BastReportRepository
{
    public function getDataTableMaintenanceQuery($params)
    {
        $query = DB::table("container_delegation_from_vendor_sub_details", "bast_from_vendor")
            ->select([
                'bast_to_vendor_detail.container_code',
                'bast_to_vendor_header.action_date',
                'bast_to_vendor_detail.carriage_number',
                'bast_from_vendor.job_type',
                'bast_from_vendor.root_cause',
                'bast_from_vendor.material_size',
                'bast_from_vendor.qty',
                'bast_from_vendor.unit',
                'bast_from_vendor.unit_price',
                'bast_from_vendor.price_estimation',
                'bast_to_vendor_header.approve_date',
                'bast_to_vendor_header.approve2_date',
                'bast_to_vendor_header.approve3_date',
                'bast_from_vendor_header.action_date as tgl_selesai',
                'bast_from_vendor.ct_from_vendor_detail_id as id_detail'

            ])
            ->join("container_delegation_from_vendor_details as bast_from_vendor_detail",
             "bast_from_vendor_detail.id", "=", "bast_from_vendor.ct_from_vendor_detail_id", 'left')

            ->join("container_delegation_details as bast_to_vendor_detail",
             "bast_to_vendor_detail.id", "=", "bast_from_vendor_detail.container_delegation_detail_id", 'left')

            ->join("container_delegations as bast_to_vendor_header",
             "bast_to_vendor_header.id", "=", "bast_to_vendor_detail.container_delegation_id", 'left')

            ->join("container_delegation_from_vendors as bast_from_vendor_header",
             "bast_from_vendor_header.id", "=", "bast_from_vendor_detail.from_vendor_id", 'left')

            ->where('bast_to_vendor_header.job_type', 'Maintenance')
            ->whereNull('bast_from_vendor_detail.deleted_at')
            ->where('bast_to_vendor_detail.is_done', 1);


        // Query from params
        if (count($params) > 0) {
            // Filter Mode
            $query->when($params['by_vendor'], function ($q) use ($params) {
                $q->where('bast_to_vendor_header.vendor_id', $params['by_vendor']);
            });

            $query->when($params['by_contract'], function ($q) use ($params) {
                $q->where('bast_to_vendor_header.contract_id', $params['by_contract']);
            });

            $query->when($params['from'] && $params['to'], function ($q) use ($params) {
                $q->whereDate('bast_from_vendor_header.action_date', '>=', $params['from'])
                    ->whereDate('bast_from_vendor_header.action_date', '<=', $params['to']);
            });

            $query->when($params['by_location'], function ($q) use ($params) {
                $q->where('bast_to_vendor_header.location_id', $params['by_location']);
            });

            // $query->when($params['by_type'], function ($q) use ($params) {
            //     $q->where('bast_to_vendor_header.job_type', $params['by_type']);
            // });
        }

        $query->orderBy('id_detail', 'asc')->orderBy('bast_to_vendor_header.action_date', 'asc');
        // sorting by action_date doesn't have much of an effect

        // $query->orderBy(DB::raw('TRY_CAST(bast_to_vendor_detail.container_code as INT)'), 'asc');
        return $query->get();
    }

    public function getDataTableUpgradeQuery($params)
    {
        $query = DB::table("container_delegations", "bast_to_vendor_header")
        ->select([
            'bast_to_vendor_detail.container_code',
            'bast_to_vendor_header.action_date',
            'sub_detail_from_vendor.job_type',
            'sub_detail_from_vendor.description',
            'sub_detail_from_vendor.qty',
            'bast_from_vendor_header.action_date as tgl_selesai',
            'bast_to_vendor_detail.carriage_number',

        ])
        ->join("container_delegation_details as bast_to_vendor_detail", "bast_to_vendor_detail.container_delegation_id", "=", "bast_to_vendor_header.id","left")

        ->join("container_delegation_from_vendor_details as bast_from_vendor_detail", "bast_from_vendor_detail.container_delegation_detail_id", "=", "bast_to_vendor_detail.id", "left")

        ->join("container_delegation_from_vendor_sub_details as sub_detail_from_vendor", "sub_detail_from_vendor.ct_from_vendor_detail_id", "=", "bast_from_vendor_detail.id","left")
        
        ->join("container_delegation_from_vendors as bast_from_vendor_header", "bast_from_vendor_header.id", "=", "bast_from_vendor_detail.from_vendor_id", "left")

        ->whereNull('bast_from_vendor_detail.deleted_at')

        ->where('bast_to_vendor_header.job_type', 'Upgrade & Repair');

        $query->when($params['by_vendor'], function ($q) use ($params) {
            $q->where('bast_to_vendor_header.vendor_id', $params['by_vendor']);
        });

        $query->when($params['by_contract'], function ($q) use ($params) {
            $q->where('bast_to_vendor_header.contract_id', $params['by_contract']);
        });

        $query->when($params['from'], function ($q) use ($params) {
            $q->whereDate('bast_from_vendor_header.action_date', '>=', $params['from'])
                ->whereDate('bast_from_vendor_header.action_date', '<=', $params['to']);
        });

        $query->when($params['by_location'], function ($q) use ($params) {
            $q->where('bast_to_vendor_header.location_id', $params['by_location']);
        });

        $query->orderBy('bast_to_vendor_header.action_date', 'asc');
        // $query->orderBy(DB::raw('TRY_CAST(bast_to_vendor_detail.container_code as INT)'), 'asc');
        return $query->get();

    }

    public function getDataInspection($params)
    {
        $query = DB::table("inspections", "header")
            ->select([
                'detail.container_code',
                'header.action_date',
                'detail.damage_description',
                'detail.root_cause',
                'header.code',
                'header.id'
            ])
            ->join("inspection_details as detail",
             "detail.inspection_id", "=", "header.id")
            ->whereNull('header.deleted_at');

            if(isset($params['by_type'])) {
                $query->where('header.fixing_job_type', $params['by_type']);
            }


        // Query from params
        if (count($params) > 0) {
            // Filter Mode
            $query->when($params['from'] && $params['to'], function ($q) use ($params) {
                $q->whereDate('header.action_date', '>=', $params['from'])
                    ->whereDate('header.action_date', '<=', $params['to']);
            });

            $query->when($params['by_location'], function ($q) use ($params) {
                $q->where('header.location_id', $params['by_location']);
            });
        }

        $query->orderBy('detail.id', 'asc')->orderBy('header.action_date', 'asc');
        // sorting by action_date doesn't have much of an effect

        // $query->orderBy(DB::raw('TRY_CAST(bast_to_vendor_detail.container_code as INT)'), 'asc');
        return $query->get();
    }

}
