<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsCategory;
use App\Models\MsProduct;
use App\Models\MsCustomer;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = MsCategory::all();
        $products = MsProduct::with(['msbrand', 'mscategory'])->get();
        $customers = auth('customer')->user();
        return view('products.index', compact('categories', 'products', 'customers'));
    }

    public function filterByCategory($category_slug)
    {
        $categories = MsCategory::all();
        $category = MsCategory::where('category_slug', $category_slug)->first();

        if (!$category){
            abort(404);
        }

        if ($category) {
            $products = MsProduct::with(['msbrand', 'mscategory'])
                ->where('category_id', $category->category_id)
                ->get();
        } 
        else {
            $products = MsProduct::with(['msbrand', 'mscategory'])->get();
        }

        $customers = auth('customer')->user();

        return view('products.index', compact('categories', 'products', 'customers'));
    }
}
