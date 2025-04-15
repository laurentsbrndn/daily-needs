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
        return view('topup.index', compact('customers'));
    }

    public function update(Request $request)
    {
        $customers = Auth::guard('customer')->user();

        $paymentMethod = MsPaymentMethod::where('payment_method_name', 'Bank Transfer')->first();

        if (!$paymentMethod) {
            return back()->with('error', 'Payment method not found.');
        }

        $validateData = $request->validate([
            'customer_balance' => 'nullable|numeric|min:1',
        ]);

        if (empty($request->customer_balance)) {
            return back()->withErrors(['customer_Balance' => 'Top up amount cannot be empty. Please enter the amount you wish to add.'])->withInput();
        }

        $customers->customer_balance += $validateData['customer_balance'];

        $customers->save();

        MsTopUp::create([
            'top_up_amount' => $validateData['customer_balance'],
            'top_up_date' => now(),
            'customer_id' => $customers->customer_id,
            'payment_method_id' => $paymentMethod->payment_method_id,
        ]);

        $request->session()->flash('success', 'Your top up was successful! Your balance has been updated.');

        return redirect('/dashboard/topup');
    }
}
