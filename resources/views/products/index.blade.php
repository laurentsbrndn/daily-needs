@extends('layouts.main')

@section('container')
    @auth('customer')
        <h3>Your balance: Rp{{ number_format($customers->customer_balance, 2, ',', '.') }}</h3>
    @else

    @endauth
    @if ($products->count())

        @if (request('category'))
            <h2 class="category-title">
                Category: {{ $categories->firstWhere('category_slug', request('category'))->category_name }}
            </h2>
        @endif
        
        <div class="products-container">
            @foreach ($products as $product)
                <div class="products-cover">
                    <div class="products-card">
                        <a href="{{ url($product->msbrand->brand_slug . '/' . $product->product_slug) }}">
                            <img src="{{ asset('storage/product_photos/' . $product->product_image) }}" class="card-img-top" alt="{{ $product->product_name }}">

                            <div class="card-body">
                                <h3 class="products-card-name">{{ $product->product_name }}</h3>
                                <p class="products-card-price">Rp{{ number_format($product->product_price, 2, ',', '.') }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    
    @else
        <p>No Product found.</p>
    @endif

@endsection