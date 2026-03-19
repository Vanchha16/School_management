<section>
    <form method="post" action="{{ route('password.update') }}" class="row g-3">
        @csrf
        @method('put')

        <div class="col-12">
            <label for="update_password_current_password" class="form-label fw-semibold">{{ __('app.Current Password') }}</label>
            <div class="position-relative">
                <input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    class="form-control pe-5"
                    autocomplete="current-password">
                <button
                    type="button"
                    class="btn border-0 bg-transparent position-absolute top-50 end-0 translate-middle-y me-2 p-0"
                    onclick="togglePassword('update_password_current_password', 'eyeIconCurrent')">
                    <i id="eyeIconCurrent" class="bi bi-eye"></i>
                </button>
            </div>
            @if ($errors->updatePassword->get('current_password'))
                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="col-12">
            <label for="update_password_password" class="form-label fw-semibold">{{ __('app.New Password') }}</label>
            <div class="position-relative">
                <input
                    id="update_password_password"
                    name="password"
                    type="password"
                    class="form-control pe-5"
                    autocomplete="new-password">
                <button
                    type="button"
                    class="btn border-0 bg-transparent position-absolute top-50 end-0 translate-middle-y me-2 p-0"
                    onclick="togglePassword('update_password_password', 'eyeIconNew')">
                    <i id="eyeIconNew" class="bi bi-eye"></i>
                </button>
            </div>
            @if ($errors->updatePassword->get('password'))
                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="col-12">
            <label for="update_password_password_confirmation" class="form-label fw-semibold">{{ __('app.Confirm Password') }}</label>
            <div class="position-relative">
                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="form-control pe-5"
                    autocomplete="new-password">
                <button
                    type="button"
                    class="btn border-0 bg-transparent position-absolute top-50 end-0 translate-middle-y me-2 p-0"
                    onclick="togglePassword('update_password_password_confirmation', 'eyeIconConfirm')">
                    <i id="eyeIconConfirm" class="bi bi-eye"></i>
                </button>
            </div>
            @if ($errors->updatePassword->get('password_confirmation'))
                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="col-12 d-flex align-items-center gap-3 pt-2">
            <button type="submit" class="btn btn-dark rounded-pill px-4">{{ __('app.Update Password') }}</button>

            @if (session('status') === 'password-updated')
                <span class="text-success small">{{ __('app.Password updated.') }}</span>
            @endif
        </div>
    </form>
</section>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>