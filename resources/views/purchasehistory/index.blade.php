@extends('layouts.dashboardmain')

@section('container')
<div class="purchase-history-container">
    <div class="history-header">
        <h2>Purchase History</h2>
        <div class="status-filter">
            @foreach($statusMap as $key => $value)
                <a href="?status={{ $key }}" class="{{ $status == $value ? 'active' : '' }}">{{ $value }}</a>
            @endforeach
        </div>
    </div>

    <div class="search-box">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search transactions..." value="{{ request('search') }}">
            <button type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div>

    @if($transactions->isEmpty())
        <div class="empty-state">
            <p>No transactions found</p>
        </div>
    @else
        <div class="transactions-list">
            @foreach($transactions as $transaction)
            <div class="transaction-card">
                <div class="transaction-header">
                    <span class="order-id">Order #{{ $transaction->transaction_id }}</span>
                    <span class="order-date">
                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y H:i') }}
                    </span>
                    <span class="order-status {{ strtolower($transaction->transaction_status) }}">{{ $transaction->transaction_status }}</span>
                </div>

                <div class="transaction-body">
                    <div class="products-list">
                        @foreach($transaction->transactiondetail as $detail)
                        <div class="product-item">
                            <img src="{{ asset('storage/' . $detail->msproduct->product_image) }}" alt="{{ $detail->msproduct->product_name }}" class="product-image">
                            <div class="product-info">
                                <h4>{{ $detail->msproduct->product_name }}</h4>
                                <p>{{ $detail->quantity }} x Rp {{ number_format($detail->unit_price_at_buy, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="transaction-summary">
                        <div class="summary-row">
                            <span>Payment Method:</span>
                            <span>{{ $transaction->mspaymentmethod->payment_method_name }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping Address:</span>
                            <span>{{ $transaction->mscustomeraddress->address }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="transaction-footer">
                    @if($transaction->transaction_status == 'Pending')
                        <form action="{{ route('purchasehistory.cancel', $transaction->transaction_id) }}" method="POST" class="action-form">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="cancel-btn">Cancel Order</button>
                        </form>
                    @endif

                    @if($transaction->transaction_status == 'Shipped')
                        <form action="{{ route('purchasehistory.confirm', $transaction->transaction_id) }}" method="POST" class="action-form">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="confirm-btn">Confirm Receipt</button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-links">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection