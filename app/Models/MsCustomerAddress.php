<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsCustomerAddress extends Model
{
    use HasFactory;

    protected $table = 'ms_customer_addresses';
    protected $primaryKey = 'address_id';

    protected $guarded = ['address_id'];

    public function mscustomer()
    {
        return $this->belongsTo(MsCustomer::class, 'customer_id', 'customer_id');
    }
}