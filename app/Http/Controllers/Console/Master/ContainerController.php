<?php

namespace App\Http\Controllers\Console\Master;

use App\Models\Unit;
use App\Models\Vendor;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Location;
use App\Models\Container;
use Illuminate\Http\Request;
use App\Enums\ContractTypeEnum;
use App\Models\ContainerStatus;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\UnitCreateRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\DataTables\Console\UnitDataTable;
use App\Http\Requests\ContainerUpdateRequest;
use App\Http\Requests\CreateContainerRequest;
use App\DataTables\Console\ContainerDataTable;
use App\Repositories\Console\ContainerRepository;

class ContainerController extends Controller
{
    public function index(ContainerDataTable $dataTable)
    {
        return $dataTable->render('console.master.container.index');
    }

    public function create()
    {
        $vendors = Vendor::all();
        $statuses = ContainerStatus::all();
        $contracts = Contract::where('type', ContractTypeEnum::PENGADAAN)->get();
        $companies = Company::all();
        $location = Location::all();

        return view('console.master.container.create', compact('vendors', 'statuses', 'contracts', 'companies', 'location'));
    }

    public function store(CreateContainerRequest $request, ContainerRepository $repository)
    {
        try {
            $data = $request->validated();
            $repository->store($data);
            return redirect()->route('console.container.index')->with('success', 'Berhasil menginput kontainer');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.container.index')->with('error', 'Gagal menginput kontainer');
        }
    }

    public function show(Container $container)
    {
        $documents = $container->documents()->where('container_code', $container->code)->get();

        return view('console.master.container.show', compact('container', 'documents'));
    }

    public function edit(Container $container)
    {
        $container = $container->where('code', $container->code)->first();
        $vendors = Vendor::all();
        $statuses = ContainerStatus::all();
        $contracts = Contract::where('type', 'Pengadaan')->get();
        $companies = Company::all();
        $location = Location::all();

        return view('console.master.container.edit', compact('container', 'vendors', 'statuses', 'contracts', 'companies', 'location'));
    }

    public function update(ContainerUpdateRequest $request, $code, ContainerRepository $repository)
    {
        try {
            $data = $request->validated();
            $repository->update($code, $data);

            return redirect()->route('console.container.index')->with('success', 'Berhasil mengupdate kontainer');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.container.index')->with('error', 'Gagal mengupdate kontainer');
        }
    }

    public function destroy(Container $container, ContainerRepository $repository)
    {
        try {
            $repository->destroy($container->code);
            return redirect()->route('console.container.index')->with('success', 'Berhasil menghapus kontainer');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.container.index')->with('error', 'Gagal menghapus kontainer');
        }
    }
}
