<?php

namespace App\Http\Controllers\Console;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Console\AdminRepository;
use App\Http\Requests\Console\UpdatePasswordRequest;

class AccessController extends Controller
{
    public function profilePassword(Admin $admin)
    {
        return view('console.admin.profile.change-password', compact('admin'));
    }

    public function changePassword(UpdatePasswordRequest $request, Admin $admin, AdminRepository $repository)
    {
        try {
            $data = $request->validated();
            
            if (!(Hash::check($data['old_password'], auth()->user()->password))) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai.');
            }

            return $repository->changePassword($admin->id, $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Server error: Terjadi kesalahan pada server.');
        }
    }
}
