<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHeader extends Model
{
    use HasFactory;

    protected $table = 'transaction_headers';

    protected $primaryKey = 'transaction_id';

    protected $guarded = ['transaction_id'];

    public function mscustomer(){
        return $this->belongsTo(MsCustomer::class, 'customer_id', 'customer_id');
    }

    public function msadmin(){
        return $this->belongsTo(MsAdmin::class, 'admin_id', 'admin_id');
    }

    public function mspaymentmethod(){
        return $this->belongsTo(MsPaymentMethod::class, 'payment_method_id', 'payment_method_id');
    }

    public function transactiondetail(){
        return $this->hasMany(TransactionDetail::class, 'transaction_id', 'transaction_id');
    }

    public function msshipment(){
        return $this->hasOne(MsShipment::class, 'transaction_id', 'transaction_id');
    }
}
