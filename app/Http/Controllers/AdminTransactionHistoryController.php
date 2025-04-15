<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\MsAdmin;
use Illuminate\Support\Facades\Auth;

class AdminTransactionHistoryController extends Controller
{
    public function index()
    {
        $admins = Auth::guard('admin')->user();

        $transactions = TransactionHeader::with('mscustomer')
            ->where('admin_id', $admins->admin_id)
            ->whereIn('transaction_status', ['Processing', 'Shipped', 'Completed', 'Cancelled'])
            ->get();

        return view('admin-transactionhistory.index', compact('transactions'));
    }
}
