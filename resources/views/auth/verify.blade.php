<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-12 col-md-6 wow fadeInRight" data-wow-delay="0.1s">
                <div class="border-start border-end border-bottom border-top border-5 border-primary mb-5 p-5 text-center">
                    <h6 class="text-body text-uppercase mb-2">Verifikasi Alamat Email</h6>
                    <p class="mb-2">
                        Kami telah Mengirimkan Link Verifikasi ke Alamat Email <u>{{ Auth::User()->email }}</u>, Silahkan Cek Sekarang!
                    </p>
                    <p class="mb-0">
                        <br>
                        {{ __('Apakah Kamu tidak Menerima Email dari Kami ?') }}
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button class="btn btn-primary w-50 m-1 py-3" type="submit">
                                {{ __('klik di sini untuk mengirim ulang Link Verifikasi') }}
                            </button>
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
                    <br><br>
                    <p style="font-size: 13px;"><i>*Jika kamu belum menerima email dari kami setelah kamu mengirim ulang link verifikasi, silahkan coba esok hari yaa, <br> Karena kami masih memiliki batas pengiriman email verifikasi</i></p>
                </div>
            </div>
        </div>
    </div>
</div>

