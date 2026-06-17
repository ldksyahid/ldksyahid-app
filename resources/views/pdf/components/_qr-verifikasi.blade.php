{{--
    Komponen footer verifikasi QR code untuk surat PDF.
    Variabel yang dibutuhkan: $qrCode (SVG string), $kodeVerifikasi, $verifikasiUrl, $nomorSurat
    Cara pakai: @include('pdf.components._qr-verifikasi')
--}}
<div style="margin-top: 30px; display: table; width: 100%; font-size: 9px; color: #555;">
    <div style="display: table-cell; vertical-align: middle; width: 70px;">
        {!! $qrCode !!}
    </div>
    <div style="display: table-cell; vertical-align: middle; padding-left: 10px;">
        <p style="margin: 0 0 2px 0; font-weight: bold;">Verifikasi Keaslian Dokumen</p>
        <p style="margin: 0;">
            Pindai kode QR di samping atau kunjungi tautan berikut untuk memverifikasi keaslian surat ini:
        </p>
        <p style="margin: 2px 0 0 0; word-break: break-all;">{{ $verifikasiUrl }}</p>
        <p style="margin: 2px 0 0 0;">Kode Verifikasi: <strong>{{ $kodeVerifikasi }}</strong></p>
    </div>
</div>