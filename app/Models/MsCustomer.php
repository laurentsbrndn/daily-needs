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

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($customer) {
    //         if (!$customer->customer_id) {
    //             $customer->customer_id = self::generateCustomerId();
    //         }
    //     });
    // }

    // public static function generateCustomerId()
    // {
    //     \DB::beginTransaction();
    
    //     try {
    //         // Ambil angka terbesar dari customer_id dengan format CUx
    //         $lastCustomer = \DB::table('ms_customers')
    //             ->where('customer_id', 'LIKE', 'CU%')
    //             ->selectRaw("MAX(CAST(SUBSTRING(customer_id, 3) AS SIGNED)) as last_number")
    //             ->lockForUpdate()
    //             ->first();
    
    //         // Jika tidak ada data, mulai dari 1
    //         $newNumber = ($lastCustomer->last_number ?? 0) + 1;
    
    //         \DB::commit();
    
    //         return 'CU' . $newNumber;
    //     } catch (\Exception $e) {
    //         \DB::rollBack();
    //         throw $e;
    //     }
    // }
    



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

    public function mscustomeraddress()
    {
        return $this->hasMany(MsCustomer::class, 'customer_id', 'customer_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->customer_first_name} {$this->customer_last_name}";
    }

}
