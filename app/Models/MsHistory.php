<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsHistory extends Model
{
    use HasFactory;

    protected $table = 'ms_histories';

    public function mscustomer(){
        return $this->belongsTo(MsCustomer::class, 'customer_id', 'customer_id');
    }

    public function mspaymentmethod(){
        return $this->belongsTo(MsPaymentMethod::class, 'payment_method_id', 'payment_method_id');
    }

    public function transactionheader(){
        return $this->belongsTo(TransactionHeader::class, 'transaction_id', 'transaction_id');
    }

    public function msshipment(){
        return $this->belongsTo(MsShipment::class, 'transaction_id', 'transaction_id');
    }
}
