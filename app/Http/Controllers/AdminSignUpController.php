<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsAdmin;

class AdminSignUpController extends Controller
{
    public function index(){
        return view('admin-signup.index', [

        ]);
    }

    public function store(Request $request){
        
        $validatedData = $request->validate([
            'admin_first_name' => 'required|max:199',
            'admin_last_name' => 'required|max:199',
            'admin_email' => 'required|email:dns|unique:ms_admins',
            'admin_password' => 'required|min:8|max:20',
            'admin_phone_number' => 'required|max:199',
            'admin_address' => 'required|max:65000',
            'admin_photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'admin_gender' => 'required|in:Male,Female,Prefer not to say',
        ]);

        if ($request->hasFile('admin_photo')) {
            $file = $request->file('admin_photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/admin_photos', $fileName);
            $validatedData['admin_photo'] = $fileName;
        }

        $validatedData['admin_password'] = bcrypt($validatedData['admin_password']);

        MsAdmin::create($validatedData);

        $request->session()->flash('success', 'Sign Up Successful! Please Login');

        return redirect('/admin/login');
    }
}
