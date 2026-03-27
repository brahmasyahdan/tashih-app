<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Nilai - {{ $lembaga->nama_lembaga }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; }
        .header { background: #1B6B3A; color: white; padding: 15px; text-align: center; margin-bottom: 15px; }
        .header h1 { font-size: 16px; margin-bottom: 3px; }
        .header p { font-size: 10px; }
        .info { margin-bottom: 10px; }
        .info p { margin-bottom: 3px; font-size: 9px; }
        table { width: 100%; border-collapse: collapse; font-size: 8px; }
        table th { background: #1B6B3A; color: white; padding: 6px 4px; text-align: center; border: 1px solid #ddd; }
        table td { padding: 5px 4px; border: 1px solid #ddd; text-align: center; }
        .rata { background: #fef3c7; font-weight: bold; }
        .footer { margin-top: 20px; text-align: center; font-size: 8px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REKAP NILAI UJIAN TASHIH AL-QUR'AN</h1>
        <p>{{ $lembaga->nama_lembaga }}</p>
    </div>

    <div class="info">
        <p><strong>Lembaga:</strong> {{ $lembaga->nama_lembaga }}</p>
        <p><strong>Alamat:</strong> {{ $lembaga->alamat ?? '-' }}</p>
        <p><strong>Total Peserta:</strong> {{ $peserta->count() }}</p>
        <p><strong>Rata-rata Nilai Lembaga:</strong> {{ number_format($rataRata, 1) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 20%;">Nama Peserta</th>
                <th style="width: 10%;">NIS</th>
                @foreach($materi as $m)
                <th style="width: 7%;">{{ $m->nama_materi }}</th>
                @endforeach
                <th style="width: 8%;">Nilai Akhir</th>
                <th style="width: 10%;">Predikat</th>
                <th style="width: 15%;">No. Sertifikat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peserta as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="text-align: left;">{{ $p->nama_peserta }}</td>
                <td>{{ $p->nis ?? '-' }}</td>
                @foreach($materi as $m)
                <td>
                    @php
                        $items = $m->itemMateri()->where('is_active', true)->get();
                        $nilaiMateri = 0;
                        $jumlahItem = 0;
                        foreach($items as $item) {
                            $nilai = $p->nilai()->where('item_materi_id', $item->id)->first();
                            if($nilai) {
                                $nilaiMateri += ($nilai->nilai / $item->nilai_max) * 100;
                                $jumlahItem++;
                            }
                        }
                        echo $jumlahItem > 0 ? number_format($nilaiMateri / $jumlahItem, 1) : '-';
                    @endphp
                </td>
                @endforeach
                <td><strong>{{ $p->nilai_akhir ? number_format($p->nilai_akhir, 1) : '-' }}</strong></td>
                <td>{{ $p->predikat ?? '-' }}</td>
                <td style="font-size: 7px;">{{ $p->sertifikat->nomor_sertifikat ?? '-' }}</td>
            </tr>
            @endforeach
            <tr class="rata">
                <td colspan="{{ 3 + $materi->count() }}">RATA-RATA LEMBAGA</td>
                <td>{{ number_format($rataRata, 1) }}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d F Y, H:i') }} WIB
    </div>
</body>
</html>