<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MsCourier extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'ms_couriers';

    protected $primaryKey = 'courier_id';

    protected $guarded = ['courier_id'];

    public function getAuthPassword()
    {
        return $this->courier_password;
    }

    public function msshipment(){
        return $this->hasMany(MsShipment::class, 'courier_id', 'courier_id');
    }
}
