<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Absensi Sholat (QR)</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg:#eef2f0;
      --card:#ffffff;
      --ink:#0b1f16;
      --muted:#5b6b63;
      --green:#0e3a2c;
      --green-2:#0b2f24;
      --chip:#e8ecea;
      --warn:#f1c232;
      --danger:#e35d5d;
      --ok:#2f9e44;
      --shadow: 0 18px 40px rgba(10, 20, 16, .10);
      --radius: 18px;
      --radius-lg: 26px;
      --ring: 0 0 0 3px rgba(14,58,44,.12);
    }

    *{box-sizing:border-box}
    body{
      margin:0;
      font-family:"Plus Jakarta Sans", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      color:var(--ink);
      background:var(--bg);
    }

    /* App wrapper (centered on desktop) */
    .app{
      min-height:100svh;
      display:flex;
      justify-content:center;
      padding:18px 14px 92px;
    }
    .phone{
      width:100%;
      max-width:420px;
    }

    /* Header */
    .topbar{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      padding:6px 2px 14px;
    }
    .user{
      display:flex;
      align-items:center;
      gap:12px;
      min-width:0;
    }
    .avatar{
      width:44px;height:44px;border-radius:999px;
      overflow:hidden;
      background:#d7dedb;
      border:3px solid rgba(255,255,255,.65);
      box-shadow:0 10px 25px rgba(0,0,0,.08);
      flex:0 0 auto;
      display:grid;
      place-items:center;
      color:var(--green);
      font-weight:900;
    }
    .hello{line-height:1.05; min-width:0;}
    .hello .welcome{
      font-weight:800;
      font-size:20px;
      letter-spacing:-.02em;
      margin:0;
    }
    .hello .name{
      margin:4px 0 0;
      font-size:12px;
      color:var(--muted);
      text-transform:uppercase;
      letter-spacing:.08em;
      font-weight:700;
      white-space:nowrap;
      overflow:hidden;
      text-overflow:ellipsis;
      max-width:220px;
    }
    .bell{
      width:44px;height:44px;border-radius:999px;
      background:var(--warn);
      display:grid;place-items:center;
      box-shadow:0 10px 25px rgba(0,0,0,.12);
      border:none;
      cursor:pointer;
    }
    .bell svg{width:20px;height:20px;fill:#1c1c1c}

    /* Filters / Search */
    .filters{
      display:grid;
      grid-template-columns: 1fr;
      gap:10px;
      margin-bottom:14px;
    }
    .field{
      display:flex;
      align-items:center;
      gap:10px;
      background:var(--card);
      border-radius:999px;
      padding:12px 14px;
      box-shadow:0 10px 22px rgba(0,0,0,.06);
    }
    .field .icon{
      width:20px;height:20px;fill:var(--green);
      flex:0 0 auto;
    }
    .field input, .field select{
      border:0; outline:0;
      background:transparent;
      width:100%;
      font-size:14px;
      color:var(--ink);
      appearance:none;
    }
    .field select{cursor:pointer}
    .field small{color:var(--muted); font-weight:600}

    .actions{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap:10px;
      margin-top:10px;
    }
    .btn{
      border:0;
      border-radius:16px;
      padding:12px 12px;
      font-weight:800;
      cursor:pointer;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:8px;
      box-shadow:0 12px 24px rgba(0,0,0,.10);
    }
    .btn-primary{background:var(--green); color:#fff;}
    .btn-secondary{background:#dfe6e2; color:var(--green);}
    .btn svg{width:18px;height:18px;fill:currentColor}

    /* Section titles */
    .section{margin-top:18px;}
    .section h2{
      margin:0 0 12px;
      font-size:20px;
      letter-spacing:-.02em;
      font-weight:900;
      color:var(--green);
    }

    /* Prayer summary grid */
    .prayer-grid{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap:12px;
    }
    .card{
      background:var(--card);
      border-radius:22px;
      padding:14px 14px;
      box-shadow:var(--shadow);
      position:relative;
      overflow:hidden;
    }
    .card .title{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      margin-bottom:10px;
    }
    .badge{
      font-size:11px;
      font-weight:900;
      letter-spacing:.06em;
      padding:6px 10px;
      border-radius:999px;
      background:var(--chip);
      color:var(--green);
      white-space:nowrap;
    }
    .badge.live{background:rgba(47,158,68,.14); color:var(--ok)}
    .badge.closed{background:rgba(227,93,93,.14); color:var(--danger)}
    .badge.soon{background:rgba(241,194,50,.18); color:#7a5a00}

    .prayer-name{
      font-weight:900;
      letter-spacing:.02em;
      margin:0;
      font-size:14px;
    }
    .meta{
      display:flex;
      gap:8px;
      flex-wrap:wrap;
      margin-top:6px;
      color:var(--muted);
      font-size:12px;
      font-weight:700;
    }
    .stats{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap:8px 10px;
      margin-top:10px;
      font-size:12px;
      font-weight:800;
    }
    .stat{
      background:#f5f7f6;
      border-radius:14px;
      padding:10px 10px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
    }
    .stat span{color:var(--muted); font-weight:800}
    .stat strong{color:var(--green); font-weight:900}
    .stat .good{color:var(--ok)}
    .stat .bad{color:var(--danger)}
    .stat .warn{color:#7a5a00}

    /* Progress card */
    .progress-card{
      background:var(--green);
      color:#fff;
      border-radius:26px;
      padding:16px;
      box-shadow:0 18px 40px rgba(0,0,0,.16);
    }
    .progress-card .row1{
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:10px;
      margin-bottom:10px;
    }
    .progress-card h3{
      margin:0;
      font-size:16px;
      font-weight:900;
      letter-spacing:-.02em;
    }
    .progress-card p{
      margin:6px 0 0;
      color:rgba(255,255,255,.82);
      font-weight:700;
      font-size:12px;
    }
    .pill{
      background:rgba(255,255,255,.16);
      border-radius:999px;
      padding:8px 10px;
      font-size:11px;
      font-weight:900;
      letter-spacing:.06em;
      white-space:nowrap;
    }
    .bar{
      height:12px;
      background:rgba(255,255,255,.18);
      border-radius:999px;
      overflow:hidden;
    }
    .bar > div{
      height:100%;
      width:66%;
      background:#fff;
      border-radius:999px;
    }
    .progress-foot{
      margin-top:10px;
      display:flex;
      justify-content:space-between;
      gap:10px;
      font-size:12px;
      font-weight:800;
      color:rgba(255,255,255,.88);
    }

    /* Notification list */
    .notif{
      display:grid;
      gap:10px;
    }
    .notif-item{
      display:flex;
      gap:10px;
      align-items:flex-start;
      background:var(--card);
      border-radius:18px;
      padding:12px 12px;
      box-shadow:0 12px 24px rgba(0,0,0,.08);
    }
    .dot{
      width:10px;height:10px;border-radius:999px;
      margin-top:4px;
      background:var(--warn);
      flex:0 0 auto;
    }
    .dot.ok{background:var(--ok)}
    .dot.bad{background:var(--danger)}
    .notif-item h4{
      margin:0;
      font-size:13px;
      font-weight:900;
      color:var(--green);
    }
    .notif-item p{
      margin:4px 0 0;
      font-size:12px;
      font-weight:700;
      color:var(--muted);
    }

    /* Top stats */
    .row-scroll{
      display:flex;
      gap:12px;
      overflow:auto;
      padding-bottom:6px;
      scroll-snap-type:x mandatory;
      -webkit-overflow-scrolling:touch;
    }
    .row-scroll::-webkit-scrollbar{height:8px}
    .row-scroll::-webkit-scrollbar-thumb{background:rgba(0,0,0,.12);border-radius:99px}

    .mini-card{
      width:230px;
      flex:0 0 auto;
      scroll-snap-align:start;
      background:var(--card);
      border-radius:22px;
      padding:14px;
      box-shadow:var(--shadow);
    }
    .mini-card .head{
      display:flex;
      justify-content:space-between;
      align-items:center;
      gap:10px;
      margin-bottom:10px;
    }
    .mini-card .head h3{
      margin:0;
      font-size:14px;
      font-weight:900;
      color:var(--green);
    }
    .mini-card .tag{
      font-size:11px;
      font-weight:900;
      color:var(--green);
      background:var(--chip);
      padding:6px 10px;
      border-radius:999px;
      white-space:nowrap;
    }
    .list{
      display:grid;
      gap:8px;
      margin:0;
      padding:0;
      list-style:none;
    }
    .list li{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      background:#f5f7f6;
      border-radius:14px;
      padding:10px 10px;
      font-size:12px;
      font-weight:800;
    }
    .list li .left{
      display:flex; align-items:center; gap:8px; min-width:0;
    }
    .rank{
      width:22px; height:22px; border-radius:8px;
      background:rgba(14,58,44,.12);
      color:var(--green);
      display:grid; place-items:center;
      font-weight:900;
      flex:0 0 auto;
    }
    .who{
      min-width:0;
      overflow:hidden;
      text-overflow:ellipsis;
      white-space:nowrap;
    }
    .val{
      color:var(--green);
      font-weight:900;
      white-space:nowrap;
    }

    /* Bottom nav */
    .bottom-nav{
      position:fixed;
      left:0; right:0; bottom:0;
      display:flex;
      justify-content:center;
      padding:10px 12px 14px;
      pointer-events:none;
    }
    .nav-inner{
      pointer-events:auto;
      width:min(420px, calc(100% - 24px));
      background:var(--green);
      border-radius:999px;
      padding:12px 10px;
      display:grid;
      grid-template-columns: repeat(4, 1fr);
      gap:6px;
      box-shadow:0 18px 40px rgba(0,0,0,.16);
    }
    .nav-item{
      display:flex;
      flex-direction:column;
      align-items:center;
      justify-content:center;
      gap:6px;
      color:rgba(255,255,255,.88);
      text-decoration:none;
      padding:8px 6px;
      border-radius:18px;
      font-size:11px;
      font-weight:800;
    }
    .nav-item svg{width:20px;height:20px;fill:rgba(255,255,255,.90)}
    .nav-item.active{
      background:rgba(255,255,255,.14);
      box-shadow:var(--ring);
      color:#fff;
    }
    .nav-item.active svg{fill:#fff}

    /* Responsive adjustments */
    @media (min-width: 520px){
      .filters{grid-template-columns: 1fr 1fr;}
      .actions{grid-template-columns: 2fr 1fr;}
      .prayer-grid{grid-template-columns: 1fr 1fr;}
    }
    @media (min-width: 900px){
      .app{padding-bottom:18px}
      .bottom-nav{position:sticky; bottom:auto; margin-top:18px}
      .phone{max-width:520px}
      .prayer-grid{grid-template-columns: 1fr 1fr;}
      .mini-card{width:260px}
    }
  </style>
</head>

<body>
  <main class="app">
    <div class="phone">

      <!-- Header -->
      <header class="topbar">
        <div class="user">
          <div class="avatar" aria-hidden="true">A</div>
          <div class="hello">
            <p class="welcome">Dashboard Absensi</p>
            <p class="name">PETUGAS: USTADZ AHMAD</p>
          </div>
        </div>

        <button class="bell" aria-label="Notifikasi">
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 22a2.5 2.5 0 0 0 2.45-2h-4.9A2.5 2.5 0 0 0 12 22Zm7-6V11a7 7 0 1 0-14 0v5l-2 2v1h18v-1l-2-2Z"/>
          </svg>
        </button>
      </header>

      <!-- Filters -->
      <section class="filters" aria-label="Filter Dashboard">
        <div class="field">
          <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M7 2h10a2 2 0 0 1 2 2v2H5V4a2 2 0 0 1 2-2Zm12 6v14H5V8h14ZM7 10h3v3H7v-3Z"/>
          </svg>
          <input type="date" value="2025-12-28" />
        </div>

        <div class="field">
          <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.42 0-8 2.24-8 5v3h16v-3c0-2.76-3.58-5-8-5Z"/>
          </svg>
          <select>
            <option>Semua Kelas/Kamar</option>
            <option>Kelas 7A</option>
            <option>Kelas 8B</option>
            <option>Kamar Umar</option>
            <option>Kamar Ali</option>
          </select>
        </div>
      </section>

      <!-- Quick Actions -->
      <section class="actions" aria-label="Aksi Cepat">
        <button class="btn btn-primary">
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm-1 14-4-4 1.4-1.4L11 13.2l5.6-5.6L18 9l-7 7Z"/>
          </svg>
          Mulai Scan Sekarang
        </button>

        <button class="btn btn-secondary">
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M4 4h16v4H4V4Zm0 6h16v10H4V10Zm4 2v6h2v-6H8Zm6 0v6h2v-6h-2Z"/>
          </svg>
          Rekap Hari Ini
        </button>
      </section>

      <!-- Progress (Realtime) -->
      <section class="section" aria-label="Progress Absensi">
        <div class="progress-card">
          <div class="row1">
            <div>
              <h3>Progress Dzuhur (Sedang berjalan)</h3>
              <p>Window: 12:05–12:30 • Toleransi telat: 10 menit</p>
            </div>
            <div class="pill">HADIR 132/200</div>
          </div>

          <div class="bar" aria-label="progress bar">
            <div style="width:66%"></div>
          </div>

          <div class="progress-foot">
            <span>66% hadir</span>
            <span>Belum hadir: 68</span>
          </div>
        </div>
      </section>

      <!-- Summary per Prayer -->
      <section class="section" aria-label="Ringkasan per Waktu Sholat">
        <h2>Ringkasan Hari Ini (5 Waktu)</h2>

        <div class="prayer-grid">
          <!-- Subuh -->
          <article class="card">
            <div class="title">
              <p class="prayer-name">Subuh</p>
              <span class="badge closed">DITUTUP</span>
            </div>
            <div class="meta">
              <span>Scan: 04:20–04:45</span>
              <span>•</span>
              <span>Total: 200</span>
            </div>
            <div class="stats">
              <div class="stat"><span>Hadir</span><strong class="good">185</strong></div>
              <div class="stat"><span>Terlambat</span><strong class="warn">8</strong></div>
              <div class="stat"><span>Izin</span><strong>4</strong></div>
              <div class="stat"><span>Alpa</span><strong class="bad">3</strong></div>
            </div>
          </article>

          <!-- Dzuhur -->
          <article class="card">
            <div class="title">
              <p class="prayer-name">Dzuhur</p>
              <span class="badge live">BERJALAN</span>
            </div>
            <div class="meta">
              <span>Scan: 12:05–12:30</span>
              <span>•</span>
              <span>Total: 200</span>
            </div>
            <div class="stats">
              <div class="stat"><span>Hadir</span><strong class="good">132</strong></div>
              <div class="stat"><span>Terlambat</span><strong class="warn">6</strong></div>
              <div class="stat"><span>Izin</span><strong>2</strong></div>
              <div class="stat"><span>Belum</span><strong class="bad">60</strong></div>
            </div>
          </article>

          <!-- Ashar -->
          <article class="card">
            <div class="title">
              <p class="prayer-name">Ashar</p>
              <span class="badge soon">BELUM MULAI</span>
            </div>
            <div class="meta">
              <span>Scan: 15:10–15:35</span>
              <span>•</span>
              <span>Total: 200</span>
            </div>
            <div class="stats">
              <div class="stat"><span>Hadir</span><strong>0</strong></div>
              <div class="stat"><span>Terlambat</span><strong>0</strong></div>
              <div class="stat"><span>Izin</span><strong>0</strong></div>
              <div class="stat"><span>Alpa</span><strong>0</strong></div>
            </div>
          </article>

          <!-- Maghrib -->
          <article class="card">
            <div class="title">
              <p class="prayer-name">Maghrib</p>
              <span class="badge soon">BELUM MULAI</span>
            </div>
            <div class="meta">
              <span>Scan: 18:10–18:30</span>
              <span>•</span>
              <span>Total: 200</span>
            </div>
            <div class="stats">
              <div class="stat"><span>Hadir</span><strong>0</strong></div>
              <div class="stat"><span>Terlambat</span><strong>0</strong></div>
              <div class="stat"><span>Izin</span><strong>0</strong></div>
              <div class="stat"><span>Alpa</span><strong>0</strong></div>
            </div>
          </article>

          <!-- Isya (biar genap grid, kita bikin card penuh 2 kolom kalau layar kecil) -->
          <article class="card" style="grid-column: 1 / -1;">
            <div class="title">
              <p class="prayer-name">Isya</p>
              <span class="badge soon">BELUM MULAI</span>
            </div>
            <div class="meta">
              <span>Scan: 19:40–20:05</span>
              <span>•</span>
              <span>Total: 200</span>
            </div>
            <div class="stats" style="grid-template-columns: repeat(4, 1fr);">
              <div class="stat"><span>Hadir</span><strong>0</strong></div>
              <div class="stat"><span>Terlambat</span><strong>0</strong></div>
              <div class="stat"><span>Izin</span><strong>0</strong></div>
              <div class="stat"><span>Alpa</span><strong>0</strong></div>
            </div>
          </article>
        </div>
      </section>

      <!-- Notifications -->
      <section class="section" aria-label="Notifikasi Penting">
        <h2>Notifikasi</h2>
        <div class="notif">
          <div class="notif-item">
            <span class="dot ok" aria-hidden="true"></span>
            <div>
              <h4>Subuh ditutup</h4>
              <p>Absensi Subuh sudah ditutup pada 04:45. Hadir 185/200.</p>
            </div>
          </div>

          <div class="notif-item">
            <span class="dot" aria-hidden="true"></span>
            <div>
              <h4>Dzuhur masih berjalan</h4>
              <p>Masih ada 60 santri belum hadir. Tutup otomatis 12:30.</p>
            </div>
          </div>

          <div class="notif-item">
            <span class="dot bad" aria-hidden="true"></span>
            <div>
              <h4>Scan duplikat terdeteksi</h4>
              <p>Ada 4 scan duplikat pada Dzuhur (contoh: A-102, A-077).</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Top Stats -->
      <section class="section" aria-label="Statistik Singkat">
        <h2>Statistik Singkat</h2>
        <div class="row-scroll">

          <article class="mini-card">
            <div class="head">
              <h3>Hadir Tercepat</h3>
              <span class="tag">Subuh</span>
            </div>
            <ul class="list">
              <li><span class="left"><span class="rank">1</span><span class="who">Ahmad (A-021)</span></span><span class="val">04:20</span></li>
              <li><span class="left"><span class="rank">2</span><span class="who">Fikri (A-033)</span></span><span class="val">04:21</span></li>
              <li><span class="left"><span class="rank">3</span><span class="who">Rizky (A-015)</span></span><span class="val">04:21</span></li>
              <li><span class="left"><span class="rank">4</span><span class="who">Zidan (A-090)</span></span><span class="val">04:22</span></li>
              <li><span class="left"><span class="rank">5</span><span class="who">Hafiz (A-101)</span></span><span class="val">04:22</span></li>
            </ul>
          </article>

          <article class="mini-card">
            <div class="head">
              <h3>Terlambat Terbanyak</h3>
              <span class="tag">Minggu ini</span>
            </div>
            <ul class="list">
              <li><span class="left"><span class="rank">1</span><span class="who">Bima (A-077)</span></span><span class="val">5x</span></li>
              <li><span class="left"><span class="rank">2</span><span class="who">Nanda (A-064)</span></span><span class="val">4x</span></li>
              <li><span class="left"><span class="rank">3</span><span class="who">Ihsan (A-052)</span></span><span class="val">4x</span></li>
              <li><span class="left"><span class="rank">4</span><span class="who">Fauzan (A-039)</span></span><span class="val">3x</span></li>
              <li><span class="left"><span class="rank">5</span><span class="who">Rafi (A-118)</span></span><span class="val">3x</span></li>
            </ul>
          </article>

          <article class="mini-card">
            <div class="head">
              <h3>Izin / Sakit</h3>
              <span class="tag">Hari ini</span>
            </div>
            <ul class="list">
              <li><span class="left"><span class="rank">I</span><span class="who">Izin</span></span><span class="val">6</span></li>
              <li><span class="left"><span class="rank">S</span><span class="who">Sakit</span></span><span class="val">3</span></li>
              <li><span class="left"><span class="rank">A</span><span class="who">Alpa</span></span><span class="val">3</span></li>
              <li><span class="left"><span class="rank">D</span><span class="who">Duplikat Scan</span></span><span class="val">4</span></li>
              <li><span class="left"><span class="rank">N</span><span class="who">Non-aktif terscan</span></span><span class="val">1</span></li>
            </ul>
          </article>

        </div>
      </section>

    </div>
  </main>

  <!-- Bottom Navigation -->
  <nav class="bottom-nav" aria-label="Bottom navigation">
    <div class="nav-inner">
      <a class="nav-item active" href="#">
        <svg viewBox="0 0 24 24"><path d="M12 3 2 12h3v9h6v-6h2v6h6v-9h3L12 3Z"/></svg>
        Dashboard
      </a>
      <a class="nav-item" href="#">
        <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm-1 14-4-4 1.4-1.4L11 13.2l5.6-5.6L18 9l-7 7Z"/></svg>
        Scan QR
      </a>
      <a class="nav-item" href="#">
        <svg viewBox="0 0 24 24"><path d="M4 4h16v4H4V4Zm0 6h16v10H4V10Zm4 2v6h2v-6H8Zm6 0v6h2v-6h-2Z"/></svg>
        Rekap
      </a>
      <a class="nav-item" href="#">
        <svg viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.42 0-8 2.24-8 5v3h16v-3c0-2.76-3.58-5-8-5Z"/></svg>
        Profil
      </a>
    </div>
  </nav>
</body>
</html>
