<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Rekap PDF</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
    .muted { color:#666; }
    table { width:100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border:1px solid #ddd; padding:6px; vertical-align: top; }
    th { background:#f3f3f3; }
    .right { text-align:right; }
    .badge { padding:2px 6px; border-radius: 10px; font-size: 10px; }
    .hadir { background:#d1fae5; }
    .telat { background:#fef3c7; }
  </style>
</head>
<body>
  <h3 style="margin:0;">Rekap Absensi</h3>
  <div class="muted">
    Tanggal: <b>{{ $date }}</b> |
    Sholat: <b>{{ $selectedPrayer->name }}</b>
    @if($kelas) | Kelas: <b>{{ $kelas }}</b> @endif
    @if($kamar) | Kamar: <b>{{ $kamar }}</b> @endif
  </div>

  <p style="margin:8px 0 0;">
    Total: <b>{{ $totalStudents }}</b> |
    Hadir: <b>{{ $hadirCount }}</b> |
    Terlambat: <b>{{ $terlambatCount }}</b> |
    Belum: <b>{{ $belumCount }}</b>
  </p>

  <table>
    <thead>
      <tr>
        <th style="width:80px;">NIS</th>
        <th>Nama</th>
        <th style="width:70px;">Status</th>
        <th style="width:70px;" class="right">Jam</th>
      </tr>
    </thead>
    <tbody>
      @forelse($attendances as $a)
        <tr>
          <td><b>{{ $a->student->nis }}</b></td>
          <td>
            <b>{{ $a->student->name }}</b><br>
            <span class="muted">{{ $a->student->kelas ?? '-' }} • {{ $a->student->kamar ?? '-' }}</span>
          </td>
          <td>
            @if($a->status === 'hadir')
              <span class="badge hadir">Hadir</span>
            @else
              <span class="badge telat">Telat</span>
            @endif
          </td>
          <td class="right">{{ optional($a->scanned_at)->format('H:i:s') }}</td>
        </tr>
      @empty
        <tr><td colspan="4" class="muted">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
