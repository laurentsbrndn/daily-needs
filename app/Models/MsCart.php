<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsCart extends Model
{
    use HasFactory;

    protected $table = 'ms_carts';

    public function mscustomer(){
        return $this->belongsTo(MsCustomer::class, 'customer_id', 'customer_id');
    }

    public function msproduct(){
        return $this->belongsTo(MsProduct::class, 'product_id', 'product_id');
    }
}
