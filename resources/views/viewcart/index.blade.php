@extends('layouts.main')

@section('container')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="container my-5">
        <h2 class="mb-4 text-center">Shopping Cart</h2>
        
        <div class="card p-4 shadow-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th class="checkbox"></th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td>
                            <input type="checkbox" class="cart-checkbox" 
                                data-product-id="{{ $item->msproduct->product_id }}"
                                data-price="{{ $item->msproduct->product_price * $item->quantity }}">
                        </td>
                        <td>
                            <a href="{{ url($item->msproduct->msbrand->brand_slug . '/' . $item->msproduct->product_slug) }}">
                                <img src="{{ asset('storage/products/' . ($item->msproduct->product_image ?? 'default.png')) }}" 
                                alt="{{ $item->msproduct->product_name }}" 
                                class="img-thumbnail" width="80">
                                {{ $item->msproduct->product_name }}
                            </a>
                        </td>
                        <td>
                            <form class="update-cart-form d-flex align-items-center" method="post" action="{{ route('cart.update', ['brand_slug' => $item->msproduct->msbrand->brand_slug, 'product_slug' => $item->msproduct->product_slug]) }}" data-url="{{ route('cart.update', ['brand_slug' => $item->msproduct->msbrand->brand_slug, 'product_slug' => $item->msproduct->product_slug]) }}">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="product_id" value="{{ $item->msproduct->product_id }}">

                                <button type="button" name="action" value="decrease" class="btn btn-outline-secondary decrease-btn">-</button>
                                <input type="number" name="quantity" value="{{ $item->quantity }}" class="quantity-input form-control mx-2 text-center" min="1" max="{{ $item->msproduct->product_stock }}" data-max-stock="{{ $item->msproduct->product_stock }}" style="width: 50px">
                                <button type="button" name="action" value="increase" class="btn btn-outline-secondary increase-btn">+</button>
                                <div class="error-message text-danger mt-1"></div>
                            </form>
                        </td>
                        <td class="total-price-per-item" data-unit-price="{{ $item->msproduct->product_price }}">
                            Rp {{ number_format($item->msproduct->product_price * $item->quantity, 0, ',', '.') }}</td>
                        <td>
                            <form class="delete-cart-form" action="{{ route('cart.delete', ['brand_slug' => $item->msproduct->msbrand->brand_slug, 'product_slug' => $item->msproduct->product_slug]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-cart-item"><i class="bi bi-trash3"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                <h4>Subtotal</h4>
                <h4 id="total-price">0</h4>
            </div>

            {{-- <div class="text-center mt-3">
                <a href="{{ route('checkout') }}" class="btn btn-success w-100">Proceed to Checkout</a>
            </div> --}}
        </div>
    </div>

@endsection