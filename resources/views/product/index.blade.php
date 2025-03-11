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

        <div class="input-group mb-3" style="max-width: 200px;">
            <button class="btn btn-outline-secondary" id="decrease-btn" type="button" onclick="decreaseQuantity()">-</button>
            <input type="number" name="product_stock" id="product_stock" class="form-control text-center" value="{{ old('product_stock', 1) }}" min="1" max="{{ $product->product_stock }}">
            <button class="btn btn-outline-secondary" id="increase-btn" type="button" onclick="increaseQuantity()">+</button>
        </div>

        <form id="addToCartForm" action="/cart" method="post">
            @csrf
            
            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
            <input type="hidden" name="quantity" id="quantity_add" value="1">
            <button type="submit" class="btn btn-success">Add to Cart</button>
        </form>

        <form action="/cart/checkout" method="post">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" id="quantity_checkout" value="1">
            <button type="submit" class="btn btn-primary">Buy</button>
        </form>

        <div id="cartPopup">
            Item successfully added to cart! <a href="/cart" >View your cart</a>
        </div>
        
    </div>
@endsection