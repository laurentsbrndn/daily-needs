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

    public function mscustomeraddress(){
        return $this->belongsTo(MsCustomerAddress::class, 'customer_address_id', 'customer_address_id');
    }

    public function getTotalPriceAttribute()
    {
        return $this->transactiondetail->sum(function ($detail) {
            return $detail->unit_price_at_buy * $detail->quantity;
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('transaction_status', $status);
        });

        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->whereHas('transactiondetail.msproduct', function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%');
            });
        });
    }

}



