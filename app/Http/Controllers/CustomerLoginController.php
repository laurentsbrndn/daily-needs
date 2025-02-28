<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MsCustomer;


class CustomerLoginController extends Controller
{
    public function index(){
        return view('login.index', [
            
        ]);
    }
    

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'customer_email' => 'required|email:dns',
            'customer_password' => 'required',
        ]);

        $credentials['password'] = $credentials['customer_password'];
        unset($credentials['customer_password']);

        if(Auth::guard('customer')->attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Login failed!');

    }

    public function logout(Request $request){
        Auth::guard('customer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
