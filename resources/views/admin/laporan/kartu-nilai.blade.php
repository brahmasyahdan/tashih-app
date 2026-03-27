<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Nilai - {{ $peserta->nama_peserta }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1a1a1a; }
        .header { background: linear-gradient(135deg, #1B6B3A 0%, #25734d 100%); color: white; padding: 20px; text-align: center; position: relative; overflow: hidden; }
        .header::before { content: ''; position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%; }
        .header h1 { font-size: 22px; margin-bottom: 5px; font-weight: bold; }
        .header p { font-size: 12px; opacity: 0.9; }
        .info-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; margin: 20px 0; }
        .info-row { display: flex; margin-bottom: 8px; }
        .info-label { width: 150px; font-weight: 600; color: #4b5563; }
        .info-value { flex: 1; color: #1a1a1a; }
        .materi-section { margin: 15px 0; page-break-inside: avoid; }
        .materi-header { background: #1B6B3A; color: white; padding: 8px 12px; font-weight: bold; font-size: 12px; border-radius: 5px 5px 0 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table th { background: #f3f4f6; padding: 8px; text-align: left; font-size: 10px; border: 1px solid #d1d5db; }
        table td { padding: 8px; border: 1px solid #e5e7eb; font-size: 10px; }
        .nilai-cell { text-align: center; font-weight: 600; color: #1B6B3A; }
        .summary { background: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px; padding: 15px; margin: 20px 0; text-align: center; }
        .summary .nilai-akhir { font-size: 36px; font-weight: bold; color: #1B6B3A; margin: 10px 0; }
        .summary .predikat { display: inline-block; background: #10b981; color: white; padding: 8px 20px; border-radius: 20px; font-size: 14px; font-weight: bold; margin-top: 10px; }
        .signature { margin-top: 40px; display: flex; justify-content: space-around; }
        .signature div { text-align: center; width: 30%; }
        .signature .line { border-top: 1px solid #000; margin-top: 60px; padding-top: 5px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 15px; border-top: 2px solid #C9A84C; color: #6b7280; font-size: 9px; }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <h1>🌙 KARTU NILAI UJIAN TASHIH AL-QUR'AN</h1>
        <p>Penilaian Baca Tulis Al-Qur'an • Tahun {{ $peserta->tahun_ujian }}</p>
    </div>

    {{-- Info Peserta --}}
    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Nama Peserta</div>
            <div class="info-value">: <strong>{{ $peserta->nama_peserta }}</strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">NIS</div>
            <div class="info-value">: {{ $peserta->nis ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Asal Lembaga</div>
            <div class="info-value">: {{ $peserta->lembaga->nama_lembaga ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tahun Ujian</div>
            <div class="info-value">: {{ $peserta->tahun_ujian }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Nomor Sertifikat</div>
            <div class="info-value">: <strong style="color: #C9A84C;">{{ $peserta->sertifikat->nomor_sertifikat ?? 'Belum Terbit' }}</strong></div>
        </div>
    </div>

    {{-- Detail Nilai per Materi --}}
    @foreach($materi as $m)
    <div class="materi-section">
        <div class="materi-header">{{ $m->urutan }}. {{ $m->nama_materi }} (Bobot: {{ $m->bobot }}%)</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Item Penilaian</th>
                    <th style="width: 20%; text-align: center;">Nilai Maks</th>
                    <th style="width: 20%; text-align: center;">Nilai Diperoleh</th>
                    <th style="width: 10%; text-align: center;">%</th>
                </tr>
            </thead>
            <tbody>
                @foreach($m->itemMateri as $item)
                @php $n = $nilaiData[$m->id][$item->id] ?? null; @endphp
                <tr>
                    <td>{{ $item->nama_item }}</td>
                    <td class="nilai-cell">{{ $item->nilai_max }}</td>
                    <td class="nilai-cell">{{ $n ? $n->nilai : '-' }}</td>
                    <td class="nilai-cell">
                        {{ $n ? number_format(($n->nilai / $item->nilai_max) * 100, 1) : '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach

    {{-- Ringkasan Nilai Akhir --}}
    <div class="summary">
        <p style="font-size: 12px; color: #4b5563; margin-bottom: 5px;">NILAI AKHIR</p>
        <div class="nilai-akhir">{{ $peserta->nilai_akhir ? number_format($peserta->nilai_akhir, 1) : '-' }}</div>
        @if($peserta->predikat)
        <div class="predikat">{{ $peserta->predikat }}</div>
        <p style="font-size: 10px; color: #6b7280; margin-top: 8px;">
            {{ \App\Helpers\TashihHelper::getKeterangan($peserta->predikat) }}
        </p>
        @endif
    </div>

    {{-- Tanda Tangan --}}
    <div class="signature">
        <div>
            <p>Penguji</p>
            <div class="line">(...........................)</div>
        </div>
        <div>
            <p>Ketua Lembaga</p>
            <div class="line">(...........................)</div>
        </div>
        <div>
            <p>Stempel</p>
            <div class="line" style="border: none;"></div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        Dicetak pada: {{ date('d F Y, H:i') }} WIB<br>
        Aplikasi Penilaian Tashih Al-Qur'an
    </div>
</body>
</html>