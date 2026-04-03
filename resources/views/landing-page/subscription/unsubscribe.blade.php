@extends('landing-page.template.body')

@section('styles')
<style>
    @media (max-width: 767.98px) {
        .auth-center-section { padding: 4.5rem 0 1.5rem !important; overflow-x: hidden; }
    }
    .unsub-email-box {
        background: rgba(0,0,0,0.06);
        border-radius: 10px;
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
        word-break: break-all;
        margin: 1rem 0 1.5rem;
        border: 1px solid rgba(0,0,0,0.08);
    }
    [data-theme="dark"] .unsub-email-box {
        background: rgba(255,255,255,0.07);
        color: #d1d5db;
        border-color: rgba(255,255,255,0.1);
    }
    .btn-unsub {
        width: 100%;
        padding: 0.85rem 1.5rem;
        border-radius: 14px;
        font-size: 1rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #fff;
        box-shadow: 0 4px 15px rgba(220,38,38,0.35);
        letter-spacing: 0.01em;
    }
    .btn-unsub:hover { background: linear-gradient(135deg, #b91c1c, #991b1b); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(220,38,38,0.45); }
    .btn-unsub:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }
    .success-icon {
        width: 72px; height: 72px;
        background: linear-gradient(135deg,#d1fae5,#a7f3d0);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.25rem;
        font-size: 1.8rem; color: #059669;
        box-shadow: 0 4px 16px rgba(5,150,105,0.25);
    }
</style>
@endsection

@section('content')
<div class="auth-center-section">
    <div class="container" style="position:relative;z-index:1;">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="auth-center-card" id="unsubCard">

                    {{-- Badge --}}
                    <div class="auth-badge" style="margin-bottom:1.5rem;">
                        <span>📧</span>
                        <span>Berhenti Langganan</span>
                        <span class="auth-badge-pulse"></span>
                    </div>

                    {{-- Icon --}}
                    <div class="auth-card-icon" style="background:linear-gradient(135deg,#fee2e2,#fecaca);color:#dc2626;">
                        <i class="fas fa-envelope-open"></i>
                    </div>

                    <h3 class="auth-card-title mb-2">Berhenti Berlangganan</h3>
                    <p class="auth-card-subtitle mb-1">
                        Apakah kamu yakin ingin berhenti menerima<br class="d-none d-sm-inline">informasi dan pembaruan dari kami?
                    </p>

                    @if($email)
                        <div class="unsub-email-box">
                            <i class="fas fa-envelope me-2" style="color:#dc2626;"></i>{{ $email }}
                        </div>
                    @endif

                    <form id="unsubscribeForm" action="{{ route('subscribers.unsubscribe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" class="btn-unsub" id="unsubBtn">
                            <i class="fas fa-times-circle"></i>
                            <span>Ya, Berhenti Berlangganan</span>
                        </button>
                    </form>

                    <div class="auth-divider" style="margin-top:1.25rem;">
                        <span>Berubah pikiran?</span>
                    </div>

                    <p class="auth-bottom">
                        <a href="{{ route('home') }}" class="auth-link">&larr; Kembali ke Beranda</a>
                    </p>

                    <div class="auth-note" style="background:rgba(220,38,38,0.07);border-color:rgba(220,38,38,0.15);">
                        <i class="fas fa-circle-info" style="color:#dc2626;"></i>
                        Setelah berhenti berlangganan, kamu tidak akan menerima email dari kami lebih lanjut. Kamu dapat berlangganan kembali kapan saja melalui website kami.
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('unsubscribeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('unsubBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Memproses...</span>';

    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: new URLSearchParams(new FormData(this)),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('unsubCard').innerHTML = `
                <div class="success-icon"><i class="fas fa-check"></i></div>
                <h3 class="auth-card-title mb-2">Berhasil Berhenti Berlangganan</h3>
                <p class="auth-card-subtitle" style="margin-bottom:1.5rem;">
                    Email kamu telah dihapus dari daftar langganan kami.
                </p>
                <div class="auth-note" style="background:rgba(5,150,105,0.07);border-color:rgba(5,150,105,0.2);color:#059669;">
                    <i class="fas fa-circle-check"></i>
                    Tidak ada email lebih lanjut yang akan dikirim ke alamat ini.
                </div>
                <p class="auth-bottom" style="margin-top:1.25rem;">
                    <a href="{{ route('home') }}" class="auth-link">&larr; Kembali ke Beranda</a>
                </p>
            `;
        } else {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-times-circle"></i><span>Ya, Berhenti Berlangganan</span>';
            const msg = data.errors?.email?.[0] || 'Terjadi kesalahan. Silakan coba lagi.';
            Swal.fire({ icon: 'error', title: 'Gagal', text: msg, confirmButtonColor: '#dc2626' });
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-times-circle"></i><span>Ya, Berhenti Berlangganan</span>';
        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal terhubung ke server. Silakan coba lagi.', confirmButtonColor: '#dc2626' });
    });
});
</script>
@endsection
