<?php

namespace App\Http\Controllers\Console;

use App\DataTables\Console\ContainerDailyActivityDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\ContainerDailyActivity;
use App\Http\Requests\ContainerDailyActivityCreateRequest;
use App\Http\Requests\ContainerDailyActivityUpdateRequest;
use App\Models\Location;
use App\Repositories\Console\ContainerDailyActivityRepository;

class ContainerDailyActivityController extends Controller
{
    public function index(ContainerDailyActivityDataTable $dataTable, ContainerDailyActivity $containerDailyActivity, ContainerDailyActivityRepository $repository)
    {
        $repository->markDraftAsDeleted($containerDailyActivity);
        return $dataTable->render('console.container-daily-activity.index');
    }

    public function create()
    {
        $locations = Location::all();

        return view('console.container-daily-activity.create', compact('locations'));
    }

    public function store(ContainerDailyActivityCreateRequest $request, ContainerDailyActivityRepository $repository)
    {
        try {
            $containerDailyActivity = $repository->store($request->validated());

            return redirect()->route('console.container-daily-activity.detail', $containerDailyActivity)->with('success', 'Berhasil menginput laporan aktivitas harian');
        } catch (\Exception $e) {
            return redirect()->route('console.container-daily-activity.create')->with('error', 'Gagal menginput laporan aktivitas harian');
        }
    }

    public function detail(ContainerDailyActivity $containerDailyActivity)
    {
        return view('console.container-daily-activity.detail', compact('containerDailyActivity'));
    }

    public function edit(ContainerDailyActivity $containerDailyActivity)
    {
        $locations = Location::all();

        return view('console.container-daily-activity.edit', compact('containerDailyActivity', 'locations'));
    }

    public function update(ContainerDailyActivityUpdateRequest $request, ContainerDailyActivity $containerDailyActivity, ContainerDailyActivityRepository $repository)
    {
        try {
            $repository->update($containerDailyActivity, $request->validated());

            return redirect()->route('console.container-daily-activity.index')->with('success', 'Berhasil melakukan update Aktivitas Harian');
        } catch (\Exception $e) {
            return redirect()->route('console.container-daily-activity.index')->with('error', 'Gagal melakukan update Aktivitas Harian');
        }
    }

    public function posted(ContainerDailyActivity $containerDailyActivity, ContainerDailyActivityRepository $repository)
    {
        try {
            $repository->posted($containerDailyActivity);

            return redirect()->back()->with('success', 'Berhasil melakukan POSTED Aktivitas Harian');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(ContainerDailyActivity $containerDailyActivity, ContainerDailyActivityRepository $repository)
    {
        try {
            $repository->destroy($containerDailyActivity);

            return redirect()->back()->with('success', 'Berhasil menghapus Laporan Aktivitas Harian');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus Laporan Aktivitas Harian');
        }
    }
}