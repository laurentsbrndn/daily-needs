<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsCustomer;

class CustomerSignUpController extends Controller
{
    public function index(){
        return view('signup.index', [

        ]);
    }

    public function store(Request $request){
        
        $validatedData = $request->validate([
            'customer_first_name' => 'required|max:199',
            'customer_last_name' => 'required|max:199',
            'customer_email' => 'required|email:dns|unique:ms_customers',
            'customer_password' => 'required|min:8|max:20',
            'customer_phone_number' => 'required|max:199',
            'customer_address' => 'required|max:255',
            'customer_photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'customer_gender' => 'required|in:Male,Female,Prefer not to say',
        ]);

        if ($request->hasFile('customer_photo')) {
            $file = $request->file('customer_photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/customer_photos', $fileName);
            $validatedData['customer_photo'] = $fileName;
        }

        $validatedData['customer_password'] = bcrypt($validatedData['customer_password']);

        MsCustomer::create($validatedData);

        $request->session()->flash('success', 'Sign Up Successful! Please Login');

        return redirect('/login');
    }
}
