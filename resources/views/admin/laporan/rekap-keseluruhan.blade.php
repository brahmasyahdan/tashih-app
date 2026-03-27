<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Keseluruhan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 8px; }
        .header { background: #1B6B3A; color: white; padding: 12px; text-align: center; margin-bottom: 10px; }
        .header h1 { font-size: 14px; margin-bottom: 2px; }
        .stats { display: flex; justify-content: space-around; margin-bottom: 10px; font-size: 8px; }
        .stats div { text-align: center; padding: 8px; background: #f3f4f6; border-radius: 5px; }
        .lembaga-section { margin-bottom: 15px; page-break-inside: avoid; }
        .lembaga-title { background: #C9A84C; color: white; padding: 5px; font-size: 9px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; font-size: 7px; margin-bottom: 10px; }
        table th { background: #1B6B3A; color: white; padding: 4px 2px; text-align: center; border: 1px solid #ddd; }
        table td { padding: 3px 2px; border: 1px solid #ddd; text-align: center; }
        .footer { margin-top: 15px; text-align: center; font-size: 7px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REKAP KESELURUHAN NILAI UJIAN TASHIH AL-QUR'AN</h1>
        <p>Semua Lembaga • Tahun {{ date('Y') }}</p>
    </div>

    <div class="stats">
        <div><strong>Total Peserta:</strong> {{ $totalPeserta }}</div>
        <div><strong>Nilai Lengkap:</strong> {{ $totalLengkap }}</div>
        <div><strong>Rata-rata Global:</strong> {{ number_format($rataRataGlobal, 1) }}</div>
    </div>

    <div style="margin-bottom: 10px; font-size: 8px; background: #fef3c7; padding: 8px; border-radius: 5px;">
        <strong>Distribusi Predikat:</strong>
        Mumtaz: {{ $distribusiPredikat['Mumtaz'] }} |
        Jayyid Jiddan: {{ $distribusiPredikat['Jayyid Jiddan'] }} |
        Jayyid: {{ $distribusiPredikat['Jayyid'] }} |
        Maqbul: {{ $distribusiPredikat['Maqbul'] }} |
        Dhaif: {{ $distribusiPredikat['Dhaif'] }}
    </div>

    @foreach($lembagaList as $lembaga)
    @if($lembaga->peserta->isNotEmpty())
    <div class="lembaga-section">
        <div class="lembaga-title">{{ $lembaga->nama_lembaga }} ({{ $lembaga->peserta->count() }} peserta)</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 25%;">Nama</th>
                    @foreach($materi as $m)
                    <th>{{ substr($m->nama_materi, 0, 10) }}</th>
                    @endforeach
                    <th>Akhir</th>
                    <th>Predikat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lembaga->peserta as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="text-align: left;">{{ $p->nama_peserta }}</td>
                    @foreach($materi as $m)
                    <td>
                        @php
                            $items = $m->itemMateri()->where('is_active', true)->get();
                            $nilaiMateri = 0; $jumlahItem = 0;
                            foreach($items as $item) {
                                $nilai = $p->nilai()->where('item_materi_id', $item->id)->first();
                                if($nilai) { $nilaiMateri += ($nilai->nilai / $item->nilai_max) * 100; $jumlahItem++; }
                            }
                            echo $jumlahItem > 0 ? number_format($nilaiMateri / $jumlahItem, 0) : '-';
                        @endphp
                    </td>
                    @endforeach
                    <td><strong>{{ $p->nilai_akhir ? number_format($p->nilai_akhir, 1) : '-' }}</strong></td>
                    <td>{{ $p->predikat ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    @endforeach

    <div class="footer">
        Dicetak pada: {{ date('d F Y, H:i') }} WIB
    </div>
</body>
</html>