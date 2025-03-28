<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsCart extends Model
{
    use HasFactory;

    protected $table = 'ms_carts';

    protected $primaryKey = 'cart_id';

    protected $guarded = ['cart_id'];

    public function mscustomer(){
        return $this->belongsTo(MsCustomer::class, 'customer_id', 'customer_id');
    }

    public function msproduct(){
        return $this->belongsTo(MsProduct::class, 'product_id', 'product_id');
    }

    public function scopeCartItem($query, $customerId, $productId)
    {
        return $query->where('customer_id', $customerId)
                     ->where('product_id', $productId);
    }

    public function scopeFilterSubtotal($query, $customerId, $selectedProducts)
    {
        return $query->where('customer_id', $customerId)
            ->whereIn('product_id', (array) $selectedProducts)
            ->with('msproduct');
    }
}
