<?php
namespace App\Repositories\Console;

use Carbon\Carbon;
use App\Models\Contract;
use App\Models\ContractDetail;

class ContractRepository
{

    public function store(array $data)
    {

        $data['created_by'] = auth()->user()->id;

        $contract = Contract::create($data);

        $lastId = $contract->id;

        if ($contract) {
            return redirect()->route('console.contract.index')->with('success', 'Data Kontrak berhasil ditambahkan.');
        } else {
            return redirect()->route('console.contract.index')->with('error', 'Data Kontrak gagal ditambahkan.');
        }

    }

    public function update(Contract $contract, array $data)
    {


        if ($data['warranty_date_start'] != null && $data['warranty_date_end'] != null) {
            $data['warranty_in_days'] = ceil(Carbon::parse($data['warranty_date_start'])->floatDiffInDays(Carbon::parse($data['warranty_date_end'])));
        }



        $updated = $contract->update($data);

        // last id 
        $lastId = $contract->id;

        if ($updated) {
            return redirect()->route('console.contract.index')->with('success', 'Data Kontrak berhasil diubah.');
        } else {
            return redirect()->route('console.contract.index')->with('error', 'Data Kontrak gagal diubah.');
        }
    }

    public function destroy($contract)
    {

        $contract->delete();
        ContractDetail::where('contract_id', $contract->id)->delete();

        if ($contract) {
            return redirect()->route('console.contract.index')->with('success', 'Data Kontrak berhasil dihapus.');
        } else {
            return redirect()->route('console.contract.index')->with('error', 'Data Kontrak gagal dihapus.');
        }
    }

    /**
     * Menghitung masa garansi dari contract
     *
     * @param Contract $contract
     * @param Carbon $startDate
     * @return void
     */
    public function calculateWarrantyFromDate(Contract $contract, Carbon $startDate): array
    {
        // Check if warranty in days
        $dateStart = $startDate;
        $endDate = clone $startDate;
        if ($contract->warranty_in_days) {
            $endDate->addDays($contract->warranty_in_days);
        } else {
            $endDate->addMonth($contract->warranty_in_month);
        }

        return [$dateStart, $endDate];
    }
}
