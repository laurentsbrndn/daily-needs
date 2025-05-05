@extends ('layouts.dashboardmain')

@section('container')
    <div class="content">
        <h2 class="mb-4">Purchase History</h2>
        <ul class="nav nav-tabs mb-4">
            @foreach($statusMap as $urlStatus => $label)
                <li class="nav-item">
                    <a class="nav-link {{ $status == $label ? 'active' : '' }}"
                       href="{{ route('purchasehistory.show', ['status' => $urlStatus]) }}">
                        {{ $label }}
                    </a>
                </li>
            @endforeach

        </ul>

        <form method="get" action="{{ url('/dashboard/purchasehistory') }}" class="mb-4">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <div class="input-group mb-3" style="max-width: 400px;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Enter product name">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        @foreach($transactions as $transaction)
            <div class="card mb-4 shadow-sm border-0 rounded-4 px-3 py-3 bg-light">
                <div class="mb-2 fw-bold">
                    {{ \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('l, F d Y') }}
                </div>                

                @foreach($transaction->transactiondetail as $detail)
                    <div class="d-flex align-items-center border-bottom pb-2 mb-2">
                        <div class="me-3" style="width: 60px; height: 60px; background-color: #ddd; border-radius: 10px;">
                            {{ $detail->msproduct->product_image }}
                        </div>

                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $detail->msproduct->product_name }}</div>
                            <div>Rp {{ number_format($detail->unit_price_at_buy, 0, ',', '.') }}</div>
                        </div>

                        <div class="text-end">
                            <div>Quantity: {{ $detail->quantity }}</div>
                            <div>Subtotal: Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="d-flex align-items-center">
                        <h6 class="fw-bold mb-0 me-2">Payment Method:</h6>
                        <span>{{ $transaction->mspaymentmethod->payment_method_name }}</span>
                    </div>

                    @if($transaction->transaction_status == 'Pending')
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                            Cancel Order
                        </button>
                    @elseif($transaction->transaction_status == 'Shipped')
                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#completeOrderModal">
                            Complete Order
                        </button>
                    @endif
                </div>

                <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('purchasehistory.cancel', $transaction->transaction_id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelOrderModalLabel">Cancellation Confirmation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to cancel your order?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                    <button type="submit" class="btn btn-danger">Yes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="completeOrderModal" tabindex="-1" aria-labelledby="confirmOrderModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('purchasehistory.confirm', $transaction->transaction_id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelOrderModalLabel">Order Confirmation Complete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to complete your order?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                                    <button type="submit" class="btn btn-success">Yes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
  
                <div class="mt-3">
                    <h6 class="fw-bold mb-2">Shipping Address</h6>
                    <div class="">
                        {{ $transaction->mscustomeraddress->customer_address_name }}<br>
                        {{ $transaction->mscustomeraddress->customer_address_street }},
                        {{ $transaction->mscustomeraddress->customer_address_district }},
                        {{ $transaction->mscustomeraddress->customer_address_regency_city }},
                        {{ $transaction->mscustomeraddress->customer_address_province }},
                        {{ $transaction->mscustomeraddress->customer_address_country }} -
                        {{ $transaction->mscustomeraddress->customer_address_postal_code }}
                    </div>
                </div>
                
            
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <strong>Total: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
                </div>
            </div>
        @endforeach

        <div class="pagination-container">
            <div class="d-flex justify-content-center mt-4">
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
