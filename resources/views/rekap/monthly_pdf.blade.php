<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Rekap Bulanan</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
    .muted { color:#666; }
    table { width:100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border:1px solid #ddd; padding:6px; vertical-align: top; }
    th { background:#f3f3f3; }
    .right { text-align:right; }
  </style>
</head>
<body>
  <h3 style="margin:0;">Rekap Bulanan per Santri</h3>
  <div class="muted">
    Bulan: <b>{{ $month }}</b> • Periode: <b>{{ $start }}</b> s/d <b>{{ $end }}</b>
    @if($kelas) • Kelas: <b>{{ $kelas }}</b> @endif
    @if($kamar) • Kamar: <b>{{ $kamar }}</b> @endif
  </div>

  <p style="margin:8px 0 0;">
    Total Santri: <b>{{ $totalStudents }}</b> •
    Expected (total): <b>{{ $globalExpected }}</b> •
    Scan: <b>{{ $globalScan }}</b> •
    Hadir: <b>{{ $globalHadir }}</b> •
    Telat: <b>{{ $globalTelat }}</b> •
    Belum: <b>{{ $globalBelum }}</b>
  </p>

  <div class="muted" style="margin-top:4px;">
    Expected per santri: <b>{{ $expectedPerStudent }}</b> ({{ $daysInMonth }} hari × {{ $prayerCount }} sholat/hari)
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:85px;">NIS</th>
        <th>Nama</th>
        <th style="width:55px;">Hadir</th>
        <th style="width:55px;">Telat</th>
        <th style="width:60px;">Scan</th>
        <th style="width:60px;">Belum</th>
        <th style="width:55px;" class="right">%</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        @php
          $scan = (int)$r->total_scan;
          $belum = max(0, $expectedPerStudent - $scan);
          $pct = $expectedPerStudent > 0 ? round(($scan / $expectedPerStudent) * 100) : 0;
        @endphp
        <tr>
          <td><b>{{ $r->nis }}</b></td>
          <td>
            <b>{{ $r->name }}</b><br>
            <span class="muted">{{ $r->kelas ?? '-' }} • {{ $r->kamar ?? '-' }}</span>
          </td>
          <td>{{ (int)$r->hadir }}</td>
          <td>{{ (int)$r->terlambat }}</td>
          <td><b>{{ $scan }}</b></td>
          <td>{{ $belum }}</td>
          <td class="right"><b>{{ $pct }}%</b></td>
        </tr>
      @empty
        <tr><td colspan="7" class="muted">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
