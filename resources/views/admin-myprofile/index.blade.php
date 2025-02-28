@extends ('admin-sidebar.index')

@section('container')

    <div class="content">
        <h2>Edit Profile</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="/admin/myprofile/update" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Profile Photo</label>
                <input type="file" name="admin_photo" class="form-control">
                @if(auth('admin')->user()->admin_photo)
                    <img src="{{ asset('storage/admin_photos/' . auth('admin')->user()->admin_photo) }}" alt="Profile Photo" width="100">
                @endif
            </div>

            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="admin_first_name" class="form-control @error('admin_first_name') is-invalid @enderror" value="{{ old('admin_first_name', $admins->admin_first_name) }}">
                @error('admin_first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="admin_last_name" class="form-control @error('admin_last_name') is-invalid @enderror" value="{{ old('admin_last_name', $admins->admin_last_name) }}">
                @error('admin_last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="admin_phone_number" class="form-control @error('admin_phone_number') is-invalid @enderror" value="{{ old('admin_phone_number', $admins->admin_phone_number) }}">
                @error('admin_phone_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="admin_address" class="form-control @error('admin_address') is-invalid @enderror">{{ old('admin_address', $admins->admin_address)}}</textarea>
                @error('admin_address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Password (Leave blank if you do not want to change it)</label>
                <input type="password" name="admin_password" class="form-control @error('admin_password') is-invalid @enderror">
                @error('admin_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <input type="password" name="admin_password_confirmation" class="form-control @error('admin_password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
                @error('admin_password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
    </div>

@endsection