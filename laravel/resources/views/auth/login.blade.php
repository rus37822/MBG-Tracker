<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#edf8ff">
        <title>{{ ($adminLogin ?? false) ? 'Masuk Admin' : 'Masuk Petugas' }} - MBG Tracker</title>
        <style>
            :root {
                color-scheme: light;
                --bg-1: #edf8ff;
                --bg-2: #f9fcff;
                --panel: rgba(255,255,255,0.88);
                --text: #15324d;
                --muted: #526a82;
                --line: rgba(47,126,209,0.14);
                --primary: #2f7ed1;
                --input-bg: rgba(245,250,255,0.96);
                --error: #b42318;
                --focus: rgba(47,126,209,0.2);
            }

            :root[data-theme="dark"] {
                color-scheme: dark;
                --bg-1: #07141d;
                --bg-2: #0d1d2b;
                --panel: rgba(15,23,34,0.9);
                --text: #edf8ff;
                --muted: #bfd6ef;
                --line: rgba(154,215,255,0.16);
                --primary: #9ad7ff;
                --input-bg: #112433;
                --error: #ffaaa3;
                --focus: rgba(154,215,255,0.22);
            }

            * { box-sizing: border-box; }

            body {
                display: grid;
                min-height: 100vh;
                margin: 0;
                padding: 28px 18px;
                place-items: center;
                overflow-x: hidden;
                background:
                    radial-gradient(circle at 12% 12%, rgba(142,202,252,0.42), transparent 28%),
                    radial-gradient(circle at 88% 86%, rgba(168,215,255,0.28), transparent 30%),
                    linear-gradient(135deg, var(--bg-1), var(--bg-2) 70%);
                color: var(--text);
                font-family: "Segoe UI", Arial, sans-serif;
            }

            .login-shell {
                width: min(100%, 460px);
            }

            .brand {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 13px;
                margin-bottom: 22px;
                text-align: left;
            }

            .brand img {
                width: 58px;
                height: 58px;
                padding: 4px;
                border: 1px solid var(--line);
                border-radius: 16px;
                background: #fff;
                box-shadow: 0 10px 24px rgba(47,126,209,0.12);
                object-fit: contain;
            }

            .brand strong {
                display: block;
                font-size: 1.05rem;
                letter-spacing: 0.02em;
            }

            .brand span {
                display: block;
                margin-top: 4px;
                color: var(--muted);
                font-size: 0.82rem;
            }

            .card {
                padding: clamp(24px, 6vw, 38px);
                border: 1px solid var(--line);
                border-radius: 26px;
                background: var(--panel);
                box-shadow: 0 24px 60px rgba(39,84,138,0.14);
                backdrop-filter: blur(12px);
            }

            .eyebrow {
                margin: 0 0 9px;
                color: var(--primary);
                font-size: 0.74rem;
                font-weight: 800;
                letter-spacing: 0.12em;
                text-transform: uppercase;
            }

            h1 {
                margin: 0;
                font-size: clamp(1.7rem, 6vw, 2.2rem);
                letter-spacing: -0.045em;
            }

            .intro {
                margin: 10px 0 26px;
                color: var(--muted);
                font-size: 0.94rem;
                line-height: 1.6;
            }

            .field {
                margin-bottom: 18px;
            }

            label {
                display: block;
                margin-bottom: 8px;
                font-size: 0.86rem;
                font-weight: 700;
            }

            input[type="email"],
            input[type="password"] {
                width: 100%;
                min-height: 50px;
                padding: 12px 14px;
                border: 1px solid var(--line);
                border-radius: 13px;
                outline: none;
                background: var(--input-bg);
                color: var(--text);
                font: inherit;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }

            input:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 4px var(--focus);
            }

            .error {
                margin: 7px 0 0;
                color: var(--error);
                font-size: 0.82rem;
            }

            .remember {
                display: inline-flex;
                align-items: center;
                gap: 9px;
                margin: 0 0 22px;
                color: var(--muted);
                font-size: 0.86rem;
                cursor: pointer;
            }

            .remember input {
                width: 16px;
                height: 16px;
                accent-color: var(--primary);
            }

            .submit {
                display: flex;
                width: 100%;
                min-height: 50px;
                align-items: center;
                justify-content: center;
                border: 0;
                border-radius: 14px;
                background: linear-gradient(135deg, #2f7ed1, #7ec8ff);
                box-shadow: 0 12px 24px rgba(47,126,209,0.2);
                color: #fff;
                font: inherit;
                font-weight: 800;
                cursor: pointer;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .submit:hover {
                transform: translateY(-1px);
                box-shadow: 0 16px 28px rgba(47,126,209,0.26);
            }

            :root[data-theme="dark"] .submit {
                background: linear-gradient(135deg, #dff3ff, #9ad7ff);
                color: #0f2341;
            }

            .footer {
                margin: 22px 0 0;
                color: var(--muted);
                font-size: 0.78rem;
                text-align: center;
            }

            .register-link {
                display: block;
                margin-top: 20px;
                color: var(--primary);
                font-size: 0.9rem;
                font-weight: 700;
                text-align: center;
                text-decoration: none;
            }

            .register-link:hover {
                text-decoration: underline;
            }

            .admin-login-link {
                display: block;
                width: fit-content;
                margin: 20px auto 0;
                color: var(--muted);
                font-size: 0.74rem;
                opacity: 0.68;
                text-decoration: none;
            }

            .admin-login-link:hover,
            .admin-login-link:focus-visible {
                color: var(--primary);
                opacity: 1;
                text-decoration: underline;
            }

            .status {
                margin: 0 0 18px;
                color: var(--primary);
                font-size: 0.9rem;
            }

            @media (prefers-reduced-motion: reduce) {
                *, *::before, *::after {
                    scroll-behavior: auto !important;
                    transition-duration: 0.01ms !important;
                }
            }
        </style>
        <script>
            const storedTheme = localStorage.getItem('mbg-theme');
            const prefersDarkTheme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.setAttribute('data-theme', storedTheme || (prefersDarkTheme ? 'dark' : 'light'));
        </script>
    </head>
    <body>
        <main class="login-shell">
            <div class="brand">
                <img src="{{ asset('jpg.foto/logo.jpg.png') }}" alt="Logo MBG">
                <div>
                    <strong>MBG Tracker</strong>
                    <span>Program Makan Bergizi Gratis</span>
                </div>
            </div>

            <section class="card" aria-labelledby="login-title">
                <p class="eyebrow">{{ ($adminLogin ?? false) ? 'Area Admin' : 'Area Petugas' }}</p>
                <h1 id="login-title">{{ ($adminLogin ?? false) ? 'Masuk admin' : 'Selamat datang' }}</h1>
                <p class="intro">{{ ($adminLogin ?? false) ? 'Masuk dengan akun admin untuk mengelola akun pengguna.' : 'Masuk untuk mengelola pencatatan dan distribusi MBG.' }}</p>

                @if (session('status'))
                    <p class="status" role="status">{{ session('status') }}</p>
                @endif

                <form method="POST" action="{{ ($adminLogin ?? false) ? route('admin.login.store') : route('login.store') }}">
                    @csrf
                    <div class="field">
                        <label for="email">{{ ($adminLogin ?? false) ? 'Email admin' : 'Email petugas' }}</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            autocomplete="username"
                            required
                            autofocus
                            @error('email') aria-describedby="email-error" @enderror
                        >
                        @error('email')
                            <p class="error" id="email-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password">Kata sandi</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                        >
                        @error('password')
                            <p class="error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="remember">
                        <input type="checkbox" name="remember" value="1">
                        <span>Ingat saya di perangkat ini</span>
                    </label>

                    <button class="submit" type="submit">{{ ($adminLogin ?? false) ? 'Masuk ke dashboard admin' : 'Masuk ke dashboard' }}</button>
                </form>

                @if ($adminLogin ?? false)
                    <a class="register-link" href="{{ route('login') }}">Masuk sebagai petugas</a>
                @else
                    <a class="register-link" href="{{ route('register') }}">Belum punya akun? Daftar</a>
                @endif
            </section>

            <p class="footer">Khusus petugas pendataan MBG</p>
            @unless ($adminLogin ?? false)
                <a class="admin-login-link" href="{{ route('admin.login') }}">Masuk admin</a>
            @endunless
        </main>
    </body>
</html>
