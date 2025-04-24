@extends('courier-sidebar.index')

@section('container')

    <div class="content">
        <h2 class="text-xl font-bold mb-4">Courier Deliveries</h2>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <ul class="nav nav-tabs">
            @foreach($statusLink as $key => $label)
                <li class="nav-item">
                    <a class="nav-link {{ $status == $key ? 'active' : '' }}" href="{{ route('courier.delivery', ['status' => $key]) }}">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>
    
        <div class="tab-content mt-3">
            @if($status === 'to-ship')
                <table class="w-100 border-collapse text-center" style="table-layout: fixed;">
                    <thead class="text-center">
                        <tr>
                            <th class="p-2">Transaction Number</th>
                            <th class="p-2">Customer Name</th>
                            <th class="p-2">Payment Method</th>
                            <th class="p-2">City</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $transaction)
                            <tr class="text-center table-row-hover to-ship"
                                data-bs-toggle="modal"
                                data-bs-target="#toShipStatusModal"
                                data-transaction-id="{{ $transaction->transaction_id }}"
                                data-transaction-date="{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('l, d F Y') }}"
                                data-customer-name="{{ $transaction->mscustomer->full_name }}"
                                data-customer-address="{{ $transaction->mscustomeraddress->customer_full_address_name }}"
                                data-payment-method="{{ $transaction->mspaymentmethod->payment_method_name }}"
                                data-total-amount="Rp {{ number_format($transaction->total_price, 0, ',', '.') }}">
                                <td class="p-2">{{ $transaction->transaction_id }}</td>
                                <td class="p-2">{{ $transaction->mscustomer->full_name }}</td>
                                <td class="p-2">{{ $transaction->mspaymentmethod->payment_method_name }}</td>
                                <td class="p-2">{{ $transaction->mscustomeraddress->customer_short_address_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @elseif($status === 'in-progress')
                <table class="w-100 border-collapse text-center" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th class="p-2">Shipment Number</th>
                            <th class="p-2">Customer Name</th>
                            <th class="p-2">Payment Method</th>
                            <th class="p-2">City</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach ($data as $shipment)
                        <tr class="text-center table-row-hover in-progress"
                            data-payment="{{ $shipment->transactionheader->mspaymentmethod->payment_method_name }}"
                            data-shipment-id="{{ $shipment->shipment_id }}"
                            data-transaction-id="{{ $shipment->transactionheader->transaction_id }}"
                            data-shipment-date="{{ \Carbon\Carbon::parse($shipment->shipment_date_start)->format('l, d F Y \| H:i:s') }}"
                            data-address="{{ $shipment->transactionheader->mscustomeraddress->customer_full_address_name }}"
                            data-payment-method="{{ $shipment->transactionheader->mspaymentmethod->payment_method_name }}"
                            data-status="{{ $shipment->shipment_status }}"
                            data-total-price="{{ $shipment->transactionheader->total_price }}">
                            <td class="p-2">{{ $shipment->shipment_id }}</td>
                            <td class="p-2">{{ $shipment->transactionheader->mscustomer->full_name }}</td>
                            <td class="p-2">{{ $shipment->transactionheader->mspaymentmethod->payment_method_name }}</td>
                            <td class="p-2">{{ $shipment->transactionheader->mscustomeraddress->customer_short_address_name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            @elseif($status === 'delivered')
                <table class="w-100 border-collapse text-center">
                    <thead>
                        <tr>
                            <th>Shipment ID</th>
                            <th>Customer</th>
                            <th>Delivered On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $shipment)
                        <tr class="delivered">
                            <td>{{ $shipment->shipment_id }}</td>
                            <td>{{ $shipment->transactionheader->mscustomer->customer_name }}</td>
                            <td>{{ $shipment->shipment_date_end }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="modal fade" id="toShipStatusModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delivery Notes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Transaction Date:</strong> <span id="modalTransactionDate"></span></p>
                    <p><strong>Customer Name:</strong> <span id="modalCustomer"></span></p>
                    <p><strong>Address:</strong> <span id="modalAddressToShip"></span></p>
                    <p><strong>Payment Method:</strong> <span id="modalPaymentToShip"></span></p>
                </div>
                <div class="modal-footer">
                    <form id="confirmForm" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success">Confirm Delivery</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="codConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">COD Confirmation Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Total:</strong> <span id="cod-total-price"></span></p>
                    <p>Has the item been paid for and does it match the total?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cod-no" class="btn btn-danger">No</button>
                    <button type="button" id="cod-yes" class="btn btn-success">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="inProgressStatusModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delivery List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Shipment Number:</strong> <span id="modalShipmentNumber"></span></p>
                    <p><strong>Transaction Number:</strong> <span id="modalTransactionNumber"></span></p>
                    <p><strong>Shipment Date Start:</strong> <span id="modalShipmentDateStart"></span></p>
                    <p><strong>Address:</strong> <span id="modalAddressInProgress"></span></p>
                    <p><strong>Payment Method:</strong> <span id="modalPaymentInProgress"></span></p>
                    <div class="mb-3">
                        <label for="recipientName" class="form-label"><strong>Recipient Name:</strong></label>
                        <input type="text" class="form-control" id="recipientName" name="shipment_recipient_name" required>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <form id="inProgressConfirmForm" method="POST">
                        @csrf
                        <input type="hidden" name="shipment_id" id="hiddenShipmentId">
                        <input type="hidden" name="transaction_id" id="hiddenTransactionId">
                        <input type="hidden" name="shipment_date_end" value="{{ now() }}">
                        <input type="hidden" name="shipment_recipient_name" id="hiddenRecipientName">
                        <button type="submit" class="btn btn-success">Finish Delivery</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection