<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\MsAdmin;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminTransactionHistoryController extends Controller
{
    public function index(Request $request)
    {
        $admins = Auth::guard('admin')->user();

        $statusLink = [
            'processing' => 'Processing',
            'out-for-delivery' => 'Out for Delivery',
            'shipped' => 'Shipped',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        $status = $request->query('status', 'completed');

        if ($status === 'processing')
        {
            $data = TransactionHeader::with(['mscustomer', 'msshipment', 'transactiondetail.msproduct'])
                                    ->where('admin_id', $admins->admin_id)
                                    ->where('transaction_status', 'Processing')
                                    ->whereDoesntHave('msshipment')
                                    ->orderBy('transaction_date', 'desc')
                                    ->paginate(10);
        }

        else if ($status === 'out-for-delivery')
        {
            $data = TransactionHeader::with(['mscustomer', 'msshipment','transactiondetail.msproduct'])
                                    ->where('admin_id', $admins->admin_id)
                                    ->where('transaction_status', 'Out for Delivery')
                                    ->whereHas('msshipment', function ($query) use ($status) {
                                        $query->filter(['shipment_status' => 'In Progress']);
                                    })
                                    ->orderBy('transaction_date', 'desc')
                                    ->paginate(10);
        }

        else if ($status === 'shipped')
        {
            $data = TransactionHeader::with(['mscustomer', 'msshipment', 'transactiondetail.msproduct'])
                                    ->where('admin_id', $admins->admin_id)
                                    ->where('transaction_status', 'Shipped')
                                    ->whereHas('msshipment', function ($query) use ($status) {
                                        $query->filter(['shipment_status' => 'Delivered']);
                                    })
                                    ->orderBy('transaction_date', 'desc')
                                    ->paginate(10);
        }

        else if ($status === 'completed')
        {
            $data = TransactionHeader::with(['mscustomer', 'msshipment', 'transactiondetail.msproduct'])
                                    ->where('admin_id', $admins->admin_id)
                                    ->where('transaction_status', 'Completed')
                                    ->whereHas('msshipment', function ($query) use ($status) {
                                        $query->filter(['shipment_status' => 'Delivered']);
                                    })
                                    ->orderBy('transaction_date', 'desc')
                                    ->paginate(10);
        }

        else if ($status === 'cancelled')
        {
            $data = TransactionHeader::with(['mscustomer', 'msshipment', 'transactiondetail.msproduct'])
                                    ->where('admin_id', $admins->admin_id)
                                    ->where('transaction_status', 'Cancelled')
                                    ->whereHas('msshipment', function ($query) use ($status) {
                                        $query->filter(['shipment_status' => 'Cancelled']);
                                    })
                                    ->orderBy('transaction_date', 'desc')
                                    ->paginate(10); 
        }

        $data->each(function ($data) {
            $data->transactiondetail->each->append('subtotal');
        });

        return view('admin-transactionhistory.index', compact('data', 'statusLink', 'status'));
    }
}
