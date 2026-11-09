<?php

namespace App\Http\Controllers\Console;

use App\Models\Vendor;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\ContainerRepair;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\DataTables\ContainerRepairDataTable;
use App\Repositories\Console\ContainerRepository;
use App\Http\Requests\ContainerRepairCreatedRequest;
use App\Http\Requests\ContainerRepairUpdatedRequest;
use App\Repositories\Console\ContainerRepairRepository;

class ContainerRepairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContainerRepairDataTable $dataTable)
    {
        return $dataTable->render('console.container-repair.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = Vendor::all();
        $locations = Location::all();
        return view('console.container-repair.create', compact('vendors', 'locations'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContainerRepairCreatedRequest $request, ContainerRepairRepository $repository)
    {

        try {

            $containerRepair = $repository->store($request->validated());

            return redirect()->route('console.container-repair.detail', $containerRepair)->with('success', 'Berhasil melakukan input data');
            
        } catch (\Exception $e) {
            return redirect()->route('console.container-repair.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ContainerRepair $containerRepair)
    {
        return view('console.container-repair.show', compact('containerRepair'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ContainerRepair $containerRepair)
    {
        $vendors = Vendor::all();
        $locations = Location::all();

        return view('console.container-repair.edit', compact('containerRepair', 'vendors', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContainerRepairUpdatedRequest $request, ContainerRepair $containerRepair, ContainerRepairRepository $repository)
    {
        $repository->update($containerRepair, $request->validated());
        return redirect()->route('console.container-repair.index')->with('success', 'Berhasil melakukan update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContainerRepair $containerRepair, ContainerRepairRepository $repository)
    {
        $repository->destroy($containerRepair);
        return redirect()->route('console.container-repair.index')->with('success', 'Berhasil melakukan hapus data');
    }

    public function posted(ContainerRepair $containerRepair, ContainerRepairRepository $repository)
    {
        try {
            $repository->posted($containerRepair);
            return redirect()->back()->with('success', 'Berhasil melakukan POSTED Laporan Progress');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    
    public function approve(ContainerRepair $containerRepair, ContainerRepairRepository $repository) {
        try {
            $repository->approve($containerRepair);
            return redirect()->back()->with('success', 'Berhasil melakukan APPROVE Laporan Progress');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function reject(ContainerRepair $containerRepair, ContainerRepairRepository $repository) {
        try {
            $repository->reject($containerRepair);
            return redirect()->back()->with('success', 'Berhasil melakukan REJECT Laporan Progress');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
