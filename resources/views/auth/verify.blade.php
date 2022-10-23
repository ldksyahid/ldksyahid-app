@php
$title = "Verifikasi Email"
@endphp
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-12 col-md-6 wow fadeInRight" data-wow-delay="0.1s">
                <div class="border-start border-end border-bottom border-top border-5 border-primary mb-5 p-5 text-center">
                    <h6 class="text-body mb-2">{{ __('Verifikasi Alamat Email') }}</h6>
                    <p class="mb-2">
                        {{ __('Kami telah Mengirimkan Link Verifikasi ke Alamat Email Kamu, Silahkan Cek Email Kamu Sekarang') }}
                    </p>
                    <p class="mb-0">
                        {{ __('Apakah Kamu tidak Menerima Email dari Kami ?') }}
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button class="btn btn-primary w-50 m-1 py-3" type="submit">
                                {{ __('klik di sini untuk mengirim ulang Link Verifikasi') }}
                            </button>
                            {{-- <button type="submit" class="btn btn-primary p-0 m-0 align-baseline">{{ __('klik di sini untuk mengirim ulang Link Verifikasi') }}</button> --}}
                        </form>
                    </p>
                    @if (session('resent'))
                    <h6 class="mb-2 text-center" style="text-align: justify">
                        {{ __('Link Verifikasi yang Terbaru telah Kami Kirimkan ke Alamat Email Kamu') }}
                    </h6>
                    <h6 class="mb-0 text-center" style="text-align: justify">
                        {{ __('Segera Periksa Email Kamu Sekarang') }}
                    </h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

