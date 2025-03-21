@extends('layouts.main')

@section('container')
    <div class="product-detail">
        <a href="/"><i class="bi bi-arrow-left-circle"></i></a>
        <img src="{{ asset('storage/product_photos/' . $product->product_image) }}" alt="{{ $product->product_name }}">
        <h1>{{ $product->product_name }}</h1>
        <p>Rp{{ number_format($product->product_price, 2, ',', '.') }}</p>
        <p>Brand: {{ $product->msbrand->brand_name ?? 'None' }}</p>
        <p>Category: {{ $product->mscategory->category_name ?? 'None' }}</p>
        <p>Description: {{ $product->product_description ?? 'None' }}</p>
        <p>Stock: {{ $product->product_stock }}</p>

        <div class="quantity input-group mb-3" style="max-width: 200px;">
            <button class="btn btn-outline-secondary decrease-button" type="button">-</button>
            <input type="number" name="quantity" id="product_quantity" class="quantity-input form-control mx-2 text-center" value="1" min="1" max="{{ $product->product_stock }}">
            <button class="btn btn-outline-secondary increase-button" type="button">+</button>
            <div id="quantity-error"></div>
        </div> 

        @auth('customer')
            <form id="addToCartForm" action="{{ route('cart.store') }}" method="post">
                @csrf
                
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                <input type="hidden" name="quantity" id="quantity_add">
                <button type="submit" class="btn btn-success">Add to Cart</button>
                <div id="quantity-cart-error"></div>
            </form>

            <div id="cartPopup">
                Item successfully added to cart! <a href="/cart" >View your cart</a>
            </div>  
        
        @else
            <a href="{{ route('login') }}"><button type="submit" class="btn btn-success">Add to Cart</button></a>
        @endauth
        
        @auth('customer')
            <form id="checkoutForm" action="{{ route('checkout.process') }}" method="post">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                <input type="hidden" name="quantity" id="quantity_checkout">
                <button type="submit" class="btn btn-primary">Buy</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Buy</a>
        @endauth

        
    </div>
@endsection