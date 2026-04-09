<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loading — IT Department</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/photo_2024-05-27_08-46-50.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800&display=swap"
        rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #ffffff;
            /* Changed to pure white */
            --bg2: #f8fafc;
            /* Light slate for subtle elements */
            --accent: #00ff22;
            /* Kept the tech blue */
            --text: #0f172a;
            /* Dark text for readability */
            --muted: #64748b;
            /* Medium gray for secondary text */
            --dim: #cbd5e1;
            /* Light gray for inactive dots */
            --font: 'Plus Jakarta Sans', 'Segoe UI', system-ui, sans-serif;
        }

        html,
        body {
            height: 100%;
            background: var(--bg);
            font-family: var(--font);
            overflow: hidden;
        }

        /* ── Background grid ─────────────────────────────── */
        .bg-grid {
            position: fixed;
            inset: 0;
            /* Slightly increased opacity from 0.04 to 0.08 so it shows up on white */
            background-image:
                linear-gradient(rgba(59, 130, 246, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.08) 1px, transparent 1px);
            background-size: 44px 44px;
            animation: gridDrift 24s linear infinite;
        }

        @keyframes gridDrift {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 44px 44px;
            }
        }

        /* ── Ambient glow ────────────────────────────────── */
        .bg-glow {
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: glowPulse 4s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes glowPulse {

            0%,
            100% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.6;
            }

            50% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 1;
            }
        }

        /* ── Center stage ────────────────────────────────── */
        .stage {
            position: fixed;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
            animation: stageOut 0.5s ease forwards;
            animation-play-state: paused;
        }

        .stage.hiding {
            animation-play-state: running;
        }

        @keyframes stageOut {
            to {
                opacity: 0;
                transform: scale(0.96);
            }
        }

        /* ── Logo ────────────────────────────────────────── */
        /* ── Logo ────────────────────────────────────────── */
        .logo-ring {
            width: 88px;
            height: 88px;
            border-radius: 24px;
            display: flex;
            overflow: hidden;
            /* <-- UNCOMMENTED: This keeps the image inside the rounded corners */
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 0 rgba(59, 246, 68, 0.5);
            animation:
                logoIn 0.7s cubic-bezier(.34, 1.56, .64, 1) 0.1s both,
                logoPing 2s ease-in-out 1s infinite;
            margin-bottom: 28px;
        }

        /* Wrapper div takes up full space */
        .img {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Target the actual image tag */
        .img img {
            width: 100%;
            height: 100%;
            /* Use 'contain' if you want the whole logo visible without cropping. 
       Use 'cover' if you want it to stretch to fill the edges. */
            object-fit: contain;
        }

        @keyframes logoIn {
            from {
                transform: scale(0) rotate(-15deg);
                opacity: 0;
            }

            to {
                transform: scale(1) rotate(0);
                opacity: 1;
            }
        }

        @keyframes logoPing {
    0% {
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.5);
    }
    70% {
        box-shadow: 0 0 0 22px rgba(34, 197, 94, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
    }
}

        /* ── Titles ──────────────────────────────────────── */
        .title {
            font-size: 28px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.5px;
            animation: fadeUp 0.6s 0.35s ease both;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 12px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            animation: fadeUp 0.6s 0.5s ease both;
            margin-bottom: 52px;
        }

        @keyframes fadeUp {
            from {
                transform: translateY(18px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* ── Progress bar ────────────────────────────────── */
        .progress-wrap {
            width: 260px;
            animation: fadeUp 0.6s 0.65s ease both;
        }

        .progress-track {
            /* Changed from white translucent to a light gray so it's visible on white */
            height: 3px;
            background: #e2e8f0;
            border-radius: 9999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            border-radius: 9999px;
            background: var(--accent);
            transition: width 0.4s ease;
        }

        .progress-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .progress-msg {
            font-size: 12px;
            color: var(--muted);
        }

        .progress-pct {
            font-size: 12px;
            font-weight: 700;
            color: var(--accent);
        }

        /* ── Dots ────────────────────────────────────────── */
        .dots {
            display: flex;
            gap: 7px;
            margin-top: 36px;
            animation: fadeUp 0.6s 0.8s ease both;
        }

        .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--dim);
        }

        .dot:nth-child(1) {
            animation: dotBeat 1.4s 0s ease-in-out infinite;
        }

        .dot:nth-child(2) {
            animation: dotBeat 1.4s 0.2s ease-in-out infinite;
        }

        .dot:nth-child(3) {
            animation: dotBeat 1.4s 0.4s ease-in-out infinite;
        }

        @keyframes dotBeat {

            0%,
            100% {
                background: var(--dim);
                transform: scale(1);
            }

            50% {
                background: var(--accent);
                transform: scale(1.5);
            }
        }

        /* ── Footer ──────────────────────────────────────── */
        .footer-tag {
            position: fixed;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 0.06em;
            text-align: center;
            z-index: 10;
            animation: fadeUp 0.6s 1s ease both;
        }
    </style>
</head>

<body>

    <div class="bg-grid"></div>
    <div class="bg-glow"></div>

    <div class="stage" id="stage">
        <div class="logo-ring">
            <div class="img">
                <img src="{{ asset('assets/img/Logo.png') }}" alt="IT Department Logo">
            </div>
        </div>
        <div class="title">IT Department</div>
        <div class="subtitle">School Management System</div>

        <div class="progress-wrap">
            <div class="progress-track">
                <div class="progress-fill" id="progressFill"></div>
            </div>
            <div class="progress-meta">
                <span class="progress-msg" id="progressMsg">Initializing…</span>
                <span class="progress-pct" id="progressPct">0%</span>
            </div>
        </div>

        <div class="dots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>

    <div class="footer-tag">
        Setec Institute &nbsp;·&nbsp; Cambodia
    </div>

    <script>
        // ── Loading sequence ────────────────────────────────
        // Each step: [delay_ms, progress_%, message]
        const steps = [
            [200, 10, 'Loading resources…'],
            [700, 30, 'Connecting to database…'],
            [1300, 55, 'Fetching configurations…'],
            [1900, 75, 'Checking permissions…'],
            [2500, 90, 'Almost ready…'],
            [3100, 100, 'Done — welcome back!'],
        ];

        const fill = document.getElementById('progressFill');
        const msg = document.getElementById('progressMsg');
        const pct = document.getElementById('progressPct');
        const stage = document.getElementById('stage');

        // The URL to redirect to after loading.
        const REDIRECT_URL = '{{ url(' / dashboard') }}';

        steps.forEach(([delay, percent, text]) => {
            setTimeout(() => {
                fill.style.width = percent + '%';
                msg.textContent = text;
                pct.textContent = percent + '%';

                // Once 100% — fade out then redirect
                if (percent >= 100) {
                    setTimeout(() => {
                        stage.classList.add('hiding');
                        setTimeout(() => {
                            window.location.href = REDIRECT_URL;
                        }, 550);
                    }, 600);
                }
            }, delay);
        });
    </script>
    <!-- Code injected by live-server -->
    <script>
        // <![CDATA[  <-- For SVG support
        if ('WebSocket' in window) {
            (function () {
                function refreshCSS() {
                    var sheets = [].slice.call(document.getElementsByTagName("link"));
                    var head = document.getElementsByTagName("head")[0];
                    for (var i = 0; i < sheets.length; ++i) {
                        var elem = sheets[i];
                        var parent = elem.parentElement || head;
                        parent.removeChild(elem);
                        var rel = elem.rel;
                        if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
                            var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
                            elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
                        }
                        parent.appendChild(elem);
                    }
                }
                var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
                var address = protocol + window.location.host + window.location.pathname + '/ws';
                var socket = new WebSocket(address);
                socket.onmessage = function (msg) {
                    if (msg.data == 'reload') window.location.reload();
                    else if (msg.data == 'refreshcss') refreshCSS();
                };
                if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
                    console.log('Live reload enabled.');
                    sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
                }
            })();
        }
        else {
            console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
        }
        // ]]>
    </script>
</body>

</html>