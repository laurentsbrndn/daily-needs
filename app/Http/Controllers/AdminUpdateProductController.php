<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsProduct;
use App\Models\MsBrand;
use App\Models\MsCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class AdminUpdateProductController extends Controller
{
    public function show($product_slug)
    {
        $products = MsProduct::where('product_slug', $product_slug)->first();

        if (!$products) {
            return redirect('/admin/productlist')->with('error', 'Product not found.');
        }

        $categories = MsCategory::all();
        $brands = MsBrand::all();

        return view('admin-product.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function update(Request $request, $product_slug)
    {
        $products = MsProduct::where('product_slug', $product_slug)->first();

        if (!$products) {
            return redirect('/admin/productlist')->with('error', 'Product not found');
        }

        $validateData = $request->validate([
            'product_name' => 'sometimes|required|max:199',
            'product_price' => 'sometimes|required|numeric|min:1',
            'product_stock' => 'sometimes|required|integer|min:1',
            'product_description' => 'sometimes|required|max:65000',
            'product_image' => 'sometimes|required|mimes:jpg,jpeg,png|max:2048',
            'brand_id' => 'sometimes|required|exists:ms_brands,brand_id',
            'category_id' => 'sometimes|required|exists:ms_categories,category_id',
        ]);

        if ($request->hasFile('product_image')) {
            if ($products->product_image) {
                Storage::delete('public/product_photos/' . $products->product_image);
            }

            $file = $request->file('product_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/product_photos', $fileName);
            $products->product_image = $fileName;
        }

        if ($request->filled('product_name')) {
            $products->product_name = $validateData['product_name'];
            $products->product_slug = Str::slug($validateData['product_name']);
        }
        if ($request->filled('product_price')) {
            $products->product_price = $validateData['product_price'];
        }
        if ($request->filled('product_stock')) {
            $products->product_stock = $validateData['product_stock'];
        }
        if ($request->filled('product_description')) {
            $products->product_description = $validateData['product_description'];
        }
        if ($request->filled('product_slug')) {
            $products->product_slug = $validateData['product_slug'];
        }

        $brands = MsBrand::where('brand_name', $request->brand_name)->first();
        $categories = MsCategory::where('category_name', $request->category_name)->first();

        if ($request->filled('brand_id')) {
            $products->brand_id = $validateData['brand_id'];
        }
        
        if ($request->filled('category_id')) {
            $products->category_id = $validateData['category_id'];
        }

        $products->save();

        return redirect('/admin/productlist')->with('success', 'Product updated successfully');
    }

}