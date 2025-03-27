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
        $customers = Auth::guard('customer')->user();

        $productId = session('checkout_product_id');
        $quantity = session('checkout_quantity');

        if (!$productId || !$quantity) {
            return redirect()->back()->with('error', 'Checkout invalid!');
        }

        $product = MsProduct::where('product_id', $productId)->first();

        $totalPrice = $product->product_price * $quantity;

        $addresses = MsCustomerAddress::where('customer_id', $customers->customer_id)->get();

        $paymentMethods = MsPaymentMethod::all();
        $categories = MsCategory::all();
        $customers = Auth::guard('customer')->user();
        return view('checkout.index', compact('customers', 'categories', 'product', 'quantity', 'totalPrice', 'paymentMethods', 'addresses'));
    }

    public function storeAddress(Request $request)
    {
        $validateData = $request->validate([
            'customer_address_name' => 'required|string|max:199',
            'customer_address_street' => 'required|string|max:199',
            'customer_address_postal_code' => 'required|string|max:199',
            'customer_address_district' => 'required|string|max:199',
            'customer_address_regency_city' => 'required|string|max:199',
            'customer_address_province' => 'required|string|max:199',
            'customer_address_country' => 'required|string|max:199',
        ]);

        $customers = Auth::guard('customer')->user();

        if (!$customers) {
            return response()->json([
                'success' => false,
                'message' => 'Please Login!'
            ], 400);
        }

        MsCustomerAddress::create([
            'customer_address_name' => $request->customer_address_name,
            'customer_address_street' => $request->customer_address_street,
            'customer_address_postal_code' => $request->customer_address_postal_code,
            'customer_address_district' => $request->customer_address_district,
            'customer_address_regency_city' => $request->customer_address_regency_city,
            'customer_address_province' => $request->customer_address_province,
            'customer_address_country' => $request->customer_address_country,
            'customer_id' => $customers->customer_id
        ]);

        $addresses = MsCustomerAddress::where('customer_id', $customers->customer_id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Address successfully added!',
            'addresses' => $addresses
        ], 200);
    }

    public function showAddress()
    {
        $customers = Auth::guard('customer')->user();

        if (!$customers) {
            return response()->json(['addresses' => []], 400);
        }

        $addresses = MsCustomerAddress::where('customer_id', $customers->customer_id)->get();

        return response()->json(['addresses' => $addresses]);
    }

    public function updateAddress(Request $request, $customer_address_id)
    {
        
        $customers = Auth::guard('customer')->user();

        $addresses = MsCustomerAddress::where('customer_id', $customers->customer_id)->where('customer_address_id', $customer_address_id)->firstOrFail();

        $validateData = $request->validate([
            'customer_address_name' => 'sometimes|required|max:199',
            'customer_address_street' => 'sometimes|required|max:199',
            'customer_address_district' => 'sometimes|required|max:199',
            'customer_address_regency_city' => 'sometimes|required|max:199',
            'customer_address_province' => 'sometimes|required|max:199',
            'customer_address_country' => 'sometimes|required|max:199',
            'customer_address_postal_code' => 'sometimes|required|max:199',
        ]);

        $addresses->update($validateData);

        return response()->json([
            'success' => true,
            'message' => 'Address successfully updated!',
            'updated_address' => $addresses
        ], 200);
    }

    public function destroyAddress($customer_address_id)
    {
        $customers = Auth::guard('customer')->user();

        $addresses = MsCustomerAddress::where('customer_id', $customers->customer_id)->where('customer_address_id', $customer_address_id)->first();

        if (!$addresses) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found or unauthorized access.'
            ], 404);
        }
    
        $addresses->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address successfully deleted.'
        ]);
    }
}