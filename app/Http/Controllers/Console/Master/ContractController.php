<?php

namespace App\Http\Controllers\Console\Master;

use Carbon\Carbon;
use App\Models\Vendor;
use App\Models\Contract;
use App\Models\ContractType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Console\ContractDataTable;
use App\Repositories\Console\ContractRepository;
use App\Http\Requests\Console\ContractCreateRequest;
use App\Http\Requests\Console\ContractUpdateRequest;

class ContractController extends Controller
{

    protected $contractTypes = [
        'Pengadaan',
        'Maintenance',
        'Upgrade & Repair'
    ];

    protected $contractStatus = [
        'ACTIVE',
        'NON ACTIVE'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContractDataTable $dataTable)
    {
        $content_title = 'Kontrak';
        return $dataTable->render('console.master.contract.index', compact('content_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $content_title = 'Kontrak';
        $contractTypes = $this->contractTypes;
        $contractStatus = $this->contractStatus;
        $vendors = Vendor::all();
        return view('console.master.contract.create', compact('content_title', 'contractTypes', 'vendors', 'contractStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractCreateRequest $request, ContractRepository $repository)
    {
        try {
            $data = $request->validated();
            return $repository->store($data);
        } catch (\Exception $e) {
            return redirect()->route('console.contract.index')->with('error', $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {

        $content_title = 'Kontrak';
        $contract = Contract::with(['vendor'])->find($contract->id);
        $contract->active_date_start = Carbon::parse($contract->active_date_start)->format('Y-m-d');
        $contract->active_date_end = Carbon::parse($contract->active_date_end)->format('Y-m-d');
        $contract->warranty_date_start = $contract->warranty_date_start ? Carbon::parse($contract->warranty_date_start)->format('Y-m-d') : null; 
        Carbon::parse($contract->warranty_date_start)->format('Y-m-d');
        
        $contract->warranty_date_end = $contract->warranty_date_end ? Carbon::parse($contract->warranty_date_end)->format('Y-m-d') : null;
        
        $contractTypes = $this->contractTypes;
        $contractStatus = $this->contractStatus;
        $vendors = Vendor::all();
        return view('console.master.contract.edit', compact('content_title', 'contractTypes', 'contractStatus', 'vendors', 'contract'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContractUpdateRequest $request, Contract $contract, ContractRepository $repository)
    {

        try {
            $data = $request->validated();
            return $repository->update($contract, $data);
        } catch (\Exception $e) {
            return redirect()->route('console.contract.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract, ContractRepository $repository)
    {

        try {
            return $repository->destroy($contract);
        } catch (\Exception $e) {
            return redirect()->route('console.contract.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }
      
        
    }
}
