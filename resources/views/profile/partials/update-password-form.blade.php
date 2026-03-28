<section id="password-section">
    <form id="passwordUpdateForm" method="post" action="{{ route('password.update') }}" class="row g-3">
        @csrf
        @method('put')

        <div class="col-12">
            <label for="update_password_current_password"
                class="form-label fw-semibold">{{ __('app.Current Password') }}</label>
            <div class="position-relative">
                <input id="update_password_current_password" name="current_password" type="password"
                    class="form-control pe-5" autocomplete="current-password">
                <button type="button"
                    class="btn border-0 bg-transparent position-absolute top-50 end-0 translate-middle-y me-2 p-0"
                    onclick="togglePassword('update_password_current_password', 'eyeIconCurrent')">
                    <i id="eyeIconCurrent" class="bi bi-eye"></i>
                </button>
            </div>
            <div class="text-danger small mt-1" id="error-current_password"></div>
        </div>

        <div class="col-12">
            <label for="update_password_password" class="form-label fw-semibold">{{ __('app.New Password') }}</label>
            <div class="position-relative">
                <input id="update_password_password" name="password" type="password" class="form-control pe-5"
                    autocomplete="new-password">
                <button type="button"
                    class="btn border-0 bg-transparent position-absolute top-50 end-0 translate-middle-y me-2 p-0"
                    onclick="togglePassword('update_password_password', 'eyeIconNew')">
                    <i id="eyeIconNew" class="bi bi-eye"></i>
                </button>
            </div>

            {{-- <div id="password-rules" class="small mt-2">
                <div id="rule-length" class="text-danger">✗ At least 8 characters</div>
                <div id="rule-uppercase" class="text-danger">✗ At least 1 uppercase letter</div>
                <div id="rule-lowercase" class="text-danger">✗ At least 1 lowercase letter</div>
                <div id="rule-number" class="text-danger">✗ At least 1 number</div>
                <div id="rule-special" class="text-danger">✗ At least 1 special character</div>
            </div> --}}

            <div class="text-danger small mt-1" id="error-password"></div>
        </div>

        <div class="col-12">
            <label for="update_password_password_confirmation"
                class="form-label fw-semibold">{{ __('app.Confirm Password') }}</label>
            <div class="position-relative">
                <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="form-control pe-5" autocomplete="new-password">
                <button type="button"
                    class="btn border-0 bg-transparent position-absolute top-50 end-0 translate-middle-y me-2 p-0"
                    onclick="togglePassword('update_password_password_confirmation', 'eyeIconConfirm')">
                    <i id="eyeIconConfirm" class="bi bi-eye"></i>
                </button>
            </div>

            <div id="confirm-message" class="small mt-2"></div>
            <div class="text-danger small mt-1" id="error-password_confirmation"></div>
        </div>

        <div class="col-12 d-flex align-items-center gap-3 pt-2">
            <button type="submit" id="submitBtn" class="btn btn-dark rounded-pill px-4">
                {{ __('app.Update Password') }}
            </button>
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

    const form = document.getElementById('passwordUpdateForm');
    const passwordInput = document.getElementById('update_password_password');
    const confirmInput = document.getElementById('update_password_password_confirmation');
    const currentPasswordInput = document.getElementById('update_password_current_password');
    const submitBtn = document.getElementById('submitBtn');
    const confirmMessage = document.getElementById('confirm-message');

    function validatePassword() {
        const password = passwordInput.value;

        if (password.length === 0) {
            document.getElementById('error-password').textContent = '';
            return false;
        }

        if (password.length < 8) {
            document.getElementById('error-password').textContent = 'Password must be at least 8 characters.';
            return false;
        }

        document.getElementById('error-password').textContent = '';
        return true;
    }

    function validateConfirmPassword() {
        const password = passwordInput.value;
        const confirmPassword = confirmInput.value;

        if (confirmPassword === '') {
            confirmMessage.textContent = '';
            confirmMessage.classList.remove('text-success', 'text-danger');
            return false;
        }

        if (password === confirmPassword) {
            confirmMessage.textContent = '✓ Passwords match';
            confirmMessage.classList.remove('text-danger');
            confirmMessage.classList.add('text-success');
            return true;
        } else {
            confirmMessage.textContent = '✗ Passwords do not match';
            confirmMessage.classList.remove('text-success');
            confirmMessage.classList.add('text-danger');
            return false;
        }
    }

    function toggleSubmitButton() {
        const isPasswordValid = validatePassword();
        const isConfirmValid = validateConfirmPassword();
        submitBtn.disabled = !(isPasswordValid && isConfirmValid);
    }

    function clearErrors() {
        document.getElementById('error-current_password').textContent = '';
        document.getElementById('error-password').textContent = '';
        document.getElementById('error-password_confirmation').textContent = '';
    }

    currentPasswordInput.addEventListener('input', toggleSubmitButton);
    passwordInput.addEventListener('input', toggleSubmitButton);
    confirmInput.addEventListener('input', toggleSubmitButton);

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        clearErrors();
        submitBtn.disabled = true;

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: formData
            });

            let data = {};
            const contentType = response.headers.get('content-type') || '';

            if (contentType.includes('application/json')) {
                data = await response.json();
            } else {
                const text = await response.text();
                console.log('Non-JSON response:', text);
            }

            if (response.ok) {
                alert(data.message || 'Password updated successfully.');

                form.reset();
                confirmMessage.textContent = '';
                confirmMessage.classList.remove('text-success', 'text-danger');
                clearErrors();
            } else if (response.status === 422) {
                const errors = data.errors || {};

                if (errors.current_password) {
                    document.getElementById('error-current_password').textContent = errors.current_password[0];
                }
                if (errors.password) {
                    document.getElementById('error-password').textContent = errors.password[0];
                }
                if (errors.password_confirmation) {
                    document.getElementById('error-password_confirmation').textContent = errors.password_confirmation[0];
                }
            } else {
                alert(data.message || 'Update failed.');
            }
        } catch (error) {
            console.error(error);
            document.getElementById('error-password').textContent = 'Something went wrong. Please try again.';
        }

        toggleSubmitButton();
    });

    toggleSubmitButton();
</script>