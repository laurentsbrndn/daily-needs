@extends('layouts.main')

@section('container')
    <h1>Checkout</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <p><strong>Nama Produk:</strong> {{ $product->product_name }}</p>
    <p><strong>Harga:</strong> Rp{{ number_format($product->product_price, 0, ',', '.') }}</p>
    <p><strong>Jumlah:</strong> {{ $quantity }}</p>
    <p><strong>Total:</strong> Rp{{ number_format($product->product_price * $quantity, 0, ',', '.') }}</p>
    
    {{-- <form action="{{ route('payment.process') }}" method="post">
        @csrf
        <button type="submit" class="btn btn-success">Bayar Sekarang</button>
    </form> --}}
@endsection
