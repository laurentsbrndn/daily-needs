@extends ('courier-sidebar.index')

@section('container')

<div class="content">
    <div class="container-header">
        <i class="bi bi-arrow-left-circle"></i>
        <h2>Edit Profile</h2>
    </div>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="/courier/myprofile/update" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <div id="profile-pic">
                    <div class="form-wrapper">
                        @if(auth('courier')->user()->courier_photo)
                            <img src="{{ asset('storage/courier_photos/' . auth('courier')->user()->courier_photo) }}" alt="Profile Photo" width="100" id="profile-image">
                        @else
                            <img src="{{ asset('path/to/default-icon.png') }}" alt="Default Profile" width="100" id="profile-image">
                        @endif
                        <input type="file" name="courier_photo" class="form-control-file" id="profile-photo" style="display: none;" onchange="previewImage(event)">
                        <label for="profile-photo" class="pen-icon-label">
                            <i class="bi bi-pencil-square"></i>
                        </label>
                    </div>
                </div>
            </div>

            <!-- First Name -->
            <div class="form-group">
                <label>First Name</label>
                <div class="form-wrapper">
                    <input type="text" name="courier_first_name" class="form-control @error('courier_first_name') is-invalid @enderror" value="{{ old('courier_first_name', $couriers->courier_first_name) }}" id="first-name-input" oninput="hidePenIcon('first-name-icon')">
                    <i class="bi bi-pen edit-icon" id="first-name-icon"></i>
                    @error('courier_first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label>Last Name</label>
                <div class="form-wrapper">
                    <input type="text" name="courier_last_name" class="form-control @error('courier_last_name') is-invalid @enderror" value="{{ old('courier_last_name', $couriers->courier_last_name) }}" id="last-name-input" oninput="hidePenIcon('last-name-icon')">
                    <i class="bi bi-pen edit-icon" id="last-name-icon"></i>
                    @error('courier_last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label>Phone Number</label>
                <div class="form-wrapper">
                    <input type="text" name="courier_phone_number" class="form-control @error('courier_phone_number') is-invalid @enderror" value="{{ old('courier_phone_number', $couriers->courier_phone_number) }}" id="phone-number-input" oninput="hidePenIcon('phone-number-icon')">
                    <i class="bi bi-pen edit-icon" id="phone-number-icon"></i>
                    @error('courier_phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label>Address</label>
                <div class="form-wrapper">
                    <textarea name="courier_address" class="form-control @error('courier_address') is-invalid @enderror" id="address-input" oninput="hidePenIcon('address-icon')">{{ old('courier_address', $couriers->courier_address) }}</textarea>
                    <i class="bi bi-pen edit-icon" id="address-icon"></i>
                    @error('courier_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Password (Leave blank if you do not want to change it)</label>
                <div class="form-wrapper">
                    <input type="password" name="courier_password" class="form-control @error('courier_password') is-invalid @enderror" id="password-input" oninput="hidePenIcon('password-icon')">
                    <i class="bi bi-pen edit-icon" id="password-icon"></i>
                    @error('courier_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <input type="password" name="courier_password_confirmation" class="form-control @error('courier_password_confirmation') is-invalid @enderror" placeholder="Confirm Password" id="confirm-password-input" oninput="hidePenIcon('confirm-password-icon')">
                @error('courier_password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            
            <button type="submit" class="btn btn-success">Save Changes</button>
            

        </form>
    </div>
</div>

@endsection
