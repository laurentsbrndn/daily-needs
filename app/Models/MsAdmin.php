<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MsAdmin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'ms_admins';

    protected $primaryKey = 'admin_id';
    
    protected $guarded = ['admin_id'];

    public function getAuthPassword()
    {
        return $this->admin_password;
    }

    public function transactionheader(){
        return $this->hasMany(TransactionHeader::class, 'admin_id', 'admin_id');
    }
}
