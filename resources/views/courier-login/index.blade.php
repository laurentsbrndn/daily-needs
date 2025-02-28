@extends('courier-layouts.main')

@section('container')

@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

        </button>
    </div>
@endif

@if(session()->has('loginError'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('loginError') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

        </button>
    </div>
@endif

<div>
    <h1>Login</h1>
</div>

<form action="/courier/login" method="post">
    @csrf

    <div>
        <div>
            <p class="signup">Don't have any account? <a href="/courier/signup">Sign Up</a></p>
        </div>
        <div>    
            <label for="courier_email">Email</label>
            <input type="email" name="courier_email" id="courier_email" class="form-control @error('courier_email') is-invalid @enderror" placeholder="Enter your email" value="{{ old('courier_email') }}" autofocus required>
            @error('courier_email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    
        <div>
            <label for="courier_password">Password</label>
            <input type="password" name="courier_password" id="courier_password" class="form-control @error('courier_password') is-invalid @enderror" placeholder="Enter your password" required>
        </div>
    </div>
    
    <div>
        <button type="submit">Login</button>
    </div>

</form>


@endsection
