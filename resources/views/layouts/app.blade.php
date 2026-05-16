<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Absensi QR')</title>

  {{-- Bootstrap 5 CDN --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  {{-- Style kecil (opsional) --}}
  <style>
    body { background: #eef2f0; }
    .card-soft { border: 0; border-radius: 1.25rem; box-shadow: 0 18px 40px rgba(10,20,16,.10); }
    .pill { border-radius: 999px; }
    .bottom-safe { padding-bottom: 92px; } /* ruang untuk bottom nav */
    .bottom-nav-wrap{
      position: fixed; left: 0; right: 0; bottom: 0;
      padding: 12px 12px 14px;
      z-index: 1030;
    }
    .bottom-nav{
      background: #0e3a2c;
      border-radius: 999px;
      padding: 10px 8px;
      box-shadow: 0 18px 40px rgba(0,0,0,.16);
      max-width: 420px;
      margin: 0 auto;
    }
    .bottom-nav a{
      text-decoration: none;
      color: rgba(255,255,255,.85);
      font-weight: 700;
      font-size: 12px;
      border-radius: 16px;
      padding: 10px 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .bottom-nav a.active{
      background: rgba(255,255,255,.14);
      color: #fff;
    }
     .app-menu {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: .75rem;
  }
  @media (min-width: 576px) { .app-menu { grid-template-columns: repeat(3, 1fr);} }
  @media (min-width: 992px) { .app-menu { grid-template-columns: repeat(6, 1fr);} }

  .app-tile{
    border: 1px solid rgba(0,0,0,.06);
    border-radius: 16px;
    padding: 12px;
    background: #fff;
    text-decoration: none;
    transition: transform .08s ease, box-shadow .08s ease;
    box-shadow: 0 6px 18px rgba(0,0,0,.04);
  }
  .app-tile:active{ transform: scale(.98); }
  .app-tile:hover{ box-shadow: 0 10px 24px rgba(0,0,0,.07); }

  .app-icon{
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: grid;
    place-items: center;
    font-size: 20px;
  }
  .app-label{ font-weight: 600; font-size: 13px; margin-top: 10px; line-height: 1.1; }
  .app-sub{ font-size: 11px; color: #6c757d; margin-top: 2px; }

  /* warna lembut */
  .bg-soft-success{ background: rgba(25,135,84,.12); color:#198754; }
  .bg-soft-primary{ background: rgba(13,110,253,.12); color:#0d6efd; }
  .bg-soft-warning{ background: rgba(255,193,7,.16); color:#b58100; }
  .bg-soft-danger{ background: rgba(220,53,69,.12); color:#dc3545; }
  .bg-soft-dark{ background: rgba(33,37,41,.10); color:#212529; }
  .bg-soft-info{ background: rgba(13,202,240,.14); color:#0aa2c0; }


  .menu-bubble-wrap{
    background: linear-gradient(180deg, #0b7a6a 0%, #0b7a6a 30%, transparent 30%);
    border-radius: 18px;
    padding: 14px;
  }
  .menu-bubble-card{
    background: #fff;
    border-radius: 18px;
    padding: 12px;
    box-shadow: 0 10px 24px rgba(0,0,0,.08);
    border: 1px solid rgba(0,0,0,.04);
  }
  .menu-bubble-grid{
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 10px;
  }
  @media (min-width: 768px){
    .menu-bubble-grid{ grid-template-columns: repeat(6, 1fr); }
  }
  @media (min-width: 1200px){
    .menu-bubble-grid{ grid-template-columns: repeat(8, 1fr); }
  }
  .menu-bubble-item{
    text-decoration: none;
    color: inherit;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap: 6px;
    padding: 6px 2px;
    border-radius: 14px;
    transition: transform .08s ease, background .08s ease;
  }
  .menu-bubble-item:active{ transform: scale(.98); }
  .menu-bubble-item:hover{ background: rgba(13,110,253,.06); }

  .menu-bubble-icon{
    width: 44px;
    height: 44px;
    border-radius: 999px;
    display:grid;
    place-items:center;
    font-size: 20px;
    background: #f3f6ff;
    color: #0d6efd;
  }
  .menu-bubble-label{
    font-size: 11px;
    font-weight: 600;
    text-align:center;
    line-height: 1.1;
    max-width: 82px;
  }

  /* variasi warna */
  .ic-success{ background: rgba(25,135,84,.12); color:#198754; }
  .ic-primary{ background: rgba(13,110,253,.12); color:#0d6efd; }
  .ic-warning{ background: rgba(255,193,7,.18); color:#b58100; }
  .ic-danger{ background: rgba(220,53,69,.12); color:#dc3545; }
  .ic-dark{ background: rgba(33,37,41,.10); color:#212529; }
  .ic-info{ background: rgba(13,202,240,.14); color:#0aa2c0; }

  .menu-bubble-title{
    color:#fff;
    font-weight:700;
    font-size:14px;
    margin-bottom:10px;
  }


  .menu-bubble-wrap{
    background: linear-gradient(180deg, #0b7a6a 0%, #0b7a6a 34%, transparent 34%);
    border-radius: 18px;
    padding: 14px;
  }
  .menu-bubble-card{
    background: #fff;
    border-radius: 18px;
    padding: 12px;
    box-shadow: 0 10px 24px rgba(0,0,0,.08);
    border: 1px solid rgba(0,0,0,.04);
  }

  /* FIX: selalu 4 kolom */
  .menu-bubble-grid{
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 10px;
  }

  .menu-bubble-item{
    text-decoration: none;
    color: inherit;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap: 6px;
    padding: 8px 2px;
    border-radius: 14px;
    transition: transform .08s ease, background .08s ease;
  }
  .menu-bubble-item:active{ transform: scale(.98); }
  .menu-bubble-item:hover{ background: rgba(13,110,253,.06); }

  .menu-bubble-icon{
    width: 46px;
    height: 46px;
    border-radius: 999px;
    display:grid;
    place-items:center;
    font-size: 20px;
    background: #f3f6ff;
    color: #0d6efd;
  }
  .menu-bubble-label{
    font-size: 11px;
    font-weight: 700;
    text-align:center;
    line-height: 1.1;
    max-width: 84px;
  }

  /* warna lembut */
  .ic-success{ background: rgba(25,135,84,.12); color:#198754; }
  .ic-primary{ background: rgba(13,110,253,.12); color:#0d6efd; }
  .ic-warning{ background: rgba(255,193,7,.18); color:#b58100; }
  .ic-danger{ background: rgba(220,53,69,.12); color:#dc3545; }
  .ic-dark{ background: rgba(33,37,41,.10); color:#212529; }
  .ic-info{ background: rgba(13,202,240,.14); color:#0aa2c0; }

  .menu-bubble-title{
    color:#fff;
    font-weight:800;
    font-size:14px;
    margin-bottom:10px;
  }


/* ==== Bottom Nav ==== */
.bottom-nav-wrap{
  position: fixed;
  left: 0;
  right: 0;
  bottom: env(safe-area-inset-bottom);
  z-index: 1030;
  padding: 8px 14px;
  pointer-events: none;
}

.bottom-nav{
  max-width: 520px;
  margin: auto;
  height: 56px;
  background: rgba(255,255,255,.72);
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  border-radius: 18px;
  box-shadow: 0 12px 28px rgba(0,0,0,.15);
  display: flex;
  align-items: center;
  justify-content: space-around;
  pointer-events: auto;
}

.bottom-nav .nav-item{
  width: 44px;
  height: 44px;
  border-radius: 14px;
  display: grid;
  place-items: center;
  color: #6c757d;
  text-decoration: none;
  font-size: 22px;
  transition: all .15s ease;
}

.bottom-nav .nav-item:hover{
  color: #0d6efd;
}

.bottom-nav .nav-item.active{
  background: rgba(13,110,253,.14);
  color: #0d6efd;
}

/* supaya konten gak ketutup bottom nav */
body{
  padding-bottom: 90px;
}

/* sembunyikan di desktop besar (opsional) */
@media (min-width: 992px){
  .bottom-nav-wrap{
    display: none;
  }
}


/* ===== Bottom Navigation (Green Elegant) ===== */
.bottom-nav-wrap{
  position: fixed;
  left: 0;
  right: 0;
  bottom: env(safe-area-inset-bottom);
  z-index: 1030;
  padding: 10px 14px;
  pointer-events: none;
}

.bottom-nav-green{
  max-width: 520px;
  margin: auto;
  height: 58px;
  background: linear-gradient(135deg, #0f766e, #16a34a);
  border-radius: 20px;
  box-shadow: 0 18px 36px rgba(16, 185, 129, .35);
  display: flex;
  align-items: center;
  justify-content: space-around;
  pointer-events: auto;
}

/* icon */
.bottom-nav-green .nav-item{
  width: 46px;
  height: 46px;
  border-radius: 16px;
  display: grid;
  place-items: center;
  color: rgba(255,255,255,.75);
  font-size: 22px;
  text-decoration: none;
  transition: all .18s ease;
}

/* hover */
.bottom-nav-green .nav-item:hover{
  color: #ffffff;
  transform: translateY(-1px);
}

/* active */
.bottom-nav-green .nav-item.active{
  background: rgba(255,255,255,.22);
  color: #ffffff;
}

/* scan icon lebih menonjol */
.bottom-nav-green .nav-item.scan{
  background: rgba(255,255,255,.18);
  color: #ffffff;
  box-shadow: 0 8px 18px rgba(0,0,0,.18);
}

/* agar konten tidak ketutup */
body{
  padding-bottom: 96px;
}

/* hide di desktop besar */
@media (min-width: 992px){
  .bottom-nav-wrap{
    display: none;
  }
}


/* ===== Topbar ===== */
.topbar-wrap{
  background: linear-gradient(135deg, #0f766e, #16a34a);
  padding: 14px 0;
  box-shadow: 0 12px 30px rgba(16,185,129,.35);
}

.topbar{
  color: #fff;
}

/* avatar bulat */
.avatar-circle{
  width: 46px;
  height: 46px;
  border-radius: 999px;
  background: rgba(255,255,255,.22);
  display: grid;
  place-items: center;
  font-weight: 800;
  font-size: 18px;
  color: #ffffff;
  box-shadow: inset 0 0 0 2px rgba(255,255,255,.35);
}

/* sub title */
.topbar-sub{
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: .08em;
  color: rgba(255,255,255,.85);
  font-weight: 600;
}

/* tombol notifikasi */
.notif-btn{
  width: 46px;
  height: 46px;
  border-radius: 999px;
  border: none;
  background: rgba(255,255,255,.22);
  color: #fff;
  display: grid;
  place-items: center;
  font-size: 20px;
  box-shadow: 0 8px 22px rgba(0,0,0,.18);
  transition: transform .12s ease, background .12s ease;
}

.notif-btn:hover{
  background: rgba(255,255,255,.32);
}

.notif-btn:active{
  transform: scale(.96);
}

<style>
/* ===== Topbar (Photo Avatar) ===== */
.topbar-wrap{
  background: linear-gradient(135deg, #0f766e, #16a34a);
  padding: 14px 0;
  box-shadow: 0 12px 30px rgba(16,185,129,.35);
}

.topbar{
  color: #fff;
}

/* FOTO AVATAR */
.topbar-avatar{
  width: 46px;
  height: 46px;
  border-radius: 999px;
  object-fit: cover;
  background: #fff;
  box-shadow:
    0 8px 20px rgba(0,0,0,.25),
    inset 0 0 0 2px rgba(255,255,255,.55);
}

/* subtitle */
.topbar-sub{
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: .08em;
  color: rgba(255,255,255,.9);
  font-weight: 600;
}

/* tombol notifikasi */
.notif-btn{
  width: 46px;
  height: 46px;
  border-radius: 999px;
  border: none;
  background: rgba(255,255,255,.22);
  color: #fff;
  display: grid;
  place-items: center;
  font-size: 20px;
  box-shadow: 0 8px 22px rgba(0,0,0,.18);
  transition: transform .12s ease, background .12s ease;
}

.notif-btn:hover{
  background: rgba(255,255,255,.32);
}

.notif-btn:active{
  transform: scale(.96);
}
</style>




  </style>

  @stack('styles')
</head>
<body>

  @include('partials.navbar')

  <main class="container bottom-safe py-3" style="max-width: 460px;">
    @yield('content')
  </main>

  @include('partials.bottomnav')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
