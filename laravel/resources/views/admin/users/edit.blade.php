<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#edf8ff">
        <title>Ubah Akun - MBG Tracker</title>
        <style>
            :root {
                color-scheme: light;
                --bg: #edf8ff;
                --panel: rgba(255,255,255,0.9);
                --text: #15324d;
                --muted: #526a82;
                --line: rgba(47,126,209,0.16);
                --primary: #2f7ed1;
                --error: #b42318;
            }

            :root[data-theme="dark"] {
                color-scheme: dark;
                --bg: #07141d;
                --panel: #102232;
                --text: #edf8ff;
                --muted: #bfd6ef;
                --line: rgba(154,215,255,0.18);
                --primary: #9ad7ff;
                --error: #ffaaa3;
            }

            * { box-sizing: border-box; }

            body {
                display: grid;
                min-height: 100vh;
                margin: 0;
                padding: 28px 18px;
                place-items: center;
                background: linear-gradient(135deg, var(--bg), #f9fcff);
                color: var(--text);
                font-family: "Segoe UI", Arial, sans-serif;
            }

            :root[data-theme="dark"] body { background: linear-gradient(135deg, var(--bg), #0d1d2b); }
            main { width: min(100%, 520px); }

            .panel {
                padding: clamp(22px, 5vw, 36px);
                border: 1px solid var(--line);
                border-radius: 22px;
                background: var(--panel);
                box-shadow: 0 18px 45px rgba(39,84,138,0.1);
            }

            h1 { margin: 0; font-size: 1.8rem; }
            .intro { margin: 8px 0 24px; color: var(--muted); }
            .field { margin-bottom: 18px; }

            label {
                display: block;
                margin-bottom: 8px;
                font-size: 0.88rem;
                font-weight: 700;
            }

            input {
                width: 100%;
                min-height: 48px;
                padding: 11px 13px;
                border: 1px solid var(--line);
                border-radius: 11px;
                outline: none;
                background: transparent;
                color: var(--text);
                font: inherit;
            }

            input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(47,126,209,0.14); }
            .hint { margin: 7px 0 0; color: var(--muted); font-size: 0.8rem; }
            .error { margin: 7px 0 0; color: var(--error); font-size: 0.82rem; }
            .buttons { display: flex; align-items: center; gap: 16px; margin-top: 24px; }

            .submit {
                min-height: 46px;
                padding: 10px 18px;
                border: 0;
                border-radius: 11px;
                background: linear-gradient(135deg, #2f7ed1, #7ec8ff);
                color: #fff;
                font: inherit;
                font-weight: 800;
                cursor: pointer;
            }

            :root[data-theme="dark"] .submit { color: #0f2341; }
            a { color: var(--muted); font-size: 0.88rem; text-decoration: none; }
            a:hover { color: var(--primary); text-decoration: underline; }
        </style>
        <script>
            const storedTheme = localStorage.getItem('mbg-theme');
            const prefersDarkTheme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.setAttribute('data-theme', storedTheme || (prefersDarkTheme ? 'dark' : 'light'));
        </script>
    </head>
    <body>
        <main>
            <section class="panel" aria-labelledby="edit-title">
                <h1 id="edit-title">Ubah akun</h1>
                <p class="intro">Perbarui informasi atau tetapkan kata sandi baru untuk {{ $user->name }}.</p>

                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label for="name">Nama</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" autocomplete="name" required>
                        @error('name')
                            <p class="error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" autocomplete="email" required>
                        @error('email')
                            <p class="error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password">Kata sandi baru</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" minlength="8">
                        <p class="hint">Kosongkan jika tidak ingin mengganti kata sandi.</p>
                        @error('password')
                            <p class="error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Konfirmasi kata sandi baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                    </div>

                    <div class="buttons">
                        <button class="submit" type="submit">Simpan perubahan</button>
                        <a href="{{ route('admin.users.index') }}">Batal</a>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>
