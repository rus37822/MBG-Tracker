<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#edf8ff">
        <title>Menu MBG Hari Ini - MBG Tracker</title>
        <style>
            :root {
                color-scheme: light;
                --bg: #edf8ff;
                --bg-soft: #f9fcff;
                --panel: rgba(255,255,255,0.86);
                --text: #15324d;
                --muted: #526a82;
                --line: rgba(47,126,209,0.16);
                --primary: #2f7ed1;
                --primary-dark: #1d5e9d;
                --soft-blue: rgba(47,126,209,0.08);
                --shadow: 0 24px 60px rgba(39,84,138,0.12);
            }

            :root[data-theme="dark"] {
                color-scheme: dark;
                --bg: #07141d;
                --bg-soft: #0d1d2b;
                --panel: rgba(16,34,50,0.9);
                --text: #edf8ff;
                --muted: #bfd6ef;
                --line: rgba(154,215,255,0.18);
                --primary: #9ad7ff;
                --primary-dark: #153d5e;
                --soft-blue: rgba(154,215,255,0.1);
                --shadow: 0 24px 60px rgba(2,7,12,0.36);
            }

            * { box-sizing: border-box; }

            html { min-width: 320px; scroll-behavior: smooth; }

            body {
                min-height: 100vh;
                margin: 0;
                padding: 22px 20px 130px;
                overflow-x: hidden;
                background:
                    radial-gradient(circle at 8% 0%, rgba(142,202,252,0.34), transparent 26%),
                    radial-gradient(circle at 96% 78%, rgba(168,215,255,0.22), transparent 28%),
                    linear-gradient(135deg, var(--bg), var(--bg-soft) 65%);
                color: var(--text);
                font-family: "Segoe UI", Arial, sans-serif;
            }

            :root[data-theme="dark"] body {
                background:
                    radial-gradient(circle at 8% 0%, rgba(34,91,133,0.24), transparent 28%),
                    radial-gradient(circle at 96% 78%, rgba(31,72,105,0.2), transparent 30%),
                    linear-gradient(135deg, var(--bg), var(--bg-soft) 65%);
            }

            .page { width: min(100%, 1120px); margin: 0 auto; }

            .topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 18px;
                margin-bottom: 24px;
                padding: 12px 16px;
                border: 1px solid var(--line);
                border-radius: 20px;
                background: var(--panel);
                box-shadow: 0 12px 32px rgba(39,84,138,0.07);
                backdrop-filter: blur(14px);
            }

            .brand { display: flex; min-width: 0; align-items: center; gap: 12px; }

            .brand img {
                width: 46px;
                height: 46px;
                padding: 4px;
                border: 1px solid var(--line);
                border-radius: 15px;
                background: #fff;
                object-fit: contain;
            }

            .brand-copy strong, .brand-copy span { display: block; }
            .brand-copy strong { font-size: 0.96rem; letter-spacing: -0.02em; }
            .brand-copy span { margin-top: 3px; color: var(--muted); font-size: 0.75rem; }
            .topbar-actions { display: flex; align-items: center; gap: 10px; }

            .theme-toggle,
            .login-link {
                display: inline-flex;
                min-height: 42px;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 9px 14px;
                border: 1px solid var(--line);
                border-radius: 12px;
                font: inherit;
                font-size: 0.82rem;
                font-weight: 750;
                text-decoration: none;
                cursor: pointer;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .theme-toggle {
                background: var(--soft-blue);
                color: var(--text);
            }

            .login-link {
                border-color: transparent;
                background: linear-gradient(135deg, #2f7ed1, #58a7ed);
                color: #fff;
                box-shadow: 0 8px 18px rgba(47,126,209,0.2);
            }

            :root[data-theme="dark"] .login-link { color: #0d263b; }
            .theme-toggle:hover, .login-link:hover { transform: translateY(-2px); box-shadow: 0 12px 22px rgba(47,126,209,0.18); }
            .theme-toggle svg, .login-link svg { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 1.8; }
            .theme-toggle:focus-visible, .login-link:focus-visible, .footer-login:focus-visible { outline: 3px solid rgba(47,126,209,0.34); outline-offset: 3px; }

            .hero {
                position: relative;
                display: grid;
                min-height: 290px;
                align-items: center;
                overflow: hidden;
                margin-bottom: 22px;
                padding: clamp(30px, 6vw, 58px);
                border: 1px solid rgba(255,255,255,0.35);
                border-radius: 30px;
                background: linear-gradient(118deg, #174d7d 0%, #2f7ed1 55%, #8ecafc 100%);
                color: #fff;
                box-shadow: 0 24px 54px rgba(39,100,159,0.2);
            }

            .hero::before, .hero::after {
                position: absolute;
                border: 1px solid rgba(255,255,255,0.19);
                border-radius: 50%;
                content: "";
                pointer-events: none;
            }

            .hero::before {
                top: -190px;
                right: -40px;
                width: 440px;
                height: 440px;
                box-shadow: 0 0 0 35px rgba(255,255,255,0.05), 0 0 0 75px rgba(255,255,255,0.035);
            }

            .hero::after {
                right: 12%;
                bottom: -180px;
                width: 300px;
                height: 300px;
                border-color: rgba(255,255,255,0.12);
            }

            .hero-copy { position: relative; z-index: 1; max-width: 690px; }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 9px;
                margin-bottom: 18px;
                padding: 8px 13px;
                border: 1px solid rgba(255,255,255,0.25);
                border-radius: 999px;
                background: rgba(255,255,255,0.14);
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.1em;
                text-transform: uppercase;
            }

            .eyebrow::before {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #a9f0cf;
                box-shadow: 0 0 0 4px rgba(169,240,207,0.16);
                content: "";
            }

            h1 { margin: 0; font-size: clamp(2.2rem, 6vw, 4.1rem); letter-spacing: -0.055em; line-height: 1.03; }
            .hero-copy p { max-width: 56ch; margin: 16px 0 0; color: rgba(255,255,255,0.84); font-size: 1.02rem; line-height: 1.7; }

            .date-chip {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                margin-top: 23px;
                padding: 10px 14px;
                border: 1px solid rgba(255,255,255,0.24);
                border-radius: 13px;
                background: rgba(255,255,255,0.13);
                font-size: 0.86rem;
                font-weight: 700;
            }

            .date-chip svg { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 1.8; }

            .menu-card {
                position: relative;
                z-index: 2;
                margin: -2px auto 28px;
                padding: clamp(18px, 4vw, 30px);
                border: 1px solid var(--line);
                border-radius: 26px;
                background: var(--panel);
                box-shadow: var(--shadow);
                backdrop-filter: blur(14px);
            }

            .menu-heading {
                display: flex;
                align-items: flex-end;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 18px;
            }

            .menu-kicker { display: block; margin-bottom: 5px; color: var(--primary); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.11em; text-transform: uppercase; }
            h2 { margin: 0; font-size: clamp(1.35rem, 3vw, 1.8rem); letter-spacing: -0.04em; }
            .menu-heading p { margin: 6px 0 0; color: var(--muted); font-size: 0.88rem; }

            .today-badge {
                flex: 0 0 auto;
                padding: 8px 11px;
                border: 1px solid var(--line);
                border-radius: 999px;
                background: var(--soft-blue);
                color: var(--primary);
                font-size: 0.73rem;
                font-weight: 800;
            }

            .menu-photo-wrap {
                position: relative;
                overflow: hidden;
                border: 1px solid var(--line);
                border-radius: 20px;
                background: linear-gradient(135deg, rgba(142,202,252,0.12), rgba(47,126,209,0.06));
            }

            .menu-photo {
                display: block;
                width: 100%;
                max-height: 620px;
                aspect-ratio: 16 / 9;
                object-fit: contain;
            }

            .empty-menu {
                display: grid;
                min-height: 280px;
                place-items: center;
                padding: 28px;
                border: 1px dashed var(--line);
                border-radius: 20px;
                background: var(--soft-blue);
                text-align: center;
            }

            .empty-menu-icon {
                display: grid;
                width: 66px;
                height: 66px;
                place-items: center;
                margin: 0 auto 15px;
                border: 1px solid var(--line);
                border-radius: 22px;
                background: var(--panel);
                color: var(--primary);
            }

            .empty-menu-icon svg { width: 31px; height: 31px; fill: none; stroke: currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 1.7; }
            .empty-menu strong { display: block; font-size: 1.08rem; }
            .empty-menu p { max-width: 42ch; margin: 7px 0 0; color: var(--muted); font-size: 0.88rem; line-height: 1.6; }

            .notice-strip {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-top: 16px;
                padding: 13px 15px;
                border: 1px solid var(--line);
                border-radius: 14px;
                background: var(--soft-blue);
                color: var(--muted);
                font-size: 0.82rem;
                line-height: 1.55;
            }

            .notice-strip svg { width: 20px; height: 20px; flex: 0 0 auto; fill: none; stroke: var(--primary); stroke-linecap: round; stroke-linejoin: round; stroke-width: 1.8; }

            .footer-card {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 22px;
                position: fixed;
                z-index: 20;
                right: 0;
                bottom: max(14px, env(safe-area-inset-bottom));
                left: 0;
                width: min(1120px, calc(100% - 40px));
                margin: 0 auto;
                padding: 14px 18px;
                border: 1px solid var(--line);
                border-radius: 20px;
                background: var(--panel);
                box-shadow: 0 12px 32px rgba(39,84,138,0.07);
                backdrop-filter: blur(16px);
            }

            .footer-card strong { display: block; font-size: 1rem; }
            .footer-card p { margin: 5px 0 0; color: var(--muted); font-size: 0.84rem; line-height: 1.5; }

            .footer-login {
                display: inline-flex;
                min-height: 46px;
                flex: 0 0 auto;
                align-items: center;
                justify-content: center;
                gap: 9px;
                padding: 11px 17px;
                border-radius: 13px;
                background: linear-gradient(135deg, #2f7ed1, #58a7ed);
                color: #fff;
                font-size: 0.84rem;
                font-weight: 800;
                text-decoration: none;
                box-shadow: 0 9px 20px rgba(47,126,209,0.18);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            :root[data-theme="dark"] .footer-login { color: #0d263b; }
            .footer-login:hover { box-shadow: 0 13px 24px rgba(47,126,209,0.24); }
            .footer-login svg { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 1.8; }
            footer { padding-top: 22px; color: var(--muted); font-size: 0.75rem; text-align: center; }

            @media (max-width: 600px) {
                body { padding: 12px 12px 130px; }
                .topbar { gap: 8px; margin-bottom: 15px; padding: 10px; border-radius: 17px; }
                .brand { gap: 9px; }
                .brand img { width: 40px; height: 40px; border-radius: 13px; }
                .brand-copy strong { font-size: 0.84rem; }
                .brand-copy span { font-size: 0.66rem; }
                .topbar-actions { gap: 6px; }
                .theme-toggle, .login-link { min-height: 38px; gap: 5px; padding: 8px 9px; font-size: 0.72rem; }
                .theme-toggle svg, .login-link svg { width: 16px; height: 16px; }
                .hero { min-height: 270px; margin-bottom: 16px; padding: 27px 22px; border-radius: 23px; }
                .hero::before { right: -220px; }
                .hero-copy p { font-size: 0.91rem; }
                .date-chip { margin-top: 18px; font-size: 0.78rem; }
                .menu-card { margin-bottom: 16px; padding: 17px 14px; border-radius: 21px; }
                .menu-heading { align-items: flex-start; }
                .menu-heading p { font-size: 0.8rem; line-height: 1.45; }
                .today-badge { padding: 7px 9px; font-size: 0.67rem; }
                .menu-photo { min-height: 210px; aspect-ratio: 4 / 3; }
                .empty-menu { min-height: 230px; padding: 22px 15px; }
                .footer-card { width: calc(100% - 24px); gap: 12px; padding: 12px; border-radius: 17px; }
                .footer-card strong { font-size: 0.83rem; }
                .footer-card p { max-width: 24ch; font-size: 0.7rem; }
                .footer-login { min-height: 42px; gap: 6px; padding: 9px 11px; font-size: 0.73rem; white-space: nowrap; }
                .footer-login svg { width: 16px; height: 16px; }
            }

            @media (max-width: 380px) {
                .brand-copy span { display: none; }
                .theme-toggle { width: 38px; padding-inline: 0; }
                .theme-toggle-label { display: none; }
            }

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
        <main class="page">
            <header class="topbar">
                <a class="brand" href="{{ route('home') }}" aria-label="MBG Tracker, halaman utama">
                    <img src="{{ asset('jpg.foto/logo.jpg.png') }}" alt="">
                    <span class="brand-copy">
                        <strong>MBG Tracker</strong>
                        <span>Program makan bergizi gratis</span>
                    </span>
                </a>
                <div class="topbar-actions">
                    <button class="theme-toggle" id="themeToggle" type="button" aria-label="Ganti ke mode gelap" aria-pressed="false">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/></svg>
                        <span class="theme-toggle-label">Tema</span>
                    </button>
                    <a class="login-link" href="{{ route('login', absolute: false) }}">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="m10 17 5-5-5-5M15 12H3"/></svg>
                        Login petugas
                    </a>
                </div>
            </header>

            <section class="hero" aria-labelledby="page-title">
                <div class="hero-copy">
                    <span class="eyebrow">Informasi menu untuk semua</span>
                    <h1 id="page-title">Menu MBG<br>Hari Ini</h1>
                    <p>Temukan informasi menu Makan Bergizi Gratis hari ini. Halaman ini dapat diakses oleh seluruh warga sekolah tanpa perlu login.</p>
                    <span class="date-chip">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 11h18"/></svg>
                        {{ $todayLabel }}
                    </span>
                </div>
            </section>

            <section class="menu-card" aria-labelledby="menu-title">
                <div class="menu-heading">
                    <div>
                        <span class="menu-kicker">Disiapkan untuk hari ini</span>
                        <h2 id="menu-title">Menu makan bergizi</h2>
                        <p>Lihat sajian MBG yang tersedia hari ini.</p>
                    </div>
                    <span class="today-badge">MENU HARI INI</span>
                </div>

                @if ($dailyMenu)
                    <div class="menu-photo-wrap">
                        <img
                            class="menu-photo"
                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($dailyMenu->foto) }}"
                            alt="Foto menu Makan Bergizi Gratis hari ini"
                        >
                    </div>
                    <div class="notice-strip">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 11v5M12 8h.01"/></svg>
                        <span>Informasi menu ini berlaku untuk {{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }}. Silakan hubungi petugas sekolah jika ada pertanyaan.</span>
                    </div>
                @else
                    <div class="empty-menu">
                        <div>
                            <span class="empty-menu-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><path d="M3 3v7a4 4 0 0 0 4 4h1v7M7 3v4M11 3v4M17 3v8M17 3c2 2 3 4 3 6a3 3 0 0 1-3 3v9"/></svg>
                            </span>
                            <strong>Menu hari ini belum tersedia</strong>
                            <p>Foto menu akan tampil di halaman ini setelah diperbarui oleh admin sekolah.</p>
                        </div>
                    </div>
                @endif
            </section>

            <section class="footer-card" aria-label="Login petugas">
                <div>
                    <strong>Anda petugas MBG?</strong>
                    <p>Masuk untuk mencatat pengambilan dan mengelola informasi distribusi.</p>
                </div>
                <a class="footer-login" href="{{ route('login', absolute: false) }}">
                    Login sebagai petugas
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </section>

            <footer>MBG Tracker · Informasi menu Makan Bergizi Gratis</footer>
        </main>
        <script>
            const themeToggle = document.getElementById('themeToggle');
            const updateThemeToggle = () => {
                const isDark = document.documentElement.dataset.theme === 'dark';
                themeToggle.setAttribute('aria-pressed', String(isDark));
                themeToggle.setAttribute('aria-label', isDark ? 'Ganti ke mode terang' : 'Ganti ke mode gelap');
                themeToggle.querySelector('.theme-toggle-label').textContent = isDark ? 'Gelap' : 'Terang';
            };

            updateThemeToggle();
            themeToggle.addEventListener('click', () => {
                const nextTheme = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', nextTheme);
                localStorage.setItem('mbg-theme', nextTheme);
                updateThemeToggle();
            });
        </script>
    </body>
</html>
