<?php

namespace App\Http\Controllers\Console\Report;

use App\Exports\InspectionsExport;
use App\Models\Vendor;
use App\Models\Contract;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Exports\BastListExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Console\BastReportRepository;

class BastReportController extends Controller
{

    public function maintenance(BastReportRepository $repository, Request $request)
    {

        $results = collect([]);
        $params = $request->all();

        $showTableFilter = false;
        if (in_array($request->get('action'), ['filter', 'export'])) {
            if ($request->get('action') == 'filter' && $request->get('by_type') == 'Maintenance') {
                $results = $repository->getDataTableMaintenanceQuery($request->all());
            } elseif ($request->get('action') == 'filter' && $request->get('by_type') == 'Upgrade & Repair') {
                $results = $repository->getDataTableUpgradeQuery($request->all());
            }
            $showTableFilter = true;
        }

        if ($request->get('action') == "export") {
            if ($request->get('by_type') == 'Maintenance') {
                $results = $repository->getDataTableMaintenanceQuery($request->all());
            } elseif ($request->get('by_type') == 'Upgrade & Repair') {
                $results = $repository->getDataTableUpgradeQuery($request->all());
            }


            if ($results->count() == 0) {
                return redirect()->back()->with('error', 'Tidak ada data yang dapat diexport.');
            } else {
                return Excel::download(new BastListExport($results, $params['by_type']), 'bast_list_' . strtolower($params['by_type']) . '.xlsx');
            }


        }


        // dd($results);


        return view('console.report.bast-maintenance', compact('results', 'showTableFilter', 'params'));
    }

    public function upgrade(BastReportRepository $repository, Request $request)
    {
        $query = $repository->getDataTableUpgradeQuery($request->all());

        return $query;
    }

    public function inspection(BastReportRepository $repository, Request $request)
    {

        $results = collect([]);
        $params = $request->all();

        $showTableFilter = false;
        if (in_array($request->get('action'), ['filter', 'export'])) {
            if ($request->get('action') == 'filter') {
                $results = $repository->getDataInspection($request->all());
            }
            $showTableFilter = true;
        }

        if ($request->get('action') == "export") {
            if ($request->get('by_type') == 'Maintenance') {
                $results = $repository->getDataInspection($request->all());
            } elseif ($request->get('by_type') == 'Upgrade & Repair') {
                $results = $repository->getDataInspection($request->all());
            }


            if ($results->count() == 0) {
                return redirect()->back()->with('error', 'Tidak ada data yang dapat diexport.');
            } else {
                return Excel::download(new InspectionsExport($results, $params['by_type']), 'inspections_' . strtolower($params['by_type']) . '.xlsx');
            }
        }


        // dd($results);


        return view('console.report.inspection-report', compact('results', 'showTableFilter', 'params'));
    }
}
