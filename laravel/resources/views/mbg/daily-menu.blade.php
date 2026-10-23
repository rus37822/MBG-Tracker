<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Unggah Foto Menu Hari Ini - Pendataan MBG</title>
        <style>
            :root {
                color-scheme: light;
                --background: #edf8ff;
                --panel: rgba(255, 255, 255, 0.88);
                --text: #15324d;
                --muted: #526a82;
                --line: rgba(47, 126, 209, 0.16);
                --primary: #2f7ed1;
                --error: #b42318;
            }

            * { box-sizing: border-box; }

            body {
                display: grid;
                min-height: 100vh;
                margin: 0;
                padding: 32px 20px;
                place-items: center;
                background:
                    radial-gradient(circle at top left, rgba(142, 202, 252, 0.4), transparent 30%),
                    linear-gradient(135deg, var(--background), #f9fcff 70%);
                color: var(--text);
                font-family: "Segoe UI", Arial, sans-serif;
            }

            .page {
                width: min(100%, 680px);
            }

            .back-link {
                display: inline-block;
                margin-bottom: 18px;
                color: var(--primary);
                font-weight: 700;
                text-decoration: none;
            }

            .card {
                padding: clamp(22px, 5vw, 36px);
                border: 1px solid var(--line);
                border-radius: 24px;
                background: var(--panel);
                box-shadow: 0 24px 60px rgba(39, 84, 138, 0.12);
                backdrop-filter: blur(8px);
            }

            .eyebrow {
                margin: 0 0 8px;
                color: var(--primary);
                font-size: 0.78rem;
                font-weight: 800;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            h1 {
                margin: 0;
                font-size: clamp(1.6rem, 5vw, 2rem);
            }

            .date {
                margin: 8px 0 22px;
                color: var(--muted);
            }

            .current-photo {
                display: block;
                width: 100%;
                max-height: 340px;
                margin-bottom: 22px;
                aspect-ratio: 16 / 9;
                border-radius: 14px;
                background: #f5faff;
                object-fit: cover;
            }

            .empty-photo {
                display: grid;
                min-height: 130px;
                margin-bottom: 22px;
                place-items: center;
                border: 1px dashed var(--line);
                border-radius: 14px;
                color: var(--muted);
                text-align: center;
            }

            .notice {
                margin-bottom: 18px;
                padding: 13px 15px;
                border-radius: 12px;
                background: rgba(46, 194, 126, 0.12);
                color: #24774e;
                font-weight: 700;
            }

            form {
                display: grid;
                gap: 12px;
            }

            label {
                font-size: 0.9rem;
                font-weight: 700;
            }

            input[type="file"] {
                width: 100%;
                padding: 12px;
                border: 1px solid var(--line);
                border-radius: 12px;
                background: #f8fbff;
                color: var(--text);
                font: inherit;
            }

            .error {
                color: var(--error);
                font-size: 0.82rem;
                font-weight: 700;
            }

            button {
                min-height: 48px;
                margin-top: 4px;
                border: 0;
                border-radius: 12px;
                background: var(--primary);
                color: #fff;
                font: inherit;
                font-weight: 800;
                cursor: pointer;
            }

            button:hover { background: #2469b4; }

            .delete-button,
            .delete-button:hover {
                background: #b42318;
            }

            @media (prefers-color-scheme: dark) {
                :root {
                    color-scheme: dark;
                    --background: #07141d;
                    --panel: rgba(15, 29, 43, 0.94);
                    --text: #edf8ff;
                    --muted: #bfd6ef;
                    --line: rgba(154, 215, 255, 0.2);
                    --primary: #3890dc;
                }

                input[type="file"], .empty-photo, .current-photo { background: #112433; }
                .notice { color: #9be2b9; }
            }
        </style>
    </head>
    <body>
        <main class="page">
            <a class="back-link" href="{{ route('mbg.index') }}">&larr; Kembali ke halaman utama</a>
            <section class="card">
                <p class="eyebrow">Makanan Bergizi Gratis</p>
                <h1>Unggah Foto Menu Hari Ini</h1>
                <p class="date">{{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }}</p>

                @if (session('success'))
                    <div class="notice" role="status">{{ session('success') }}</div>
                @endif

                @if ($dailyMenu)
                    <img
                        class="current-photo"
                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($dailyMenu->foto) }}"
                        alt="Foto menu MBG hari ini"
                    >
                    <form action="{{ route('mbg.daily-menu.destroy') }}" method="POST" onsubmit="return confirm('Hapus foto menu hari ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="delete-button" type="submit">Hapus Foto Menu</button>
                    </form>
                @else
                    <div class="empty-photo">Foto menu hari ini belum diunggah.</div>
                @endif

                <form action="{{ route('mbg.daily-menu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <p>{{ $dailyMenu ? 'Pilih foto menu pengganti dari album atau ambil foto baru.' : 'Pilih foto menu dari album atau ambil foto baru.' }}</p>
                    <label for="foto_menu">Pilih dari album foto</label>
                    <input id="foto_menu" type="file" name="foto_menu" accept="image/*">
                    @error('foto_menu')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    <label for="foto_menu_kamera">Ambil foto langsung</label>
                    <input id="foto_menu_kamera" type="file" name="foto_menu_kamera" accept="image/*" capture="environment">
                    @error('foto_menu_kamera')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    <button type="submit">{{ $dailyMenu ? 'Ganti Foto Menu' : 'Simpan Foto Menu' }}</button>
                </form>
            </section>
        </main>
    </body>
</html>
