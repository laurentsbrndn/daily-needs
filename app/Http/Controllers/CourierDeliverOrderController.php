<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsShipment;
use App\Models\MsCourier;
use App\Models\TransactionHeader;
use Illuminate\Support\Facades\Auth;

class CourierDeliverOrderController extends Controller
{
    public function show(){
        $courier = Auth::guard('courier')->user();

        $toShip = TransactionHeader::where('transaction_status', 'Processing')->get();
        $inProgress = MsShipment::whereNotNull('shipment_date_start')
                                ->whereNull('shipment_date_end')
                                ->where('courier_id', $courier->courier_id)
                                ->get();
        $delivered = MsShipment::whereNotNull('shipment_date_end')
                                ->where('courier_id', $courier->courier_id)
                                ->get();   
        
        return view('courier-deliverorder.index', compact('toShip', 'inProgress', 'delivered'));
    }

    public function store(Request $request,$transaction_id)
    {
        $courier = Auth::guard('courier')->user();
        $transaction = TransactionHeader::findOrFail($transaction_id);

        if (!$transaction || $transaction->transaction_status !== 'Processing') {
            return redirect()->back()->with('error', 'Invalid transaction or already processed.');
        }

        MsShipment::create([
            'shipment_date_start' => now(),
            'shipment_status' => 'In Progress',
            'transaction_id' => $transaction->transaction_id,
            'courier_id' => $courier->courier_id,
        ]);

        return redirect()->back()->with('success', 'Shipment started successfully.');
    }

    public function update(Request $request, $shipment_id)
    {
        $courier = Auth::guard('courier')->user();
        $shipment = MsShipment::findOrFail($shipment_id);

        if ($shipment->courier_id !== $courier->courier_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $validateData = $request->validate([
            'shipment_recipient_name' => 'required|max:199',
        ]);

        $shipment->shipment_recipient_name = $validateData['shipment_recipient_name'];
        $shipment->shipment_date_end = now();
        $shipment->shipment_status = 'Delivered';
        $shipment->save();

        return redirect()->back()->with('success', 'Shipment marked as delivered.');
    }
}
