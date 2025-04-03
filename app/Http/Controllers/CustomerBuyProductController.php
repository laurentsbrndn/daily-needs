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
        if ($request->has('cart')) {
            $cart = session()->get('cart', []);
    
            if (empty($cart)) {
                return redirect()->back()->with('error', 'Cart is empty!');
            }
    
            session(['checkout_cart' => $cart]);
            return redirect()->route('checkout.page');
        }
        else {
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
            
    }

    public function index()
    {
        $customers = Auth::guard('customer')->user();

        $cart = session('checkout_cart');
        $productId = session('checkout_product_id');
        $quantity = session('checkout_quantity');

        if ($cart){
            $products = MsProduct::whereIn('product_id', array_column($cart, 'product_id'))->get();
            $totalPrice = collect($cart)->sum(fn($item) => $item['product_price'] * $item['quantity']);
        }

        else if ($productId && $quantity){
            $product = MsProduct::where('product_id', $productId)->first();
            $products = [$product];
            $totalPrice = $product->product_price * $quantity;
        }

        else {
            return redirect()->back()->with('error', 'Checkout invalid!');
        }

        $addresses = MsCustomerAddress::where('customer_id', $customers->customer_id)->get();
        $paymentMethods = MsPaymentMethod::all();
        $categories = MsCategory::all();

        return view('checkout.index', compact('customers', 'categories', 'products', 'quantity', 'totalPrice', 'paymentMethods', 'addresses'));
    }

    public function store(Request $request)
    {
        $customers = Auth::guard('customer')->user();

        if (!$customers) {
            return redirect()->route('login')->with('error', 'You need to login first.');
        }

        try {
            $validateData = $request->validate([
                'product_id' => 'required|exists:ms_products,product_id',
                'quantity' => 'required|integer|min:1',
                'payment_method_id' => 'required|exists:ms_payment_methods,payment_method_id',
                'customer_address_id' => 'required|exists:ms_customer_addresses,customer_address_id',
            ]);
    
            $transactionHeader = TransactionHeader::create([
                'transaction_date' => now(),
                'transaction_status' => 'Pending',
                'customer_id' => $customers->customer_id,
                'customer_address_id' => $validateData['customer_address_id'],
                'payment_method_id' => $validateData['payment_method_id']
            ]);
    
            TransactionDetail::create([
                'transaction_id' => $transactionHeader->transaction_id,
                'product_id' => $validateData['product_id'],
                'quantity'=> $validateData['quantity']
            ]);
            
        }

        catch (\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'status' => 'error',
                'errors' => $e->validator->errors()
            ], 422);
        }
        
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