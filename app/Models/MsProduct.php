<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MsProduct extends Model
{
    use HasFactory;

    protected $table = 'ms_products';

    protected $primaryKey = 'product_id';

    protected $guarded = ['product_id'];

    public function getRouteKeyName()
    {
        return 'product_name';
    }

    public function mscategory(){
        return $this->belongsTo(MsCategory::class, 'category_id', 'category_id');
    }

    public function msbrand(){
        return $this->belongsTo(MsBrand::class, 'brand_id', 'brand_id');
    }

    public function transactiondetail(){
        return $this->hasMany(TransactionDetail::class, 'product_id', 'product_id');
    }

    public function mscart(){
        return $this->hasMany(MsCart::class, 'product_id', 'product_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->product_slug = Str::slug($product->product_name);
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['category'] ?? false, function($query, $category){
            $query->whereHas('mscategory', function($query) use ($category) {
                $query->where('category_slug', $category);
            });
        });
    
        $query->when($filters['search'] ?? false, function($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('product_name', 'like', '%' . $search . '%')
                      ->orWhere('product_description', 'like', '%' . $search . '%')
                      ->orWhereHas('msbrand', function ($brandQuery) use ($search) {
                          $brandQuery->where('brand_name', 'like', '%' . $search . '%');
                      });
            });
        });
    }

}
