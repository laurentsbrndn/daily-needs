<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsCustomer;
use App\Models\MsProduct;
use App\Models\MsCategory;
use App\Models\MsBrand;
use App\Models\MsCart;

class CustomerViewCartController extends Controller
{
    public function index()
    {
        $categories = MsCategory::all();
        $customers = auth('customer')->user();

        $cartItems = MsCart::where('customer_id', $customers->customer_id)->with('msproduct.msbrand')->get();

        return view('viewcart.index', compact('categories', 'cartItems', 'customers'));
    }

    public function getSubtotal(Request $request)
    {
        $customer = auth('customer')->user();
    
        $selectedProducts = $request->input('selected_products', []);
    
        if (empty($selectedProducts)) {
            return response()->json(['subtotal' => 0]);
        }

        $subtotal = MsCart::filterSubtotal($customer->customer_id, $selectedProducts);

        $subtotal = number_format($subtotal, 0, ',', '.');
        return response()->json(['subtotal' => $subtotal]);
    }


    public function store(Request $request)
    {
        $validateData = $request->validate([
            'product_id' => 'required|exists:ms_products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $customers = auth('customer')->user();

        $cartItems = MsCart::CartItem($customers->customer_id, $request->product_id)->first();

        if ($cartItems) {
            $cartItems->increment('quantity', $request->quantity);
        } 
        
        else {
            MsCart::create([
                'customer_id' => $customers->customer_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }
        
        return response()->json([
            'message' => 'Product added to cart!',
            'cart_count' => MsCart::where('customer_id', $customers->customer_id)->count()
        ]);

    }

    public function update(Request $request, $brand_slug, $product_slug)
    {
        
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);
    
        $customer = auth('customer')->user();
        $product = MsProduct::where('product_slug', $product_slug)->first();
    
        if (!$product) {
            return response()->json(['error' => 'Product not found!'], 404);
        }
    
        $cartItem = MsCart::CartItem($customer->customer_id, $product->product_id)->first();
    
        if (!$cartItem) {
            return response()->json(['error' => 'Product not in cart!'], 404);
        }
    
        $maxStock = $product->product_stock;
        $currentQuantity = $cartItem->quantity;
        $newQuantity = $request->quantity;
    
        if ($newQuantity > $maxStock) {
            $cartItem->update(['quantity' => $maxStock]);
            return response()->json([
                'error' => "Stock not enough! Maximum stock available is $maxStock.",
                'max_stock' => $maxStock,
                'prev_quantity' => $currentQuantity,
                'new_quantity' => $maxStock
            ], 400);
        }
    
        if ($newQuantity < 1) {
            $cartItem->update(['quantity' => 1]);
            return response()->json([
                'error' => "Minimum quantity is 1!",
                'prev_quantity' => $currentQuantity,
                'new_quantity' => 1
            ], 400);
        }
    
        $cartItem->update(['quantity' => $newQuantity]);
    
        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'new_quantity' => $cartItem->quantity
        ]);
    }

    public function destroy($brand_slug, $product_slug)
    {
        $customer = auth('customer')->user();

        $product = MsProduct::where('product_slug', $product_slug)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found!'], 404);
        }

        $cartItem = MsCart::CartItem($customer->customer_id, $product->product_id)->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Product not in cart!'], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart!',
            'product_slug' => $product_slug
        ]);
    }
}