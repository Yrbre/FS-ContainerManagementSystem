<?php 
namespace App\Repositories\Console;

use App\Models\Contract;
use App\Models\ContractDetail;

Class ContractDetailRepository {

    public function store($data, $contract) {
        
        $contractDetail = ContractDetail::create(
            [
                'job_type' => $data['job_type'],
                'contract_id' => $contract->id,
                'unit_id' => $data['unit'],
                'price' => $data['price'],
                'qty' => $data['qty'],    
                'working_duration' => $data['working_duration'],
            ]
        );

        if ($contractDetail) {
            return redirect()->route('console.contract.detail.index', $contract->id)->with('success', 'Detail Kontrak berhasil ditambahkan.');
        } else {
            return redirect()->route('console.contract.detail.index', $contract->id)->with('error', 'Detail Kontrak gagal ditambahkan.');
        }

    }

    public function update(int $id, $data, $contract_id) {

        $contractDetail = ContractDetail::find($id)->update([
            'job_type' => $data['job_type'],
            'unit_id' => $data['unit'],
            'price' => $data['price'],
            'qty' => $data['qty'],    
            'working_duration' => $data['working_duration'],
        ]);


        if ($contractDetail) {
            return redirect()->route('console.contract.detail.index', $contract_id)->with('success', 'Detail Kontrak berhasil diubah.');
        } else {
            return redirect()->route('console.contract.detail.index', $contract_id)->with('error', 'Detail Kontrak gagal diubah.');
        }
    }

    public function destroy(int $id, $contract_id) {

        $contractDetail = ContractDetail::find($id)->delete();

        if ($contractDetail) {
            return redirect()->route('console.contract.detail.index', $contract_id)->with('success', 'Detail Kontrak berhasil dihapus.');
        } else {
            return redirect()->route('console.contract.detail.index', $contract_id)->with('error', 'Detail Kontrak gagal dihapus.');
        }
    }

}


?>