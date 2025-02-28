<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MsCourier;

class CourierLoginController extends Controller
{
    public function index()
    {
        return view('courier-login.index', [

        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'courier_email' => 'required|email:dns',
            'courier_password' => 'required',
        ]);

        $credentials['password'] = $credentials['courier_password'];
        unset($credentials['courier_password']);

        if(Auth::guard('courier')->attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/courier/myprofile');
        }

        return back()->with('loginError', 'Login failed!');
    }

    public function logout(Request $request)
    {
        Auth::guard('courier')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/courier/login');
    }
}
