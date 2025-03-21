@extends('layouts.main')

@section('container')
    <h1>Checkout</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->product_name }}">
    <p>{{ $product->product_name }}</p>
    <p>Rp{{ number_format($product->product_price, 0, ',', '.') }}</p>
    <p><strong>Quantity:</strong> {{ $quantity }}</p>
    <p><strong>Total:</strong> Rp{{ number_format($totalPrice, 0, ',', '.') }}</p>

    <p><strong>Payment Methods</strong></p>
    <select name="payment_method" id="paymentMethod" class="form-select">
        @foreach ($paymentMethods as $paymentMethod)
            <option value="{{ $paymentMethod->payment_method_id }}" 
                {{ $loop->first ? 'selected' : '' }}>
                {{ $paymentMethod->payment_method_name }}
            </option>
        @endforeach
    </select>
    <input type="hidden" name="selected_payment" id="selectedPayment" value="{{ $paymentMethods->first()->payment_method_id ?? '' }}">
    <div class="card p-3 shadow-sm">
        <h3 class="mb-3">Select Address</h3>
        <button class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#addressModal">
            <i class="fas fa-map-marker-alt"></i> Choose Address
        </button>
        
    </div>
    

    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Address List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="address-list">
                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                            Add New Address
                        </button>
                        {{-- @foreach ($addresses as $address)
                        <div class="card p-3 mb-2">
                            <strong>{{ $address->address_name }}</strong>
                            <p>{{ $address->street }}, {{ $address->city }}, {{ $address->province }}</p>
                            <button class="btn btn-success btn-sm select-address" data-address="{{ $address->address_name }}">
                                Select
                            </button>
                        </div>
                        @endforeach --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="address_name" class="form-control mb-2" placeholder="Address Name">
                    <input type="text" id="street" class="form-control mb-2" placeholder="Street">
                    <input type="text" id="postal_code" class="form-control mb-2" placeholder="Postal Code">
                    <input type="text" id="district" class="form-control mb-2" placeholder="District">
                    <input type="text" id="city" class="form-control mb-2" placeholder="Regency / City">
                    <input type="text" id="province" class="form-control mb-2" placeholder="Province">
                    <input type="text" id="country" class="form-control mb-2" placeholder="Country">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addressModal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveAddress">Save</button>
                </div>
            </div>
        </div>
    </div>

    
        
    {{-- <form action="{{ route('payment.process') }}" method="post">
        @csrf   
        <button type="submit" class="btn btn-success">Bayar Sekarang</button>
    </form> --}}
@endsection
