@extends('layouts.app')
@section('title','Scan Kegiatan')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h4 class="fw-bold mb-0">Scan Kegiatan Santri</h4>
    <div class="text-muted small">Pilih metode scan: Kamera / Scanner / Manual</div>
  </div>
  <a href="{{ route('students.index') }}" class="btn btn-light">Data Santri</a>
</div>

@if($activeActivity)
  <div class="alert alert-success d-flex justify-content-between align-items-center">
    <div>
      <div class="fw-bold">Kegiatan Aktif: {{ $activeActivity->name }}</div>
      <div class="small">
        Window: {{ $activeActivity->start_time }}–{{ $activeActivity->end_time }}
        • Toleransi telat: {{ $activeActivity->late_minutes }} menit
      </div>
    </div>
    <span class="badge bg-success">LIVE</span>
  </div>
@else
  <div class="alert alert-warning">
    <div class="fw-bold">Tidak ada kegiatan aktif</div>
    <div class="small">Scan ditahan dulu (atau bisa dibuat mode pilih sholat manual).</div>
  </div>
@endif

<div class="row g-3">
  <div class="col-12">
    <div class="card p-3">

      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
        <div class="fw-bold">Metode Scan</div>

        <div class="btn-group" role="group" aria-label="mode">
          <input type="radio" class="btn-check" name="mode" id="modeCamera" autocomplete="off" checked>
          <label class="btn btn-outline-primary btn-sm" for="modeCamera">Kamera</label>

          <input type="radio" class="btn-check" name="mode" id="modeScanner" autocomplete="off">
          <label class="btn btn-outline-primary btn-sm" for="modeScanner">Scanner</label>

          <input type="radio" class="btn-check" name="mode" id="modeManual" autocomplete="off">
          <label class="btn btn-outline-primary btn-sm" for="modeManual">Manual</label>
        </div>

        <div class="d-flex gap-2">
          <button id="btnStart" class="btn btn-success btn-sm">Start Kamera</button>
          <button id="btnStop" class="btn btn-outline-danger btn-sm" disabled>Stop</button>
        </div>
      </div>

      {{-- Kamera --}}
      <div id="cameraWrap" class="mt-2">
        <div id="reader" style="width:100%; max-width:420px;"></div>
        <div class="text-muted small mt-2">
          Tips: gunakan kamera belakang HP. Jika minta izin kamera, pilih <b>Allow</b>.
        </div>
      </div>

      {{-- Scanner HID (Keyboard) --}}
      <div id="scannerWrap" class="mt-2 d-none">
        <div class="text-muted small mb-2">
          Gunakan alat scanner (USB/Bluetooth) mode <b>Keyboard (HID)</b> dan pastikan suffix <b>Enter</b> aktif.
        </div>
        <input id="scannerInput" class="form-control" placeholder="Arahkan scanner... (otomatis kirim saat Enter)" autocomplete="off">
        <div class="form-text">Jika scanner tidak mengirim Enter, kamu bisa tekan Enter manual setelah scan.</div>
      </div>

      {{-- Manual --}}
      <div id="manualWrap" class="mt-3 d-none">
        <div class="fw-semibold mb-2">Input Manual</div>
        <div class="input-group">
          <input id="manualToken" class="form-control" placeholder="Tempel token QR di sini..." autocomplete="off">
          <button id="btnManual" class="btn btn-primary">Kirim</button>
        </div>
      </div>

    </div>
  </div>

  <div class="col-12">
    <div class="card p-3">
      <div class="fw-bold mb-2">Hasil Scan</div>

      <div id="alertBox" class="alert d-none mb-3"></div>

      <div id="resultBox" class="border rounded p-3 bg-light">
        <div class="text-muted small">Belum ada scan.</div>
      </div>

      <audio id="beepSound" src="{{ asset('sounds/beep.mp3') }}" preload="auto"></audio>
    </div>
  </div>
</div>

{{-- html5-qrcode --}}
<script src="https://unpkg.com/html5-qrcode" defer></script>

<script>
window.__HAS_ACTIVE_ACTIVITY__ = @json((bool) $activeActivity);
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const csrf = @json(csrf_token());
  const scanUrl = @json(route('activities.scan.store'));
  const hasActivePrayer = window.__HAS_ACTIVE_ACTIVITY__;

  const alertBox  = document.getElementById('alertBox');
  const resultBox = document.getElementById('resultBox');

  const btnStart = document.getElementById('btnStart');
  const btnStop  = document.getElementById('btnStop');

  const modeCamera  = document.getElementById('modeCamera');
  const modeScanner = document.getElementById('modeScanner');
  const modeManual  = document.getElementById('modeManual');

  const cameraWrap  = document.getElementById('cameraWrap');
  const scannerWrap = document.getElementById('scannerWrap');
  const manualWrap  = document.getElementById('manualWrap');

  const scannerInput = document.getElementById('scannerInput');
  const manualToken  = document.getElementById('manualToken');
  const btnManual    = document.getElementById('btnManual');

  const beep = document.getElementById('beepSound');
  function playBeep() {
    if (!beep) return;
    beep.currentTime = 0;
    beep.play().catch(() => {});
  }

  // Unlock audio (biar HP tidak blok suara)
  btnStart?.addEventListener('click', async () => {
    try {
      if (!beep) return;
      await beep.play();
      beep.pause();
      beep.currentTime = 0;
    } catch {}
  });

  let html5QrCode = null;
  let isScanning = false;
  let lastToken = null;
  let lock = false;

  function showAlert(type, msg) {
    if (!alertBox) return;
    alertBox.className = `alert alert-${type} mb-3`;
    alertBox.textContent = msg;
    alertBox.classList.remove('d-none');
  }
  function hideAlert() {
    alertBox?.classList.add('d-none');
  }

  async function sendToken(token) {
    if (!hasActivePrayer) {
      showAlert('warning', 'Tidak ada sholat aktif. Scan ditunda.');
      return;
    }

    token = String(token ?? '').trim();
    if (!token) return;

    // cegah dobel
    if (token === lastToken) return;
    if (lock) return;
    lock = true;

    try {
      hideAlert();

      const res = await fetch(scanUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf,
          'Accept': 'application/json'
        },
        body: JSON.stringify({ token })
      });

      const json = await res.json();

      if (!res.ok || !json.ok) {
        showAlert('danger', json.message ?? 'Gagal memproses scan.');
        if (resultBox) {
          resultBox.innerHTML = `<div class="text-danger small fw-semibold">${json.message ?? 'QR tidak valid.'}</div>`;
        }
      } else {
        const badge = json.status === 'terlambat'
          ? '<span class="badge bg-warning text-dark">TERLAMBAT</span>'
          : '<span class="badge bg-success">HADIR</span>';

        const already = json.already
          ? '<span class="badge bg-secondary">SUDAH ABSEN</span>'
          : '<span class="badge bg-primary">TERCATAT</span>';

        showAlert('success', json.message ?? 'Berhasil.');

        if (resultBox) {
          resultBox.innerHTML = `
            <div class="d-flex justify-content-between align-items-start gap-2">
              <div>
                <div class="fw-bold mb-1">${json.student.name}</div>
                <div class="small text-muted">NIS: <b>${json.student.nis}</b></div>
                <div class="small text-muted">Kelas: ${json.student.kelas ?? '-'} • Kamar: ${json.student.kamar ?? '-'}</div>
                <div class="small mt-2">Sholat: <b>${json.activity}</b> • Jam: <b>${json.scanned_at}</b></div>
              </div>
              <div class="text-end">
                ${badge}<br/>
                <div class="mt-2">${already}</div>
              </div>
            </div>
          `;
        }

        lastToken = token;
        playBeep();
        if (navigator.vibrate) navigator.vibrate(80);
      }
    } catch (e) {
      showAlert('danger', 'Koneksi bermasalah. Coba lagi.');
    } finally {
      setTimeout(() => lock = false, 900);
    }
  }

  // ===== Kamera =====
  async function startScan() {
    if (!hasActivePrayer) {
      showAlert('warning', 'Tidak ada kegiatan aktif. Scan ditunda.');
      return;
    }
    if (isScanning) return;

    html5QrCode = new Html5Qrcode("reader");

    try {
      const devices = await Html5Qrcode.getCameras();
      if (!devices || devices.length === 0) {
        showAlert('danger', 'Kamera tidak ditemukan.');
        return;
      }

      const backCam = devices.find(d => /back|rear|environment/i.test(d.label));
      const cameraId = (backCam ? backCam.id : devices[0].id);

      isScanning = true;
      btnStart.disabled = true;
      btnStop.disabled = false;

      await html5QrCode.start(
        { deviceId: { exact: cameraId } },
        { fps: 10, qrbox: { width: 240, height: 240 } },
        (decodedText) => {
          let token = decodedText;
          try {
            if (decodedText.startsWith('http')) {
              const u = new URL(decodedText);
              token = u.searchParams.get('token') || decodedText;
            }
          } catch {}
          sendToken(token);
        }
      );

      showAlert('info', 'Mode Kamera aktif. Arahkan ke QR santri.');
    } catch (err) {
      showAlert('danger', 'Gagal akses kamera. Pastikan izin kamera diaktifkan.');
      isScanning = false;
      btnStart.disabled = false;
      btnStop.disabled = true;
    }
  }

  async function stopScan() {
    if (!html5QrCode || !isScanning) return;
    try {
      await html5QrCode.stop();
      await html5QrCode.clear();
    } catch {}
    isScanning = false;
    btnStart.disabled = false;
    btnStop.disabled = true;
    showAlert('secondary', 'Mode Kamera dihentikan.');
  }

  btnStart?.addEventListener('click', startScan);
  btnStop?.addEventListener('click', stopScan);

  // ===== Scanner HID (Keyboard) =====
  function enableScannerMode() {
    // stop kamera biar nggak double scan
    if (isScanning) stopScan();

    cameraWrap.classList.add('d-none');
    scannerWrap.classList.remove('d-none');
    manualWrap.classList.add('d-none');

    btnStart.disabled = true;
    btnStop.disabled = true;

    setTimeout(() => scannerInput?.focus(), 150);
    showAlert('info', 'Mode Scanner aktif. Arahkan alat scanner ke QR.');
  }

  function enableCameraMode() {
    scannerWrap.classList.add('d-none');
    manualWrap.classList.add('d-none');
    cameraWrap.classList.remove('d-none');

    btnStart.disabled = !hasActivePrayer;
    btnStop.disabled  = true;
    showAlert('secondary', 'Pilih Start untuk mengaktifkan kamera.');
  }

  function enableManualMode() {
    if (isScanning) stopScan();

    cameraWrap.classList.add('d-none');
    scannerWrap.classList.add('d-none');
    manualWrap.classList.remove('d-none');

    btnStart.disabled = true;
    btnStop.disabled  = true;

    setTimeout(() => manualToken?.focus(), 150);
    showAlert('info', 'Mode Manual aktif. Tempel token lalu Kirim.');
  }

  scannerInput?.addEventListener('keydown', (e) => {
    if (e.key !== 'Enter') return;
    const token = scannerInput.value.trim();
    scannerInput.value = '';
    if (token) sendToken(token);
  });

  // Manual
  btnManual?.addEventListener('click', () => {
    const token = manualToken.value.trim();
    if (!token) return showAlert('warning', 'Token masih kosong.');
    sendToken(token);
  });

  // Toggle mode events
  modeCamera?.addEventListener('change', () => { if (modeCamera.checked) enableCameraMode(); });
  modeScanner?.addEventListener('change', () => { if (modeScanner.checked) enableScannerMode(); });
  modeManual?.addEventListener('change', () => { if (modeManual.checked) enableManualMode(); });

  // Default state
  if (!hasActivePrayer) {
    btnStart.disabled = true;
    btnManual.disabled = true;
    showAlert('warning', 'Tidak ada kegiatan aktif. Scan ditunda.');
  } else {
    enableCameraMode();
  }
});
</script>
@endsection
