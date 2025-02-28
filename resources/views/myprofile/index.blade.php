@extends ('layouts.dashboardmain')

@section('container')

    <div class="content">
        <h2>Edit Profile</h2>
    
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    
        <form action="/dashboard/myprofile/update" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
    
            <div class="form-group">
                <label>Profile Photo</label>
                <input type="file" name="customer_photo" class="form-control">
                @if(auth('customer')->user()->customer_photo)
                    <img src="{{ asset('storage/customer_photos/' . auth('customer')->user()->customer_photo) }}" alt="Profile Photo" width="100">
                @endif
            </div>
    
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="customer_first_name" class="form-control @error('customer_first_name') is-invalid @enderror" value="{{ old('customer_first_name', $customers->customer_first_name) }}">
                @error('customer_first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="customer_last_name" class="form-control @error('customer_last_name') is-invalid @enderror" value="{{ old('customer_last_name', $customers->customer_last_name) }}">
                @error('customer_last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="customer_phone_number" class="form-control @error('customer_phone_number') is-invalid @enderror" value="{{ old('customer_phone_number', $customers->customer_phone_number) }}">
                @error('customer_phone_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="form-group">
                <label>Address</label>
                <textarea name="customer_address" class="form-control @error('customer_address') is-invalid @enderror">{{ old('customer_address', $customers->customer_address)}}</textarea>
                @error('customer_address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="form-group">
                <label>Password (Leave blank if you do not want to change it)</label>
                <input type="password" name="customer_password" class="form-control @error('customer_password') is-invalid @enderror">
                @error('customer_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <input type="password" name="customer_password_confirmation" class="form-control @error('customer_password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
                @error('customer_password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
    </div>

@endsection