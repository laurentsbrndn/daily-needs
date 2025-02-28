@extends ('courier-sidebar.index')

@section('container')

    <div class="content">
        <h2>Edit Profile</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="/courier/myprofile/update" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Profile Photo</label>
                <input type="file" name="courier_photo" class="form-control">
                @if(auth('courier')->user()->courier_photo)
                    <img src="{{ asset('storage/courier_photos/' . auth('courier')->user()->courier_photo) }}" alt="Profile Photo" width="100">
                @endif
            </div>

            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="courier_first_name" class="form-control @error('courier_first_name') is-invalid @enderror" value="{{ old('courier_first_name', $couriers->courier_first_name) }}">
                @error('courier_first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="courier_last_name" class="form-control @error('courier_last_name') is-invalid @enderror" value="{{ old('courier_last_name', $couriers->courier_last_name) }}">
                @error('courier_last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="courier_phone_number" class="form-control @error('courier_phone_number') is-invalid @enderror" value="{{ old('courier_phone_number', $couriers->courier_phone_number) }}">
                @error('courier_phone_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="courier_address" class="form-control @error('courier_address') is-invalid @enderror">{{ old('courier_address', $couriers->courier_address)}}</textarea>
                @error('courier_address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Password (Leave blank if you do not want to change it)</label>
                <input type="password" name="courier_password" class="form-control @error('courier_password') is-invalid @enderror">
                @error('courier_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <input type="password" name="courier_password_confirmation" class="form-control @error('courier_password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
                @error('courier_password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
    </div>

@endsection