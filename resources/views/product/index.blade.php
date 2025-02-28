@extends('layouts.main')

@section('container')
    <div class="product-detail">
        <img src="{{ asset('storage/product_photos/' . $product->product_image) }}" alt="{{ $product->product_name }}">
        <h1>{{ $product->product_name }}</h1>
        <p>Rp{{ number_format($product->product_price, 2, ',', '.') }}</p>
        <p>Stock: {{ $product->product_stock }}</p>
        <p>Brand: {{ $product->msbrand->brand_name ?? 'None' }}</p>
        <p>Category: {{ $product->mscategory->category_name ?? 'None' }}</p>
        <p>Description: {{ $product->product_description ?? 'None' }}</p>
        <a href="/" class="btn btn-primary">Back</a>
    </div>
@endsection
