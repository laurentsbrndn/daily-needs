@extends('admin-layouts.main')

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

<form action="/admin/login" method="post">
    @csrf

    <div>
        <div>
            <p class="signup">Don't have any account? <a href="/admin/signup">Sign Up</a></p>
        </div>
        <div>    
            <label for="admin_email">Email</label>
            <input type="email" name="admin_email" id="admin_email" class="form-control @error('admin_email') is-invalid @enderror" placeholder="Enter your email" value="{{ old('admin_email') }}" autofocus required>
            @error('admin_email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    
        <div>
            <label for="admin_password">Password</label>
            <input type="password" name="admin_password" id="admin_password" class="form-control @error('admin_password') is-invalid @enderror" placeholder="Enter your password" required>
        </div>
    </div>
    
    <div>
        <button type="submit">Login</button>
    </div>

</form>


@endsection
