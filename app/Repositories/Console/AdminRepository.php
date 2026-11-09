<?php 
namespace App\Repositories\Console;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;



Class AdminRepository {

    public function store($data) {

        // if exist upload image signature
        if (!empty($data['signature'])) {
            $signature = $data['signature'];
            $signaturePath = $signature->storePublicly('signature');
            $data['signature'] = $signaturePath;
        } else {
            $data['signature'] = null;
        } 

        $data['password'] = Hash::make($data['password']);
        
        $admin = Admin::create(
           $data
        );

        if ($admin) {
            return redirect()->route('console.admin.index')->with('success', 'User berhasil ditambahkan.');
        } else {
            return redirect()->route('console.admin.index')->with('error', 'User gagal ditambahkan.');
        }


    }


    public function update($admin, $data) 
    {
        // if exist upload image signature
        if (!empty($data['signature'])) {
            $signature = $data['signature'];
            $signatureName = time() . '.' . $signature->getClientOriginalExtension();
            
            $signature->move(storage_path('/app/public/signature'), $signatureName);

            $signaturePath = '/storage/signature/' . $signatureName;

            // remove old signature 
            $oldSignature = $admin->signature;
            if ($oldSignature != null) {
                unlink(storage_path('app/public/signature/' . basename($oldSignature)));
            }

            $admin->signature = $signaturePath;

        }

        if ($data['password']) {
            $admin->password = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $admin->username = $data['username'];
        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->role = $data['role'];
        $inserted = $admin->save();

        if ($inserted) {
            return redirect()->route('console.admin.edit', $admin->id)->with('success', 'User berhasil di perbaharui.');
        } else {
            return redirect()->route('console.admin.index')->with('error', 'User gagal di perbaharui.');
        }
    }

    public function destroy($admin) {

        // delete admin
        $deleted = $admin->delete();

        if ($deleted) {
            return redirect()->route('console.admin.index')->with('success', 'User berhasil di hapus.');
        } else {
            return redirect()->route('console.admin.index')->with('error', 'User gagal di hapus.');
        }

    }

    public function changePassword(int $id, $data)
    {
        $admin = Admin::find($id)->update([
            'password' => Hash::make($data['password']),
        ]);

        if ($admin) {
            return redirect()->back()->with('success', 'Kata sandi berhasil di perbaharui');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan, kata sandi gagal di perbaharui');
        }
    }
}


?>