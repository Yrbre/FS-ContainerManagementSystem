<?php

namespace App\Http\Controllers\Console\Master;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Console\VendorDataTable;
use App\Repositories\Console\VendorRepository;
use App\Http\Requests\Console\VendorCreateRequest;
use App\Http\Requests\Console\VendorUpdateRequest;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VendorDataTable $datatable)
    {
        $content_title = 'Vendor';
        return $datatable->render('console.master.vendor.index', compact('content_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $content_title = 'Vendor';
        return view('console.master.vendor.create', compact('content_title'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorCreateRequest $request, VendorRepository $repository)
    {
        try {
            $data = $request->validated();
            return $repository->store($data);
        } catch (\Exception $e) {
            return redirect()->route('console.vendor.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        return view('console.master.vendor.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        $content_title = 'Vendor';
        return view('console.master.vendor.edit', compact('content_title', 'vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorUpdateRequest $request, Vendor $vendor, VendorRepository $repository)
    {
        try {
            $data = $request->validated();
            return $repository->update($vendor->id, $data);
        } catch (\Exception $e) {
            return redirect()->route('console.vendor.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor, VendorRepository $repository)
    {

        try {
            return $repository->destroy($vendor->id);
        } catch (\Exception $e) {
            return redirect()->route('console.unit.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }

    }
}
