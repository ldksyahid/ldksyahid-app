<!-- Footer Start -->
<div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h2 class="text-white mb-4">
                    <img src='https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1' width="55" height="55" alt="Logo LDK Syahid"> LDK Syahid
                </h2>
                <p style="text-align: justify">
                    Lembaga Dakwah Kampus UIN Syarif Hidayatullah (LDK Syahid) merupakan Unit Kegiatan Mahasiswa (UKM) yang berada di bawah naungan UIN Syarif Hidayatullah Jakarta.
                </p>
                <div class="d-flex pt-2">
                    <a class="btn btn-icon me-2" href="https://www.facebook.com/ldksyahid/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-icon me-2" href="https://twitter.com/ldksyahid/" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-icon me-2" href="https://www.youtube.com/channel/UCJ-SyxQN5sG4CzO0waSYpBQ?app=desktop/" target="_blank"><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-icon" href="https://www.instagram.com/ldksyahid/" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Alamat</h4>
                <p style="text-align: justify">
                    <i class="fas fa-map-marker-alt me-3"></i>Lt. 3 Gedung SC UIN Jakarta
                </p>
                <p><i class="fas fa-phone-alt me-3"></i>+62 851-5936-0504</p>
                <p><i class="fa fa-envelope me-3"></i>ldk@apps.uinjkt.ac.id</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Akses Cepat</h4>
                <a class="btn btn-link" href="/about/contact">Hubungi Kami</a>
                <a class="btn btn-link" href="/articles">Artikel</a>
                <a class="btn btn-link" href="/news">Berita</a>
                <a class="btn btn-link" href="/events">Kegiatan</a>
                <a class="btn btn-link" href="/schedule">Jadwal</a>
                <a class="btn btn-link" href="/kalkulatorkestari">Kalkulator Kestari</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Berlangganan</h4>
                <p style="text-align: justify">Dapatkan Informasi terkini yang akan dikirimkan melewati Email kamu Seputar LDK Syahid UIN Syarif Hidayatullah Jakarta dengan cara berlangganan bersama Kami</p>
                <form action="{{ route('subscribers.store') }}" method="post">
                    @csrf
                    <div class="position-relative mx-auto" style="max-width: 400px">
                        <input class="form-control subscribe-input" type="email" name="email" placeholder="Email kamu" required />
                        <button type="submit" class="btn subscribe-btn">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a href="#">UKM LDK Syahid UIN Syarif Hidayatullah Jakarta - #KitaAdalahSaudara</a>
                    <p>All Right Reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a href="https://htmlcodex.com" target="_blank">HTML Codex</a>
                    <br/>
                    Distributed By <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                    <br>
                    Developed By <a href="/itsupport" target="_blank">IT Support UKM LDK Syahid</a>
                    <br>
                    Managed By <a href="/">UKM LDK Syahid</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->
<style>
.subscribe-input {
    border-radius: 30px;
    padding: 12px 20px;
    padding-right: 110px;
    background-color: rgba(255, 255, 255, 0.07);
    color: #fff;
    border: 1px solid #555;
    width: 100%;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.subscribe-input:focus {
    outline: none;
    border-color: var(--bs-primary);
    background-color: rgba(255, 255, 255, 0.1);
}

.subscribe-input::placeholder {
    color: #ccc;
    font-style: italic;
}

.subscribe-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    height: calc(100% - 10px);
    padding: 0 20px;
    border-radius: 30px;
    background-color: var(--bs-primary);
    color: #fff;
    font-weight: normal; /* <- ini agar tidak bold */
    border: none;
    transition: all 0.3s ease;
}

.subscribe-btn:hover {
    transform: scale(1.05); /* <- hanya membesar */
    color: #fff;
    background-color: var(--bs-primary);
    /* Tidak ubah background-color dan color */
}


.btn-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background-color: transparent;
    border: 2px solid var(--bs-primary);
    color: var(--bs-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-size: 18px;
}

.btn-icon:hover {
    background-color: var(--bs-primary);
    color: #fff;
    transform: scale(1.1);
}

.btn-icon:hover {
    background-color: var(--bs-primary);
    color: #fff;
    transform: scale(1.1);
    box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
}


</style>

