@extends ('layouts.dashboardmain')

@section('container')

    <div class="content">
        <h2>Top Up</h2>
    
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div>
            <h3>Balance</h3>
            <h2>{{ $customers->customer_balance }}</h2>
        </div>

        <form action="/dashboard/topup/update" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Top Up Amount</label>
                <input type="number" name="customer_balance" class="form-control @error('customer_balance') is-invalid @enderror" value="{{ old('customer_balance')}}">
                @error('customer_balance')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <input type="text" name="payment_method" class="payment_method form-control" value="Bank Transfer" disabled>
            </div>

            <button type="submit" class="btn btn-success">Top Up</button>
        </form>
    </div>
@endsection