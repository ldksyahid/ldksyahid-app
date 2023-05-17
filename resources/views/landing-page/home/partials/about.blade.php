<!-- About Start -->
@if((new \Jenssegers\Agent\Agent())->isDesktop())
<div class="container-xxl">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-12">
                <div class="h-100">
                    <div class="border-end border-5 border-start border-primary mb-5 text-center wow fadeInUp" data-wow-delay="0.5s">
                        <h6 class="text-body text-uppercase mb-2">Tentang Kami</h6>
                        <h1 class="display-6 mb-0">UKM LDK Syahid UIN Syarif Hidayatullah Jakarta</h1>
                    </div>
                    <div class="h-100 wow fadeIn" data-wow-delay="0.5s">
                        <div class="text-center mb-3">
                            <h5>Sejarah</h5>
                        </div>
                        <div style="text-align: justify">
                            <p>Lembaga Dakwah Kampus Syahid (LDK Syahid) UIN Syarif Hidayatullah Jakarta adalah sebuah organisasi dalam lingkup Unit Kegiatan Mahasiswa (UKM) di lingkungan UIN Syarif Hidayatullah Jakarta yang didirikan pada hari Selasa 10 Muharram 1417 H atau bertepatan dengan tanggal 28 Mei 1996 M.</p>
                            <p>Tepat tanggal 28 Mei 1996, dua puluh mahasiswa IAIN Jakarta dari lima fakultas dilantik sebagai pengurus LDK Syahid periode pertama 1996-1997. Pelantikan tersebut langsung dipimpin oleh Senat Mahasiswa Institut (SMI), Thobib El-Hasyr, sekaligus menandai kelahiran LDK Syahid di lingkungan IAIN Syarif Hidayatullah Jakarta yang sekarang telah menjadi UIN Syarif Hidayatullah Jakarta. Ketua SMI saat itu, Muhammad Ali, adalah salah seorang yang memberikan jalan bagi berdirinya LDK Syahid di kampus peradaban ini dalam forum Majelis Perwakilan Mahasiswa Institut (MPMI) saat itu.</p>
                            <p>Usaha beliau dalam mengukuhkan LDK dimulai dengan mengajak mahasiswa IAIN seperti Misbah (Ushuludin) yang saat itu aktif di lembaga ekstra kampus Fikratussalam yang bergerak di bidang dakwah. Selanjutnya dibentuk tim kecil yang bertugas mempersiapkan berdirinya LDK Syahid, baik persiapan konstitusi maupun persiapan teknis. Tim yang terdiri dari Deka Kurniawan (Ushuludin-Aqidah Filsafat ’93), Muhammad Mustofa (Syariah-MU ’94), dan Rinaldi Syafiq (Tarbiyah-Bahasa Arab ’94) itu dihasilkan dalam musyawarah yang dihadiri oleh sejumlah perwakilan fakultas. Deka Kurniawan (Ushuludin-Aqidah Filsafat ’93) merupakan Ketua LDK Syahid yang pertama.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 text-center mb-5 mt-3">
                <div class="" style="min-height: 527px">
                    <img class="w-70 h-70 wow fadeInUp" data-wow-delay="0.5s" src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt=""/>
                    <p style="text-align: center" class="mt-5 wow fadeInDown" data-wow-delay="0.1s">
                        <i>LDK Syahid adalah Salah satu Unit Kegiatan Mahasiswa (UKM) bidang keislaman di UIN Jakarta. Kegiatan-kegiatan yang dilakukan oleh LDK Syahid ialah Mentoring Pekanan, Kajian Keislaman, Rihlah, Upgrading Softskill, Menguatkan Ukhuwah Islamiyah, Management SDM, Management Problem Solved, Pembentukan Karakter Kepemimpinan, dan masih banyak lagi. Outputnya adalah Anggota LDK Syahid menjadi generasi emas menyongsong kehidupan masyarakat madani.</i>
                    </p>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp mt-0" data-wow-delay="0.5s">
                <h5>Visi</h5>
                <p style="text-align: justify">
                    “Terciptanya insan-insan dakwah yang memiliki kekokohan spiritualitas, intelektualitas, dan solidaritas dengan etos profesionalisme menuju kampus yang islami dalam rangka mewujudkan khairu ummah.”
                </p>
            </div>
            <div class="col-lg-6 wow fadeInUp mt-0" data-wow-delay="0.5s">
                <h5>Misi</h5>
                <ol style="text-align: justify">
                    <li>Tarbiyah Madal Hayah (Pendidikan Sepanjang Hidup)</li>
                    <li>Amal Sholeh (Perbuatan yang Baik)</li>
                    <li>Amar Ma’ruf Nahi Mungkar (Memerintahkan yang Baik dan Mencegah yang Mungkar)</li>
                    <li>Khidmatul Ummah (Pengabdian Masyarakat)</li>
                    <li>Wihdatul Ummah dan Ukhuwah Islamiyah (Persatuan Umat dan Ukhuwah Islamiyah)</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endif

@if((new \Jenssegers\Agent\Agent())->isMobile())
<div class="container-xxl">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-12">
                <div class="h-100 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="border-5 border-start border-primary mb-3 px-4">
                        <h6 class="text-body text-uppercase mb-2 mobile-font-2">&mdash; Tentang Kami</h6>
                        <h1 class="display-6 mb-0 mobile-font-4">UKM LDK Syahid <br> UIN Syarif Hidayatullah Jakarta</h1>
                    </div>
                    <div>
                        <ul class="nav nav-pills mb-3 justify-content-start" id="pills-tab" role="tablist" style="font-size: 14px; border-radius: 20px;">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active mobile-font-2" id="pills-perkenalan-tab" data-bs-toggle="pill" data-bs-target="#pills-perkenalan" type="button" role="tab" aria-controls="pills-perkenalan" aria-selected="true" style="border-radius :5px;">Perkenalan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link mobile-font-2" id="pills-visi-tab" data-bs-toggle="pill" data-bs-target="#pills-visi" type="button" role="tab" aria-controls="pills-visi" aria-selected="false" style="border-radius :5px;">Visi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link mobile-font-2" id="pills-misi-tab" data-bs-toggle="pill" data-bs-target="#pills-misi" type="button" role="tab" aria-controls="pills-misi" aria-selected="false" style="border-radius :5px;">Misi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link mobile-font-2" id="pills-sejarah-tab" data-bs-toggle="pill" data-bs-target="#pills-sejarah" type="button" role="tab" aria-controls="pills-sejarah" aria-selected="false" style="border-radius :5px;">Sejarah</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-perkenalan" role="tabpanel" aria-labelledby="pills-perkenalan-tab">
                                <div class="col-lg-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-center">
                                                <img class="my-3" src="{{ asset('Images/Logos/logoldksyahid.png') }}" width="175" height="180">
                                            </div>
                                            <div>
                                                <p class="mobile-body-font" style="text-align: justify">
                                                    LDK Syahid adalah Salah satu Unit Kegiatan Mahasiswa (UKM) bidang keislaman di UIN Jakarta. Kegiatan-kegiatan yang dilakukan oleh LDK Syahid ialah Mentoring Pekanan, Kajian Keislaman, Rihlah, Upgrading Softskill, Menguatkan Ukhuwah Islamiyah, Management SDM, Management Problem Solved, Pembentukan Karakter Kepemimpinan, dan masih banyak lagi. Outputnya adalah Anggota LDK Syahid menjadi generasi emas menyongsong kehidupan masyarakat madani.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-visi" role="tabpanel" aria-labelledby="pills-visi-tab">
                                <div class="col-lg-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <p style="text-align: justify" class="mobile-body-font">
                                                “Terciptanya insan-insan dakwah yang memiliki kekokohan spiritualitas, intelektualitas, dan solidaritas dengan etos profesionalisme menuju kampus yang islami dalam rangka mewujudkan khairu ummah.”
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-misi" role="tabpanel" aria-labelledby="pills-misi-tab"><div class="col-lg-4">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <ol class="mobile-body-font">
                                            <li>Tarbiyah Madal Hayah (Pendidikan Sepanjang Hidup)</li>
                                            <li>Amal Sholeh (Perbuatan yang Baik)</li>
                                            <li>Amar Ma’ruf Nahi Mungkar (Memerintahkan yang Baik dan Mencegah yang Mungkar)</li>
                                            <li>Khidmatul Ummah (Pengabdian Masyarakat)</li>
                                            <li>Wihdatul Ummah dan Ukhuwah Islamiyah (Persatuan Umat dan Ukhuwah Islamiyah)</li>
                                        </ol>
                                    </div>
                                </div>
                            </div></div>
                            <div class="tab-pane fade" id="pills-sejarah" role="tabpanel" aria-labelledby="pills-sejarah-tab">
                                <div class="col-lg-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div style="text-align: justify" class="mobile-body-font">
                                                <p>Lembaga Dakwah Kampus Syahid (LDK Syahid) UIN Syarif Hidayatullah Jakarta adalah sebuah organisasi dalam lingkup Unit Kegiatan Mahasiswa (UKM) di lingkungan UIN Syarif Hidayatullah Jakarta yang didirikan pada hari Selasa 10 Muharram 1417 H atau bertepatan dengan tanggal 28 Mei 1996 M.</p>
                                                <p>Tepat tanggal 28 Mei 1996, dua puluh mahasiswa IAIN Jakarta dari lima fakultas dilantik sebagai pengurus LDK Syahid periode pertama 1996-1997. Pelantikan tersebut langsung dipimpin oleh Senat Mahasiswa Institut (SMI), Thobib El-Hasyr, sekaligus menandai kelahiran LDK Syahid di lingkungan IAIN Syarif Hidayatullah Jakarta yang sekarang telah menjadi UIN Syarif Hidayatullah Jakarta. Ketua SMI saat itu, Muhammad Ali, adalah salah seorang yang memberikan jalan bagi berdirinya LDK Syahid di kampus peradaban ini dalam forum Majelis Perwakilan Mahasiswa Institut (MPMI) saat itu.</p>
                                                <p>Usaha beliau dalam mengukuhkan LDK dimulai dengan mengajak mahasiswa IAIN seperti Misbah (Ushuludin) yang saat itu aktif di lembaga ekstra kampus Fikratussalam yang bergerak di bidang dakwah. Selanjutnya dibentuk tim kecil yang bertugas mempersiapkan berdirinya LDK Syahid, baik persiapan konstitusi maupun persiapan teknis. Tim yang terdiri dari Deka Kurniawan (Ushuludin-Aqidah Filsafat ’93), Muhammad Mustofa (Syariah-MU ’94), dan Rinaldi Syafiq (Tarbiyah-Bahasa Arab ’94) itu dihasilkan dalam musyawarah yang dihadiri oleh sejumlah perwakilan fakultas. Deka Kurniawan (Ushuludin-Aqidah Filsafat ’93) merupakan Ketua LDK Syahid yang pertama.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<!-- About End -->
