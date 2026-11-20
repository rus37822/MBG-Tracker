<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#e7edf1">
        <title>Menu MBG Hari Ini - MBG Tracker</title>
        <style>
            :root {
                color-scheme: light;
                --bg-1: #e7edf1;
                --bg-2: #eef2f4;
                --panel: rgba(248,250,251,0.92);
                --panel-strong: #f8fafb;
                --primary: #8ecafc;
                --primary-strong: #2f7ed1;
                --secondary: #e3ebf0;
                --accent: #cfdee8;
                --text: #1d3447;
                --muted: #536879;
                --line: rgba(48,83,108,0.14);
                --shadow: 0 24px 60px rgba(39, 65, 84, 0.12);
                --input-bg: rgba(242,246,248,0.96);
                --hero-bg-1: #edf9ff;
                --hero-bg-2: #cfeaff;
                --hero-bg-3: #9cc8ff;
                --hero-bg-4: #eaf7ff;
                --hero-text: #12314d;
                --hero-subtext: rgba(18,49,77,0.8);
            }

            :root[data-theme="dark"] {
                color-scheme: dark;
                --bg-1: #07141d;
                --bg-2: #0d1d2b;
                --panel: rgba(15,23,34,0.82);
                --panel-strong: #102232;
                --primary: #89d1ff;
                --primary-strong: #9ad7ff;
                --secondary: #1d3146;
                --accent: #244d73;
                --text: #edf8ff;
                --muted: #bfd6ef;
                --line: rgba(154,215,255,0.12);
                --shadow: 0 24px 60px rgba(2, 7, 12, 0.46);
                --input-bg: #112433;
                --hero-bg-1: #0e2339;
                --hero-bg-2: #153d5e;
                --hero-bg-3: #1b4c75;
                --hero-bg-4: #0d2033;
                --hero-text: #edf7ff;
                --hero-subtext: rgba(237,247,255,0.8);
            }

            * { box-sizing: border-box; }

            body {
                min-height: 100vh;
                margin: 0;
                padding: 22px;
                background:
                    radial-gradient(circle at top left, rgba(112, 157, 184, 0.2), transparent 24rem),
                    radial-gradient(circle at bottom right, rgba(133, 166, 188, 0.14), transparent 30rem),
                    linear-gradient(135deg, var(--bg-1) 0%, var(--bg-2) 55%, #e9eff2 100%);
                color: var(--text);
                font-family: "Segoe UI", Arial, sans-serif;
            }

            .welcome-overlay {
                position: fixed;
                inset: 0;
                z-index: 9999;
                display: grid;
                place-items: center;
                overflow: hidden;
                background: #12334b;
                transition: opacity 0.8s ease, visibility 0.8s ease;
            }

            .welcome-overlay::before {
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(135deg, rgba(8, 28, 43, 0.68), rgba(14, 51, 73, 0.38) 55%, rgba(8, 28, 43, 0.66)),
                    url("{{ asset('jpg.foto/foto-prabowo,jpg.png') }}") center 42% / cover no-repeat;
                animation: welcomeBackdropIn 1.4s ease both;
                content: "";
            }

            .welcome-overlay.hidden {
                opacity: 0;
                visibility: hidden;
            }

            .welcome-card {
                position: relative;
                z-index: 1;
                padding: 26px 34px;
                border: 1px solid rgba(255,255,255,0.28);
                border-radius: 28px;
                background: rgba(12, 35, 51, 0.42);
                box-shadow: 0 25px 80px rgba(0,0,0,0.24);
                color: white;
                text-align: center;
                backdrop-filter: blur(12px);
                animation: floatIn 1s ease both;
            }

            .welcome-visual {
                position: relative;
                display: flex;
                width: 96px;
                height: 96px;
                align-items: center;
                justify-content: center;
                margin: 0 auto 18px;
            }

            .welcome-logo {
                position: absolute;
                top: 50%;
                left: 50%;
                display: block;
                width: 78px;
                height: 78px;
                padding: 5px;
                transform: translate(-50%, -50%) scale(0.25);
                transform-origin: center center;
                border: 2px solid rgba(255,255,255,0.95);
                border-radius: 20px;
                background: #ffffff;
                box-shadow: 0 18px 36px rgba(32, 96, 161, 0.2);
                object-fit: contain;
                opacity: 0;
                animation: logoIn 0.7s cubic-bezier(0.2, 0.9, 0.2, 1) forwards 0.45s;
            }

            .welcome-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 14px;
                padding: 8px 14px;
                border: 1px solid rgba(255,255,255,0.18);
                border-radius: 999px;
                background: rgba(255,255,255,0.14);
                font-size: 12px;
                letter-spacing: 0.12em;
                text-transform: uppercase;
            }

            .welcome-badge::before {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #d6f0ff;
                box-shadow: 0 0 0 5px rgba(214, 240, 255, 0.28);
                content: "";
            }

            .welcome-card h2 {
                margin: 0;
                font-size: clamp(2rem, 5vw, 4rem);
                letter-spacing: -0.06em;
                animation: revealText 1.2s ease both 0.25s;
            }

            .welcome-card p {
                margin: 10px 0 0;
                font-size: 1rem;
                letter-spacing: 0.08em;
                opacity: 0.8;
                text-transform: uppercase;
            }

            .mbg-car-track {
                position: fixed;
                z-index: 10000;
                right: 0;
                bottom: 0;
                left: 0;
                height: clamp(76px, 12vh, 120px);
                overflow: hidden;
                pointer-events: none;
            }

            .mbg-car {
                position: absolute;
                bottom: 0;
                left: 0;
                width: clamp(220px, 34vw, 420px);
                height: 100%;
                object-fit: contain;
                animation: mbg-car-drive 4.5s linear infinite;
                will-change: transform;
            }

            @keyframes mbg-car-drive {
                from { transform: translate3d(-100%, 0, 0); }
                to { transform: translate3d(100vw, 0, 0); }
            }

            @keyframes floatIn {
                from {
                    opacity: 0;
                    transform: translateY(18px) scale(0.94);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            @keyframes revealText {
                from {
                    opacity: 0;
                    transform: translateY(18px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes logoIn {
                0% {
                    opacity: 0;
                    transform: translate(-50%, -50%) scale(0.25);
                }
                60% {
                    opacity: 1;
                    transform: translate(-50%, -50%) scale(1.08);
                }
                100% {
                    opacity: 1;
                    transform: translate(-50%, -50%) scale(1);
                }
            }

            @keyframes welcomeBackdropIn {
                from {
                    opacity: 0.7;
                    transform: scale(1.06);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .page {
                width: min(100%, 1120px);
                margin: 0 auto;
            }

            .topbar {
                display: flex;
                min-height: 68px;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                padding: 9px 12px 9px 16px;
                border: 1px solid rgba(48,83,108,0.12);
                border-radius: 20px;
                background: var(--panel);
                box-shadow: 0 10px 30px rgba(39, 65, 84, 0.08);
                backdrop-filter: blur(12px);
            }

            .brand {
                display: flex;
                align-items: center;
                gap: 12px;
                color: inherit;
                text-decoration: none;
            }

            .brand img {
                width: 46px;
                height: 46px;
                padding: 3px;
                border: 1px solid rgba(47,126,209,0.08);
                border-radius: 14px;
                background: #fff;
                object-fit: contain;
            }

            .brand-copy strong,
            .brand-copy span { display: block; }

            .brand-copy strong {
                font-size: 0.98rem;
                letter-spacing: -0.02em;
            }

            .brand-copy span {
                margin-top: 3px;
                color: var(--muted);
                font-size: 0.76rem;
            }

            .login-link {
                display: inline-flex;
                min-height: 44px;
                align-items: center;
                justify-content: center;
                gap: 9px;
                padding: 0 17px;
                border: 1px solid rgba(47,126,209,0.12);
                border-radius: 13px;
                background: linear-gradient(135deg, #2f7ed1, #7ec8ff);
                box-shadow: 0 12px 24px rgba(47,126,209,0.2);
                color: #fff;
                font-size: 0.86rem;
                font-weight: 750;
                text-decoration: none;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .login-link:hover {
                transform: translateY(-1px);
                box-shadow: 0 16px 28px rgba(47,126,209,0.26);
            }

            .login-link:focus-visible,
            .brand:focus-visible {
                outline: 3px solid var(--primary);
                outline-offset: 3px;
            }

            .topbar-actions {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .theme-toggle {
                display: inline-flex;
                min-height: 42px;
                align-items: center;
                gap: 8px;
                padding: 8px 12px;
                border: 1px solid var(--line);
                border-radius: 999px;
                background: rgba(255,255,255,0.45);
                color: var(--text);
                font: inherit;
                font-size: 0.76rem;
                font-weight: 700;
                cursor: pointer;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .theme-toggle:hover {
                transform: translateY(-1px);
                box-shadow: 0 8px 18px rgba(15, 31, 47, 0.12);
            }

            .theme-toggle-icon {
                position: relative;
                display: inline-flex;
                width: 20px;
                height: 20px;
                align-items: center;
                justify-content: center;
                border: 1px solid rgba(17,17,17,0.18);
                border-radius: 50%;
                background: rgba(112,157,184,0.12);
            }

            .theme-toggle-icon::before {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #111;
                box-shadow: 0 0 0 2px rgba(17,17,17,0.08);
                content: "";
            }

            :root[data-theme="dark"] .theme-toggle-icon {
                border-color: rgba(255,255,255,0.18);
                background: rgba(255,255,255,0.06);
            }

            :root[data-theme="dark"] .theme-toggle-icon::before {
                background: #fff;
                box-shadow: 0 0 0 2px rgba(255,255,255,0.08);
            }

            main {
                padding: clamp(52px, 8vw, 88px) 0 42px;
                text-align: center;
            }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                margin: 0 0 17px;
                padding: 8px 13px;
                border: 1px solid var(--line);
                border-radius: 999px;
                background: var(--panel);
                color: var(--primary-strong);
                font-size: 0.73rem;
                font-weight: 800;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .eyebrow svg { width: 16px; height: 16px; }

            h1 {
                max-width: 760px;
                margin: 0 auto;
                font-size: clamp(2.35rem, 6vw, 4.2rem);
                line-height: 1.06;
                letter-spacing: -0.065em;
            }

            h1 span { color: var(--primary-strong); }

            .intro {
                max-width: 560px;
                margin: 18px auto 0;
                color: var(--muted);
                font-size: clamp(0.94rem, 2vw, 1.06rem);
                line-height: 1.7;
            }

            .menu-section {
                width: min(100%, 880px);
                margin: 38px auto 0;
                text-align: left;
            }

            .menu-heading {
                display: flex;
                align-items: end;
                justify-content: space-between;
                gap: 16px;
                margin: 0 5px 13px;
            }

            .menu-heading p { margin: 0; }

            .menu-label {
                color: var(--muted);
                font-size: 0.78rem;
                font-weight: 750;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .date {
                margin-top: 5px !important;
                color: var(--text);
                font-size: 1rem;
                font-weight: 750;
            }

            .today-badge {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                padding: 7px 11px;
                border-radius: 999px;
                background: var(--secondary);
                color: var(--primary-strong);
                font-size: 0.75rem;
                font-weight: 750;
                white-space: nowrap;
            }

            .today-badge::before {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: var(--primary-strong);
                content: "";
            }

            .menu-card {
                overflow: hidden;
                padding: 10px;
                border: 1px solid var(--line);
                border-radius: 25px;
                background: var(--panel);
                box-shadow: var(--shadow);
            }

            .menu-photo {
                display: block;
                width: 100%;
                max-height: 66vh;
                min-height: 250px;
                border-radius: 17px;
                background: var(--input-bg);
                object-fit: contain;
            }

            .empty-menu {
                display: grid;
                min-height: 300px;
                padding: 28px;
                place-items: center;
                border: 1px dashed var(--line);
                border-radius: 17px;
                background:
                    radial-gradient(circle at 50% 40%, var(--panel-strong), transparent 60%),
                    var(--secondary);
                color: var(--muted);
                line-height: 1.65;
                text-align: center;
            }

            .empty-icon {
                display: grid;
                width: 58px;
                height: 58px;
                margin: 0 auto 15px;
                place-items: center;
                border: 1px solid var(--line);
                border-radius: 19px;
                background: var(--panel-strong);
                color: var(--primary-strong);
            }

            .empty-icon svg { width: 28px; height: 28px; }

            .empty-menu strong {
                display: block;
                margin-bottom: 5px;
                color: var(--text);
                font-size: 1.08rem;
            }

            .footer {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 7px;
                margin: 22px 0 0;
                color: var(--muted);
                font-size: 0.8rem;
            }

            .footer svg { width: 15px; height: 15px; color: var(--primary-strong); }

            @media (max-width: 560px) {
                .welcome-overlay::before { background-position: 86% 42%; }
                body { padding: 13px; }
                .topbar { min-height: 62px; padding: 8px; border-radius: 17px; }
                .brand { gap: 8px; }
                .brand img { width: 40px; height: 40px; border-radius: 12px; }
                .brand-copy strong { font-size: 0.88rem; }
                .brand-copy span { display: none; }
                .topbar-actions { gap: 6px; }
                .theme-toggle { min-height: 40px; gap: 0; padding: 8px; }
                .theme-toggle-text { display: none; }
                .login-link { min-height: 40px; gap: 6px; padding: 0 11px; font-size: 0.78rem; }
                .login-link svg { width: 14px; height: 14px; }
                main { padding-top: 54px; }
                .intro { padding: 0 8px; }
                .menu-section { margin-top: 31px; }
                .menu-heading { align-items: center; margin-inline: 2px; }
                .menu-label { font-size: 0.7rem; }
                .date { font-size: 0.9rem; }
                .today-badge { padding: 6px 9px; font-size: 0.68rem; }
                .menu-card { padding: 7px; border-radius: 20px; }
                .menu-photo { min-height: 205px; border-radius: 14px; }
                .empty-menu { min-height: 240px; padding: 20px; border-radius: 14px; }
            }

            :root[data-theme="dark"] .login-link {
                background: linear-gradient(135deg, #e7f8ff, #bfdfff);
                color: #0f2341;
            }

            :root[data-theme="dark"] .topbar,
            :root[data-theme="dark"] .theme-toggle {
                border-color: var(--line);
                background: var(--panel);
            }

            :root[data-theme="dark"] .menu-card {
                border-color: var(--line);
            }

            :root[data-theme="dark"] .empty-menu {
                background:
                    radial-gradient(circle at 50% 40%, var(--panel-strong), transparent 60%),
                    var(--secondary);
            }

            @media (prefers-reduced-motion: reduce) {
                *, *::before, *::after {
                    scroll-behavior: auto !important;
                    transition-duration: 0.01ms !important;
                }

                .mbg-car {
                    right: 0;
                    left: auto;
                    animation: none;
                }
            }

            .topbar {
                border-color: var(--line);
                box-shadow: 0 16px 38px rgba(39, 84, 138, 0.09);
            }

            main {
                position: relative;
                isolation: isolate;
            }

            main::before {
                position: absolute;
                top: 16px;
                left: 50%;
                z-index: -1;
                width: min(72vw, 680px);
                aspect-ratio: 1;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(112, 157, 184, 0.16), transparent 68%);
                content: "";
                pointer-events: none;
                transform: translateX(-50%);
            }

            h1 {
                max-width: 860px;
                text-wrap: balance;
            }

            h1 span {
                background: linear-gradient(110deg, var(--primary-strong), #57a9e8 72%, #72c4d2);
                background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            :root[data-theme="dark"] h1 span {
                background-image: linear-gradient(110deg, #a4d9ff, #7fc4ee 72%, #8bd1d7);
            }

            .intro {
                max-width: 54ch;
            }

            .menu-section {
                width: min(100%, 920px);
                margin-top: clamp(42px, 6vw, 64px);
            }

            .menu-card {
                padding: 12px;
                border-radius: 30px;
                background: linear-gradient(145deg, var(--panel-strong), var(--panel));
                box-shadow: 0 28px 72px rgba(39, 84, 138, 0.16);
                transition: box-shadow 0.25s ease, transform 0.25s ease;
            }

            .menu-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 34px 82px rgba(39, 84, 138, 0.2);
            }

            .menu-photo {
                min-height: clamp(280px, 42vw, 520px);
                max-height: 72vh;
                border-radius: 20px;
            }

            .empty-menu {
                min-height: clamp(260px, 35vw, 380px);
            }

            .footer {
                width: fit-content;
                max-width: 100%;
                padding: 11px 16px;
                border: 1px solid var(--line);
                border-radius: 999px;
                background: var(--panel);
                box-shadow: 0 8px 22px rgba(39, 84, 138, 0.06);
                line-height: 1.5;
                text-align: center;
            }

            @media (max-width: 560px) {
                .menu-card {
                    padding: 8px;
                    border-radius: 23px;
                }

                .menu-photo {
                    min-height: 220px;
                    max-height: 58vh;
                    border-radius: 16px;
                }

                .footer {
                    border-radius: 16px;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .menu-card {
                    transition: none;
                }

                .menu-card:hover {
                    transform: none;
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
        <div class="welcome-overlay" id="welcomeOverlay">
            <div class="welcome-card">
                <div class="welcome-visual">
                    <img class="welcome-logo" src="{{ asset('jpg.foto/logo.jpg.png') }}" alt="Logo MBG">
                </div>
                <div class="welcome-badge">Program MBG</div>
                <h2>Selamat Datang</h2>
                <p>Monitoring Pengambilan Makanan Bergizi Gratis</p>
            </div>
            <div class="mbg-car-track" aria-hidden="true">
                <img class="mbg-car" src="{{ asset('jpg.foto/mobil-mbg,jpg.png') }}" alt="">
            </div>
        </div>
        <div class="page">
            <header class="topbar">
                <a class="brand" href="{{ route('home', absolute: false) }}" aria-label="MBG Tracker">
                    <img src="{{ asset('jpg.foto/logo.jpg.png') }}" alt="">
                    <span class="brand-copy">
                        <strong>MBG Tracker</strong>
                        <span>Program Makan Bergizi Gratis</span>
                    </span>
                </a>
                <div class="topbar-actions">
                    <button type="button" class="theme-toggle" id="themeToggle" aria-label="Mode terang" aria-pressed="false">
                        <span class="theme-toggle-icon" aria-hidden="true"></span>
                        <span class="theme-toggle-text">Mode gelap</span>
                    </button>
                    <a class="login-link" href="{{ route('login', absolute: false) }}">
                        Masuk Petugas
                        <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path d="M4 10h11m-4-4 4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </header>

            <main>
                <p class="eyebrow">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 21c4.4-2.6 7-6.1 7-10.7C14.3 9.9 9 12.7 9 17c0 1.5 1 2.8 3 4Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                        <path d="M5 5c4.5-.2 7.4 1.5 8.7 5.2M12 21c.1-3.4 1.7-6.5 5-9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                    Makanan Bergizi Gratis
                </p>
                <h1>Hidangan sehat,<br><span>semangat hebat.</span></h1>
                <p class="intro">Lihat menu MBG yang disiapkan untuk hari ini. Informasi menu terbuka untuk seluruh warga sekolah.</p>

                <section class="menu-section" aria-label="Menu MBG hari ini">
                    <div class="menu-heading">
                        <div>
                            <p class="menu-label">Menu hari ini</p>
                            <p class="date">{{ \Carbon\Carbon::parse($today)->locale('id')->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <span class="today-badge">Hari ini</span>
                    </div>

                    <div class="menu-card">
                        @if ($dailyMenu)
                            <img
                                class="menu-photo"
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($dailyMenu->foto) }}"
                                alt="Foto menu MBG hari ini"
                            >
                        @else
                            <div class="empty-menu">
                                <div>
                                    <span class="empty-icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M4 7.5h16v12H4zM7 7.5l1-3h8l1 3" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                            <circle cx="12" cy="13.5" r="3.2" stroke="currentColor" stroke-width="1.6"/>
                                            <path d="M17 10h.01" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                                        </svg>
                                    </span>
                                    <strong>Menu hari ini sedang disiapkan</strong>
                                    Silakan kunjungi kembali halaman ini nanti.
                                </div>
                            </div>
                        @endif
                    </div>
                </section>

                <p class="footer">
                    <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                        <path d="M10 17s-6-3.6-6-8a3.4 3.4 0 0 1 6-2.2A3.4 3.4 0 0 1 16 9c0 4.4-6 8-6 8Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                    Informasi menu dapat dilihat oleh semua orang.
                </p>
            </main>
        </div>
        <script>
            const welcomeOverlay = document.getElementById('welcomeOverlay');
            window.setTimeout(function () {
                if (welcomeOverlay) {
                    welcomeOverlay.classList.add('hidden');
                }
            }, 2400);

            const root = document.documentElement;
            const themeToggle = document.getElementById('themeToggle');
            const themeToggleText = themeToggle.querySelector('.theme-toggle-text');

            function applyTheme(theme) {
                const isDark = theme === 'dark';
                root.setAttribute('data-theme', theme);
                themeToggle.setAttribute('aria-pressed', String(isDark));
                themeToggle.setAttribute('aria-label', isDark ? 'Mode terang' : 'Mode gelap');
                themeToggleText.textContent = isDark ? 'Mode terang' : 'Mode gelap';
            }

            applyTheme(root.getAttribute('data-theme') || 'light');

            themeToggle.addEventListener('click', function () {
                const nextTheme = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                localStorage.setItem('mbg-theme', nextTheme);
                applyTheme(nextTheme);
            });
        </script>
    </body>
</html>
