<?php 
namespace App\Repositories\Console;

use App\Models\Unit;

Class UnitRepository {

    public function store($data) {

        
        $unit = Unit::create($data);

        if ($unit) {
            return redirect()->route('console.unit.index')->with('success', 'Data satuan berhasil ditambahkan.');
        } else {
            return redirect()->route('console.unit.index')->with('error', 'Data satuan gagal ditambahkan.');
        }

    }

    public function update(int $id, $data) {

        $unit = Unit::find($id)->update($data);

        if ($unit) {
            return redirect()->route('console.unit.index')->with('success', 'Data satuan berhasil diubah.');
        } else {
            return redirect()->route('console.unit.index')->with('error', 'Data satuan gagal diubah.');
        }
    }

    public function destroy(int $id) {

        $unit = Unit::find($id)->delete();

        if ($unit) {
            return redirect()->route('console.unit.index')->with('success', 'Data satuan berhasil dihapus.');
        } else {
            return redirect()->route('console.unit.index')->with('error', 'Data satuan gagal dihapus.');
        }
    }

}


?>