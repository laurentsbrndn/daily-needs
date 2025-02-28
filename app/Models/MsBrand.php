<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsBrand extends Model
{
    use HasFactory;

    protected $table = 'ms_brands';

    protected $primaryKey = 'brand_id';

    protected $guarded = ['brand_id'];

    public function mscompany(){
        return $this->belongsTo(MsCompany::class, 'company_id', 'company_id');
    }

    public function msproduct(){
        return $this-> hasMany(MsProduct::class, 'brand_id', 'brand_id');
    }
}
