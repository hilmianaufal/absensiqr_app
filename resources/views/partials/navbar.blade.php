<nav class="topbar-wrap">
  <div class="container px-3" style="max-width:460px;">
    <div class="topbar d-flex align-items-center justify-content-between">

      <div class="d-flex align-items-center gap-3">
        <img
          src="{{ auth()->check() ? auth()->user()->avatarUrl() : asset('images/default.jpg') }}"
          alt="avatar"
          class="topbar-avatar">

        <div class="lh-sm">
          <div class="fw-bold text-white fs-6">Dashboard Absensi</div>
          <div class="topbar-sub">
            Petugas:
            {{ auth()->check() ? auth()->user()->name : 'Tamu' }}
          </div>
        </div>
      </div>

      <button class="notif-btn" type="button" title="Notifikasi">
        <i class="bi bi-bell"></i>
      </button>

    </div>
  </div>
</nav>
