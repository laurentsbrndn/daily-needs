<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsCourier;


class CourierSignUpController extends Controller
{
    public function index()
    {
        return view('courier-signup.index', [

        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'courier_first_name' => 'required|max:199',
            'courier_last_name' => 'required|max:199',
            'courier_email' => 'required|email:dns|unique:ms_couriers',
            'courier_password' => 'required|min:8|max:20',
            'courier_phone_number' => 'required|max:199',
            'courier_address' => 'required|max:255',
            'courier_photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'courier_gender' => 'required|in:Male,Female,Prefer not to say',
        ]);

        if ($request->hasFile('courier_photo')) {
            $file = $request->file('courier_photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/courier_photos', $fileName);
            $validatedData['courier_photo'] = $fileName;
        }

        $validatedData['courier_password'] = bcrypt($validatedData['courier_password']);

        MsCourier::create($validatedData);

        $request->session()->flash('success', 'Sign Up Successful! Please Login');

        return redirect('/courier/login');
    }
}
