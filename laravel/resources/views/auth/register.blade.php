<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#edf8ff">
        <title>Daftar Petugas - MBG Tracker</title>
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

            .register-shell { width: min(100%, 460px); }

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

            .brand strong { display: block; font-size: 1.05rem; letter-spacing: 0.02em; }
            .brand span { display: block; margin-top: 4px; color: var(--muted); font-size: 0.82rem; }

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

            h1 { margin: 0; font-size: clamp(1.7rem, 6vw, 2.2rem); letter-spacing: -0.045em; }
            .intro { margin: 10px 0 26px; color: var(--muted); font-size: 0.94rem; line-height: 1.6; }
            .field { margin-bottom: 18px; }

            label {
                display: block;
                margin-bottom: 8px;
                font-size: 0.86rem;
                font-weight: 700;
            }

            input {
                width: 100%;
                min-height: 50px;
                padding: 12px 14px;
                border: 1px solid var(--line);
                border-radius: 13px;
                outline: none;
                background: var(--input-bg);
                color: var(--text);
                font: inherit;
            }

            input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px var(--focus); }
            .error { margin: 7px 0 0; color: var(--error); font-size: 0.82rem; }

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
            }

            :root[data-theme="dark"] .submit {
                background: linear-gradient(135deg, #dff3ff, #9ad7ff);
                color: #0f2341;
            }

            .login-link {
                display: block;
                margin-top: 20px;
                color: var(--primary);
                font-size: 0.9rem;
                font-weight: 700;
                text-align: center;
                text-decoration: none;
            }

            .login-link:hover { text-decoration: underline; }

            @media (prefers-reduced-motion: reduce) {
                *, *::before, *::after { scroll-behavior: auto !important; transition-duration: 0.01ms !important; }
            }
        </style>
        <script>
            const storedTheme = localStorage.getItem('mbg-theme');
            const prefersDarkTheme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.setAttribute('data-theme', storedTheme || (prefersDarkTheme ? 'dark' : 'light'));
        </script>
    </head>
    <body>
        <main class="register-shell">
            <div class="brand">
                <img src="{{ asset('jpg.foto/logo.jpg.png') }}" alt="Logo MBG">
                <div>
                    <strong>MBG Tracker</strong>
                    <span>Program Makan Bergizi Gratis</span>
                </div>
            </div>

            <section class="card" aria-labelledby="register-title">
                <p class="eyebrow">Area Petugas</p>
                <h1 id="register-title">Buat akun</h1>
                <p class="intro">Daftar untuk mulai mengelola pencatatan dan distribusi MBG.</p>

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <div class="field">
                        <label for="name">Nama lengkap</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            required
                            autofocus
                            @error('name') aria-describedby="name-error" @enderror
                        >
                        @error('name')
                            <p class="error" id="name-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                            @error('email') aria-describedby="email-error" @enderror
                        >
                        @error('email')
                            <p class="error" id="email-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password">Kata sandi (minimal 8 karakter)</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                            @error('password') aria-describedby="password-error" @enderror
                        >
                        @error('password')
                            <p class="error" id="password-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Konfirmasi kata sandi</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                        >
                    </div>

                    <button class="submit" type="submit">Daftar</button>
                </form>

                <a class="login-link" href="{{ route('login') }}">Sudah punya akun? Masuk</a>
            </section>
        </main>
    </body>
</html>
