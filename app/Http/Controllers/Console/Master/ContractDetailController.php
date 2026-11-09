<?php

namespace App\Http\Controllers\Console\Master;

use App\Models\Unit;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\ContractDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContractDetailCreateRequest;
use App\DataTables\Console\ContractDetailDataTable;
use App\Http\Requests\ContractDetailUpdateRequest;
use App\Repositories\Console\ContractDetailRepository;

class ContractDetailController extends Controller
{
    public function index(Contract $contract,ContractDetailDataTable $dataTable) {
        $content_title = 'Detail Kontrak';
        return $dataTable->with('contractId', $contract->id)->render('console.master.contract_detail.index', compact('content_title', 'contract'));
    }

    public function create(Contract $contract) {

        $content_title = 'Detail Kontrak';
        $units = Unit::all(); 
        return view('console.master.contract_detail.create', compact('contract', 'content_title', 'units'));
        
    }

    public function store(ContractDetailCreateRequest $request, Contract $contract, ContractDetailRepository $repository) {
        try {
            $data = $request->validated();
            return $repository->store($data, $contract);
        } catch (\Exception $e) {
            return redirect()->route('console.contract.detail.index', $contract->id)->with('error', 'Server Error: Terjadi kesalahan pada server: ' .  $e->getMessage());
        }

    }

    public function edit(ContractDetail $contractDetail) {
        $content_title = 'Detail Kontrak';
        $contract = Contract::find($contractDetail->contract_id);
        $units = Unit::all(); 
        return view('console.master.contract_detail.edit', compact('contract', 'contractDetail', 'content_title', 'units'));
    }

    public function update(ContractDetailUpdateRequest $request, ContractDetail $contractDetail, ContractDetailRepository $repository) {
        try {
            $data = $request->validated();
            return $repository->update($contractDetail->id, $data, $contractDetail->contract_id);
        } catch (\Exception $e) {
            return redirect()->route('console.contract.detail.index')->with('error', 'Server Error: Terjadi kesalahan pada server: '  . $e->getMessage());
        }
    }

    public function destroy(ContractDetail $contractDetail, ContractDetailRepository $repository) {
        try {
            return $repository->destroy($contractDetail->id, $contractDetail->contract_id);
        } catch (\Exception $e) {
            return redirect()->route('console.contract.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }
    }

}
