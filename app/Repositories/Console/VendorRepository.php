<?php 
namespace App\Repositories\Console;

use App\Models\Vendor;


Class VendorRepository {

    public function store($data) {
        
        $vendor = Vendor::create(
            [
                'erp_code' => $data['erp_code'],
                'name' => $data['name'],
                'address_1' => $data['address_1'],
                'address_2' => $data['address_2'],
                'address_3' => $data['address_3'],
                'created_by' => auth()->user()->id
            ]
        );

        if ($vendor) {
            return redirect()->route('console.vendor.index')->with('success', 'Data vendor berhasil ditambahkan.');
        } else {
            return redirect()->route('console.vendor.index')->with('error', 'Data vendor gagal ditambahkan.');
        }

    }

    public function update(int $id, $data) {

        $vendor = Vendor::find($id)->update([
            'erp_code' => $data['erp_code'],
            'name' => $data['name'],
            'address_1' => $data['address_1'],
            'address_2' => $data['address_2'],
            'address_3' => $data['address_3'],
            'created_by' => auth()->user()->id
        ]);

        if ($vendor) {
            return redirect()->route('console.vendor.index')->with('success', 'Data vendor berhasil diubah.');
        } else {
            return redirect()->route('console.vendor.index')->with('error', 'Data vendor gagal diubah.');
        }
    }

    public function destroy(int $id) {

        $vendor = Vendor::find($id)->delete();

        if ($vendor) {
            return redirect()->route('console.vendor.index')->with('success', 'Data vendor berhasil dihapus.');
        } else {
            return redirect()->route('console.vendor.index')->with('error', 'Data vendor gagal dihapus.');
        }
    }

}


?>