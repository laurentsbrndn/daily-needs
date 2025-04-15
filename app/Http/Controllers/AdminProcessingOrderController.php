<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\MsAdmin;
use Illuminate\Support\Facades\Auth;

class AdminProcessingOrderController extends Controller
{
    public function index()
    {
        $transactions = TransactionHeader::with(['mscustomer', 'mspaymentmethod', 'transactiondetail.msproduct', 'mscustomeraddress'])->where('transaction_status', 'Pending')->paginate(10);

        $transactions->each(function ($transaction) {
            $transaction->transactiondetail->each->append('subtotal');
        });

        return view('admin-processingorder.index', compact('transactions'));
    }

    public function store($transaction_id)
    {
        $transaction = TransactionHeader::findOrFail($transaction_id);
        $admin = Auth::guard('admin')->user();
    
        $transaction->transaction_status = 'Processing';
        $transaction->admin_id = $admin->admin_id;
        $transaction->save();

        return redirect()->back()->with('success', 'Order has been confirmed and is now processing.');

    }
}
