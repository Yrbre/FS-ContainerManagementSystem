<?php

namespace App\Http\Controllers\Console\Master;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LocationCreateRequest;
use App\DataTables\Console\LocationDataTable;
use App\Http\Requests\LocationEditRequest;
use App\Repositories\Console\LocationRepository;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LocationDataTable $dataTable)
    {
        $content_title = 'Lokasi';
        return $dataTable->render('console.master.location.index', compact('content_title'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $content_title = 'Lokasi';
        return view('console.master.location.create', compact('content_title'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationCreateRequest $request, LocationRepository $repository)
    {

        try {
            
            $location = $request->validated();
            return $repository->store($location);
            
        } catch (\Exception $e) {
            return redirect()->route('console.location.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return view('console.master.location.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $content_title = 'Lokasi';
        return view('console.master.location.edit', compact('location', 'content_title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LocationEditRequest $request, Location $location, LocationRepository $repository)
    {
        try {
            
            $data = $request->validated();
            return $repository->update($location->id, $data);
            
        } catch (\Exception $e) {
            return redirect()->route('console.location.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location, LocationRepository $repository)
    {

        try {
            return $repository->destroy($location->id);
        } catch (\Exception $e) {
            return redirect()->route('console.location.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }
        
    }
}
