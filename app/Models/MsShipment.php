<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsShipment extends Model
{
    use HasFactory;

    protected $table = 'ms_shipments';

    protected $primaryKey = 'shipment_id';

    protected $guarded = ['shipment_id'];

    public function transactionheader(){
        return $this->belongsTo(TransactionHeader::class, 'transaction_id', 'transaction_id');
    }

    public function mscourier(){
        return $this->belongsTo(MsCourier::class, 'courier_id', 'courier_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['shipment_status'] ?? false, function ($query, $status) {
            $query->where('shipment_status', $status);
        });

        // $query->when($filters['search'] ?? false, function ($query, $search) {
        //     $query->whereHas('transactionheader.mscustomer', function ($q) use ($search) {
        //         $q->where('full_name', 'like', '%' . $search . '%');
        //     });
        // });
    }

}
