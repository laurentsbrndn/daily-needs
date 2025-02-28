<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsCompany extends Model
{
    use HasFactory;

    protected $table = 'ms_companies';

    protected $primaryKey = 'company_id';

    protected $guarded = ['company_id'];

    public function msbrand(){
        return $this->hasMany(MsBrand::class, 'company_id', 'company_id');
    }
}
