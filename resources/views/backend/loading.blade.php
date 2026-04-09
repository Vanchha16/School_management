<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Loading — IT Department</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/photo_2024-05-27_08-46-50.jpg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800&display=swap" rel="stylesheet">

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg:        #0f172a;
      --bg2:       #1e293b;
      --accent:    #3b82f6;
      --text:      #f1f5f9;
      --muted:     #475569;
      --dim:       #1e3a5f;
      --font:      'Plus Jakarta Sans', 'Segoe UI', system-ui, sans-serif;
    }

    html, body {
      height: 100%;
      background: var(--bg);
      font-family: var(--font);
      overflow: hidden;
    }

    /* ── Background grid ─────────────────────────────── */
    .bg-grid {
      position: fixed; inset: 0;
      background-image:
        linear-gradient(rgba(59,130,246,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(59,130,246,0.04) 1px, transparent 1px);
      background-size: 44px 44px;
      animation: gridDrift 24s linear infinite;
    }
    @keyframes gridDrift {
      from { background-position: 0 0; }
      to   { background-position: 44px 44px; }
    }

    /* ── Ambient glow ────────────────────────────────── */
    .bg-glow {
      position: fixed;
      width: 600px; height: 600px; border-radius: 50%;
      background: radial-gradient(circle, rgba(59,130,246,0.10) 0%, transparent 70%);
      top: 50%; left: 50%; transform: translate(-50%, -50%);
      animation: glowPulse 4s ease-in-out infinite;
      pointer-events: none;
    }
    @keyframes glowPulse {
      0%, 100% { transform: translate(-50%,-50%) scale(1);   opacity: 0.6; }
      50%       { transform: translate(-50%,-50%) scale(1.2); opacity: 1; }
    }

    /* ── Center stage ────────────────────────────────── */
    .stage {
      position: fixed; inset: 0;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      z-index: 10;
      animation: stageOut 0.5s ease forwards;
      animation-play-state: paused;
    }
    .stage.hiding { animation-play-state: running; }
    @keyframes stageOut {
      to { opacity: 0; transform: scale(0.96); }
    }

    /* ── Logo ────────────────────────────────────────── */
    .logo-ring {
      width: 88px; height: 88px; border-radius: 24px;
      background: var(--accent);
      display: flex; align-items: center; justify-content: center;
      font-size: 30px; font-weight: 900; color: #fff;
      letter-spacing: -1px;
      box-shadow: 0 0 0 0 rgba(59,130,246,0.5);
      animation:
        logoIn 0.7s cubic-bezier(.34,1.56,.64,1) 0.1s both,
        logoPing 2s ease-in-out 1s infinite;
      margin-bottom: 28px;
    }
    @keyframes logoIn {
      from { transform: scale(0) rotate(-15deg); opacity: 0; }
      to   { transform: scale(1) rotate(0);      opacity: 1; }
    }
    @keyframes logoPing {
      0%   { box-shadow: 0 0 0 0   rgba(59,130,246,0.5); }
      70%  { box-shadow: 0 0 0 22px rgba(59,130,246,0); }
      100% { box-shadow: 0 0 0 0   rgba(59,130,246,0); }
    }

    /* ── Titles ──────────────────────────────────────── */
    .title {
      font-size: 28px; font-weight: 800;
      color: var(--text); letter-spacing: -0.5px;
      animation: fadeUp 0.6s 0.35s ease both;
      margin-bottom: 6px;
    }
    .subtitle {
      font-size: 12px; font-weight: 700;
      color: var(--muted);
      text-transform: uppercase; letter-spacing: 0.1em;
      animation: fadeUp 0.6s 0.5s ease both;
      margin-bottom: 52px;
    }
    @keyframes fadeUp {
      from { transform: translateY(18px); opacity: 0; }
      to   { transform: translateY(0);    opacity: 1; }
    }

    /* ── Progress bar ────────────────────────────────── */
    .progress-wrap {
      width: 260px;
      animation: fadeUp 0.6s 0.65s ease both;
    }
    .progress-track {
      height: 3px; background: rgba(255,255,255,0.07);
      border-radius: 9999px; overflow: hidden;
    }
    .progress-fill {
      height: 100%; width: 0%; border-radius: 9999px;
      background: var(--accent);
      transition: width 0.4s ease;
    }
    .progress-meta {
      display: flex; justify-content: space-between;
      align-items: center; margin-top: 10px;
    }
    .progress-msg  { font-size: 12px; color: var(--muted); }
    .progress-pct  { font-size: 12px; font-weight: 700; color: var(--accent); }

    /* ── Dots ────────────────────────────────────────── */
    .dots {
      display: flex; gap: 7px; margin-top: 36px;
      animation: fadeUp 0.6s 0.8s ease both;
    }
    .dot {
      width: 6px; height: 6px; border-radius: 50%;
      background: var(--dim);
    }
    .dot:nth-child(1) { animation: dotBeat 1.4s 0s   ease-in-out infinite; }
    .dot:nth-child(2) { animation: dotBeat 1.4s 0.2s ease-in-out infinite; }
    .dot:nth-child(3) { animation: dotBeat 1.4s 0.4s ease-in-out infinite; }
    @keyframes dotBeat {
      0%, 100% { background: var(--dim);    transform: scale(1); }
      50%       { background: var(--accent); transform: scale(1.5); }
    }

    /* ── Footer ──────────────────────────────────────── */
    .footer-tag {
      position: fixed; bottom: 28px; left: 50%;
      transform: translateX(-50%);
      font-size: 11px; color: #1e293b;
      letter-spacing: 0.06em; text-align: center;
      z-index: 10;
      animation: fadeUp 0.6s 1s ease both;
    }
  </style>
</head>
<body>

  <div class="bg-grid"></div>
  <div class="bg-glow"></div>

  <div class="stage" id="stage">
    <div class="logo-ring">IT</div>
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
    Setec School &nbsp;·&nbsp; Cambodia
  </div>

  <script>
    // ── Loading sequence ────────────────────────────────
    // Each step: [delay_ms, progress_%, message]
    const steps = [
      [200,  10, 'Loading resources…'],
      [700,  30, 'Connecting to database…'],
      [1300, 55, 'Fetching configurations…'],
      [1900, 75, 'Checking permissions…'],
      [2500, 90, 'Almost ready…'],
      [3100, 100,'Done — welcome back!'],
    ];

    const fill   = document.getElementById('progressFill');
    const msg    = document.getElementById('progressMsg');
    const pct    = document.getElementById('progressPct');
    const stage  = document.getElementById('stage');

    // The URL to redirect to after loading.
    // Change this to your actual route, e.g. '{{ route("dashboard") }}'
    const REDIRECT_URL = '{{ url("/dashboard") }}';

    steps.forEach(([delay, percent, text]) => {
      setTimeout(() => {
        fill.style.width  = percent + '%';
        msg.textContent   = text;
        pct.textContent   = percent + '%';

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
</body>
</html>