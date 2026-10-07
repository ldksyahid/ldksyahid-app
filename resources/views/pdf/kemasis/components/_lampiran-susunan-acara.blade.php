<div class="content page-break lampiran-page">
    <div class="lampiran-tag">Lampiran 1</div>
    <div class="lampiran-title">SUSUNAN ACARA</div>
    <div class="lampiran-subtitle">
        [{{ strtoupper($data['nama_acara'] ?? $data['nama_kegiatan'] ?? 'NAMA KEGIATAN') }}]<br>
        <span style="font-weight: normal; font-size: 10pt;">
            {{ $data['tempat_dipinjam'] ?? $data['tempat'] ?? '-' }}, {{ $hariTanggal }}
        </span>
    </div>

    @php
        $rundown = $data['susunan_acara'] ?? [];
        if (is_string($rundown)) {
            $rundown = collect(preg_split('/\r\n|\r|\n/', $rundown))
                ->map(function ($line) {
                    $parts = array_map('trim', explode('|', $line));
                    return ['waktu' => $parts[0] ?? '', 'kegiatan' => $parts[1] ?? '', 'pengisi' => $parts[2] ?? ''];
                })
                ->filter(fn ($item) => $item['waktu'] !== '' || $item['kegiatan'] !== '' || $item['pengisi'] !== '')
                ->values()->all();
        }
    @endphp
    <table class="rundown-table">
        <thead>
            <tr>
                <th class="col-time">Waktu</th>
                <th class="col-act">Kegiatan</th>
                <th class="col-person">Pengisi</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($rundown) && is_array($rundown))
                @foreach($rundown as $item)
                    @if(!empty($item['is_header']))
                        <tr class="rundown-section-row">
                            <td colspan="3">{{ $item['kegiatan'] ?? '' }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="col-time">{{ $item['waktu'] ?? '-' }}</td>
                            <td class="col-act">{{ $item['kegiatan'] ?? '-' }}</td>
                            <td class="col-person">{{ $item['pengisi'] ?? '-' }}</td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr><td colspan="3" style="text-align:center;">Susunan acara belum tersedia.</td></tr>
            @endif
        </tbody>
    </table>
</div>
