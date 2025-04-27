@extends ('layouts.dashboardmain')
<link rel="stylesheet" type="text/css" href="{{ asset('css/topup.css') }}">

@section('container')

    <div class="content">
        <div class="wallet-bg">
            <h2>Top Up</h2> <!-- Pindah ke dalam wallet-bg -->
        </div>

        <div class="wrapper">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <h3>Balance</h3>
            <h2> Rp {{ number_format($customers->customer_balance, 0, ',', '.') }}</h2>

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
                    <select name="payment_method" id="payment_method" class="payment_method form-control">
                        <option value="" disabled selected>Pilih Metode Pembayaran...</option>
                        @foreach ($paymentMethods as $payment)
                            <option value="{{ $payment->payment_method_id }}">{{ $payment->payment_name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-success">Top Up</button>
            </form>
        </div>
    </div>

   
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let payment = document.getElementById("payment_method");
        payment.selectedIndex = 0;

        payment.addEventListener("change", function () {
            let firstOption = this.querySelector("option[value='']");
            
            if (this.selectedIndex !== 0) {
                firstOption.remove();
            }
        });
    });
</script>


@endsection