<?php 
namespace App\Repositories\Console;

use App\Models\Location;

Class LocationRepository {

    public function store($data) {
        
        $location = Location::create(
            [
                'code' => $data['code'],
                'name' => $data['name'],
                'address' => $data['address'],
                'created_by' => auth()->user()->id
            ]
        );

        if ($location) {
            return redirect()->route('console.location.index')->with('success', 'Data lokasi berhasil ditambahkan.');
        } else {
            return redirect()->route('console.location.index')->with('error', 'Data lokasi gagal ditambahkan.');
        }

    }

    public function update(int $id, $data) {

        $location = Location::find($id)->update([
            'code' => $data['code'],
            'name' => $data['name'],
            'address' => $data['address'],
            'created_by' => auth()->user()->id
        ]);

        if ($location) {
            return redirect()->route('console.location.index')->with('success', 'Data lokasi berhasil diubah.');
        } else {
            return redirect()->route('console.location.index')->with('error', 'Data lokasi gagal diubah.');
        }
    }

    public function destroy(int $id) {

        $location = Location::find($id)->delete();

        if ($location) {
            return redirect()->route('console.location.index')->with('success', 'Data lokasi berhasil dihapus.');
        } else {
            return redirect()->route('console.location.index')->with('error', 'Data lokasi gagal dihapus.');
        }
    }

}


?>