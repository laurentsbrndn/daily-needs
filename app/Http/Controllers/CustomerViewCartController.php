<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsCustomer;
use App\Models\MsProduct;
use App\Models\MsCategory;

class CustomerViewCartController extends Controller
{
    public function index()
    {
        $categories = MsCategory::all();
        $products = MsProduct::with(['msbrand', 'mscategory'])->get();
        $customers = auth('customer')->user();
        return view('viewcart.index', compact('categories', 'products', 'customers'));
    }
}
