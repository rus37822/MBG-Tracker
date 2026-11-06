<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#edf8ff">
        <title>Kelola Akun - MBG Tracker</title>
        <style>
            :root {
                color-scheme: light;
                --bg: #edf8ff;
                --panel: rgba(255,255,255,0.9);
                --text: #15324d;
                --muted: #526a82;
                --line: rgba(47,126,209,0.16);
                --primary: #2f7ed1;
                --danger: #b42318;
                --success: #176b43;
            }

            :root[data-theme="dark"] {
                color-scheme: dark;
                --bg: #07141d;
                --panel: #102232;
                --text: #edf8ff;
                --muted: #bfd6ef;
                --line: rgba(154,215,255,0.18);
                --primary: #9ad7ff;
                --danger: #ffaaa3;
                --success: #88ddb3;
            }

            * { box-sizing: border-box; }

            body {
                min-height: 100vh;
                margin: 0;
                padding: 32px 18px;
                background: linear-gradient(135deg, var(--bg), #f9fcff);
                color: var(--text);
                font-family: "Segoe UI", Arial, sans-serif;
            }

            :root[data-theme="dark"] body { background: linear-gradient(135deg, var(--bg), #0d1d2b); }
            main { width: min(100%, 1100px); margin: 0 auto; }

            header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 24px;
            }

            h1 { margin: 0; font-size: clamp(1.7rem, 5vw, 2.4rem); }
            .subtitle { margin: 7px 0 0; color: var(--muted); }
            .back-link { color: var(--muted); font-size: 0.88rem; text-decoration: none; }
            .back-link:hover { color: var(--primary); text-decoration: underline; }

            .panel {
                padding: 22px;
                border: 1px solid var(--line);
                border-radius: 20px;
                background: var(--panel);
                box-shadow: 0 18px 45px rgba(39,84,138,0.1);
            }

            .notice, .error {
                margin: 0 0 18px;
                padding: 12px 14px;
                border-radius: 12px;
                font-size: 0.9rem;
            }

            .notice { background: rgba(46,194,126,0.1); color: var(--success); }
            .error { background: rgba(180,35,24,0.08); color: var(--danger); }
            .table-wrap { overflow-x: auto; }
            table { width: 100%; border-collapse: collapse; text-align: left; }
            th, td { padding: 14px 12px; border-bottom: 1px solid var(--line); vertical-align: middle; }
            th { color: var(--muted); font-size: 0.75rem; letter-spacing: 0.07em; text-transform: uppercase; }
            td { font-size: 0.9rem; }
            .role { color: var(--muted); font-size: 0.75rem; }
            .actions { display: flex; align-items: center; gap: 10px; white-space: nowrap; }
            .edit-link { color: var(--primary); font-weight: 700; text-decoration: none; }
            .delete-button {
                padding: 7px 10px;
                border: 1px solid var(--line);
                border-radius: 9px;
                background: transparent;
                color: var(--danger);
                font: inherit;
                font-size: 0.8rem;
                cursor: pointer;
            }

            .delete-button:hover { border-color: var(--danger); }
            .pagination { margin-top: 20px; }
            .pagination nav { display: flex; justify-content: space-between; gap: 12px; }
            .pagination a, .pagination span { color: var(--primary); font-size: 0.85rem; text-decoration: none; }

            @media (max-width: 640px) {
                body { padding: 22px 12px; }
                .panel { padding: 12px; }
                th, td { padding: 12px 8px; }
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
            <header>
                <div>
                    <h1>Kelola akun</h1>
                    <p class="subtitle">Lihat, ubah, atau hapus akun pengguna MBG Tracker.</p>
                </div>
                <a class="back-link" href="{{ route('mbg.index') }}">Kembali ke dashboard</a>
            </header>

            <section class="panel" aria-label="Daftar akun pengguna">
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
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Peran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="role">{{ $user->is_admin ? 'Admin' : 'Pengguna' }}</td>
                                    <td>
                                        <div class="actions">
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
                                    <td colspan="4">Belum ada akun pengguna.</td>
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
