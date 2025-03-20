<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\MsAdmin;
use App\Models\MsCustomer;
use App\Models\MsCategory;
use App\Models\MsProduct;
use App\Models\MsCustomerAddress;
use App\Models\MsPaymentMethod;
use Illuminate\Support\Facades\Auth;

class CustomerBuyProductController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:ms_products,product_id',
            'quantity' => 'required|integer|min:1'
        ]);

        session([
            'checkout_product_id' => $request->product_id,
            'checkout_quantity' => $request->quantity
        ]);

        return redirect()->route('checkout.page');
    }

    public function index()
    {
        $productId = session('checkout_product_id');
        $quantity = session('checkout_quantity');

        if (!$productId || !$quantity) {
            return redirect()->back()->with('error', 'Checkout tidak valid');
        }

        $product = MsProduct::where('product_id', $productId)->first();
        $categories = MsCategory::all();
        $customers = Auth::guard('customer')->user();
        return view('checkout.index', compact('customers', 'categories', 'product', 'quantity'));
    }

}