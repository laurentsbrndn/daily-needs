<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsTopUp extends Model
{
    use HasFactory;

    protected $table = 'ms_top_ups';

    protected $primaryKey = 'top_up_id';

    protected $guarded = ['top_up_id'];

    public function mscustomer(){
        return $this->belongsTo(MsCustomer::class, 'customer_id', 'customer_id');
    }

    public function mspaymentmethod(){
        return $this->hasOne(MsPaymentMethod::class, 'payment_method_id', 'payment_method_id');
    }
}
