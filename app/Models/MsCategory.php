<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsCategory extends Model
{
    use HasFactory;

    protected $table = 'ms_categories';

    protected $primaryKey = 'category_id';

    protected $guarded = ['category_id'];
    
    public function msproduct(){
        return $this->hasMany(MsProduct::class, 'category_id', 'category_id');
    }
}
