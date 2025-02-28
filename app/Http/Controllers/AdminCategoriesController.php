<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsProduct;
use App\Models\MsCategory;

class AdminCategoriesController extends Controller
{
    public function index()
    {
        $categories = MsCategory::all();
        $products = MsProduct::all();
        return view('admin-products.index', compact('categories', 'products'));
    }

    public function filterByCategory($category_slug)
    {
        $categories = MsCategory::all();
        $category = MsCategory::where('category_slug', $category_slug)->first();

        if ($category) {
            $products = $category->msproduct;
        } else {
            $products = MsProduct::all();
        }

        return view('admin-products.index', compact('categories', 'products'));
    }
}
