<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#e7edf1">
        <title>Kelola Akun - MBG Tracker</title>
        @include('partials.redirect-on-refresh')
        <style>
            :root {
                color-scheme: light;
                --bg: #e7edf1;
                --panel: rgba(248,250,251,0.92);
                --panel-solid: #f8fafb;
                --text: #1d3447;
                --muted: #536879;
                --line: rgba(48,83,108,0.16);
                --primary: #2f7ed1;
                --danger: #b42318;
                --success: #176b43;
                --soft-blue: rgba(48,83,108,0.08);
                --shadow: 0 20px 55px rgba(39,65,84,0.1);
            }

            :root[data-theme="dark"] {
                color-scheme: dark;
                --bg: #07141d;
                --panel: #102232;
                --panel-solid: #132a3c;
                --text: #edf8ff;
                --muted: #bfd6ef;
                --line: rgba(154,215,255,0.18);
                --primary: #9ad7ff;
                --danger: #ffaaa3;
                --success: #88ddb3;
                --soft-blue: rgba(154,215,255,0.1);
                --shadow: 0 20px 55px rgba(2,7,12,0.28);
            }

            * { box-sizing: border-box; }

            body {
                min-height: 100vh;
                margin: 0;
                padding: 34px 20px 56px;
                background:
                    radial-gradient(circle at 8% 0%, rgba(112,157,184,0.16), transparent 25%),
                    radial-gradient(circle at 95% 90%, rgba(133,166,188,0.12), transparent 28%),
                    linear-gradient(135deg, var(--bg), #eef2f4);
                color: var(--text);
                font-family: "Segoe UI", Arial, sans-serif;
            }

            :root[data-theme="dark"] body {
                background:
                    radial-gradient(circle at 8% 0%, rgba(34,91,133,0.24), transparent 26%),
                    radial-gradient(circle at 95% 90%, rgba(31,72,105,0.2), transparent 28%),
                    linear-gradient(135deg, var(--bg), #0d1d2b);
            }

            main { width: min(100%, 1120px); margin: 0 auto; }

            .topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 28px;
                padding: 13px 18px;
                border: 1px solid var(--line);
                border-radius: 20px;
                background: var(--panel);
                box-shadow: 0 12px 32px rgba(39,84,138,0.07);
                backdrop-filter: blur(14px);
            }

            .brand {
                display: flex;
                align-items: center;
                gap: 12px;
                min-width: 0;
            }

            .brand img {
                width: 44px;
                height: 44px;
                padding: 4px;
                border: 1px solid var(--line);
                border-radius: 14px;
                background: #f8fafb;
                object-fit: contain;
            }

            .brand-copy strong,
            .brand-copy span {
                display: block;
            }

            .brand-copy strong { font-size: 0.96rem; letter-spacing: -0.02em; }
            .brand-copy span { margin-top: 3px; color: var(--muted); font-size: 0.76rem; }
            .topbar-links { display: flex; flex-wrap: wrap; align-items: center; justify-content: flex-end; gap: 8px; }

            .back-link {
                display: inline-flex;
                min-height: 42px;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 9px 14px;
                border: 1px solid var(--line);
                border-radius: 12px;
                background: var(--soft-blue);
                color: var(--primary);
                font-size: 0.84rem;
                font-weight: 700;
                text-decoration: none;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .back-link:hover {
                transform: translateY(-1px);
                box-shadow: 0 8px 18px rgba(47,126,209,0.12);
            }

            .back-link:focus-visible,
            .edit-link:focus-visible,
            .delete-button:focus-visible {
                outline: 3px solid rgba(47,126,209,0.32);
                outline-offset: 3px;
            }

            .hero {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 24px;
                overflow: hidden;
                margin-bottom: 20px;
                padding: clamp(24px, 5vw, 42px);
                border: 1px solid rgba(255,255,255,0.4);
                border-radius: 26px;
                background: linear-gradient(118deg, #1d5e9d 0%, #2f7ed1 52%, #8ecafc 100%);
                color: #fff;
                box-shadow: 0 20px 44px rgba(39,100,159,0.2);
            }

            .hero::after {
                position: absolute;
                top: -110px;
                right: -40px;
                width: 310px;
                height: 310px;
                border: 1px solid rgba(255,255,255,0.2);
                border-radius: 50%;
                box-shadow: 0 0 0 28px rgba(255,255,255,0.06), 0 0 0 58px rgba(255,255,255,0.04);
                content: "";
                pointer-events: none;
            }

            .hero-copy,
            .admin-chip { position: relative; z-index: 1; }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 12px;
                padding: 7px 11px;
                border: 1px solid rgba(255,255,255,0.26);
                border-radius: 999px;
                background: rgba(255,255,255,0.14);
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.1em;
                text-transform: uppercase;
            }

            .eyebrow::before {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: #a9f0cf;
                box-shadow: 0 0 0 4px rgba(169,240,207,0.16);
                content: "";
            }

            h1 { margin: 0; font-size: clamp(1.8rem, 5vw, 2.7rem); letter-spacing: -0.045em; }
            .subtitle { max-width: 58ch; margin: 9px 0 0; color: rgba(255,255,255,0.84); line-height: 1.6; }

            .admin-chip {
                display: grid;
                width: 92px;
                height: 92px;
                flex: 0 0 auto;
                place-items: center;
                border: 1px solid rgba(255,255,255,0.32);
                border-radius: 28px;
                background: rgba(255,255,255,0.16);
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.16);
                backdrop-filter: blur(8px);
            }

            .admin-chip svg { width: 42px; height: 42px; fill: none; stroke: currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 1.6; }

            .summary-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 16px;
                margin-bottom: 20px;
            }

            .summary-card {
                display: flex;
                align-items: center;
                gap: 15px;
                padding: 18px 20px;
                border: 1px solid var(--line);
                border-radius: 18px;
                background: var(--panel);
                box-shadow: 0 10px 28px rgba(39,84,138,0.06);
            }

            .summary-icon {
                display: grid;
                width: 48px;
                height: 48px;
                flex: 0 0 auto;
                place-items: center;
                border: 1px solid var(--line);
                border-radius: 15px;
                background: var(--soft-blue);
                color: var(--primary);
            }

            .summary-icon svg { width: 23px; height: 23px; fill: none; stroke: currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 1.8; }
            .summary-card span, .summary-card strong { display: block; }
            .summary-card span { color: var(--muted); font-size: 0.78rem; }
            .summary-card strong { margin-top: 3px; font-size: 1.45rem; letter-spacing: -0.04em; font-variant-numeric: tabular-nums; }

            .panel {
                overflow: hidden;
                border: 1px solid var(--line);
                border-radius: 22px;
                background: var(--panel);
                box-shadow: var(--shadow);
                backdrop-filter: blur(14px);
            }

            .panel-heading {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                padding: 22px 24px;
                border-bottom: 1px solid var(--line);
            }

            .panel-heading h2 { margin: 0; font-size: 1.05rem; letter-spacing: -0.02em; }
            .panel-heading p { margin: 5px 0 0; color: var(--muted); font-size: 0.82rem; }
            .record-count { color: var(--muted); font-size: 0.78rem; white-space: nowrap; }
            .user-search {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 18px 24px;
                border-bottom: 1px solid var(--line);
            }
            .user-search input {
                width: min(100%, 420px);
                min-height: 42px;
                padding: 9px 13px;
                border: 1px solid var(--line);
                border-radius: 11px;
                background: var(--panel-solid);
                color: var(--text);
                font: inherit;
            }
            .user-search input:focus-visible,
            .search-button:focus-visible,
            .clear-search:focus-visible {
                outline: 3px solid rgba(47,126,209,0.32);
                outline-offset: 2px;
            }
            .search-button,
            .clear-search {
                display: inline-flex;
                min-height: 40px;
                align-items: center;
                justify-content: center;
                padding: 8px 13px;
                border: 1px solid var(--line);
                border-radius: 10px;
                background: var(--panel-solid);
                color: var(--primary);
                font: inherit;
                font-size: 0.8rem;
                font-weight: 750;
                text-decoration: none;
                cursor: pointer;
            }

            .notice, .error {
                margin: 18px 24px 0;
                padding: 12px 14px;
                border-radius: 12px;
                font-size: 0.9rem;
            }

            .notice { background: rgba(46,194,126,0.1); color: var(--success); }
            .error { background: rgba(180,35,24,0.08); color: var(--danger); }
            .table-wrap { overflow-x: auto; }
            table { width: 100%; border-collapse: collapse; text-align: left; }
            th, td { padding: 15px 24px; border-bottom: 1px solid var(--line); vertical-align: middle; }
            th { color: var(--muted); font-size: 0.7rem; letter-spacing: 0.08em; text-transform: uppercase; }
            td { font-size: 0.88rem; }
            tbody tr { transition: background 0.18s ease; }
            tbody tr:hover { background: var(--soft-blue); }
            tbody tr:last-child td { border-bottom: 0; }

            .account-cell { display: flex; align-items: center; gap: 12px; min-width: 220px; }
            .user-avatar {
                display: grid;
                width: 40px;
                height: 40px;
                flex: 0 0 auto;
                place-items: center;
                border: 1px solid var(--line);
                border-radius: 13px;
                background: linear-gradient(145deg, var(--soft-blue), rgba(112,157,184,0.16));
                color: var(--primary);
                font-size: 0.83rem;
                font-weight: 800;
            }

            .account-name, .account-email { display: block; overflow: hidden; text-overflow: ellipsis; }
            .account-name { font-weight: 750; }
            .account-email { max-width: 300px; margin-top: 4px; color: var(--muted); font-size: 0.78rem; }
            .role {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 6px 10px;
                border: 1px solid var(--line);
                border-radius: 999px;
                background: var(--soft-blue);
                color: var(--muted);
                font-size: 0.72rem;
                font-weight: 750;
                white-space: nowrap;
            }

            .role.admin { color: var(--primary); }
            .role::before { width: 6px; height: 6px; border-radius: 50%; background: currentColor; content: ""; }
            .role.pending { color: #9a5b00; }
            :root[data-theme="dark"] .role.pending { color: #ffd27a; }
            .actions { display: flex; align-items: center; gap: 8px; white-space: nowrap; }
            .actions form { margin: 0; }

            .edit-link,
            .delete-button,
            .approve-button {
                display: inline-flex;
                min-height: 34px;
                align-items: center;
                justify-content: center;
                padding: 7px 11px;
                border: 1px solid var(--line);
                border-radius: 10px;
                background: var(--panel-solid);
                font: inherit;
                font-size: 0.77rem;
                font-weight: 750;
                text-decoration: none;
                cursor: pointer;
                transition: border-color 0.18s ease, transform 0.18s ease;
            }

            .edit-link { color: var(--primary); }
            .delete-button { color: var(--danger); }
            .approve-button { border-color: rgba(23,107,67,0.24); color: var(--success); }
            .edit-link:hover, .delete-button:hover, .approve-button:hover { transform: translateY(-1px); }
            .edit-link:hover { border-color: var(--primary); }
            .delete-button:hover { border-color: var(--danger); }
            .approve-button:hover { border-color: var(--success); }
            .empty-state { padding: 34px 20px; color: var(--muted); text-align: center; }
            .pagination { padding: 18px 24px; border-top: 1px solid var(--line); }
            .pagination nav { display: flex; justify-content: space-between; gap: 12px; }
            .pagination a, .pagination span { color: var(--primary); font-size: 0.85rem; text-decoration: none; }

            @media (max-width: 680px) {
                body { padding: 18px 12px 36px; }
                .topbar { margin-bottom: 18px; padding: 11px 12px; }
                .brand img { width: 40px; height: 40px; }
                .brand-copy span { font-size: 0.68rem; }
                .back-link { min-height: 38px; padding: 8px 10px; font-size: 0.76rem; }
                .topbar-links { gap: 6px; }
                .hero { gap: 14px; padding: 24px 20px; border-radius: 22px; }
                .subtitle { font-size: 0.88rem; }
                .admin-chip { width: 64px; height: 64px; border-radius: 20px; }
                .admin-chip svg { width: 32px; height: 32px; }
                .summary-grid { gap: 10px; }
                .summary-card { gap: 10px; padding: 14px 12px; }
                .summary-icon { width: 40px; height: 40px; border-radius: 12px; }
                .summary-card span { font-size: 0.7rem; }
                .summary-card strong { font-size: 1.25rem; }
                .panel { border-radius: 18px; }
                .panel-heading { align-items: flex-start; padding: 18px 16px; }
                .panel-heading p { max-width: 35ch; line-height: 1.5; }
                .record-count { padding-top: 2px; font-size: 0.7rem; }
                .user-search { flex-wrap: wrap; padding: 16px; }
                .user-search input { flex: 1 1 100%; }
                th, td { padding: 13px 14px; }
                th:last-child, td:last-child { padding-right: 16px; }
                .pagination { padding: 16px; }
                .notice, .error { margin-inline: 16px; }
            }

            @media (max-width: 420px) {
                .brand-copy span { display: none; }
                .back-link { gap: 5px; font-size: 0.7rem; }
                .hero { align-items: flex-start; }
                .admin-chip { width: 50px; height: 50px; border-radius: 16px; }
                .admin-chip svg { width: 26px; height: 26px; }
                .summary-grid { grid-template-columns: 1fr; }
                .summary-card { padding: 12px 14px; }
            }
        </style>
        <script>
            const storedTheme = localStorage.getItem('mbg-theme');
            const prefersDarkTheme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.setAttribute('data-theme', storedTheme || (prefersDarkTheme ? 'dark' : 'light'));
        </script>
    </head>
    <body>
        <main>
            <header class="topbar">
                <div class="brand">
                    <img src="{{ asset('jpg.foto/logo.jpg.png') }}" alt="Logo MBG Tracker">
                    <div class="brand-copy">
                        <strong>MBG Tracker</strong>
                        <span>Program makan bergizi gratis</span>
                    </div>
                </div>
                <div class="topbar-links">
                    <a class="back-link" href="{{ route('mbg.daily-menu') }}">Kelola menu hari ini</a>
                    <a class="back-link" href="{{ route('mbg.index') }}">
                        <span aria-hidden="true">&larr;</span>
                        Dashboard petugas
                    </a>
                </div>
            </header>

            <section class="hero" aria-labelledby="admin-title">
                <div class="hero-copy">
                    <span class="eyebrow">Ruang pengelola</span>
                    <h1 id="admin-title">Kelola akun</h1>
                    <p class="subtitle">Halo, {{ auth()->user()->name }}. Kelola akses dan informasi akun pengguna MBG Tracker dari satu tempat.</p>
                </div>
                <div class="admin-chip" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M20 8v6M23 11h-6"/></svg>
                </div>
            </section>

            <section class="summary-grid" aria-label="Ringkasan akun">
                <article class="summary-card">
                    <span class="summary-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </span>
                    <div>
                        <span>Total akun terdaftar</span>
                        <strong>{{ number_format($totalUsersCount, 0, ',', '.') }}</strong>
                    </div>
                </article>
                <article class="summary-card">
                    <span class="summary-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M12 3 19 6v5c0 4.5-3 7.5-7 10-4-2.5-7-5.5-7-10V6l7-3Z"/><path d="m9 12 2 2 4-4"/></svg>
                    </span>
                    <div>
                        <span>Menunggu verifikasi</span>
                        <strong>{{ number_format($pendingUsersCount, 0, ',', '.') }}</strong>
                    </div>
                </article>
            </section>

            <section class="panel" aria-label="Daftar akun pengguna">
                <div class="panel-heading">
                    <div>
                        <h2>Daftar pengguna</h2>
                        <p>Verifikasi pendaftaran baru atau perbarui akses akun.</p>
                    </div>
                    <span class="record-count">Menampilkan {{ $users->count() }} dari {{ $users->total() }} akun</span>
                </div>
                <form class="user-search" method="GET" action="{{ route('admin.users.index') }}" role="search">
                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama atau email pengguna"
                        aria-label="Cari nama atau email pengguna"
                    >
                    <button class="search-button" type="submit">Cari</button>
                    @if ($search !== '')
                        <a class="clear-search" href="{{ route('admin.users.index') }}">Hapus pencarian</a>
                    @endif
                </form>
                @if (session('status'))
                    <p class="notice" role="status">{{ session('status') }}</p>
                @endif
                @if ($errors->has('account'))
                    <p class="error" role="alert">{{ $errors->first('account') }}</p>
                @endif

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Akun pengguna</th>
                                <th>Peran</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>
                                        <div class="account-cell">
                                            <span class="user-avatar" aria-hidden="true">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            <span>
                                                <span class="account-name">{{ $user->name }}</span>
                                                <span class="account-email">{{ $user->email }}</span>
                                            </span>
                                        </div>
                                    </td>
                                    <td><span class="role {{ $user->is_admin ? 'admin' : '' }}">{{ $user->is_admin ? 'Admin' : 'Petugas' }}</span></td>
                                    <td>
                                        <span class="role {{ $user->is_approved ? '' : 'pending' }}">
                                            {{ $user->is_approved ? 'Terverifikasi' : 'Menunggu verifikasi' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            @if (! $user->is_admin && ! $user->is_approved)
                                                <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="approve-button" type="submit">Verifikasi</button>
                                                </form>
                                            @endif
                                            <a class="edit-link" href="{{ route('admin.users.edit', $user) }}">Ubah</a>
                                            @if (! auth()->user()->is($user))
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="delete-button" type="submit">Hapus</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-state">
                                        {{ $search !== '' ? 'Tidak ada pengguna yang cocok dengan pencarian.' : 'Belum ada akun pengguna.' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination">{{ $users->links() }}</div>
            </section>
        </main>
    </body>
</html>
