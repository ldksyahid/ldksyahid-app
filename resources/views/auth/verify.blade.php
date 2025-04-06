<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center g-5">
            <div class="col-lg-10 wow fadeInUp" data-wow-delay="0.1s">
               <div class="bg-light border border-3 border-primary custom-rounded shadow p-5 text-center position-relative">

                    <!-- Icon Email -->
                    <div class="mb-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="fas fa-envelope fa-2x"></i>
                        </div>
                    </div>

                    <!-- Title -->
                    <h4 class="fw-bold text-uppercase text-primary mb-3">Verifikasi Alamat Email</h4>

                    <!-- Message -->
                    <p class="text-muted mb-2 fs-6">
                        Kami telah mengirimkan link verifikasi ke alamat email:
                        <u class="fw-semibold text-lowercase text-dark">{{ Auth::user()->email }}</u>
                    </p>
                    <p class="text-muted">
                        Silakan cek email kamu dan klik link verifikasi untuk mengaktifkan akunmu.
                    </p>

                    <!-- Resend Form -->
                    <div class="mt-4">
                        <p class="mb-2">{{ __('Belum menerima email dari kami?') }}</p>
                        <form class="d-inline-block" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button class="btn btn-outline-primary px-4 py-2 rounded-pill" type="submit">
                                {{ __('Klik di sini untuk kirim ulang') }}
                            </button>
                        </form>
                    </div>

                    <!-- Success Message -->
                    @if (session('resent'))
                    <div class="alert alert-success mt-4 mb-0 rounded-3" role="alert">
                        {{ __('Link verifikasi terbaru telah dikirim ke email kamu. Segera periksa emailmu ya!') }}
                    </div>
                    @endif

                    <!-- Note -->
                    <div class="text-muted mt-5 small">
                        <i class="fas fa-info-circle me-1"></i>
                        <em>
                            Jika kamu belum menerima email setelah mengirim ulang atau mengalami error,
                            silakan coba lagi besok karena ada batas pengiriman email dari server.
                        </em>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-rounded {
        border-radius: 20px; /* Atur sesuai selera: 8px, 12px, 16px, 20px, dll */
    }
</style>

