@extends('admin.layouts.master')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Hi, {{ old('name', $user->name) }}</h2>
            <p class="section-lead">
                Change information about yourself on this page.
            </p>

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Profile Information</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="form-group col-12">
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">Choose File</label>
                                            <input class="form-control" type="file" name="avatar" id="image-upload" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', $user->name) }}" required="">
                                        @if ($errors->has('name'))
                                            <code>{{ $errors->first('name') }}</code>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email', $user->email) }}" required="">
                                        @if ($errors->has('email'))
                                            <code>{{ $errors->first('email') }}</code>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Update Password</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('password.update') }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Current Password</label>
                                        <input type="password" class="form-control" name="current_password"
                                            autocomplete="current-password">
                                        @if ($errors->updatePassword->has('password'))
                                            <code>{{ $errors->updatePassword->first('password') }}</code>
                                        @endif
                                    </div>

                                    <div class="form-group col-12">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" name="password"
                                            autocomplete="new-password">
                                        @if ($errors->updatePassword->has('current_password'))
                                            <code>{{ $errors->updatePassword->first('current_password') }}</code>
                                        @endif
                                    </div>

                                    <div class="form-group col-12">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            autocomplete="new-password">
                                        @if ($errors->updatePassword->has('password_confirmation'))
                                            <code>{{ $errors->updatePassword->first('password_confirmation') }}</code>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            var imageUrl = '{{ Storage::url(auth()->user()->avatar) }}';
            console.log('Image URL:', imageUrl);
            $('.image-preview').css({
                'background-image': 'url(' + imageUrl + ')',
                'background-size': 'cover',
                'background-position': 'center center'
            });
        });
    </script>

    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('status') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
@endpush
