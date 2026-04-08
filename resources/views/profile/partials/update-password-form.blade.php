<style>
    .floating-alert-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 2000;
        display: flex;
        flex-direction: column;
        gap: 14px;
        max-width: 420px;
        width: calc(100% - 24px);
        pointer-events: none;
    }

    .floating-alert {
        background: #f3f4f6;
        border-radius: 22px;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.14);
        padding: 18px 18px 18px 22px;
        position: relative;
        overflow: hidden;
        border-left: 4px solid #22c55e;
        animation: slideInToast 0.25s ease;
        pointer-events: auto;
    }

    .floating-alert.success {
        border-left-color: #22c55e;
    }

    .floating-alert.error {
        border-left-color: #ef4444;
    }

    .floating-alert.success .floating-alert-title {
        color: #166534;
    }

    .floating-alert.error .floating-alert-title {
        color: #b91c1c;
    }

    .floating-alert-content {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .floating-alert-icon {
        font-size: 24px;
        line-height: 1;
        color: #111827;
        padding-top: 2px;
        font-weight: 700;
        min-width: 20px;
    }

    .floating-alert-body {
        flex: 1;
        min-width: 0;
    }

    .floating-alert-title {
        font-size: 14px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .floating-alert-message {
        font-size: 14px;
        color: #4b5563;
        line-height: 1.6;
        word-break: break-word;
    }

    .floating-alert-close {
        background: transparent;
        border: 0;
        color: #9ca3af;
        font-size: 20px;
        line-height: 1;
        padding: 0;
        cursor: pointer;
        margin-left: 8px;
        flex-shrink: 0;
    }

    .floating-alert-close:hover {
        color: #4b5563;
    }

    .small-text-error {
        font-size: 0.875rem;
    }

    @keyframes slideInToast {
        from {
            opacity: 0;
            transform: translateX(30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @media (max-width: 576px) {
        .floating-alert-container {
            top: 14px;
            right: 12px;
            left: 12px;
            max-width: none;
            width: auto;
        }
    }
</style>

<div id="floatingAlertContainer" class="floating-alert-container"></div>

<section id="password-section">
    <form id="passwordUpdateForm" method="post" action="{{ route('password.update') }}" class="row g-3">
        @csrf
        @method('put')

        <div class="col-12">
            <label for="update_password_current_password" class="form-label fw-semibold">
                {{ __('app.Current Password') }}
            </label>
            <div class="position-relative">
                <input id="update_password_current_password" name="current_password" type="password"
                    class="form-control pe-5" autocomplete="current-password">
                <button type="button"
                    class="btn border-0 bg-transparent position-absolute top-50 end-0 translate-middle-y me-2 p-0"
                    onclick="togglePassword('update_password_current_password', 'eyeIconCurrent')">
                    <i id="eyeIconCurrent" class="bi bi-eye-slash"></i>
                </button>
            </div>
            <div class="text-danger small-text-error mt-1" id="error-current_password"></div>
        </div>

        <div class="col-12">
            <label for="update_password_password" class="form-label fw-semibold">
                {{ __('app.New Password') }}
            </label>
            <div class="position-relative">
                <input id="update_password_password" name="password" type="password" class="form-control pe-5"
                    autocomplete="new-password">
                <button type="button"
                    class="btn border-0 bg-transparent position-absolute top-50 end-0 translate-middle-y me-2 p-0"
                    onclick="togglePassword('update_password_password', 'eyeIconNew')">
                    <i id="eyeIconNew" class="bi bi-eye-slash"></i>
                </button>
            </div>
            <div class="text-danger small-text-error mt-1" id="error-password"></div>
        </div>

        <div class="col-12">
            <label for="update_password_password_confirmation" class="form-label fw-semibold">
                {{ __('app.Confirm Password') }}
            </label>
            <div class="position-relative">
                <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="form-control pe-5" autocomplete="new-password">
                <button type="button"
                    class="btn border-0 bg-transparent position-absolute top-50 end-0 translate-middle-y me-2 p-0"
                    onclick="togglePassword('update_password_password_confirmation', 'eyeIconConfirm')">
                    <i id="eyeIconConfirm" class="bi bi-eye-slash"></i>
                </button>
            </div>

            <div id="confirm-message" class="small mt-2"></div>
            <div class="text-danger small-text-error mt-1" id="error-password_confirmation"></div>
        </div>

        <div class="col-12 d-flex align-items-center gap-3 pt-2">
            <button type="submit" id="submitBtn" class="btn btn-dark rounded-pill px-4">
                <span id="submitBtnText">{{ __('app.Update Password') }}</span>
            </button>
        </div>
    </form>
</section>

<script>
    function showFloatingAlert(message, type = 'success', title = null) {
    const container = document.getElementById('floatingAlertContainer');
    if (!container) return;

    const toastId = 'toast-' + Date.now();
    const finalTitle = title || (type === 'success' ? 'Success' : 'Error');
    const icon = type === 'success' ? '✓' : '!';

    const html = `
        <div class="floating-alert ${type}" id="${toastId}">
            <div class="floating-alert-content">
                <div class="floating-alert-icon">${icon}</div>
                <div class="floating-alert-body">
                    <div class="floating-alert-title">${finalTitle}</div>
                    <div class="floating-alert-message">${message}</div>
                </div>
                <button type="button" class="floating-alert-close" onclick="document.getElementById('${toastId}').remove()">
                    &times;
                </button>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);

    setTimeout(() => {
        const el = document.getElementById(toastId);
        if (el) el.remove();
    }, 4000);
}

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
    const submitBtnText = document.getElementById('submitBtnText');
    const confirmMessage = document.getElementById('confirm-message');

    function clearErrors() {
        document.getElementById('error-current_password').textContent = '';
        document.getElementById('error-password').textContent = '';
        document.getElementById('error-password_confirmation').textContent = '';
    }

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
        }

        confirmMessage.textContent = '✗ Passwords do not match';
        confirmMessage.classList.remove('text-success');
        confirmMessage.classList.add('text-danger');
        return false;
    }

    function toggleSubmitButton() {
        const isPasswordValid = validatePassword();
        const isConfirmValid = validateConfirmPassword();
        const hasCurrentPassword = currentPasswordInput.value.trim() !== '';

        submitBtn.disabled = !(isPasswordValid && isConfirmValid && hasCurrentPassword);
    }

    currentPasswordInput.addEventListener('input', toggleSubmitButton);
    passwordInput.addEventListener('input', toggleSubmitButton);
    confirmInput.addEventListener('input', toggleSubmitButton);

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        clearErrors();
        submitBtn.disabled = true;
        submitBtnText.textContent = 'Updating...';

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
                showFloatingAlert(data.message || 'Password updated successfully.', 'success', 'Success');

                form.reset();
                confirmMessage.textContent = '';
                confirmMessage.classList.remove('text-success', 'text-danger');
                clearErrors();
            } else if (response.status === 422) {
                const errors = data.errors || {};

                if (errors.current_password) {
                    document.getElementById('error-current_password').textContent = errors.current_password[
                        0];
                }

                if (errors.password) {
                    document.getElementById('error-password').textContent = errors.password[0];
                }

                if (errors.password_confirmation) {
                    document.getElementById('error-password_confirmation').textContent = errors
                        .password_confirmation[0];
                }

                const firstError =
                    errors.current_password?.[0] ||
                    errors.password?.[0] ||
                    errors.password_confirmation?.[0] ||
                    'Please check your input.';

                showFloatingAlert(firstError, 'error', 'Error');
            } else {
                showFloatingAlert(data.message || 'Update failed.', 'error', 'Error');
            }
        } catch (error) {
            console.error(error);
            showFloatingAlert('Something went wrong. Please try again.', 'error', 'Error');
        } finally {
            submitBtnText.textContent = 'Update Password';
            toggleSubmitButton();
        }
    });

    toggleSubmitButton();
</script>
