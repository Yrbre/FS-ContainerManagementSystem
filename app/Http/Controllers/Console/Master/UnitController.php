<?php

namespace App\Http\Controllers\Console\Master;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\UnitCreateRequest;
use App\DataTables\Console\UnitDataTable;
use App\Http\Requests\UnitUpdateRequest;
use App\Models\Unit;
use App\Repositories\Console\UnitRepository;

class UnitController extends Controller
{
    public function index(UnitDataTable $dataTable)
    {
        $content_title = 'Satuan';
        return $dataTable->render('console.master.unit.index');
    }        

    public function create() {
        $content_title = 'Satuan';
        return view('console.master.unit.create', compact('content_title'));
    }

    public function store(UnitCreateRequest $request, UnitRepository $repository) {
        
        try {
            
            $unit = $request->validated();
            return $repository->store($unit);
            
        } catch (\Exception $e) {
            return redirect()->route('console.unit.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }

    }

    public function show(Unit $unit)
    {
        return view('console.master.unit.show', compact('unit'));
    }

    public function edit(Unit $unit) {
        $content_title = 'Satuan';
        return view('console.master.unit.edit', compact('unit', 'content_title'));

    }

    public function update(UnitUpdateRequest $request, Unit $unit, UnitRepository $repository) {
        
        try {

            $data = $request->validated();
            return $repository->update($unit->id, $data);
            
        } catch (\Exception $e) {
            return redirect()->route('console.unit.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }

    }

    public function destroy(Unit $unit, UnitRepository $repository) {
        
        try {
            return $repository->destroy($unit->id);
        } catch (\Exception $e) {
            return redirect()->route('console.unit.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }

    }
    

            
}
