@extends ('admin-sidebar.index')

@section('container')
    <div class="content">
        <h2 class="text-xl font-bold mb-4">Transaction History</h2>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        <table class="w-full border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2">Transaction Number</th>
                    <th class="p-2">Customer Name</th>
                    <th class="p-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr class="text-center border-b">
                        <td class="p-2">{{ $transaction->transaction_id }}</td>
                        <td class="p-2">{{ $transaction->mscustomer->full_name }}</td>
                        <td class="p-2">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td class="p-2">
                            {{-- <form action="{{ route('admin.confirmOrder', $transaction->transaction_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-yellow-400 px-4 py-1 rounded hover:bg-yellow-500">
                                    Confirm
                                </button>
                            </form> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center">No pending orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection