<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContainerScrapCreateRequest;
use App\Http\Requests\ContainerScrapUpdateRequest;
use App\Models\ContainerScrap;
use App\Models\ContainerScrapDetail;
use App\Models\Location;
use App\Models\Vendor;
use App\Repositories\Console\ContainerScrapRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\DataTables\Console\ContainerScrapDataTable;

class ContainerScrapController extends Controller
{
    public function index(ContainerScrapDataTable $dataTable)
    {
        return $dataTable->render('console.container-scrap.index');
    }

    public function create()
    {
        $locations = Location::all();
        $vendors = Vendor::all();

        return view('console.container-scrap.create', compact('locations', 'vendors'));
    }

    public function store(ContainerScrapCreateRequest $request, ContainerScrapRepository $repository)
    {
        try {
            $containerScrap = $repository->store($request->validated());

            return redirect()->route('console.container-scrap.detail', $containerScrap)->with('success', 'Berhasil membuat Proses Scrap CT');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat Proses Scrap CT');
        }
    }

    public function detail(ContainerScrap $containerScrap)
    {
        return view('console.container-scrap.detail', compact('containerScrap'));
    }

    public function detailDestroy(ContainerScrap $containerScrap, ContainerScrapDetail $containerScrapDetail, ContainerScrapRepository $repository)
    {
        try {
            $repository->detailDestroy($containerScrapDetail);
            return redirect()->back()->with('success', 'Berhasil menghapus detail Proses Scrap CT');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus detail Proses Scrap CT: ' . $e->getMessage());
        }
    }

    public function edit(ContainerScrap $containerScrap)
    {
        $ctScrap = $containerScrap;
        $locations = Location::all();
        $vendors = Vendor::all();

        return view('console.container-scrap.edit', compact('ctScrap', 'locations', 'vendors'));
    }

    public function update(ContainerScrapUpdateRequest $request, ContainerScrap $containerScrap, ContainerScrapRepository $repository)
    {
        try {
            $repository->update($containerScrap, $request->validated());
            return redirect()->route('console.container-scrap.index')->with('success', 'Berhasil mengupdate Proses Scrap CT');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.container-scrap.index')->with('error', 'Gagal mengupdate Proses Scrap CT, '. $e->getMessage());
        }
    }

    public function destroy(ContainerScrap $containerScrap, ContainerScrapRepository $repository)
    {
        try {
            $repository->destroy($containerScrap);
            return redirect()->back()->with('success', 'Berhasil menghapus Proses Scrap CT');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus Proses Scrap CT');
        }
    }

    public function posted(ContainerScrap $containerScrap, ContainerScrapRepository $repository)
    {
        try {
            $repository->posted($containerScrap);
            return redirect()->route('console.container-scrap.detail', $containerScrap)->with('success', 'Berhasil melakukan POST Proses Scrap CT');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.container-scrap.detail', $containerScrap)->with('error', $e->getMessage());
        }
    }

    public function approve(ContainerScrap $containerScrap, ContainerScrapRepository $repository)
    {
        try {
            $repository->approve($containerScrap);
            return redirect()->route('console.container-scrap.detail', $containerScrap)->with('success', 'Berhasil melakukan Approve Proses Scrap CT');
        } catch (\Exception $e) {
            throw $e;
            Log::error($e);
            return redirect()->route('console.container-scrap.detail', $containerScrap)->with('error', 'Gagal melakukan Approve Proses Scrap CT');
        }
    }

    public function reject(ContainerScrap $containerScrap, ContainerScrapRepository $repository)
    {
        try {
            $repository->reject($containerScrap);
            return redirect()->route('console.container-scrap.detail', $containerScrap)->with('success', 'Berhasil melakukan Reject Proses Scrap CT');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.container-scrap.detail', $containerScrap)->with('error', 'Gagal melakukan Reject Proses Scrap CT'. $e->getMessage());
        }
    }

}