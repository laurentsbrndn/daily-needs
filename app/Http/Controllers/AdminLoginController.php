<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MsAdmin;

class AdminLoginController extends Controller
{
    public function index(){
        return view('admin-login.index', [
            
        ]);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'admin_email' => 'required|email:dns',
            'admin_password' => 'required',
        ]);

        $credentials['password'] = $credentials['admin_password'];
        unset($credentials['admin_password']);

        if(Auth::guard('admin')->attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/admin/myprofile');
        }

        return back()->with('loginError', 'Login failed!');

    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
