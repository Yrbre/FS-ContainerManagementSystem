<?php

namespace App\Http\Controllers\Console;

use App\Models\Vendor;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\DelegationFromVendorCreateRequest;
use App\DataTables\Console\DelegationFromVendorDataTable;
use App\Http\Requests\DelegationFromVendorUpdateRequest;
use App\Models\ContainerDelegationFromVendor;
use App\Models\ContainerDelegationFromVendorDetail;
use App\Repositories\Console\ContainerDelegationFromVendorRepository;

class DelegationFromVendorController extends Controller
{
    public function index(DelegationFromVendorDataTable $dataTable)
    {
        return $dataTable->render('console.container-delegation-from-vendor.index');
    }

    public function create()
    {
        $locations = Location::all();
        $vendors = Vendor::all();

        return view('console.container-delegation-from-vendor.create', compact('locations', 'vendors'));
    }

    public function store(DelegationFromVendorCreateRequest $request, ContainerDelegationFromVendorRepository $repository)
    {
        try {
            $delegationFromVendor = $repository->store($request->validated());

            return redirect()->route('console.delegation-from-vendor.detail', $delegationFromVendor)->with('success', 'Berhasil membuat BAST CT dari Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat BAST CT dari Vendor');
        }
    }

    public function detail(ContainerDelegationFromVendor $containerDelegationFromVendor)
    {
        return view('console.container-delegation-from-vendor.detail', compact('containerDelegationFromVendor'));
    }

    public function detailDestroy(ContainerDelegationFromVendor $containerDelegationFromVendor, ContainerDelegationFromVendorDetail $ctFromVendorDetail, ContainerDelegationFromVendorRepository $repository)
    {
        try {
            $repository->detailDestroy($ctFromVendorDetail);
            return redirect()->back()->with('success', 'Berhasil menghapus detail BAST dari Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus detail BAST dari Vendor: ' . $e->getMessage());
        }
    }

    public function edit(ContainerDelegationFromVendor $containerDelegationFromVendor)
    {
        $delegationFromVendor = $containerDelegationFromVendor;
        $locations = Location::all();
        $vendors = Vendor::all();

        return view('console.container-delegation-from-vendor.edit', compact('delegationFromVendor', 'locations', 'vendors'));
    }

    public function update(DelegationFromVendorUpdateRequest $request, ContainerDelegationFromVendor $containerDelegationFromVendor, ContainerDelegationFromVendorRepository $repository)
    {
        try {
            $repository->update($containerDelegationFromVendor, $request->validated());
            return redirect()->route('console.delegation-from-vendor.index')->with('success', 'Berhasil mengupdate BAST dari Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.delegation-from-vendor.index')->with('error', 'Gagal mengupdate BAST dari Vendor');
        }
    }

    public function destroy(ContainerDelegationFromVendor $containerDelegationFromVendor, ContainerDelegationFromVendorRepository $repository)
    {
        try {
            $repository->destroy($containerDelegationFromVendor);
            return redirect()->back()->with('success', 'Berhasil menghapus BAST dari Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus BAST dari Vendor');
        }
    }

    public function subDetail(ContainerDelegationFromVendor $containerDelegationFromVendor, ContainerDelegationFromVendorDetail $ctFromVendorDetail)
    {
        return view('console.container-delegation-from-vendor.sub-detail', compact('containerDelegationFromVendor', 'ctFromVendorDetail'));
    }

    public function posted(ContainerDelegationFromVendor $containerDelegationFromVendor, ContainerDelegationFromVendorRepository $repository)
    {
        try {
            $repository->posted($containerDelegationFromVendor);
            return redirect()->route('console.delegation-from-vendor.detail', $containerDelegationFromVendor)->with('success', 'Berhasil melakukan POST BAST dari Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.delegation-from-vendor.detail', $containerDelegationFromVendor)->with('error', $e->getMessage());
        }
    }

    public function updateProgress(ContainerDelegationFromVendor $containerDelegationFromVendor, ContainerDelegationFromVendorRepository $repository)
    {
        try {
            $repository->updateProgress($containerDelegationFromVendor);
            return redirect()->back()->with('success', 'Berhasil Mengupdate progress BAST dari Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal Mengupdate progress BAST dari Vendor');
        }
    }

    public function approve(ContainerDelegationFromVendor $containerDelegationFromVendor, ContainerDelegationFromVendorRepository $repository)
    {
        try {
            $repository->approve($containerDelegationFromVendor);
            return redirect()->route('console.delegation-from-vendor.detail', $containerDelegationFromVendor)->with('success', 'Berhasil melakukan Approve BAST dari Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.delegation-from-vendor.detail', $containerDelegationFromVendor)->with('error', $e->getMessage());
        }
    }

    public function reject(ContainerDelegationFromVendor $containerDelegationFromVendor, ContainerDelegationFromVendorRepository $repository)
    {
        try {
            $repository->reject($containerDelegationFromVendor);
            return redirect()->route('console.delegation-from-vendor.detail', $containerDelegationFromVendor)->with('success', 'Berhasil melakukan Reject BAST dari Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.delegation-from-vendor.detail', $containerDelegationFromVendor)->with('error', 'Gagal melakukan Reject BAST dari Vendor');
        }
    }

    public function duplicateSubDetail($delegationId, $delegationdetailId, $subDetailId, ContainerDelegationFromVendorRepository $repository)
    {
        try {
            $repository->duplicateSubDetail($subDetailId);
            return redirect()->back()->with('success', 'Berhasil men Duplicate Data Sub Detail BAST ke Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}