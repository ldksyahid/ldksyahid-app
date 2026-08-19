{{--
    Komponen footer verifikasi QR code untuk surat PDF.
    Update: Menyesuaikan 3 badge status (Hijau, Kuning, Merah) sesuai kondisi validitas surat.
--}}
<div style="margin-top: 30px; display: table; width: 100%; font-size: 9px; color: #555; border-top: 1px solid #eee; padding-top: 10px;">
    <div style="display: table-cell; vertical-align: middle; width: 70px;">
        @if($suratLog->status === 'approved')
            {!! $qrCode !!}
        @else
            <div style="width: 70px; height: 70px; background: #f8f9fa; border: 1px dashed #ccc; text-align: center; line-height: 70px; color: #999;">
                N/A
            </div>
        @endif
    </div>
    
    <div style="display: table-cell; vertical-align: middle; padding-left: 10px;">
        <div style="margin-bottom: 5px;">
            <span style="padding: 2px 6px; border-radius: 3px; font-weight: bold; color: #fff; 
                background-color: {{ 
                    match($suratLog->status) {
                        'approved' => '#28a745', // Hijau
                        'pending'  => '#ffc107', // Kuning
                        'rejected' => '#dc3545', // Merah
                        default    => '#dc3545'  // Merah (Safety fallback)
                    }
                }};">
                {{ match($suratLog->status) {
                    'approved' => 'SUDAH TERVERIFIKASI',
                    'pending'  => 'PENINJAUAN ULANG / KADALUARSA',
                    'rejected' => 'BUKAN SURAT LDK / DITOLAK',
                    default    => 'TIDAK VALID'
                } }}
            </span>
        </div>

        @if($suratLog->status === 'approved')
            {{-- Status: HIJAU --}}
            <p style="margin: 0 0 2px 0; font-weight: bold;">Verifikasi Keaslian Dokumen</p>
            <p style="margin: 0;">Pindai kode QR atau kunjungi tautan berikut untuk memverifikasi keaslian surat:</p>
            <p style="margin: 2px 0 0 0; word-break: break-all;">{{ $verifikasiUrl }}</p>
            <p style="margin: 2px 0 0 0;">Kode Verifikasi: <strong>{{ $kodeVerifikasi }}</strong></p>

        @elseif($suratLog->status === 'pending')
            {{-- Status: KUNING --}}
            <p style="margin: 0;">Dokumen ini <strong>sedang dalam peninjauan ulang</strong>, bermasalah, atau masa berlakunya telah kadaluarsa.</p>
            @if($suratLog->catatan_admin)
                <p style="margin: 2px 0 0 0; color: #d08002;">Catatan: {{ $suratLog->catatan_admin }}</p>
            @endif

        @else
            {{-- Status: MERAH --}}
            <p style="margin: 0; color: #dc3545; font-weight: bold;">Peringatan: Dokumen Tidak Valid</p>
            <p style="margin: 0;">Dokumen ini <strong>BUKAN</strong> surat resmi dari LDK Syahid atau pengajuannya telah <strong>ditolak</strong>.</p>
            @if($suratLog->catatan_admin)
                <p style="margin: 2px 0 0 0; color: #dc3545;">Alasan Penolakan: {{ $suratLog->catatan_admin }}</p>
            @endif

        @endif
    </div>
</div>