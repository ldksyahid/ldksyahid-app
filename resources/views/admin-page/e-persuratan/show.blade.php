@extends('admin-page.template.body')

@section('content')
<style>
    /* Styling Kertas HVS A4 dengan Background Kop Surat */
    .a4-paper {
        background-color: white;
        /* Memanggil gambar kop surat yang full A4 */
        background-image: url("{{ asset('assets/img/kop-surat.png') }}");
        background-size: 21cm 29.7cm; /* Menyesuaikan ukuran asli A4 */
        background-position: center top;
        background-repeat: no-repeat;
        
        width: 21cm;
        min-height: 29.7cm;
        margin: 20px auto;
        /* Atur padding: Atas(4.5cm biar ga nabrak header), Kanan(2.5cm), Bawah(3cm biar ga nabrak footer), Kiri(2.5cm) */
        padding: 4.5cm 2.5cm 3cm 2.5cm; 
        
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        font-family: 'Times New Roman', Times, serif !important; /* Sesuai SOP Kestari */
        font-size: 12pt;
        line-height: 1.15; /* Sesuai SOP Kestari */
        color: #000;
        position: relative;
    }
    
    .content-surat { text-align: justify; }
    .ttd-box { width: 300px; float: right; text-align: left; margin-top: 30px; }

    /* Pengaturan khusus saat tombol Cetak/PDF diklik */
    @media print {
        body * {
            visibility: hidden;
        }
        .a4-paper, .a4-paper * {
            visibility: visible;
        }
        .a4-paper {
            position: absolute;
            left: 0;
            top: 0;
            margin: 0;
            box-shadow: none;
            /* Memaksa browser menge-print background kop suratnya */
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>

<div class="container-fluid pt-4 px-4">
    <div class="d-flex align-items-center justify-content-between mb-4 d-print-none">
        <div>
            <a href="{{ route('admin.e-persuratan.index') }}" class="btn btn-light rounded-pill px-3 me-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h4 class="mb-0 d-inline-block">Preview Surat</h4>
        </div>
        
        <div>
            @if($letter->status == 'approved')
                <button class="btn btn-primary rounded-pill px-4" onclick="window.print()">
                    <i class="fas fa-print me-2"></i> Cetak / PDF
                </button>
            @endif

            @role('Superadmin')
                @if($letter->status == 'pending')
                <form action="{{ route('admin.e-persuratan.approve', $letter->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm" onclick="return confirm('ACC surat ini sekarang?')">
                        <i class="fas fa-check-circle me-2"></i> Approve & Generate E-Sign
                    </button>
                </form>
                @endif
            @endrole
        </div>
    </div>

    <div class="a4-paper">
        
        <div class="text-end mb-4">
            Jakarta, {{ \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d F Y') }}
        </div>

        <table class="mb-4">
            <tr>
                <td width="80">Nomor</td>
                <td width="10">:</td>
                <td>{{ $letter->letter_number ?? '......./LDK-SYAHID/..../2026' }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td><strong>{{ $letter->subject }}</strong></td>
            </tr>
        </table>

        <div class="mb-4">
            Kepada Yth.<br>
            <strong>{{ $letter->destination }}</strong><br>
            di<br>
            &nbsp;&nbsp;&nbsp;&nbsp;Tempat
        </div>

        <div class="mb-3">
            <em>Assalamu’alaikum Warahmatullahi Wabarakatuh,</em>
        </div>

        <div class="content-surat mb-4">
            {!! nl2br(e($letter->content)) !!}
        </div>

        <div class="mb-4">
            <em>Wassalamu’alaikum Warahmatullahi Wabarakatuh.</em>
        </div>

        <div class="ttd-box">
            @if($letter->status == 'approved')
                <p class="mb-1">Ketua Umum LDK Syahid,</p>
                <div class="my-2 p-2 border border-2 border-success rounded text-center d-inline-block" style="background-color: white; width: 120px;">
                    <i class="fas fa-qrcode fa-3x text-success mb-1"></i><br>
                    <small class="text-success fw-bold" style="font-size: 8pt;">Telah di-ACC<br>Oleh: BPH</small>
                </div>
                <p class="mb-0 fw-bold text-decoration-underline">Muhammad Syauqi Mubarak</p>
                <p class="mb-0">NIM. 11230600000067</p>
            @else
                <p class="mb-5">Ketua Umum LDK Syahid,</p>
                <br>
                <p class="mb-0 fw-bold text-decoration-underline text-muted">(Belum ada tanda tangan)</p>
                <p class="mb-0 text-muted">NIM. .................................</p>
            @endif
        </div>

        <div class="clearfix"></div>
    </div>
</div>
@endsection