<?php

namespace App\Http\Controllers\Console\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers {
        logout as performLogout;
    }
    
    protected $redirectTo = '/console/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('console.auth.login');
    }

    public function authenticated(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('username', 'password');
        
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }
        return back()->with(['error' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('console.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
