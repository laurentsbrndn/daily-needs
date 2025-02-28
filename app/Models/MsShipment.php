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
        return $this->belongsTo(MsShipment::class, 'transaction_id', 'transaction_id');
    }

    public function mscourier(){
        return $this->belongsTo(MsCourier::class, 'courier_id', 'courier_id');
    }

    public function mshistory()
    {
        return $this->hasMany(MsShipment::class, 'shipment_id', 'shipment_id');
    }
}
