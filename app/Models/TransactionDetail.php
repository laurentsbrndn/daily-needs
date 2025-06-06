<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'transaction_details';

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'unit_price_at_buy'
    ];

    public function transactionheader(){
        return $this->belongsTo(TransactionHeader::class, 'transaction_id', 'transaction_id');
    }

    public function msproduct(){
        return $this->belongsTo(MsProduct::class, 'product_id', 'product_id');
    }

    public function getSubtotalAttribute()
    {
        return $this->unit_price_at_buy * $this->quantity;
    }

}
