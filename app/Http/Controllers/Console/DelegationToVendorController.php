<?php

namespace App\Http\Controllers\Console;

use App\Models\Contract;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\DelegationToVendorCreateRequest;
use App\DataTables\Console\DelegationToVendorDataTable;
use App\Enums\StatusEnum;
use App\Http\Requests\DelegationToVendorUpadateRequest;
use App\Models\ContainerDelegation;
use App\Models\ContainerDelegationDetail;
use App\Models\Inspection;
use App\Models\InspectionDetail;
use App\Models\Vendor;
use App\Repositories\Console\ContainerDelegationToVendorRepository;
use App\Repositories\Console\RootCauseListRepository;

class DelegationToVendorController extends Controller
{
    public function index(DelegationToVendorDataTable $dataTable)
    {
        return $dataTable->render('console.container-delegation-to-vendor.index');
    }

    public function create()
    {
        $locations = Location::all();
        $vendors = Vendor::all();

        return view('console.container-delegation-to-vendor.create', compact('locations', 'vendors'));
    }

    public function store(DelegationToVendorCreateRequest $request, ContainerDelegationToVendorRepository $repository)
    {
        try {
            $delegationToVendor = $repository->store($request->validated());

            return redirect()->route('console.delegation-to-vendor.detail', $delegationToVendor)->with('success', 'Berhasil membuat BAST ke Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.delegation-to-vendor.detail', $delegationToVendor)->with('error', 'Gagal membuat BAST ke Vendor');
        }
    }

    public function detail(ContainerDelegation $containerDelegation)
    {
        return view('console.container-delegation-to-vendor.detail', compact('containerDelegation'));
    }

    public function detailDelete($delegationId, $delegationDetailId,ContainerDelegationToVendorRepository $repository)
    {
        try {
            $repository->detailDelete($delegationDetailId);

            return redirect()->back()->with('success', 'Berhasil Menghapus Detail BAST');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal Menghapus Detail BAST,' . ($e->getMessage()));
        }
    }

    public function edit(ContainerDelegation $containerDelegation)
    {
        return view('console.container-delegation-to-vendor.edit', compact('containerDelegation'));
    }

    public function update(DelegationToVendorUpadateRequest $request, ContainerDelegation $containerDelegation, ContainerDelegationToVendorRepository $repository)
    {
        try {
            $repository->update($containerDelegation, $request->validated());
            return redirect()->route('console.delegation-to-vendor.index')->with('success', 'Berhasil mengupate BAST ke Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.delegation-to-vendor.index')->with('error', 'Gagal mengupate BAST ke Vendor');
        }
    }

    public function destroy(ContainerDelegation $containerDelegation, ContainerDelegationToVendorRepository $repository)
    {
        try {
            $repository->destroy($containerDelegation);
            return redirect()->back()->with('success', 'Berhasil menghapus BAST ke Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus BAST ke Vendor '. ($e->getMessage()));
        }
    }

    public function subDetail(ContainerDelegation $containerDelegation, ContainerDelegationDetail $containerDelegationDetail)
    {
        return view('console.container-delegation-to-vendor.sub-detail', compact('containerDelegation', 'containerDelegationDetail'));
    }

    public function posted(ContainerDelegation $containerDelegation, ContainerDelegationToVendorRepository $repository)
    {
        try {
            $repository->posted($containerDelegation);
            return redirect()->route('console.delegation-to-vendor.detail', $containerDelegation)->with('success', 'Berhasil melakukan POST BAST ke Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.delegation-to-vendor.detail', $containerDelegation)->with('error', $e->getMessage());
        }
    }

    public function approve(ContainerDelegation $containerDelegation, ContainerDelegationToVendorRepository $repository)
    {
        try {
            $repository->approve($containerDelegation);
            return redirect()->route('console.delegation-to-vendor.detail', $containerDelegation)->with('success', 'Berhasil melakukan Approve BAST ke Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.delegation-to-vendor.detail', $containerDelegation)->with('error', $e->getMessage());
        }
    }

    public function reject(ContainerDelegation $containerDelegation, ContainerDelegationToVendorRepository $repository)
    {
        try {
            $repository->reject($containerDelegation);
            return redirect()->route('console.delegation-to-vendor.detail', $containerDelegation)->with('success', 'Berhasil melakukan Reject BAST ke Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.delegation-to-vendor.detail', $containerDelegation)->with('error', 'Gagal melakukan Reject BAST ke Vendor');
        }
    }

    public function unapprove(ContainerDelegation $containerDelegation, ContainerDelegationToVendorRepository $repository)
    {
        try {
            $repository->unapprove($containerDelegation);
            return redirect()->route('console.delegation-to-vendor.detail', $containerDelegation)->with('success', 'Berhasil melakukan Unapprove BAST ke Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.delegation-to-vendor.detail', $containerDelegation)->with('error', $e->getMessage());
        }
    }

    public function subDetailDestroy($delegationId, $delegationdetailId, $subDetailId, ContainerDelegationToVendorRepository $repository)
    {
        try {
            $repository->subDetailDestroy($subDetailId);
            return redirect()->back()->with('success', 'Berhasil Menghapus Data Sub Detail BAST ke Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal Menghapus Data Sub Detail BAST ke Vendor');
        }
    }

    public function duplicateSubDetail($delegationId, $delegationdetailId, $subDetailId, ContainerDelegationToVendorRepository $repository)
    {
        try {
            $repository->duplicateSubDetail($subDetailId);
            return redirect()->back()->with('success', 'Berhasil men Duplicate Data Sub Detail BAST ke Vendor');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal men Duplicate Data Sub Detail BAST ke Vendor');
        }
    }
}
