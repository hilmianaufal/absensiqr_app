<nav class="bottom-nav-wrap">
  <div class="bottom-nav-green">
    <a href="{{ route('dashboard') }}"
       class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <i class="bi bi-house"></i>
    </a>

    <a href="{{ route('scan.index') }}"
       class="nav-item scan {{ request()->routeIs('scan.*') ? 'active' : '' }}">
      <i class="bi bi-qr-code-scan"></i>
    </a>

    <a href="{{ route('rekap.index') }}"
       class="nav-item {{ request()->routeIs('rekap.*') ? 'active' : '' }}">
      <i class="bi bi-clipboard-data"></i>
    </a>

    <a href="#" class="nav-item">
      <i class="bi bi-person"></i>
    </a>
  </div>
</nav>
