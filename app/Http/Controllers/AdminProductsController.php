<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsCategory;
use App\Models\MsProduct;
use App\Models\MsBrand;
use App\Models\MsCompany;
use App\Models\MsAdmin;
use Illuminate\Support\Facades\Auth;

class AdminProductsController extends Controller
{
    public function show($product_slug)
    {
        $product = MsProduct::where('product_slug', $product_slug)->firstOrFail();

        return view('admin-product.index', compact('product'));
    }

    public function index()
    {   
        $admins = Auth::guard('admin')->user();
        $categories = MsCategory::all();

        $products = MsProduct::latest()
            ->filter(request(['search', 'category']))
            ->with(['msbrand', 'mscategory'])->get();

        return view('admin-products.index', compact('products', 'categories', 'admins'));
    }
}
