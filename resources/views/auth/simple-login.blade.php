<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg: #f8fafc;
            --card: rgba(255, 255, 255, 0.92);
            --text: #0f172a;
            --muted: #64748b;
            --border: #dbe2ea;
            --accent: #4f46e5;
            --accent-soft: rgba(79, 70, 229, 0.10);
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: "Inter", "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(99, 102, 241, 0.18), transparent 28%),
                radial-gradient(circle at bottom right, rgba(14, 165, 233, 0.10), transparent 24%),
                linear-gradient(135deg, #f8fafc, #eef2ff, #f8fafc);
        }

        .auth-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 620px;
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 28px;
            overflow: hidden;
            background: var(--card);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10);
        }

        .auth-body {
            padding: 42px 36px 46px;
        }

        .small-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #eef2ff;
            color: #4338ca;
            border: 1px solid #e0e7ff;
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .logo-img {
            width: 78px;
            height: 78px;
            object-fit: cover;
            border-radius: 18px;
            border: 4px solid #fff;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.08);
            margin-bottom: 16px;
        }

        .form-title {
            font-size: 2.35rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
            line-height: 1.1;
        }

        .form-subtitle {
            color: var(--muted);
            font-size: 1rem;
            margin-bottom: 28px;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            font-size: 0.98rem;
        }

        .input-wrap {
            position: relative;
            margin-bottom: 20px;
        }

        .input-wrap .left-icon {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            z-index: 3;
        }

        .input-wrap .toggle-password {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #64748b;
            font-size: 1rem;
            z-index: 3;
            cursor: pointer;
            padding: 4px;
        }

        .form-control {
            height: 58px;
            border-radius: 17px;
            border: 1.5px solid var(--border);
            padding-left: 48px;
            padding-right: 48px;
            font-size: 1rem;
            box-shadow: none !important;
            transition: all 0.2s ease;
            background: rgba(241, 245, 249, 0.95);
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px var(--accent-soft) !important;
            background: #fff;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .meta-link {
            color: var(--accent);
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 600;
        }

        .meta-link:hover {
            text-decoration: underline;
        }

        .muted-text {
            color: var(--muted);
            font-size: 0.92rem;
        }

        .btn-login {
            height: 58px;
            border: none;
            border-radius: 17px;
            background: linear-gradient(135deg, #0f172a, #334155);
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.22s ease;
            box-shadow: 0 10px 18px rgba(15, 23, 42, 0.12);
        }

        .btn-login:hover {
            transform: translateY(-1px);
            opacity: 0.98;
        }

        .bottom-note {
            margin-top: 22px;
            text-align: center;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .alert {
            border-radius: 14px;
            font-size: 0.95rem;
        }

        @media (max-width: 768px) {
            .auth-card {
                border-radius: 22px;
            }

            .auth-body {
                padding: 28px 20px 32px;
            }

            .form-title {
                font-size: 1.9rem;
            }

            .form-subtitle {
                font-size: 0.95rem;
            }

            .form-control,
            .btn-login {
                height: 54px;
                border-radius: 15px;
            }

            .logo-img {
                width: 72px;
                height: 72px;
            }
        }
    </style>
</head>

<body>
    <div class="container auth-section">
        <div class="auth-card">
            <div class="auth-body">

                <div class="mb-2">
                    <img src="{{ asset('assets/img/photo_2024-05-27_08-46-50.jpg') }}" alt="logo" class="logo-img">
                </div>

                <div class="form-title">IT Room</div>
                <div class="form-subtitle">Please sign in to access the System </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Username or Email</label>
                        <div class="input-wrap">
                            <i class="bi bi-person left-icon"></i>
                            <input
                                type="text"
                                name="login"
                                class="form-control"
                                placeholder="Enter username or email"
                                value="{{ old('login') }}"
                                required
                                autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock left-icon"></i>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Enter your password"
                                required>
                            <button type="button" class="toggle-password" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="meta-row">
                        {{-- <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label muted-text" for="remember">
                                Remember me
                            </label>
                        </div> --}}

                        <a href="https://t.me/ChulChivorn" target="_bank" class="meta-link">Forgot password? Contact Admin!!</a>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login to Dashboard
                    </button>
                </form>

                {{-- <div class="bottom-note">
                    Protected admin access with secure session handling
                </div> --}}
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            this.innerHTML = type === 'password'
                ? '<i class="bi bi-eye"></i>'
                : '<i class="bi bi-eye-slash"></i>';
        });
    </script>
</body>

</html>