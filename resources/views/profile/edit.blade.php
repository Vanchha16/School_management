@extends('backend.layout.master')

@section('title', 'Profile')

@section('contents')
    <div class="container-fluid py-4">
        @php
            $user = Auth::user();
            $profilePhoto = !empty($user?->photo) ? asset('storage/' . $user->photo) : null;
            $userInitial = strtoupper(substr($user->name ?? 'A', 0, 1));
        @endphp

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-0">
                <div class="p-3 p-md-4 text-white rounded-4"
                    style="background: linear-gradient(135deg, #111827 0%, #1f2937 45%, #4338ca 100%);">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            @if ($profilePhoto)
                                <img src="{{ $profilePhoto }}" alt="Profile Photo"
                                    class="rounded-circle border border-white shadow-sm"
                                    style="width:72px; height:72px; object-fit:cover;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase shadow-sm"
                                    style="width:72px; height:72px; background: rgba(255,255,255,0.18); font-size: 28px;">
                                    {{ $userInitial }}
                                </div>
                            @endif

                            <div>
                                <h2 class="fw-bold mb-1 text-white">{{ __('app.my_profile') }}</h2>
                                <div class="text-white-50 mb-1">
                                    Manage your account information and password
                                </div>
                                <div class="small text-white-50">
                                    {{ $user->email ?? '' }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4">
                                <i class="bi bi-arrow-left me-1"></i> {{ __('app.back_to_dashboard') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/img/default-user.png') }}"
                                alt="User Photo" class="rounded-circle border shadow-sm"
                                style="width:96px; height:96px; object-fit:cover;">
                        </div>

                        <h4 class="fw-bold mb-1">{{ $user->name ?? 'Admin' }}</h4>
                        <div class="text-secondary mb-2">{{ $user->email ?? '' }}</div>

                        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                            Online
                        </span>

                        <hr class="my-4">

                        <div class="text-start">
                            <div class="mb-3">
                                <div class="text-secondary small">Role</div>
                                <div class="fw-semibold">Administrator</div>
                            </div>

                            <div class="mb-3">
                                <div class="text-secondary small">Joined</div>
                                <div class="fw-semibold">
                                    {{ $user->created_at ? $user->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') : '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-secondary small">Last Update</div>
                                <div class="fw-semibold">
                                    {{ $user->updated_at ? $user->updated_at->timezone('Asia/Jakarta')->format('d M Y H:i') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8">
                <div class="d-flex flex-column gap-4">

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <h4 class="fw-bold mb-1">{{ __('app.Profile Information') }}</h4>
                                <div class="text-secondary">{{ __('app.Update your account\'s profile information and email address.') }}
                                </div>
                            </div>

                            {{-- Profile info form --}}
                            <form method="POST" action="{{ route('profile.update') }}" class="row g-3">
                                @csrf
                                @method('PATCH')

                                <div class="col-12">
                                    <label for="name" class="form-label fw-semibold">{{ __('app.Name') }}</label>
                                    <input id="name" name="name" type="text" class="form-control"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="email" class="form-label fw-semibold">{{ __('app.Email') }}</label>
                                    <input id="email" name="email" type="email" class="form-control"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-dark">{{ __('app.Save') }}</button>
                                </div>
                            </form>

                            <hr class="my-4">

                            {{-- Photo form --}}
                            <div>
                                <label class="form-label fw-semibold">{{ __('app.Profile Photo') }}</label>

                                <div class="d-flex align-items-center gap-3 flex-wrap mb-3">
                                    @if ($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile"
                                            class="rounded-circle border"
                                            style="width:80px; height:80px; object-fit:cover;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase border"
                                            style="width:80px; height:80px; background:#e0e7ff; color:#3730a3; font-size:24px;">
                                            {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                @if (!$user->photo)
                                    <form method="POST" action="{{ route('profile.photo.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <input type="file" name="photo" class="form-control mb-2" accept="image/*">

                                        @error('photo')
                                            <div class="text-danger small mb-2">{{ $message }}</div>
                                        @enderror

                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('profile.photo.update') }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <input type="file" name="photo" class="form-control mb-2" accept="image/*">

                                        @error('photo')
                                            <div class="text-danger small mb-2">{{ $message }}</div>
                                        @enderror

                                        <button type="submit" class="btn btn-warning">Change Photo</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <h4 class="fw-bold mb-1">{{ __('app.Update Password') }}</h4>
                                <div class="text-secondary">{{ __('app.Use a strong password to keep your account secure.') }}</div>
                            </div>

                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    {{-- <div class="card border-0 shadow-sm rounded-4 border border-danger-subtle">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <h4 class="fw-bold text-danger mb-1">Delete Account</h4>
                                <div class="text-secondary">
                                    Permanently delete your account and all associated data.
                                </div>
                            </div>

                            @include('profile.partials.delete-user-form')
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>

    </div>
@endsection
