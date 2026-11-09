<?php

namespace App\Http\Controllers\Console;

use App\Models\Location;
use App\Models\Inspection;
use Illuminate\Http\Request;
use App\Models\InspectionDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInspectionRequest;
use App\Http\Requests\UpdateInspectionRequest;
use App\DataTables\Console\InspectionDataTable;
use App\Repositories\Console\InspectionRepository;
use App\Repositories\Console\RootCauseListRepository;
use Illuminate\Support\Facades\Log;

class InspectionController extends Controller
{
    public function index(InspectionDataTable $dataTable)
    {
        return $dataTable->render('console.inspection.index');
    }

    public function create()
    {
        $locations = Location::all();
        $is_edit = false;
        return view('console.inspection.create', compact('locations', 'is_edit'));
    }

    public function store(CreateInspectionRequest $request, InspectionRepository $repository)
    {
        $inspection = $repository->store($request->validated());
        return redirect()->route('console.inspection.detail', $inspection);
    }   

    public function detail(Inspection $inspection, RootCauseListRepository $repository)
    {   
        $rootCauseList = $repository->rootCauseList;
        return view('console.inspection.detail', compact('inspection', 'rootCauseList'));
    }

    public function detailDestroy(InspectionDetail $inspectionDetail, InspectionRepository $repository)
    {
        $repository->detailDestroy($inspectionDetail);
        return redirect()->back()->with('success', 'Berhasil melakukan hapus Inspeksi Detail');
    }
  

    public function posted(Inspection $inspection, InspectionRepository $repository)
    {
        try {
            $repository->posted($inspection);
            return redirect()->back()->with('success', 'Berhasil melakukan POSTED Inspeksi');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Inspection $inspection)
    {
        $inspection->delete();
        return redirect()->back()->with('success', 'Berhasil melakukan hapus Inspeksi');
    }

    public function edit(Inspection $inspection)
    {
        $locations = Location::all();
        $is_edit = true;
        return view('console.inspection.edit', compact('inspection', 'locations', 'is_edit'));
    }
    
    public function update(UpdateInspectionRequest $request, Inspection $inspection, InspectionRepository $repository)
    {
        $repository->update($inspection, $request->validated());
        return redirect()->back()->with('success', 'Berhasil melakukan update Inspeksi');
    }

    public function approve(Inspection $inspection, InspectionRepository $repository) {
        try {
            $repository->approve($inspection);
            return redirect()->back()->with('success', 'Berhasil melakukan APPROVE Inspeksi');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function reject(Inspection $inspection, InspectionRepository $repository) {
        try {
            $repository->reject($inspection);
            return redirect()->back()->with('success', 'Berhasil melakukan REJECT Inspeksi');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
