@extends('layouts.main')

@section('container')
    @auth('customer')
        <h3 class="balance">Your balance: Rp{{ number_format($customers->customer_balance, 2, ',', '.') }}</h3>
    @else

    @endauth
    @if ($products->count())

        @if (request('category'))
            <h2 class="category-title">
                Category: {{ $categories->firstWhere('category_slug', request('category'))->category_name }}
            </h2>
        @endif
        
        <div class="background-image">
            <img src="assets/image/all-products-background.png" alt="">
        </div>

        <div class="subtitle">
            <h2>All products</h2>
        </div>

        <div class="products-container">
            @foreach ($products as $product)
                <div class="products-cover">
                    <div class="products-card">
                        <img src="{{ asset('storage/product_photos/' . $product->product_image) }}" class="card-img-top" alt="{{ $product->product_name }}">

                        <div class="card-body">
                            <h3 class="products-card-name">
                                <a href="{{ url($product->msbrand->brand_slug . '/' . $product->product_slug) }}">
                                    {{ $product->product_name }}
                                </a>
                            </h3>
                            <p class="products-card-price">Rp {{ number_format($product->product_price, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    
    @else
        <p>No Product found.</p>
    @endif

@endsection