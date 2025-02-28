<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MsCustomer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'ms_customers';
    protected $primaryKey = 'customer_id';

    protected $guarded = ['customer_id', 'customer_balance'];

    protected $attributes = [
        'customer_balance' => 0,
    ];

    protected $hidden = [
        'customer_password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->customer_password;
    }

    public function mstopup()
    {
        return $this->hasMany(MsTopUp::class, 'customer_id', 'customer_id');
    }

    public function transactionheader()
    {
        return $this->hasMany(TransactionHeader::class, 'customer_id', 'customer_id');
    }

    public function mscart()
    {
        return $this->hasMany(MsCart::class, 'customer_id', 'customer_id');
    }

    public function mshistory()
    {
        return $this->hasMany(MsHistory::class, 'customer_id', 'customer_id');
    }
}
