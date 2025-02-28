@extends('layouts.main')

@section('container')
    <h1>{{ $category->category_name }}</h1>
    <div class="products-container">
        @foreach ($products as $product)
            <div>
                <a href="{{ url('/products/' . $product->product_slug) }}">
                    <img src="{{ asset('storage/product_photos/' . $product->product_image) }}" class="card-img-top" alt="{{ $product->product_name }}">
                </a>
            </div>
            <div class="product-card">
                <h3 class="products-card-name">{{ $product->product_name }}</h3>
                <p class="products-card-price">Rp{{ number_format($product->product_price, 2, ',', '.') }}</p>
            </div>
        @endforeach
    </div>
@endsection