<?php 
namespace App\Repositories\Console;

use App\Models\Config;

Class ConfigRepository {

    public function store($data) {

        
        $config = Config::create($data);

        if ($config) {
            return redirect()->route('console.config.index')->with('success', 'Data config berhasil ditambahkan.');
        } else {
            return redirect()->route('console.config.index')->with('error', 'Data config gagal ditambahkan.');
        }

    }

    public function update(int $id, $data) {

        $config = Config::find($id)->update($data);

        if ($config) {
            return redirect()->route('console.config.index')->with('success', 'Data config berhasil diubah.');
        } else {
            return redirect()->route('console.config.index')->with('error', 'Data config gagal diubah.');
        }
    }

    public function destroy(int $id) {

        $config = Config::find($id)->delete();

        if ($config) {
            return redirect()->route('console.config.index')->with('success', 'Data config berhasil dihapus.');
        } else {
            return redirect()->route('console.config.index')->with('error', 'Data config gagal dihapus.');
        }
    }

}


?>