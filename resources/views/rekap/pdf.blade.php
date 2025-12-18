<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $meta['title'] ?? 'Rekap Posyandu' }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 18px;
        }
        h1 {
            text-align: center;
            font-size: 16px;
            margin: 0 0 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 4px 24px;
            margin-bottom: 12px;
        }
        .meta-grid .label {
            font-weight: bold;
            width: 90px;
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td { border: 1px solid #1f2937; padding: 4px 6px; vertical-align: top; }
        th { background: #f3f4f6; font-size: 11px; text-transform: uppercase; letter-spacing: 0.3px; }
        .col-no { width: 30px; text-align: center; }
        .col-uraian { width: 70%; }
        .col-total { width: 90px; text-align: center; }
        .small-note { font-size: 10px; color: #6b7280; margin-top: 6px; }
    </style>
</head>
<body>
    <h1>{{ $meta['title'] ?? 'FORMAT 5 REKAP HASIL KEGIATAN POSYANDU' }}</h1>

    <div class="meta-grid">
        <div><span class="label">Posyandu</span>: {{ $meta['posyandu'] ?? '-' }}</div>
        <div><span class="label">Kecamatan</span>: {{ $meta['kecamatan'] ?? '-' }}</div>
        <div><span class="label">Kelurahan</span>: {{ $meta['kelurahan'] ?? '-' }}</div>
        <div><span class="label">Kota</span>: {{ $meta['kota'] ?? '-' }}</div>
        <div><span class="label">Puskesmas</span>: {{ $meta['puskesmas'] ?? '-' }}</div>
        <div><span class="label">Bulan/Tahun</span>: {{ ($meta['bulan'] ?? '') ? ($meta['bulan'] . ' / ' . $meta['year']) : $meta['year'] }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-uraian">Uraian</th>
                <th class="col-total">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap_list as $row)
                @php
                    $hasGender = !empty($row['has_gender']);
                    $male    = $hasGender ? ($row['male'] ?? 0) : null;
                    $female  = $hasGender ? ($row['female'] ?? 0) : null;
                    $jumlah  = $hasGender ? ($male + $female) : ($row['value'] ?? 0);
                @endphp
                <tr>
                    <td class="col-no">{{ $row['no'] }}</td>
                    <td class="col-uraian">{{ $row['label'] }}</td>
                    <td class="col-total">{{ number_format($jumlah) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="small-note">
        Dicetak otomatis dari aplikasi Posyandu Pintar. Nilai mengikuti data indikator pada tahun {{ $meta['year'] ?? '' }}.
    </p>
</body>
</html>
