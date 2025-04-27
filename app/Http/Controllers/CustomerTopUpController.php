<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MsCustomer;
use App\Models\MsPaymentMethod;
use App\Models\MsTopUp;

class CustomerTopUpController extends Controller
{
    public function show()
    {
        $customers = Auth::guard('customer')->user();
        $paymentMethods = MsPaymentMethod::all(); 
       // dd($paymentMethods); // tadinya commenting by jess for test
        return view('topup.index', compact('customers', 'paymentMethods'));
    }

    public function update(Request $request)
    {
        $customers = Auth::guard('customer')->user();

        $validateData = $request->validate([
            'customer_balance' => 'nullable|numeric|min:1',
            //tambahin validasi by jess buat handle null
            'payment_method' => 'required|exists:ms_payment_methods,payment_method_id', //add by jess
        ]);

        if (empty($request->customer_balance)) {
            //ubah B jadi b di customer_balance
            return back()->withErrors(['customer_balance' => 'Top up amount cannot be empty. Please enter the amount you wish to add.'])->withInput();
        }

        $customers->customer_balance += $validateData['customer_balance'];

        $customers->save();
       // dd($request->all());  //tadinya commenting by jess for test

        MsTopUp::create([
            'top_up_amount' => $validateData['customer_balance'],
            'top_up_date' => now(),
            'customer_id' => $customers->customer_id,
            'payment_method_id' => $request->payment_method,
        ]);

        $request->session()->flash('success', 'Your top up was successful! Your balance has been updated.');

        return redirect('/dashboard/topup');
    }
}
