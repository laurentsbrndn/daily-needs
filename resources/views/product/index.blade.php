@extends('layouts.main')

@section('container')
    <div class="product-detail">
        
        <div class="product_image">
            <img src="{{ asset('storage/product_photos/' . $product->product_image) }}" alt="{{ $product->product_name }}">
        </div>
        <div>
            <a href="/"><i class="bi bi-arrow-left-circle"></i></a>
        </div>

        <div class="product-desc">
            <h2>{{ $product->product_name }}</h2>
            <h1>Rp{{ number_format($product->product_price, 2, ',', '.') }}</h1>
            <p>Brand: {{ $product->msbrand->brand_name ?? 'None' }}</p>
            <p>Category: {{ $product->mscategory->category_name ?? 'None' }}</p>
            <p>Description: {{ $product->product_description ?? 'None' }}</p>
        </div>

        
        <div class="stock-quantity-wrapper">

            <div class="quantity input-group mb-3" style="max-width: 200px;">
                <button class="btn btn-outline-secondary decrease-button" type="button">-</button>
                <input type="number" name="quantity" id="product_quantity" class="quantity-input form-control mx-2 text-center" 
                value="{{ $product->product_stock == 0 ? 0 : 1 }}" 
                min="1" 
                max="{{ $product->product_stock }}" 
                {{ $product->product_stock == 0 ? 'readonly' : '' }}>
                <button class="btn btn-outline-secondary increase-button" type="button">+</button>
                <div id="quantity-error"></div>
            </div>

            <div class="stock-label">
                <p>Stock: {{ $product->product_stock }}</p>
            </div>
        </div>


        <div class="button-wrapper">
            @auth('customer')
                <form id="addToCartForm" action="{{ route('cart.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <input type="hidden" name="quantity" id="quantity_add">
                    <button type="submit" class="btn btn-success" {{ $product->product_stock == 0 ? 'disabled data-bs-toggle=tooltip data-bs-placement=top title=Stok%20habis%2C%20tidak%20bisa%20ditambahkan%20ke%20keranjang' : '' }}>Add to Cart</button>
                    <div id="quantity-cart-error"></div>
                </form>
            @else
                <a href="{{ route('login') }}"><button type="submit" class="btn btn-success">Add to Cart</button></a>
            @endauth

            @auth('customer')
                <form id="checkoutForm" action="{{ route('checkout.process') }}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <input type="hidden" name="quantity" id="quantity_checkout">
                    <button type="submit" class="btn btn-primary" {{ $product->product_stock == 0 ? 'disabled data-bs-toggle=tooltip data-bs-placement=top title=Stok%20habis%2C%20tidak%20bisa%20dibeli' : '' }}>Buy</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Buy</a>
            @endauth
    </div>


    </div>
    <!-- <div class="product-detail">
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
            <input type="number" name="quantity" id="product_quantity" class="quantity-input form-control mx-2 text-center" 
            value="{{ $product->product_stock == 0 ? 0 : 1 }}" 
            min="1" 
            max="{{ $product->product_stock }}" 
            {{ $product->product_stock == 0 ? 'readonly' : '' }}>
            <button class="btn btn-outline-secondary increase-button" type="button">+</button>
            <div id="quantity-error"></div>
        </div> 

        @auth('customer')
            <form id="addToCartForm" action="{{ route('cart.store') }}" method="post">
                @csrf
                
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                <input type="hidden" name="quantity" id="quantity_add">
                <button type="submit" class="btn btn-success" {{ $product->product_stock == 0 ? 'disabled data-bs-toggle=tooltip data-bs-placement=top title=Stok%20habis%2C%20tidak%20bisa%20ditambahkan%20ke%20keranjang' : '' }}>Add to Cart</button>
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
                <button type="submit" class="btn btn-primary" {{ $product->product_stock == 0 ? 'disabled data-bs-toggle=tooltip data-bs-placement=top title=Stok%20habis%2C%20tidak%20bisa%20dibeli' : '' }}>Buy</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Buy</a>
        @endauth        
    </div> -->
@endsection