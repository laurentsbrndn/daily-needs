@extends ('admin-sidebar.index')

@section('container')
    <div class="content">
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="mb-4">Transaction History</h2>
        <ul class="nav nav-tabs">
            @foreach($statusLink as $key => $label)
                <li class="nav-item">
                    <a class="nav-link {{ $status == $key ? 'active' : '' }}"
                       href="{{ route('admin.transaction-history', ['status' => $key]) }}">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content mt-3">
            @if($status === 'processing')
                <table class="w-100 border-collapse text-center" style="table-layout: fixed;">
                    <thead class="text-center">
                        <tr>
                            <th class="p-2">Transaction Number</th>
                            <th class="p-2">Customer Name</th>
                            <th class="p-2">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $transaction)
                            <tr class="text-center border-b">
                                <td class="p-2">{{ $transaction->transaction_id }}</td>
                                <td class="p-2">{{ $transaction->mscustomer->full_name }}</td>
                                <td class="p-2">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center">No pending orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $data->links() }}

            @elseif($status === 'out-for-delivery')
                <table class="w-100 border-collapse text-center" style="table-layout: fixed;">
                    <thead class="text-center">
                        <tr>
                            <th class="p-2">Transaction Number</th>
                            <th class="p-2">Customer Name</th>
                            <th class="p-2">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $transaction)
                            <tr class="text-center border-b">
                                <td class="p-2">{{ $transaction->transaction_id }}</td>
                                <td class="p-2">{{ $transaction->mscustomer->full_name }}</td>
                                <td class="p-2">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center">No pending orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $data->links() }}
            
            @elseif($status === 'shipped')
                <table class="w-100 border-collapse text-center" style="table-layout: fixed;">
                    <thead class="text-center">
                        <tr>
                            <th class="p-2">Transaction Number</th>
                            <th class="p-2">Customer Name</th>
                            <th class="p-2">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $transaction)
                            <tr class="text-center border-b">
                                <td class="p-2">{{ $transaction->transaction_id }}</td>
                                <td class="p-2">{{ $transaction->mscustomer->full_name }}</td>
                                <td class="p-2">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center">No pending orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $data->links() }}
            
            @elseif($status === 'completed')
                <table class="w-100 border-collapse text-center" style="table-layout: fixed;">
                    <thead class="text-center">
                        <tr>
                            <th class="p-2">Transaction Number</th>
                            <th class="p-2">Customer Name</th>
                            <th class="p-2">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $transaction)
                            <tr class="text-center border-b">
                                <td class="p-2">{{ $transaction->transaction_id }}</td>
                                <td class="p-2">{{ $transaction->mscustomer->full_name }}</td>
                                <td class="p-2">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center">No pending orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $data->links() }}
            
            @elseif($status === 'cancelled')
                <table class="w-100 border-collapse text-center" style="table-layout: fixed;">
                    <thead class="text-center">
                        <tr>
                            <th class="p-2">Transaction Number</th>
                            <th class="p-2">Customer Name</th>
                            <th class="p-2">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $transaction)
                            <tr class="text-center border-b">
                                <td class="p-2">{{ $transaction->transaction_id }}</td>
                                <td class="p-2">{{ $transaction->mscustomer->full_name }}</td>
                                <td class="p-2">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center">No pending orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $data->links() }}

            @endif
        </div>
        
       
    </div>
@endsection