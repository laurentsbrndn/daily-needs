<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\MsProduct;
use App\Models\MsBrand;
use App\Models\MsCategory;

class AdminAddNewProductController extends Controller
{
    public function index()
    {
        $products = MsProduct::all();
        $brands = MsBrand::all();
        $categories = MsCategory::all();

        return view('admin-addproduct.index', compact('products', 'brands', 'categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|max:199',
            'product_price' => 'required|numeric|min:1',
            'product_stock' => 'required|numeric|min:1',
            'product_image' => 'required|mimes:jpg,jpeg,png|max:2048',
            'product_description' => 'required|max:65000',
            'brand_id' => 'required|exists:ms_brands,brand_id',
            'category_id' => 'required|exists:ms_categories,category_id',
        ], [
            'brand_id.required' => 'Brand is required. Please select a brand.',
            'category_id.required' => 'Category is required. Please select a category.',
        ]);

        if (empty($request->product_slug)) {
            $validatedData['product_slug'] = Str::slug($request->product_name);
        }

        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/product_photos', $fileName);
            $validatedData['product_image'] = $fileName;
        }

        Msproduct::create($validatedData);

        $request->session()->flash('success', 'Product successfully added!');

        return redirect('/admin/productlist');
    }
}
