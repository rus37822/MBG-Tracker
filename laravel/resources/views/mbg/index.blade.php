<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pendataan MBG</title>
        <style>
            :root {
                --bg-1: #edf8ff;
                --bg-2: #f9fcff;
                --panel: rgba(255,255,255,0.85);
                --panel-strong: #ffffff;
                --primary: #8ecafc;
                --primary-strong: #2f7ed1;
                --secondary: #dff3ff;
                --accent: #bfe6ff;
                --success: #7ac9ff;
                --text: #15324d;
                --muted: #526a82;
                --line: rgba(47,126,209,0.12);
                --shadow: 0 24px 60px rgba(39, 84, 138, 0.12);
                --radius: 22px;
                --input-bg: rgba(245, 250, 255, 0.96);
                --input-border: rgba(47,126,209,0.12);
                --hero-bg-1: #edf9ff;
                --hero-bg-2: #cfeaff;
                --hero-bg-3: #9cc8ff;
                --hero-bg-4: #eaf7ff;
                --hero-text: #12314d;
                --hero-subtext: rgba(18,49,77,0.8);
                --button-soft: rgba(255,255,255,0.38);
            }

            :root[data-theme="dark"] {
                --bg-1: #07141d;
                --bg-2: #0d1d2b;
                --panel: rgba(15,23,34,0.82);
                --panel-strong: #102232;
                --primary: #89d1ff;
                --primary-strong: #9ad7ff;
                --secondary: #1d3146;
                --accent: #244d73;
                --success: #63d297;
                --text: #edf8ff;
                --muted: #bfd6ef;
                --line: rgba(154,215,255,0.12);
                --shadow: 0 24px 60px rgba(2, 7, 12, 0.46);
                --input-bg: #112433;
                --input-border: rgba(154,215,255,0.18);
                --hero-bg-1: #0e2339;
                --hero-bg-2: #153d5e;
                --hero-bg-3: #1b4c75;
                --hero-bg-4: #0d2033;
                --hero-text: #edf7ff;
                --hero-subtext: rgba(237,247,255,0.8);
                --button-soft: rgba(255,255,255,0.08);
            }

            * { box-sizing: border-box; }

            html {
                scroll-behavior: smooth;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: "Segoe UI", Arial, sans-serif;
                background:
                    radial-gradient(circle at top left, rgba(142, 202, 252, 0.4), transparent 24%),
                    radial-gradient(circle at bottom right, rgba(168, 215, 255, 0.22), transparent 30%),
                    linear-gradient(135deg, var(--bg-1) 0%, var(--bg-2) 55%, #f5fbff 100%);
                color: var(--text);
                overflow-x: hidden;
            }

            .welcome-overlay {
                position: fixed;
                inset: 0;
                display: grid;
                place-items: center;
                overflow: hidden;
                background: #12334b;
                z-index: 9999;
                transition: opacity 0.8s ease, visibility 0.8s ease;
            }

            .welcome-overlay::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(135deg, rgba(8, 28, 43, 0.68), rgba(14, 51, 73, 0.38) 55%, rgba(8, 28, 43, 0.66)),
                    url("{{ asset('jpg.foto/foto-prabowo,jpg.png') }}") center 42% / cover no-repeat;
                animation: welcomeBackdropIn 1.4s ease both;
            }

            .welcome-overlay.hidden {
                opacity: 0;
                visibility: hidden;
            }

            .welcome-card {
                position: relative;
                z-index: 1;
                padding: 26px 34px;
                border-radius: 28px;
                background: rgba(12, 35, 51, 0.42);
                border: 1px solid rgba(255,255,255,0.28);
                backdrop-filter: blur(12px);
                box-shadow: 0 25px 80px rgba(0,0,0,0.24);
                text-align: center;
                color: white;
                animation: floatIn 1s ease both;
            }

            .welcome-visual {
                position: relative;
                width: 96px;
                height: 96px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 18px;
            }

            .welcome-logo {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 78px;
                height: 78px;
                display: block;
                padding: 5px;
                border: 2px solid rgba(255,255,255,0.95);
                border-radius: 20px;
                object-fit: contain;
                background: #ffffff;
                box-shadow: 0 18px 36px rgba(32, 96, 161, 0.2);
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.25);
                transform-origin: center center;
                animation: logoIn 0.7s cubic-bezier(0.2, 0.9, 0.2, 1) forwards 0.45s;
            }

            .welcome-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 14px;
                border-radius: 999px;
                background: rgba(255,255,255,0.14);
                border: 1px solid rgba(255,255,255,0.18);
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: 0.12em;
                margin-bottom: 14px;
            }

            .welcome-badge::before {
                content: "";
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #d6f0ff;
                box-shadow: 0 0 0 5px rgba(214, 240, 255, 0.28);
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
                opacity: 0.8;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }


            .page-shell {
                position: relative;
                max-width: 1240px;
                margin: 0 auto;
                padding: 32px 20px 56px;
                opacity: 0;
                transform: translateY(20px);
                animation: pageIn 0.9s ease forwards 0.8s;
            }

            .ambient {
                position: absolute;
                border-radius: 50%;
                filter: blur(60px);
                opacity: 0.26;
                z-index: 0;
                animation: drift 16s ease-in-out infinite alternate;
            }

            .ambient-1 {
                width: 240px;
                height: 240px;
                background: rgba(29, 143, 95, 0.52);
                top: 40px;
                right: 5%;
            }

            .ambient-2 {
                width: 300px;
                height: 300px;
                background: rgba(15, 76, 129, 0.42);
                left: 2%;
                bottom: 80px;
                animation-delay: 1.5s;
            }

            .topbar,
            .hero-panel,
            .stats,
            .content-grid {
                position: relative;
                z-index: 1;
            }

            .topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                margin-bottom: 24px;
                padding: 16px 20px;
                border: 1px solid rgba(255,255,255,0.5);
                border-radius: 18px;
                background: rgba(255,255,255,0.52);
                backdrop-filter: blur(12px);
                box-shadow: 0 10px 30px rgba(21, 52, 41, 0.08);
            }

            .topbar-actions {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .theme-toggle {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 9px 12px;
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
                align-items: center;
                justify-content: center;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                background: rgba(142, 202, 252, 0.18);
                border: 1px solid rgba(17, 17, 17, 0.18);
            }

            .theme-toggle-icon::before {
                content: "";
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #111111;
                display: block;
                box-shadow: 0 0 0 2px rgba(17, 17, 17, 0.08);
            }

            :root[data-theme="dark"] .theme-toggle-icon {
                border-color: rgba(255, 255, 255, 0.18);
                background: rgba(255,255,255,0.06);
            }

            :root[data-theme="dark"] .theme-toggle-icon::before {
                background: #ffffff;
                box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.08);
            }

            :root[data-theme="dark"] .topbar,
            :root[data-theme="dark"] .panel,
            :root[data-theme="dark"] .stat-card,
            :root[data-theme="dark"] .mobile-tabs,
            :root[data-theme="dark"] .brand-mark,
            :root[data-theme="dark"] .theme-toggle {
                background: var(--panel);
            }

            :root[data-theme="dark"] .topbar,
            :root[data-theme="dark"] .mobile-tabs,
            :root[data-theme="dark"] .panel,
            :root[data-theme="dark"] .stat-card,
            :root[data-theme="dark"] .theme-toggle {
                border-color: var(--line);
            }

            :root[data-theme="dark"] .hero-panel {
                background: linear-gradient(135deg, var(--hero-bg-1) 0%, var(--hero-bg-2) 26%, var(--hero-bg-3) 58%, var(--hero-bg-4) 100%);
                color: var(--hero-text);
            }

            :root[data-theme="dark"] .hero-copy p {
                color: var(--hero-subtext);
            }

            :root[data-theme="dark"] .comparison-value.is-up { color: #6de0a8; }
            :root[data-theme="dark"] .comparison-value.is-down { color: #ff9b93; }

            :root[data-theme="dark"] .brand-copy span,
            :root[data-theme="dark"] .panel-header span,
            :root[data-theme="dark"] .history-filter label,
            :root[data-theme="dark"] .history-search label,
            :root[data-theme="dark"] .field label,
            :root[data-theme="dark"] .table-card p,
            :root[data-theme="dark"] thead th,
            :root[data-theme="dark"] .stat-card .label {
                color: var(--muted);
            }

            :root[data-theme="dark"] .field input,
            :root[data-theme="dark"] .field select,
            :root[data-theme="dark"] .field textarea,
            :root[data-theme="dark"] .history-filter input,
            :root[data-theme="dark"] .history-search input {
                background: var(--input-bg);
                border-color: var(--input-border);
                color: var(--text);
            }

            :root[data-theme="dark"] .hero-actions .secondary-btn,
            :root[data-theme="dark"] .pdf-btn,
            :root[data-theme="dark"] .history-filter button,
            :root[data-theme="dark"] .history-nav a,
            :root[data-theme="dark"] .history-nav span,
            :root[data-theme="dark"] .live-indicator {
                background: rgba(255,255,255,0.05);
                color: var(--text);
                border-color: var(--line);
            }

            :root[data-theme="dark"] .primary-btn {
                background: linear-gradient(135deg, #e7f8ff, #bfdfff);
                color: #0f2341;
            }

            :root[data-theme="dark"] .secondary-btn {
                background: var(--button-soft);
                border-color: var(--line);
                color: var(--text);
            }

            :root[data-theme="dark"] tbody tr:hover {
                background: rgba(154, 215, 255, 0.06);
            }

            :root[data-theme="dark"] table,
            :root[data-theme="dark"] th,
            :root[data-theme="dark"] td {
                border-color: var(--line);
            }

            :root[data-theme="dark"] .alert {
                color: var(--text);
            }

            .brand {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                min-height: 52px;
            }

            .brand-mark {
                width: 52px;
                height: 52px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                overflow: hidden;
                background: rgba(255, 255, 255, 0.7);
                border: 1px solid rgba(47,126,209,0.08);
                box-shadow: 0 8px 18px rgba(47, 126, 209, 0.08);
                transform: rotate(0deg);
                flex-shrink: 0;
            }

            .brand-mark img {
                width: 100%;
                height: 100%;
                display: block;
                object-fit: cover;
                object-position: center;
                transform: rotate(0deg) scale(1);
                filter: none;
                border-radius: 10px;
            }

            .brand-copy {
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 2px;
                line-height: 1.1;
            }

            .brand-copy strong {
                font-size: 0.93rem;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .brand-copy span {
                color: var(--muted);
                font-size: 0.75rem;
            }

            .live-indicator {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 16px;
                border-radius: 999px;
                background: rgba(46, 194, 126, 0.12);
                color: var(--primary-strong);
                font-size: 0.8rem;
                font-weight: 700;
                border: 1px solid rgba(46,194,126,0.2);
            }

            .live-indicator::before {
                content: "";
                width: 9px;
                height: 9px;
                border-radius: 50%;
                background: var(--success);
                box-shadow: 0 0 0 5px rgba(46, 194, 126, 0.18);
                animation: pulse 2s infinite ease-in-out;
            }

            .hero-panel {
                display: grid;
                grid-template-columns: 1.2fr 0.8fr;
                gap: 28px;
                padding: 28px;
                border-radius: 30px;
                background: linear-gradient(135deg, #edf9ff 0%, #cfeaff 26%, #9cc8ff 58%, #eaf7ff 100%);
                color: #12314d;
                box-shadow: 0 26px 70px rgba(70, 118, 181, 0.18);
                margin-bottom: 22px;
                overflow: hidden;
            }

            .hero-copy {
                padding: 8px 4px;
            }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 14px;
                border-radius: 999px;
                background: rgba(255,255,255,0.12);
                border: 1px solid rgba(255,255,255,0.16);
                letter-spacing: 0.12em;
                text-transform: uppercase;
                font-size: 11px;
                font-weight: 700;
            }

            .hero-copy h1 {
                margin: 18px 0 14px;
                font-size: clamp(2.3rem, 4vw, 4.2rem);
                line-height: 0.96;
                letter-spacing: -0.06em;
            }

            .hero-copy h1 span {
                display: block;
                color: #f5fbff;
            }

            .hero-copy p {
                max-width: 620px;
                margin: 0;
                color: rgba(18,49,77,0.8);
                font-size: 1.05rem;
                line-height: 1.7;
            }

            .hero-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 14px;
                margin-top: 24px;
            }

            .primary-btn,
            .secondary-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 48px;
                padding: 0 20px;
                border-radius: 14px;
                font-weight: 700;
                text-decoration: none;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .primary-btn {
                background: linear-gradient(135deg, #ffffff, #e4f5ff);
                color: var(--primary-strong);
                box-shadow: 0 16px 30px rgba(116, 175, 236, 0.2);
            }

            .secondary-btn {
                background: rgba(255,255,255,0.38);
                color: var(--primary-strong);
                border: 1px solid rgba(47,126,209,0.18);
            }

            .primary-btn:hover,
            .secondary-btn:hover,
            .submit-button:hover {
                transform: translateY(-2px);
            }

            .hero-visual {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .visual-card {
                position: relative;
                width: min(100%, 360px);
                min-height: 280px;
                padding: 22px;
                border-radius: 28px;
                background: rgba(255,255,255,0.09);
                border: 1px solid rgba(255,255,255,0.14);
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.08);
                backdrop-filter: blur(9px);
            }

            .mini-metric {
                display: inline-flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding: 14px 16px;
                border-radius: 16px;
                background: rgba(255,255,255,0.08);
                margin-bottom: 18px;
            }

            .mini-metric strong {
                font-size: 1.8rem;
            }

            .mini-metric small {
                display: block;
                opacity: 0.8;
                font-size: 0.7rem;
                text-transform: uppercase;
                letter-spacing: 0.12em;
            }

            .ring-wrap {
                position: relative;
                display: grid;
                place-items: center;
                width: 180px;
                height: 180px;
                margin: 12px auto 0;
            }

            .progress-ring {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                background: conic-gradient(#dff5ff 0 72%, rgba(255,255,255,0.14) 72% 100%);
                display: grid;
                place-items: center;
                box-shadow: inset 0 0 0 10px rgba(255,255,255,0.05);
            }

            .progress-ring::before {
                content: "";
                width: 120px;
                height: 120px;
                border-radius: 50%;
                background: linear-gradient(180deg, rgba(18,49,77,0.8), rgba(96,170,232,0.32));
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.12);
            }

            .ring-center {
                position: absolute;
                text-align: center;
                z-index: 2;
            }

            .ring-center strong {
                font-size: 2.2rem;
                display: block;
                line-height: 1;
            }

            .ring-center span {
                font-size: 0.7rem;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                opacity: 0.8;
            }

            .stats {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 20px;
                margin-bottom: 24px;
            }

            .stat-card {
                position: relative;
                padding: 24px 22px;
                border-radius: var(--radius);
                background: rgba(255,255,255,0.72);
                border: 1px solid var(--line);
                box-shadow: var(--shadow);
                overflow: hidden;
            }

            .stat-card::after {
                content: "";
                position: absolute;
                inset: 0 auto auto 0;
                width: 100%;
                height: 4px;
                background: linear-gradient(90deg, var(--primary), var(--secondary));
            }

            .stat-card .label {
                display: block;
                margin-bottom: 10px;
                font-size: 0.78rem;
                text-transform: uppercase;
                letter-spacing: 0.12em;
                color: var(--muted);
                font-weight: 700;
            }

            .stat-card .date {
                display: block;
                margin-top: 8px;
                color: var(--muted);
                font-size: 0.78rem;
            }

            .stat-card .value {
                font-size: clamp(2rem, 4vw, 2.7rem);
                line-height: 1;
                font-weight: 800;
                letter-spacing: -0.06em;
            }

            .stat-card:nth-child(1) .value { color: var(--primary-strong); }
            .stat-card:nth-child(2) .value { color: #4a9ae6; }
            .stat-card:nth-child(3) .value { color: #7dbaf3; }

            .stat-card .comparison-value {
                display: block;
                margin-top: 4px;
                font-size: clamp(2rem, 4vw, 2.7rem);
                line-height: 1;
                font-weight: 800;
                letter-spacing: -0.06em;
            }

            .comparison-value.is-up { color: #168457; }
            .comparison-value.is-down { color: #c2413b; }
            .comparison-value.is-even { color: var(--primary-strong); }

            .stat-card .comparison-detail {
                display: block;
                margin-top: 10px;
                color: var(--muted);
                font-size: 0.78rem;
                line-height: 1.5;
            }

            .today-chart {
                grid-column: 1 / -1;
                padding: 24px;
                border: 1px solid var(--line);
                border-radius: 22px;
                background: var(--panel);
                box-shadow: var(--shadow);
            }

            .today-chart-header {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 24px;
            }

            .today-chart h2 {
                margin: 0;
                font-size: 1.15rem;
            }

            .today-chart-subtitle {
                display: block;
                margin-top: 6px;
                color: var(--muted);
                font-size: 0.82rem;
            }

            .today-chart-total {
                flex: 0 0 auto;
                padding: 9px 12px;
                border-radius: 12px;
                background: var(--button-soft);
                color: var(--primary-strong);
                font-size: 0.8rem;
                font-weight: 700;
            }

            .today-chart-controls {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                flex-wrap: wrap;
                gap: 12px;
            }

            .today-chart-plot {
                display: grid;
                grid-template-columns: repeat(24, minmax(0, 1fr));
                grid-template-rows: minmax(0, 1fr);
                align-items: end;
                gap: 8px;
                height: 180px;
                padding: 12px 0 0;
                border-bottom: 1px solid var(--line);
                background: repeating-linear-gradient(
                    to top,
                    transparent 0,
                    transparent calc(25% - 1px),
                    var(--line) calc(25% - 1px),
                    var(--line) 25%
                );
            }

            .today-chart-hour {
                display: flex;
                height: 100%;
                flex-direction: column;
                justify-content: flex-end;
                align-items: center;
                gap: 7px;
                min-width: 0;
            }

            .today-chart-bar {
                width: min(100%, 24px);
                min-height: 3px;
                border-radius: 7px 7px 0 0;
                background: linear-gradient(180deg, #8ecafc, #2f7ed1);
                transition: height 0.3s ease;
            }

            .today-chart-hour-label {
                min-height: 14px;
                color: var(--muted);
                font-size: 0.65rem;
                line-height: 1;
            }

            .today-chart-empty {
                margin: 16px 0 0;
                color: var(--muted);
                font-size: 0.85rem;
            }

            .content-grid {
                display: grid;
                grid-template-columns: 1.1fr 1.4fr;
                gap: 24px;
                align-items: start;
            }

            .panel {
                background: rgba(255,255,255,0.8);
                backdrop-filter: blur(8px);
                border: 1px solid rgba(18,42,32,0.08);
                border-radius: 28px;
                box-shadow: var(--shadow);
            }

            .form-card {
                padding: 26px;
            }

            .daily-menu {
                margin-bottom: 26px;
                padding: 16px;
                border: 1px solid var(--line);
                border-radius: 18px;
                background: linear-gradient(180deg, rgba(255,255,255,0.92), var(--panel-strong));
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
            }

            .daily-menu-heading {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin-bottom: 14px;
            }

            .daily-menu-heading h3 {
                margin: 0;
                font-size: 1.05rem;
            }

            .daily-menu-heading span,
            .daily-menu-empty {
                color: var(--muted);
                font-size: 0.85rem;
            }

            .daily-menu-photo {
                display: block;
                width: 100%;
                max-height: 360px;
                aspect-ratio: 16 / 9;
                object-fit: contain;
                border: 1px solid rgba(18, 42, 32, 0.08);
                border-radius: 14px;
                background: linear-gradient(135deg, rgba(230, 239, 246, 0.9), rgba(240, 246, 251, 0.9));
                box-shadow: 0 12px 28px rgba(16, 50, 95, 0.08);
            }

            .daily-menu-empty {
                display: grid;
                min-height: 180px;
                place-items: center;
                margin-bottom: 14px;
                border: 1px dashed var(--input-border);
                border-radius: 14px;
                background: rgba(148, 180, 210, 0.08);
                text-align: center;
            }

            .daily-menu-upload-link {
                display: grid;
                min-height: 46px;
                margin-top: 14px;
                place-items: center;
                border-radius: 12px;
                background: linear-gradient(135deg, var(--primary-strong), #4da0ea);
                color: #fff;
                font: inherit;
                font-weight: 700;
                text-align: center;
                text-decoration: none;
                box-shadow: 0 10px 20px rgba(47, 126, 209, 0.18);
            }

            .panel-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin-bottom: 20px;
            }

            .panel-header h2 {
                margin: 0;
                font-size: clamp(1.3rem, 2vw, 1.7rem);
                letter-spacing: -0.04em;
            }

            .panel-header span {
                display: inline-flex;
                align-items: center;
                padding: 8px 12px;
                border-radius: 999px;
                background: rgba(29,143,95,0.08);
                color: var(--primary-strong);
                font-size: 0.72rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                font-weight: 700;
            }

            .header-actions {
                display: flex;
                align-items: center;
                gap: 10px;
                flex-wrap: wrap;
            }

            .pdf-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 9px 14px;
                border-radius: 12px;
                background: rgba(47,126,209,0.08);
                color: var(--primary-strong);
                border: 1px solid rgba(47,126,209,0.12);
                text-decoration: none;
                font-size: 0.75rem;
                font-weight: 700;
                letter-spacing: 0.04em;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .history-tools {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 12px;
                padding: 14px 0;
                border-bottom: 1px solid rgba(47,126,209,0.12);
            }

            .history-filter,
            .history-nav {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 8px;
            }

            .history-filter label {
                color: var(--muted);
                font-size: 0.78rem;
                font-weight: 700;
            }

            .history-filter input {
                min-height: 40px;
                padding: 8px 10px;
                border: 1px solid rgba(47,126,209,0.2);
                border-radius: 10px;
                color: var(--text);
                font: inherit;
            }

            .history-filter button,
            .history-nav a,
            .history-nav span {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 40px;
                padding: 8px 12px;
                border: 1px solid rgba(47,126,209,0.16);
                border-radius: 10px;
                background: rgba(47,126,209,0.07);
                color: var(--primary-strong);
                font-size: 0.78rem;
                font-weight: 700;
                text-decoration: none;
                white-space: nowrap;
            }

            .history-filter button {
                cursor: pointer;
            }

            .history-search {
                display: grid;
                gap: 8px;
                margin: 16px 0 10px;
            }

            .history-search label {
                color: var(--muted);
                font-size: 0.82rem;
                font-weight: 700;
            }

            .history-search input {
                width: min(100%, 420px);
                min-height: 42px;
                padding: 9px 12px;
                border: 1px solid var(--input-border);
                border-radius: 10px;
                background: var(--input-bg);
                color: var(--text);
                font: inherit;
            }

            .history-search-status {
                margin: 0;
                color: var(--muted);
                font-size: 0.8rem;
            }

            #history-search-empty td {
                color: var(--muted);
                text-align: center;
            }

            .history-nav span[aria-disabled="true"] {
                opacity: 0.45;
            }

            .delete-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 7px 10px;
                border: none;
                border-radius: 10px;
                background: rgba(220, 38, 38, 0.1);
                color: #b42318;
                font-size: 0.72rem;
                font-weight: 700;
                cursor: pointer;
            }

            .delete-confirmation {
                width: min(420px, calc(100vw - 32px));
                max-width: none;
                padding: 26px;
                border: 1px solid var(--line);
                border-radius: 20px;
                background: var(--panel-strong);
                color: var(--text);
                box-shadow: var(--shadow);
            }

            .delete-confirmation[open] {
                animation: deleteDialogIn 0.32s cubic-bezier(0.18, 0.9, 0.28, 1.25) both;
            }

            .delete-confirmation::backdrop {
                background: rgba(7, 20, 29, 0.54);
                backdrop-filter: blur(5px);
                animation: deleteBackdropIn 0.2s ease both;
            }

            .delete-confirmation-icon {
                display: grid;
                width: 48px;
                height: 48px;
                margin-bottom: 18px;
                place-items: center;
                border: 1px solid rgba(180, 35, 24, 0.16);
                border-radius: 16px;
                background: rgba(220, 38, 38, 0.1);
                color: #b42318;
                font-size: 1.4rem;
                font-weight: 800;
            }

            .delete-confirmation h2 {
                margin: 0 0 8px;
                font-size: 1.2rem;
            }

            .delete-confirmation p {
                margin: 0;
                color: var(--muted);
                line-height: 1.55;
            }

            .delete-confirmation-actions {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                margin-top: 24px;
            }

            .delete-confirmation-actions button {
                min-height: 42px;
                padding: 9px 14px;
                border: 1px solid var(--line);
                border-radius: 10px;
                font: inherit;
                font-size: 0.82rem;
                font-weight: 700;
                cursor: pointer;
                transition: transform 0.18s ease, box-shadow 0.18s ease;
            }

            .delete-confirmation-actions button:hover {
                transform: translateY(-1px);
                box-shadow: 0 8px 18px rgba(15, 31, 47, 0.12);
            }

            .delete-confirmation-cancel {
                background: var(--button-soft);
                color: var(--text);
            }

            .delete-confirmation-submit {
                border-color: #b42318 !important;
                background: #b42318;
                color: #ffffff;
            }

            @keyframes deleteDialogIn {
                from {
                    opacity: 0;
                    transform: translateY(14px) scale(0.88);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            @keyframes deleteBackdropIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            @media (prefers-reduced-motion: reduce) {
                .delete-confirmation[open],
                .delete-confirmation::backdrop {
                    animation: none;
                }
            }

            .pdf-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 10px 18px rgba(47,126,209,0.14);
            }

            .grid-form {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 16px;
            }

            .field {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .field.full {
                grid-column: 1 / -1;
            }

            .field label {
                font-size: 0.85rem;
                font-weight: 700;
                color: var(--muted);
            }

            .field input,
            .field select,
            .field textarea {
                width: 100%;
                border: 1px solid rgba(47,126,209,0.12);
                background: rgba(245, 250, 255, 0.96);
                border-radius: 14px;
                padding: 13px 14px;
                font-size: 0.96rem;
                color: var(--text);
                transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
            }

            .field input:hover,
            .field select:hover,
            .field textarea:hover {
                border-color: rgba(47,126,209,0.28);
            }

            .field input:focus,
            .field select:focus,
            .field textarea:focus {
                outline: none;
                border-color: rgba(47,126,209,0.7);
                box-shadow: 0 0 0 4px rgba(47,126,209,0.12);
                transform: translateY(-1px);
            }

            .field textarea {
                min-height: 110px;
                resize: vertical;
            }

            .photo-preview {
                width: 100%;
                max-height: 240px;
                object-fit: contain;
                border-radius: 8px;
                background: rgba(47,126,209,0.06);
            }

            .pickup-photo {
                width: 56px;
                height: 56px;
                object-fit: cover;
                border-radius: 8px;
            }

            .error {
                color: #b42318;
                font-size: 0.76rem;
                font-weight: 700;
            }

            .submit-button {
                width: 100%;
                margin-top: 18px;
                border: none;
                border-radius: 16px;
                background: linear-gradient(135deg, var(--primary-strong), #7ec8ff);
                color: white;
                padding: 16px 18px;
                font-size: 1rem;
                font-weight: 800;
                cursor: pointer;
                box-shadow: 0 16px 30px rgba(47,126,209,0.25);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .table-card {
                padding: 22px 18px 10px;
            }

            .table-wrap {
                overflow-x: auto;
                margin-top: 14px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                min-width: 660px;
            }

            thead th {
                text-align: left;
                padding: 12px 10px;
                color: var(--muted);
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.12em;
                border-bottom: 1px solid rgba(47,126,209,0.12);
            }

            tbody td {
                padding: 14px 10px;
                border-bottom: 1px solid rgba(47,126,209,0.12);
                vertical-align: middle;
            }

            tbody tr {
                transition: background 0.2s ease;
            }

            tbody tr:hover {
                background: rgba(142, 202, 252, 0.05);
            }

            .badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 7px 10px;
                border-radius: 999px;
                background: rgba(126, 200, 255, 0.18);
                color: var(--primary-strong);
                font-size: 0.7rem;
                font-weight: 800;
                letter-spacing: 0.04em;
                text-transform: uppercase;
            }

            .alert {
                margin-bottom: 20px;
                padding: 15px 18px;
                border-radius: 14px;
                background: rgba(46, 194, 126, 0.12);
                border: 1px solid rgba(46,194,126,0.22);
                color: var(--primary-strong);
                font-weight: 700;
            }

            .alert.alert-error {
                background: rgba(180,35,24,0.08);
                border-color: rgba(180,35,24,0.2);
                color: #b42318;
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

            @media (prefers-reduced-motion: reduce) {
                .mbg-car {
                    right: 0;
                    left: auto;
                    animation: none;
                }
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
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

            @keyframes pulse {
                0%, 100% { transform: scale(1); opacity: 1; }
                50% { transform: scale(1.22); opacity: 0.7; }
            }

            @keyframes logoReveal {
                0% {
                    opacity: 0;
                    transform: translate(-50%, -50%) scale(0.2);
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

            @keyframes pageIn {
                from {
                    opacity: 0;
                    transform: translateY(18px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes drift {
                0% { transform: translate3d(0, 0, 0) scale(1); }
                100% { transform: translate3d(24px, -30px, 0) scale(1.15); }
            }

            @media (max-width: 960px) {
                .hero-panel,
                .content-grid,
                .stats,
                .grid-form {
                    grid-template-columns: 1fr;
                }

                .topbar {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }

            .mobile-tabs {
                display: none;
            }

            @media (max-width: 640px) {
                .welcome-overlay::before {
                    background-position: 86% 42%;
                }

                :root {
                    --radius: 18px;
                }

                body {
                    min-width: 320px;
                }

                .page-shell {
                    padding: 18px 12px 34px;
                    max-width: 100%;
                }

                .topbar,
                .hero-panel,
                .form-card,
                .table-card {
                    border-radius: 20px;
                }

                .topbar {
                    padding: 14px 14px;
                    margin-bottom: 16px;
                }

                .welcome-card {
                    width: calc(100% - 32px);
                    padding: 24px 18px;
                }

                .welcome-visual {
                    width: 88px;
                    height: 88px;
                }

                .brand {
                    width: 100%;
                }

                .brand-copy strong {
                    font-size: 0.8rem;
                }

                .brand-copy span {
                    font-size: 0.68rem;
                }

                .live-indicator {
                    align-self: flex-end;
                    font-size: 0.72rem;
                    padding: 8px 12px;
                }

                .hero-panel {
                    padding: 20px 16px;
                    gap: 18px;
                }

                .hero-copy h1 {
                    font-size: clamp(1.9rem, 8vw, 2.6rem);
                    margin-top: 14px;
                }

                .hero-copy p {
                    font-size: 0.9rem;
                    line-height: 1.6;
                }

                .hero-actions {
                    flex-direction: column;
                    gap: 10px;
                    margin-top: 18px;
                }

                .primary-btn,
                .secondary-btn {
                    width: 100%;
                    min-height: 46px;
                    font-size: 0.92rem;
                }

                .visual-card {
                    min-height: 200px;
                    padding: 16px;
                }

                .ring-wrap {
                    width: 150px;
                    height: 150px;
                }

                .ring-center strong {
                    font-size: 1.8rem;
                }

                .mobile-tabs {
                    display: grid;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                    gap: 8px;
                    position: sticky;
                    top: max(8px, env(safe-area-inset-top));
                    z-index: 20;
                    margin: 0 0 16px;
                    padding: 8px;
                    background: rgba(255,255,255,0.82);
                    border: 1px solid rgba(47,126,209,0.08);
                    border-radius: 16px;
                    box-shadow: 0 12px 26px rgba(21, 52, 41, 0.08);
                    backdrop-filter: blur(8px);
                    -webkit-backdrop-filter: blur(8px);
                }

                .mobile-tab {
                    border: none;
                    border-radius: 12px;
                    background: transparent;
                    color: var(--muted);
                    font-weight: 700;
                    font-size: 0.7rem;
                    letter-spacing: 0.02em;
                    padding: 11px 6px;
                    cursor: pointer;
                    transition: all 0.2s ease;
                }

                .mobile-tab.is-active {
                    background: linear-gradient(135deg, var(--primary-strong), #7ec8ff);
                    color: white;
                    box-shadow: 0 10px 20px rgba(47,126,209,0.2);
                }

                .stats,
                .form-card,
                .table-card {
                    display: none;
                }

                .stats.mobile-panel.is-active,
                .form-card.mobile-panel.is-active,
                .table-card.mobile-panel.is-active {
                    display: block;
                }

                .stats.mobile-panel.is-active {
                    display: grid;
                    gap: 12px;
                }

                .today-chart {
                    padding: 18px 14px;
                    border-radius: 18px;
                }

                .today-chart-header {
                    gap: 8px;
                    margin-bottom: 18px;
                }

                .today-chart-controls {
                    justify-content: flex-start;
                }

                .today-chart h2 {
                    font-size: 1rem;
                }

                .today-chart-subtitle,
                .today-chart-total {
                    font-size: 0.72rem;
                }

                .today-chart-plot {
                    gap: 4px;
                    height: 150px;
                }

                .today-chart-hour-label {
                    font-size: 0.58rem;
                }

                .stat-card {
                    padding: 18px 16px;
                    border-radius: 18px;
                }

                .stat-card .label {
                    font-size: 0.67rem;
                    letter-spacing: 0.08em;
                }

                .stat-card .date {
                    font-size: 0.72rem;
                }

                .stat-card .value {
                    font-size: 2rem;
                }

                .panel-header {
                    align-items: flex-start;
                    flex-direction: column;
                    gap: 8px;
                    margin-bottom: 16px;
                }

                .panel-header h2 {
                    font-size: 1.2rem;
                }

                .history-tools {
                    align-items: stretch;
                }

                .history-filter {
                    width: 100%;
                }

                .history-filter input {
                    min-width: 0;
                    flex: 1;
                }

                .history-search input {
                    width: 100%;
                }

                .history-nav {
                    width: 100%;
                }

                .grid-form {
                    grid-template-columns: 1fr;
                    gap: 14px;
                }

                .field label {
                    font-size: 0.78rem;
                }

                .field input,
                .field select,
                .field textarea {
                    padding: 12px 12px;
                    font-size: 0.9rem;
                }

                .submit-button {
                    margin-top: 14px;
                    min-height: 48px;
                    font-size: 0.96rem;
                }

                .content-grid {
                    display: block;
                }

                .table-card {
                    padding: 18px 12px 8px;
                }

                .table-wrap {
                    margin-top: 10px;
                }

                table {
                    min-width: 560px;
                    font-size: 0.78rem;
                }

                thead th,
                tbody td {
                    padding: 10px 8px;
                }
            }

            :root {
                --radius: 24px;
                --shadow: 0 18px 48px rgba(39, 84, 138, 0.1);
            }

            body {
                background:
                    radial-gradient(circle at 8% 2%, rgba(142, 202, 252, 0.34), transparent 25%),
                    radial-gradient(circle at 92% 82%, rgba(168, 215, 255, 0.2), transparent 28%),
                    linear-gradient(145deg, var(--bg-1), var(--bg-2) 58%, #f5fbff);
            }

            .page-shell {
                max-width: 1360px;
                padding-top: 28px;
            }

            .topbar {
                padding: 14px 20px;
                border-color: var(--line);
                border-radius: 22px;
                background: var(--panel);
                box-shadow: 0 12px 32px rgba(39, 84, 138, 0.08);
            }

            .brand-mark {
                width: 56px;
                height: 56px;
                border-radius: 16px;
                box-shadow: 0 8px 20px rgba(47, 126, 209, 0.14);
            }

            .brand-copy strong {
                letter-spacing: 0.04em;
            }

            .hero-panel {
                position: relative;
                isolation: isolate;
                grid-template-columns: minmax(0, 1.25fr) minmax(260px, 0.75fr);
                padding: clamp(28px, 5vw, 56px);
                border: 1px solid rgba(255, 255, 255, 0.56);
                border-radius: 34px;
                box-shadow: 0 28px 72px rgba(70, 118, 181, 0.2);
            }

            .hero-panel::after {
                position: absolute;
                top: -150px;
                right: -90px;
                z-index: 0;
                width: 360px;
                height: 360px;
                border: 1px solid rgba(255, 255, 255, 0.34);
                border-radius: 50%;
                box-shadow: 0 0 0 34px rgba(255, 255, 255, 0.08), 0 0 0 68px rgba(255, 255, 255, 0.06);
                content: "";
                pointer-events: none;
            }

            .hero-copy,
            .hero-visual {
                position: relative;
                z-index: 1;
            }

            .hero-copy h1 {
                max-width: 720px;
                line-height: 1.02;
                letter-spacing: -0.055em;
            }

            .hero-copy p {
                max-width: 560px;
            }

            .primary-btn,
            .secondary-btn,
            .submit-button,
            .daily-menu-upload-link,
            .pdf-btn,
            .history-filter button,
            .history-nav a,
            .history-search-clear,
            .delete-btn {
                transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
            }

            .primary-btn:hover,
            .secondary-btn:hover,
            .submit-button:hover,
            .daily-menu-upload-link:hover,
            .history-filter button:hover,
            .history-nav a:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 24px rgba(47, 126, 209, 0.18);
            }

            .visual-card {
                display: grid;
                min-height: 300px;
                place-items: center;
                border-color: rgba(255, 255, 255, 0.36);
                background: rgba(255, 255, 255, 0.2);
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.45), 0 18px 40px rgba(47, 126, 209, 0.1);
            }

            .ring-wrap {
                margin: 0 auto;
            }

            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 18px;
            }

            .stat-card {
                padding: 26px;
                border-radius: 22px;
                background: var(--panel);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .stat-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 22px 48px rgba(39, 84, 138, 0.14);
            }

            .stat-card::after {
                height: 5px;
            }

            .stat-card .label {
                letter-spacing: 0.08em;
            }

            .content-grid {
                grid-template-columns: minmax(0, 0.92fr) minmax(0, 1.38fr);
                gap: 20px;
            }

            .panel {
                border-color: var(--line);
                border-radius: 26px;
                background: var(--panel);
                box-shadow: var(--shadow);
            }

            .form-card,
            .table-card {
                padding: 26px;
            }

            .daily-menu {
                padding: 18px;
                border-radius: 20px;
            }

            .daily-menu-photo {
                max-height: 420px;
                border-radius: 16px;
            }

            .daily-menu-upload-link {
                border-radius: 12px;
            }

            .field input,
            .field select,
            .field textarea,
            .history-filter input,
            .history-search input {
                border-color: var(--input-border);
                background: var(--input-bg);
                color: var(--text);
            }

            .submit-button {
                min-height: 54px;
                border-radius: 14px;
                background: linear-gradient(135deg, var(--primary-strong), #68b7f5);
            }

            .table-wrap {
                border: 1px solid var(--line);
                border-radius: 16px;
                background: var(--panel-strong);
            }

            table {
                min-width: 680px;
            }

            thead th {
                background: rgba(142, 202, 252, 0.1);
            }

            tbody tr {
                transition: background-color 0.18s ease;
            }

            tbody tr:hover {
                background: rgba(142, 202, 252, 0.1);
            }

            .history-search-control {
                display: flex;
                align-items: center;
                gap: 8px;
                width: min(100%, 480px);
            }

            .history-search-control input {
                flex: 1;
                min-width: 0;
            }

            .history-search-clear {
                min-height: 42px;
                padding: 8px 13px;
                border: 1px solid var(--line);
                border-radius: 10px;
                background: var(--button-soft);
                color: var(--primary-strong);
                font: inherit;
                font-size: 0.82rem;
                font-weight: 700;
                cursor: pointer;
            }

            .history-search-clear:hover {
                transform: translateY(-1px);
                box-shadow: 0 8px 18px rgba(47, 126, 209, 0.12);
            }

            .history-search-clear[hidden] {
                display: none;
            }

            .live-indicator {
                gap: 10px;
                padding: 9px 13px;
            }

            .live-indicator time {
                padding-left: 10px;
                border-left: 1px solid currentColor;
                font-variant-numeric: tabular-nums;
                letter-spacing: 0.04em;
            }

            .mobile-tabs {
                border-color: var(--line);
                background: var(--panel);
                box-shadow: 0 12px 28px rgba(39, 84, 138, 0.12);
            }

            :root[data-theme="dark"] .table-wrap {
                background: var(--panel-strong);
            }

            :root[data-theme="dark"] thead th {
                background: rgba(154, 215, 255, 0.06);
            }

            :root[data-theme="dark"] tbody tr:hover {
                background: rgba(154, 215, 255, 0.08);
            }

            :root[data-theme="dark"] .history-search-clear {
                color: var(--text);
            }

            .theme-toggle:focus-visible,
            .primary-btn:focus-visible,
            .secondary-btn:focus-visible,
            .history-search-clear:focus-visible,
            .mobile-tab:focus-visible {
                outline: 3px solid var(--primary-strong);
                outline-offset: 3px;
            }

            @media (max-width: 960px) {
                .content-grid {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 640px) {
                .page-shell {
                    padding-top: 16px;
                }

                .hero-panel {
                    grid-template-columns: 1fr;
                    padding: 24px 18px;
                    border-radius: 26px;
                }

                .hero-panel::after {
                    top: -210px;
                    right: -210px;
                    width: 300px;
                    height: 300px;
                }

                .hero-visual {
                    display: none;
                }

                .stats {
                    grid-template-columns: 1fr;
                }

                .form-card,
                .table-card {
                    padding: 20px 16px;
                }

                .history-search-control {
                    width: 100%;
                }

                .live-indicator {
                    align-self: flex-end;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                *,
                *::before,
                *::after {
                    scroll-behavior: auto !important;
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                }
            }

            .topbar {
                display: grid;
                grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr);
            }

            .topbar-actions {
                justify-self: end;
            }

            .desktop-nav {
                display: flex;
                align-items: center;
                gap: 4px;
                padding: 5px;
                border: 1px solid var(--line);
                border-radius: 999px;
                background: var(--button-soft);
            }

            .desktop-nav a {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 38px;
                padding: 8px 13px;
                border-radius: 999px;
                color: var(--muted);
                font-size: 0.8rem;
                font-weight: 700;
                text-decoration: none;
                white-space: nowrap;
                transition: color 0.2s ease, background-color 0.2s ease, transform 0.2s ease;
            }

            .desktop-nav a:hover {
                transform: translateY(-1px);
                background: rgba(142, 202, 252, 0.2);
                color: var(--primary-strong);
            }

            .desktop-nav a:focus-visible {
                outline: 3px solid var(--primary-strong);
                outline-offset: 2px;
            }

            #summary-panel,
            #form-panel,
            #history-panel {
                scroll-margin-top: 24px;
            }

            @media (max-width: 960px) {
                .topbar {
                    display: flex;
                    flex-direction: column;
                    align-items: stretch;
                }

                .desktop-nav {
                    justify-content: center;
                }
            }

            @media (max-width: 640px) {
                .desktop-nav {
                    display: none;
                }
            }

            .desktop-nav a[aria-current="page"] {
                background: var(--primary-strong);
                color: #fff;
                box-shadow: 0 6px 16px rgba(47, 126, 209, 0.2);
            }

            .page-heading {
                display: flex;
                align-items: flex-end;
                justify-content: space-between;
                gap: 24px;
                margin: 8px 0 22px;
                padding: 28px 32px;
                border: 1px solid var(--line);
                border-radius: 26px;
                background: var(--panel);
            }

            .page-heading[hidden] {
                display: none;
                box-shadow: var(--shadow);
            }

            .page-heading-copy {
                max-width: 720px;
            }

            .page-heading-kicker {
                display: block;
                margin-bottom: 8px;
                color: var(--primary-strong);
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.12em;
                text-transform: uppercase;
            }

            .page-heading h1 {
                margin: 0;
                font-size: clamp(1.8rem, 3vw, 2.6rem);
                letter-spacing: -0.055em;
            }

            .page-heading p {
                margin: 10px 0 0;
                color: var(--muted);
                line-height: 1.65;
            }

            .page-heading-date {
                flex: 0 0 auto;
                padding: 11px 15px;
                border: 1px solid var(--line);
                border-radius: 14px;
                background: var(--button-soft);
                color: var(--muted);
                font-size: 0.82rem;
                font-weight: 700;
            }

            @media (min-width: 641px) {
                .page-shell[data-page="summary"] .content-grid,
                .page-shell[data-page="form"] .stats,
                .page-shell[data-page="history"] .stats,
                .page-shell[data-page="form"] .hero-panel,
                .page-shell[data-page="history"] .hero-panel {
                    display: none;
                }

                .page-shell[data-page="form"] .content-grid,
                .page-shell[data-page="history"] .content-grid {
                    grid-template-columns: minmax(0, 1fr);
                }

                .page-shell[data-page="form"] #history-panel,
                .page-shell[data-page="history"] #form-panel {
                    display: none;
                }

                .page-shell[data-page="form"] .form-card,
                .page-shell[data-page="history"] .table-card {
                    padding: clamp(24px, 4vw, 38px);
                }
            }

            @media (max-width: 640px) {
                .page-heading {
                    display: none;
                }
            }

            .page-shell {
                width: min(100% - 40px, 1440px);
                padding-top: 22px;
            }

            .topbar {
                margin-bottom: 24px;
                padding: 12px 16px;
                border: 1px solid var(--line);
                border-radius: 22px;
                background: var(--panel);
                box-shadow: 0 12px 32px rgba(39, 84, 138, 0.08);
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
            }

            .hero-panel {
                margin-bottom: 26px;
                overflow: hidden;
            }

            .hero-copy h1 {
                font-size: clamp(2.4rem, 5vw, 4.4rem);
            }

            .eyebrow {
                padding: 8px 12px;
                border: 1px solid rgba(255, 255, 255, 0.45);
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(8px);
            }

            .primary-btn {
                gap: 10px;
                min-height: 52px;
                padding-inline: 22px;
                border: 1px solid rgba(255, 255, 255, 0.72);
                border-radius: 16px;
            }

            .primary-btn::after {
                content: "\2192";
                font-size: 1.15rem;
                transition: transform 0.2s ease;
            }

            .primary-btn:hover::after {
                transform: translateX(3px);
            }

            .stat-card {
                min-height: 172px;
                padding: 24px;
                border-radius: 24px;
            }

            .stat-card .stat-icon {
                display: grid;
                width: 42px;
                height: 42px;
                place-items: center;
                margin-bottom: 18px;
                border: 1px solid var(--line);
                border-radius: 14px;
                background: var(--button-soft);
                color: var(--primary-strong);
            }

            .stat-card .stat-icon svg {
                width: 21px;
                height: 21px;
                fill: none;
                stroke: currentColor;
                stroke-linecap: round;
                stroke-linejoin: round;
                stroke-width: 1.8;
            }

            .stat-card .label {
                margin-bottom: 8px;
            }

            .stat-card .value {
                font-variant-numeric: tabular-nums;
            }

            .today-chart {
                padding: clamp(20px, 3vw, 30px);
                border-radius: 26px;
            }

            .today-chart-controls {
                align-items: flex-end;
            }

            .chart-shortcuts {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 8px;
            }

            .chart-shortcuts a {
                display: inline-flex;
                min-height: 38px;
                align-items: center;
                justify-content: center;
                padding: 8px 12px;
                border: 1px solid var(--line);
                border-radius: 12px;
                background: var(--button-soft);
                color: var(--primary-strong);
                font-size: 0.76rem;
                font-weight: 700;
                text-decoration: none;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .chart-shortcuts a:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(47, 126, 209, 0.14);
            }

            .chart-shortcuts a.chart-export {
                background: var(--primary-strong);
                color: #fff;
            }

            .today-chart-plot {
                gap: clamp(3px, 0.65vw, 9px);
                height: 210px;
                padding-top: 18px;
            }

            .today-chart-hour {
                position: relative;
            }

            .today-chart-bar {
                width: min(76%, 28px);
                border-radius: 8px 8px 2px 2px;
                box-shadow: 0 4px 10px rgba(47, 126, 209, 0.12);
            }

            .today-chart-hour-label {
                font-variant-numeric: tabular-nums;
                font-weight: 700;
            }

            .panel {
                transition: box-shadow 0.2s ease, border-color 0.2s ease;
            }

            .form-card,
            .table-card {
                border-radius: 26px;
            }

            .form-card .panel-header,
            .table-card .panel-header {
                padding-bottom: 16px;
                border-bottom: 1px solid var(--line);
            }

            .mobile-tabs {
                border-color: var(--line);
                background: var(--panel);
            }

            .today-chart-controls .history-filter {
                margin: 0;
            }

            .chart-shortcuts a:focus-visible {
                outline: 3px solid var(--primary-strong);
                outline-offset: 3px;
            }

            .desktop-nav {
                gap: 6px;
                padding: 6px;
                border-radius: 18px;
                background: var(--panel-strong);
                box-shadow: inset 0 0 0 1px var(--line);
            }

            .desktop-nav a {
                position: relative;
                gap: 9px;
                min-height: 44px;
                padding: 9px 16px;
                border: 1px solid transparent;
                border-radius: 13px;
                font-size: 0.82rem;
                transition: color 0.2s ease, background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
            }

            .desktop-nav a svg,
            .mobile-tab svg {
                width: 18px;
                height: 18px;
                flex: 0 0 auto;
                fill: none;
                stroke: currentColor;
                stroke-linecap: round;
                stroke-linejoin: round;
                stroke-width: 1.8;
            }

            .desktop-nav a[aria-current="page"] {
                border-color: var(--line);
                background: linear-gradient(145deg, var(--secondary), var(--button-soft));
                color: var(--primary-strong);
                box-shadow: 0 5px 14px rgba(47, 126, 209, 0.1);
            }

            .desktop-nav a[aria-current="page"]::after {
                position: absolute;
                right: 14px;
                bottom: 4px;
                left: 14px;
                height: 2px;
                border-radius: 99px;
                background: var(--primary-strong);
                content: "";
                opacity: 0.72;
            }

            .mobile-tabs {
                gap: 6px;
                padding: 7px;
                border-radius: 20px;
                box-shadow: 0 14px 32px rgba(39, 84, 138, 0.13);
            }

            .mobile-tab {
                display: flex;
                min-height: 54px;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 4px;
                padding: 7px 4px;
                border: 1px solid transparent;
                border-radius: 15px;
                font-size: 0.68rem;
                letter-spacing: 0.01em;
            }

            .mobile-tab svg {
                width: 19px;
                height: 19px;
            }

            .mobile-tab.is-active {
                border-color: rgba(255, 255, 255, 0.28);
                background: linear-gradient(145deg, var(--primary-strong), #75bdf3);
                box-shadow: 0 8px 18px rgba(47, 126, 209, 0.22), inset 0 1px 0 rgba(255, 255, 255, 0.22);
            }

            .desktop-nav a:focus-visible,
            .mobile-tab:focus-visible {
                outline: 3px solid var(--primary-strong);
                outline-offset: 3px;
            }

            :root[data-theme="dark"] .desktop-nav a[aria-current="page"] {
                background: linear-gradient(145deg, rgba(137, 209, 255, 0.2), rgba(36, 77, 115, 0.62));
            }

            @media (max-width: 640px) {
                .page-shell {
                    width: min(100% - 24px, 1440px);
                    padding-top: 12px;
                }

                .topbar {
                    margin-bottom: 16px;
                    padding: 12px;
                    border-radius: 18px;
                }

                .mobile-tabs {
                    top: max(8px, env(safe-area-inset-top));
                }

                .mobile-tab {
                    min-height: 52px;
                    font-size: 0.66rem;
                }

                .hero-panel {
                    margin-bottom: 18px;
                    border-radius: 26px;
                }

                .hero-copy h1 {
                    font-size: clamp(2rem, 9vw, 2.8rem);
                }

                .today-chart-controls,
                .today-chart-controls .history-filter {
                    width: 100%;
                }

                .chart-shortcuts {
                    width: 100%;
                }

                .chart-shortcuts a {
                    flex: 1 1 auto;
                }

                .today-chart-plot {
                    height: 170px;
                }

                .stat-card {
                    min-height: 150px;
                }
            }

            :root:not([data-theme="dark"]) {
                --bg-1: #eef7ff;
                --bg-2: #f8fbff;
                --panel: rgba(255, 255, 255, 0.94);
                --panel-strong: #ffffff;
                --primary: #78baf4;
                --primary-strong: #2563a8;
                --secondary: #e7f2ff;
                --accent: #cfe5ff;
                --success: #347fc1;
                --text: #18334b;
                --muted: #61768a;
                --line: rgba(47, 109, 176, 0.14);
                --shadow: 0 18px 48px rgba(35, 75, 112, 0.09);
                --input-bg: #fbfdff;
                --input-border: rgba(47, 109, 176, 0.2);
                --hero-bg-1: #12345c;
                --hero-bg-2: #1b5b9a;
                --hero-bg-3: #398bd0;
                --hero-bg-4: #17415b;
                --hero-text: #f5fbff;
                --hero-subtext: rgba(245, 251, 255, 0.82);
                --button-soft: rgba(37, 99, 168, 0.08);
            }

            :root:not([data-theme="dark"]) body {
                background:
                    radial-gradient(circle at 8% 4%, rgba(118, 202, 226, 0.2), transparent 25%),
                    radial-gradient(circle at 92% 78%, rgba(135, 190, 238, 0.2), transparent 28%),
                    linear-gradient(145deg, var(--bg-1), var(--bg-2) 58%, #f2f8ff);
            }

            :root:not([data-theme="dark"]) .ambient-1 {
                background: rgba(82, 157, 224, 0.32);
            }

            :root:not([data-theme="dark"]) .ambient-2 {
                background: rgba(92, 165, 212, 0.3);
            }

            :root:not([data-theme="dark"]) .topbar {
                border-color: rgba(255, 255, 255, 0.92);
                background: rgba(255, 255, 255, 0.82);
                box-shadow: 0 12px 34px rgba(35, 75, 112, 0.08);
            }

            :root:not([data-theme="dark"]) .hero-panel {
                border-color: rgba(255, 255, 255, 0.22);
                background: linear-gradient(122deg, var(--hero-bg-1) 0%, var(--hero-bg-2) 48%, var(--hero-bg-3) 100%);
                color: var(--hero-text);
                box-shadow: 0 28px 68px rgba(29, 79, 133, 0.22);
            }

            :root:not([data-theme="dark"]) .hero-copy p {
                color: var(--hero-subtext);
            }

            :root:not([data-theme="dark"]) .eyebrow {
                background: rgba(255, 255, 255, 0.1);
                border-color: rgba(255, 255, 255, 0.22);
            }

            :root:not([data-theme="dark"]) .primary-btn,
            :root:not([data-theme="dark"]) .submit-button,
            :root:not([data-theme="dark"]) .daily-menu-upload-link {
                border-color: transparent;
                background: linear-gradient(135deg, #2563a8, #398bd0);
                color: #ffffff;
                box-shadow: 0 12px 24px rgba(37, 99, 168, 0.2);
            }

            :root:not([data-theme="dark"]) .secondary-btn,
            :root:not([data-theme="dark"]) .theme-toggle {
                border-color: var(--line);
                background: rgba(255, 255, 255, 0.76);
                color: var(--text);
            }

            :root:not([data-theme="dark"]) .stat-card,
            :root:not([data-theme="dark"]) .panel,
            :root:not([data-theme="dark"]) .today-chart {
                border-color: rgba(47, 109, 176, 0.1);
                background: rgba(255, 255, 255, 0.88);
                box-shadow: 0 16px 38px rgba(35, 75, 112, 0.07);
            }

            :root:not([data-theme="dark"]) .stat-card::after {
                background: linear-gradient(90deg, #438bd0, #82c5f0);
            }

            :root:not([data-theme="dark"]) .stat-card:nth-child(1) .value,
            :root:not([data-theme="dark"]) .stat-card:nth-child(2) .value,
            :root:not([data-theme="dark"]) .stat-card:nth-child(3) .value {
                color: var(--primary-strong);
            }

            :root:not([data-theme="dark"]) .stat-card .stat-icon {
                border-color: rgba(47, 109, 176, 0.1);
                background: linear-gradient(145deg, #e7f2ff, #eff8ff);
                color: var(--primary-strong);
            }

            :root:not([data-theme="dark"]) .today-chart-bar {
                background: linear-gradient(180deg, #82c5f0, #2563a8);
                box-shadow: 0 4px 12px rgba(37, 99, 168, 0.16);
            }

            :root:not([data-theme="dark"]) .chart-shortcuts a.chart-export {
                border-color: transparent;
                background: linear-gradient(135deg, #2563a8, #398bd0);
                color: #ffffff;
            }

            :root:not([data-theme="dark"]) .desktop-nav a[aria-current="page"],
            :root:not([data-theme="dark"]) .mobile-tab.is-active {
                border-color: rgba(37, 99, 168, 0.12);
                background: linear-gradient(145deg, #2563a8, #398bd0);
                color: #ffffff;
                box-shadow: 0 8px 18px rgba(37, 99, 168, 0.18);
            }

            :root:not([data-theme="dark"]) .desktop-nav a[aria-current="page"]::after {
                background: #ffffff;
            }

            :root:not([data-theme="dark"]) thead th {
                background: #f1f7ff;
            }

            :root:not([data-theme="dark"]) tbody tr:hover {
                background: rgba(42, 125, 191, 0.06);
            }

            :root:not([data-theme="dark"]) .comparison-value.is-up {
                color: #347fc1;
            }
        </style>
    </head>
    <body>
        <div class="welcome-overlay" id="welcomeOverlay">
            <div class="welcome-card">
                <div class="welcome-visual">
                    <img class="welcome-logo show" src="{{ asset('jpg.foto/logo.jpg.png') }}" alt="Logo MBG">
                </div>
                <div class="welcome-badge">Program MBG</div>
                <h2>Selamat Datang</h2>
                <p>Monitoring Pengambilan Makanan Bergizi Gratis</p>
            </div>
            <div class="mbg-car-track" aria-hidden="true">
                <img class="mbg-car" src="{{ asset('jpg.foto/mobil-mbg,jpg.png') }}" alt="">
            </div>
        </div>

        <div class="page-shell" data-page="{{ $page }}">
            <div class="ambient ambient-1"></div>
            <div class="ambient ambient-2"></div>

            <header class="topbar">
                <div class="brand">
                    <div class="brand-mark">
                        <img src="{{ asset('jpg.foto/logo.jpg.png') }}" alt="Logo MBG">
                    </div>
                    <div class="brand-copy">
                        <strong>MBG Tracker</strong>
                        <span>Program makan bergizi gratis</span>
                    </div>
                </div>

                <nav class="desktop-nav" aria-label="Navigasi utama">
                    <a href="{{ route('mbg.index') }}" @if ($page === 'summary') aria-current="page" @endif>
                        <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                        <span>Ringkasan</span>
                    </a>
                    <a href="{{ route('mbg.form') }}" @if ($page === 'form') aria-current="page" @endif>
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                        <span>Pencatatan</span>
                    </a>
                    <a href="{{ route('mbg.history') }}" @if ($page === 'history') aria-current="page" @endif>
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 2.64-6.36L3 8"/><path d="M3 3v5h5M12 7v5l3 2"/></svg>
                        <span>Riwayat</span>
                    </a>
                </nav>

                <div class="topbar-actions">
                    <button type="button" class="theme-toggle" id="themeToggle" aria-label="Mode terang" aria-pressed="false">
                        <span class="theme-toggle-icon" aria-hidden="true"></span>
                        <span class="theme-toggle-text">Mode gelap</span>
                    </button>
                    <div class="live-indicator">
                        <span>Siap dicatat</span>
                        <time id="dashboard-clock" aria-label="Waktu WIB">{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i:s') }} WIB</time>
                    </div>
                </div>
            </header>

            <section class="hero-panel">
                <div class="hero-copy">
                    <div class="eyebrow">Makanan Bergizi Gratis</div>
                    <h1>Pendataan Pengambilan MBG</h1>
                    <p>
                        Sistem pencatatan untuk memudahkan pengawasan distribusi makanan bergizi gratis,
                        memastikan data tercatat rapi, cepat, dan akurat setiap hari.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('mbg.form') }}" class="primary-btn">Catat pengambilan</a>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="visual-card">
                        <div class="ring-wrap">
                            <div class="progress-ring"></div>
                            <div class="ring-center">
                                <strong>{{ $totalPenerima }}</strong>
                                <span>Penerima · {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @if (session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            <section class="page-heading" id="page-heading" @if ($page === 'summary') hidden @endif>
                <div class="page-heading-copy">
                    <span class="page-heading-kicker" id="page-heading-kicker">MBG Tracker · {{ $page === 'form' ? 'Pencatatan' : 'Riwayat' }}</span>
                    <h1 id="page-heading-title">{{ $page === 'form' ? 'Catat Pengambilan' : 'Jelajahi Riwayat' }}</h1>
                    <p id="page-heading-description">{{ $page === 'form' ? 'Lengkapi informasi penerima agar distribusi makanan bergizi tercatat dengan rapi.' : 'Telusuri, cari, dan unduh catatan distribusi berdasarkan tanggal.' }}</p>
                </div>
                <span class="page-heading-date" id="page-heading-date">{{ \Carbon\Carbon::parse($page === 'form' ? $today : $selectedDate)->translatedFormat('d F Y') }}</span>
            </section>

            <nav class="mobile-tabs" aria-label="Navigasi mobile">
                <button type="button" class="mobile-tab {{ $page === 'summary' ? 'is-active' : '' }}" data-target="summary-panel" aria-pressed="{{ $page === 'summary' ? 'true' : 'false' }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                    <span>Ringkasan</span>
                </button>
                <button type="button" class="mobile-tab {{ $page === 'form' ? 'is-active' : '' }}" data-target="form-panel" aria-pressed="{{ $page === 'form' ? 'true' : 'false' }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                    <span>Pencatatan</span>
                </button>
                <button type="button" class="mobile-tab {{ $page === 'history' ? 'is-active' : '' }}" data-target="history-panel" aria-pressed="{{ $page === 'history' ? 'true' : 'false' }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 2.64-6.36L3 8"/><path d="M3 3v5h5M12 7v5l3 2"/></svg>
                    <span>Riwayat</span>
                </button>
            </nav>

            <section class="stats mobile-panel {{ $page === 'summary' ? 'is-active' : '' }}" id="summary-panel">
                <div class="stat-card">
                    <span class="stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </span>
                    <span class="label">Total Penerima</span>
                    <div class="value">{{ $totalPenerima }}</div>
                    <span class="date">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="stat-card">
                    <span class="stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M4 7h16l-1.5 13h-13L4 7Z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/></svg>
                    </span>
                    <span class="label">Total Porsi</span>
                    <div class="value">{{ $totalPorsi }}</div>
                    <span class="date">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="stat-card">
                    <span class="stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="m3 17 6-6 4 4 8-8"/><path d="M15 7h6v6"/></svg>
                    </span>
                    <span class="label">Perubahan Porsi</span>
                    <span class="comparison-value {{ $porsiChange > 0 ? 'is-up' : ($porsiChange < 0 ? 'is-down' : 'is-even') }}">
                        {{ $porsiChange > 0 ? '+' : '' }}{{ $porsiChange }}
                    </span>
                    <span class="comparison-detail">
                        {{ $penerimaChange > 0 ? '+' : '' }}{{ $penerimaChange }} penerima dibanding
                        {{ \Carbon\Carbon::parse($previousDate)->translatedFormat('d F Y') }}
                    </span>
                </div>
                <section class="today-chart" aria-labelledby="today-chart-title">
                    <div class="today-chart-header">
                        <div>
                            <h2 id="today-chart-title">{{ $chartDate === $today ? 'Pendataan Hari Ini' : 'Grafik Pendataan Harian' }}</h2>
                            <span class="today-chart-subtitle">{{ \Carbon\Carbon::parse($chartDate)->translatedFormat('d F Y') }} · Jumlah catatan per jam (WIB)</span>
                        </div>
                        <div class="today-chart-controls">
                            <form action="{{ route('mbg.index') }}" method="GET" class="history-filter chart-date-filter">
                                <label for="chart-date">Pilih tanggal grafik</label>
                                <input id="chart-date" type="date" name="date" value="{{ $chartDate }}" max="{{ $today }}" required>
                                <button type="submit">Lihat</button>
                            </form>
                            <nav class="chart-shortcuts" aria-label="Navigasi tanggal grafik">
                                <a href="{{ route('mbg.index', ['date' => $previousDate]) }}" data-native-navigation>← Sehari sebelumnya</a>
                                @if ($selectedDate !== $today)
                                    <a href="{{ route('mbg.index', ['date' => $today]) }}" data-native-navigation>Hari ini</a>
                                @endif
                                @if ($selectedDate < $today)
                                    <a href="{{ route('mbg.index', ['date' => $nextDate]) }}" data-native-navigation>Sehari berikutnya →</a>
                                @endif
                                <a class="chart-export" href="{{ route('mbg.pdf', ['date' => $selectedDate]) }}">Unduh laporan PDF</a>
                            </nav>
                            <span class="today-chart-total">{{ $dailyRecordCount }} data</span>
                        </div>
                    </div>

                    <div class="today-chart-plot" role="img" aria-label="Grafik jumlah pendataan tanggal {{ $chartDate }} per jam, total {{ $dailyRecordCount }} data">
                        @foreach ($hourlyCounts as $hour => $count)
                            <div class="today-chart-hour" title="{{ sprintf('%02d:00', $hour) }} WIB · {{ $count }} data">
                                <span
                                    class="today-chart-bar"
                                    data-hour="{{ sprintf('%02d', $hour) }}"
                                    data-count="{{ $count }}"
                                    style="height: {{ $maxHourlyCount > 0 ? max(3, ($count / $maxHourlyCount) * 82) : 3 }}%"
                                ></span>
                                <span class="today-chart-hour-label">{{ $hour % 6 === 0 ? sprintf('%02d', $hour) : '' }}</span>
                            </div>
                        @endforeach
                    </div>

                    @if ($dailyRecordCount === 0)
                        <p class="today-chart-empty">Belum ada pendataan pada tanggal ini.</p>
                    @endif
                </section>
            </section>

            <div class="content-grid">
                <section class="panel form-card mobile-panel {{ $page === 'form' ? 'is-active' : '' }}" id="form-panel">
                    <div class="panel-header">
                        <h2>Form Pencatatan</h2>
                        <span>Input data</span>
                    </div>

                    <section class="daily-menu" aria-labelledby="daily-menu-title">
                        <div class="daily-menu-heading">
                            <h3 id="daily-menu-title">Menu Hari Ini</h3>
                            <span>{{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }}</span>
                        </div>

                        @if ($dailyMenu)
                            <img class="daily-menu-photo" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($dailyMenu->foto) }}" alt="Foto menu MBG hari ini" loading="lazy">
                        @else
                            <div class="daily-menu-empty">Foto menu hari ini belum diunggah.</div>
                        @endif

                        <a href="{{ route('mbg.daily-menu') }}" class="daily-menu-upload-link">
                            {{ $dailyMenu ? 'Ganti foto menu' : 'Unggah foto menu' }}
                        </a>
                    </section>

                    <div id="form-feedback" class="alert" role="status" aria-live="polite" hidden></div>
                    <form id="record-form" action="{{ route('mbg.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid-form">
                            <div class="field">
                                <label for="nama">Nama</label>
                                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama penerima" required>
                                @error('nama') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="field">
                                <label for="kelas">Kelas</label>
                                <input id="kelas" type="text" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: XI PPLG 3" required>
                                @error('kelas') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="field">
                                <label for="jumlah">Jumlah</label>
                                <input id="jumlah" type="number" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" required>
                                @error('jumlah') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="field">
                                <label for="waktu_pengambilan">Waktu Pengambilan</label>
                                <input id="waktu_pengambilan" type="datetime-local" name="waktu_pengambilan" value="{{ old('waktu_pengambilan') }}" required>
                                @error('waktu_pengambilan') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="field full">
                                <label for="foto">Ambil foto langsung dari kamera</label>
                                <input id="foto" type="file" name="foto" accept="image/*" capture="environment">
                                <img id="photo-preview" class="photo-preview" alt="Pratinjau foto pengambilan" hidden>
                                @error('foto') <span class="error">{{ $message }}</span> @enderror
                            </div>

                        </div>

                        <button type="submit" class="submit-button">Simpan Data Pengambilan</button>
                    </form>
                </section>

                <section class="panel table-card mobile-panel {{ $page === 'history' ? 'is-active' : '' }}" id="history-panel">
                    <div class="panel-header">
                        <div class="header-actions">
                            <h2>Riwayat Pengambilan</h2>
                            <a href="{{ route('mbg.pdf', ['date' => $selectedDate]) }}" class="pdf-btn">PDF Tanggal Ini</a>
                        </div>
                        <span>{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M Y') }} · {{ $records->count() }} data</span>
                    </div>

                    <div class="history-tools">
                        <form action="{{ route('mbg.history') }}" method="GET" class="history-filter">
                            <label for="history-date">Tanggal riwayat</label>
                            <input id="history-date" type="date" name="date" value="{{ $selectedDate }}" max="{{ $today }}" required>
                            <button type="submit">Lihat</button>
                        </form>

                        <nav class="history-nav" aria-label="Navigasi tanggal riwayat">
                            <a href="{{ route('mbg.history', ['date' => $previousDate]) }}">&larr; Hari sebelumnya</a>
                            @if ($selectedDate < $today)
                                <a href="{{ route('mbg.history', ['date' => $nextDate]) }}">Hari berikutnya &rarr;</a>
                            @else
                                <span aria-disabled="true">Hari berikutnya &rarr;</span>
                            @endif
                            @if ($selectedDate !== $today)
                                <a href="{{ route('mbg.history', ['date' => $today]) }}">Hari ini</a>
                            @endif
                        </nav>
                    </div>

                    <div class="table-wrap">
                        @if ($records->isEmpty())
                            <p style="margin: 20px 0; color: var(--muted);">Belum ada data pengambilan pada {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}.</p>
                        @else
                            <div class="history-search">
                                <label for="history-search">Cari berdasarkan nama atau kelas</label>
                                <div class="history-search-control">
                                    <input
                                        id="history-search"
                                        type="search"
                                        placeholder="Contoh: Ayu atau VII-A"
                                        autocomplete="off"
                                        aria-controls="history-records"
                                    >
                                    <button class="history-search-clear" type="button" aria-label="Hapus kata pencarian" hidden>Hapus</button>
                                </div>
                                <p class="history-search-status" id="history-search-status" role="status" aria-live="polite">
                                    Menampilkan <span id="history-search-visible">{{ $records->count() }}</span> dari <span id="history-search-total">{{ $records->count() }}</span> data.
                                </p>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Jumlah</th>
                                        <th>Waktu</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="history-records">
                                    @foreach ($records as $record)
                                        <tr data-search="{{ $record->nama }} {{ $record->kelas }}">
                                            <td><strong>{{ $record->nama }}</strong></td>
                                            <td>{{ $record->kelas }}</td>
                                            <td><span class="badge">{{ $record->jumlah }}</span></td>
                                            <td>{{ \Carbon\Carbon::parse($record->waktu_pengambilan)->translatedFormat('d M Y, H:i') }}</td>
                                            <td>
                                                @if ($record->foto)
                                                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->foto) }}" target="_blank" rel="noopener noreferrer">
                                                        <img class="pickup-photo" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->foto) }}" alt="Foto pengambilan oleh {{ $record->nama }}" loading="lazy">
                                                    </a>
                                                @else
                                                    <span aria-label="Tidak ada foto">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('mbg.destroy', $record) }}" method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-btn">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr id="history-search-empty" hidden>
                                        <td colspan="6">Tidak ada data yang cocok dengan pencarian.</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </section>
            </div>
        </div>

        <dialog class="delete-confirmation" id="delete-confirmation" aria-labelledby="delete-confirmation-title" aria-describedby="delete-confirmation-message">
            <div class="delete-confirmation-icon" aria-hidden="true">!</div>
            <h2 id="delete-confirmation-title">Hapus data ini?</h2>
            <p id="delete-confirmation-message">Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="delete-confirmation-actions">
                <button type="button" class="delete-confirmation-cancel" id="cancel-delete" autofocus>Batalkan</button>
                <button type="button" class="delete-confirmation-submit" id="confirm-delete">Ya, hapus</button>
            </div>
        </dialog>

        <script>
            const welcomeOverlay = document.getElementById('welcomeOverlay');
            window.setTimeout(function () {
                if (welcomeOverlay) {
                    welcomeOverlay.classList.add('hidden');
                }
            }, 2400);

            const root = document.documentElement;
            const storedTheme = localStorage.getItem('mbg-theme');
            const prefersDarkTheme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const initialTheme = storedTheme || (prefersDarkTheme ? 'dark' : 'light');

            function applyTheme(theme) {
                root.setAttribute('data-theme', theme);

                const toggle = document.getElementById('themeToggle');
                if (!toggle) {
                    return;
                }

                const toggleText = toggle.querySelector('.theme-toggle-text');
                const toggleIcon = toggle.querySelector('.theme-toggle-icon');
                const isDark = theme === 'dark';

                toggle.setAttribute('aria-pressed', String(isDark));
                toggle.setAttribute('aria-label', isDark ? 'Mode terang' : 'Mode gelap');
                toggleText.textContent = isDark ? 'Mode terang' : 'Mode gelap';
            }

            applyTheme(initialTheme);

            const pageRoutes = {
                summary: @json(route('mbg.index')),
                form: @json(route('mbg.form')),
                history: @json(route('mbg.history')),
            };
            const pagePaths = Object.fromEntries(
                Object.entries(pageRoutes).map(function ([page, route]) {
                    return [new URL(route, window.location.origin).pathname, page];
                }),
            );
            const pageShell = document.querySelector('.page-shell');
            let navigationRequestId = 0;

            function getPageForUrl(url) {
                return pagePaths[url.pathname];
            }

            function updateCurrentPage(page) {
                pageShell.dataset.page = page;

                document.querySelectorAll('.mobile-panel').forEach(function (panel) {
                    panel.classList.toggle('is-active', panel.id === `${page}-panel`);
                });

                document.querySelectorAll('.mobile-tab').forEach(function (tab) {
                    const isActive = tab.dataset.target === `${page}-panel`;
                    tab.classList.toggle('is-active', isActive);
                    tab.setAttribute('aria-pressed', String(isActive));
                });

                document.querySelectorAll('.desktop-nav a').forEach(function (link) {
                    const linkUrl = new URL(link.href, window.location.origin);
                    if (getPageForUrl(linkUrl) === page) {
                        link.setAttribute('aria-current', 'page');
                    } else {
                        link.removeAttribute('aria-current');
                    }
                });

                const headings = {
                    form: {
                        kicker: 'MBG Tracker · Pencatatan',
                        title: 'Catat Pengambilan',
                        description: 'Lengkapi informasi penerima agar distribusi makanan bergizi tercatat dengan rapi.',
                    },
                    history: {
                        kicker: 'MBG Tracker · Riwayat',
                        title: 'Jelajahi Riwayat',
                        description: 'Telusuri, cari, dan unduh catatan distribusi berdasarkan tanggal.',
                    },
                };
                const heading = document.getElementById('page-heading');
                heading.hidden = page === 'summary';

                if (headings[page]) {
                    document.getElementById('page-heading-kicker').textContent = headings[page].kicker;
                    document.getElementById('page-heading-title').textContent = headings[page].title;
                    document.getElementById('page-heading-description').textContent = headings[page].description;
                }

                if (page === 'history') {
                    const refreshedHeadingDate = document.getElementById('page-heading-date');
                    const historyHeadingDate = document.querySelector('.page-heading-date');
                    if (refreshedHeadingDate && historyHeadingDate) {
                        historyHeadingDate.textContent = refreshedHeadingDate.textContent;
                    }
                }
            }

            async function navigateTo(url, options = {}) {
                const destination = new URL(url, window.location.href);
                const page = getPageForUrl(destination);
                if (!page) {
                    return false;
                }

                const requestId = ++navigationRequestId;

                try {
                    if (page === 'history') {
                        const response = await fetch(destination, {
                            headers: { Accept: 'text/html' },
                        });

                        if (!response.ok) {
                            throw new Error(`Page request failed with status ${response.status}`);
                        }

                        const pageHtml = await response.text();
                        const updatedPage = new DOMParser().parseFromString(pageHtml, 'text/html');
                        const updatedHistoryPanel = updatedPage.getElementById('history-panel');
                        const currentHistoryPanel = document.getElementById('history-panel');

                        if (!updatedHistoryPanel) {
                            throw new Error('History panel was not found in the page response');
                        }

                        if (requestId !== navigationRequestId) {
                            return true;
                        }

                        currentHistoryPanel.innerHTML = updatedHistoryPanel.innerHTML;
                        const updatedHeadingDate = updatedPage.querySelector('.page-heading-date');
                        if (updatedHeadingDate) {
                            document.getElementById('page-heading-date').textContent = updatedHeadingDate.textContent;
                        }
                    }

                    if (options.push !== false) {
                        window.history.pushState({ page: page }, '', destination);
                    }

                    updateCurrentPage(page);
                    return true;
                } catch (error) {
                    if (requestId !== navigationRequestId) {
                        return false;
                    }

                    console.error('Navigasi halaman gagal, membuka halaman secara normal.', error);
                    window.location.assign(destination);
                    return false;
                }
            }

            document.addEventListener('click', function (event) {
                if (!(event.target instanceof Element)) {
                    return;
                }

                const link = event.target.closest('a');
                if (!link || link.hasAttribute('data-native-navigation') || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
                    return;
                }

                const destination = new URL(link.href, window.location.href);
                if (destination.origin !== window.location.origin || !getPageForUrl(destination)) {
                    return;
                }

                event.preventDefault();
                navigateTo(destination);
            });

            document.addEventListener('submit', function (event) {
                const form = event.target;
                if (!form.matches('.history-filter') || form.matches('.chart-date-filter')) {
                    return;
                }

                event.preventDefault();
                const destination = new URL(form.action, window.location.href);
                destination.search = new URLSearchParams(new FormData(form)).toString();
                navigateTo(destination);
            });

            document.querySelectorAll('.mobile-tab').forEach(function (tab) {
                tab.addEventListener('click', function () {
                    navigateTo(pageRoutes[tab.dataset.target.replace('-panel', '')]);
                });
            });

            window.addEventListener('popstate', function () {
                navigateTo(window.location.href, { push: false });
            });

            const dashboardClock = document.getElementById('dashboard-clock');
            const jakartaClockFormatter = new Intl.DateTimeFormat('id-ID', {
                timeZone: 'Asia/Jakarta',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hourCycle: 'h23',
            });

            function updateDashboardClock() {
                if (dashboardClock) {
                    dashboardClock.textContent = `${jakartaClockFormatter.format(new Date())} WIB`;
                }
            }

            updateDashboardClock();
            window.setInterval(updateDashboardClock, 1000);

            const themeToggleButton = document.getElementById('themeToggle');
            if (themeToggleButton) {
                themeToggleButton.addEventListener('click', function () {
                    const currentTheme = root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
                    const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    localStorage.setItem('mbg-theme', nextTheme);
                    applyTheme(nextTheme);
                });
            }

            const formPanel = document.getElementById('form-panel');

            let photoPreviewUrl;
            formPanel.addEventListener('change', function (event) {
                if (event.target.id !== 'foto') {
                    return;
                }

                const preview = document.getElementById('photo-preview');
                const photo = event.target.files[0];

                if (photoPreviewUrl) {
                    URL.revokeObjectURL(photoPreviewUrl);
                }

                if (!photo) {
                    preview.hidden = true;
                    preview.removeAttribute('src');
                    return;
                }

                photoPreviewUrl = URL.createObjectURL(photo);
                preview.src = photoPreviewUrl;
                preview.hidden = false;
            });

            formPanel.addEventListener('submit', async function (event) {
                const form = event.target;

                if (form.id !== 'record-form') {
                    return;
                }

                event.preventDefault();

                const submitButton = form.querySelector('.submit-button');
                const originalButtonText = submitButton.textContent;
                const feedback = document.getElementById('form-feedback');

                submitButton.disabled = true;
                submitButton.textContent = 'Menyimpan...';
                feedback.hidden = true;

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: new FormData(form),
                    });
                    const result = await response.json();

                    if (!response.ok) {
                        const messages = Object.values(result.errors || {}).flat();
                        feedback.textContent = messages.join(' ') || 'Data gagal disimpan. Silakan coba lagi.';
                        feedback.className = 'alert alert-error';
                        feedback.hidden = false;
                        return;
                    }

                    const refreshUrl = new URL(window.location.href);
                    refreshUrl.searchParams.set('date', result.date);

                    const pageResponse = await fetch(refreshUrl, {
                        headers: { Accept: 'text/html' },
                    });

                    if (!pageResponse.ok) {
                        throw new Error('Dashboard update failed');
                    }

                    const pageHtml = await pageResponse.text();
                    const updatedPage = new DOMParser().parseFromString(pageHtml, 'text/html');

                    ['summary-panel', 'form-panel', 'history-panel'].forEach(function (panelId) {
                        const currentPanel = document.getElementById(panelId);
                        const updatedPanel = updatedPage.getElementById(panelId);
                        currentPanel.innerHTML = updatedPanel.innerHTML;
                    });

                    document.querySelector('.hero-visual').innerHTML = updatedPage.querySelector('.hero-visual').innerHTML;
                    window.history.replaceState(null, '', refreshUrl);

                    const updatedFeedback = document.getElementById('form-feedback');
                    updatedFeedback.textContent = result.message;
                    updatedFeedback.className = 'alert';
                    updatedFeedback.hidden = false;
                } catch (error) {
                    feedback.textContent = 'Data tersimpan atau belum dapat dipastikan. Periksa koneksi sebelum mencoba lagi.';
                    feedback.className = 'alert alert-error';
                    feedback.hidden = false;
                } finally {
                    if (formPanel.contains(submitButton)) {
                        submitButton.disabled = false;
                        submitButton.textContent = originalButtonText;
                    }
                }
            });

            const deleteConfirmation = document.getElementById('delete-confirmation');
            const deleteConfirmationMessage = document.getElementById('delete-confirmation-message');
            let pendingDeleteForm = null;

            document.addEventListener('submit', function (event) {
                const form = event.target;

                if (!form.matches('.delete-form')) {
                    return;
                }

                event.preventDefault();
                pendingDeleteForm = form;

                const recordName = form.closest('tr').querySelector('td strong').textContent.trim();
                deleteConfirmationMessage.textContent = `Apakah Anda yakin ingin menghapus data ${recordName}?`;
                deleteConfirmation.showModal();
            });

            document.getElementById('cancel-delete').addEventListener('click', function () {
                pendingDeleteForm = null;
                deleteConfirmation.close();
            });

            deleteConfirmation.addEventListener('cancel', function () {
                pendingDeleteForm = null;
            });

            document.getElementById('confirm-delete').addEventListener('click', function () {
                if (!pendingDeleteForm) {
                    return;
                }

                const formToDelete = pendingDeleteForm;
                pendingDeleteForm = null;
                deleteConfirmation.close();
                formToDelete.submit();
            });

            document.addEventListener('input', function (event) {
                if (!event.target.matches('#history-search')) {
                    return;
                }

                const historyPanel = event.target.closest('#history-panel');
                const query = event.target.value.trim().toLowerCase();
                historyPanel.querySelector('.history-search-clear').hidden = query.length === 0;
                const rows = historyPanel.querySelectorAll('#history-records tr[data-search]');
                let visibleCount = 0;

                rows.forEach(function (row) {
                    const matches = row.dataset.search.toLowerCase().includes(query);
                    row.hidden = !matches;
                    visibleCount += matches ? 1 : 0;
                });

                historyPanel.querySelector('#history-search-empty').hidden = visibleCount > 0;
                historyPanel.querySelector('#history-search-visible').textContent = visibleCount;

                const totalCount = historyPanel.querySelector('#history-search-total').textContent;
                const status = historyPanel.querySelector('#history-search-status');
                status.textContent = visibleCount === 0
                    ? `Tidak ada data yang cocok. Menampilkan 0 dari ${totalCount} data.`
                    : `Menampilkan ${visibleCount} dari ${totalCount} data.`;
            });

            document.addEventListener('click', function (event) {
                const clearButton = event.target.closest('.history-search-clear');

                if (!clearButton) {
                    return;
                }

                const searchInput = clearButton.closest('.history-search').querySelector('#history-search');
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input', { bubbles: true }));
                searchInput.focus();
            });

        </script>
    </body>
</html>
