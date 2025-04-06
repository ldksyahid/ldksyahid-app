<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse($postjumbotron as $key => $post)
            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                <img class="w-100 animate__animated animate__fadeIn"
                     src="https://lh3.googleusercontent.com/d/{{ $post->gdrive_id }}"
                     alt="{{ $post->title }}"
                     style="object-fit: cover; height: 80vh;" />

                <div class="carousel-caption d-flex align-items-center justify-content-center flex-column text-center h-100 bg-overlay">
                    <h1 class="text-white fw-bold display-4 animate__animated animate__fadeInDown animate__delay-0_5s">
                        {{ $post->title }}
                    </h1>
                    @if ($post->description)
                    <p class="text-white fs-5 animate__animated animate__fadeIn animate__delay-1s">
                        {{ $post->description }}
                    </p>
                    @endif

                    @if ($post->btnname && $post->btnlink)
                        <a href="{{ $post->btnlink }}" target="_blank" class="btn btn-primary px-5 py-3 fw-bold fs-5 mt-3 animate__animated animate__fadeInUp animate__delay-2s">
                            {{ $post->btnname }}
                        </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="carousel-item active">
                <img class="w-100 animate__animated animate__fadeIn"
                     src="https://lh3.googleusercontent.com/d/1Cur2mISU8cwkWcyBuiwv9aGYNTxsZMPo"
                     alt="Default"
                     style="object-fit: cover; height: 80vh;" />
                <div class="carousel-caption d-flex align-items-center justify-content-center h-100 bg-overlay"></div>
            </div>
            @endforelse
        </div>
    </div>
</div>


<style>
.bg-overlay {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0));
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.carousel-item img {
    object-fit: cover;
    height: 80vh;
    width: 100%;
}

/* Tombol animasi */
.carousel-caption a.btn {
    transition: all 0.3s ease;
    border-radius: 50px;
    z-index: 2;
}

.carousel-caption a.btn:hover {
    background-color: #fff;
    color: #000;
    transform: scale(1.05);
}

/* Responsive untuk mobile */
@media (max-width: 768px) {
    .bg-overlay {
        background: none !important; /* hilangkan efek gelap */
    }

    .carousel-item img {
        object-fit: contain !important; /* tampilkan seluruh gambar */
        height: auto !important;
        max-height: 80vh; /* batasi tinggi agar tidak terlalu panjang */
    }

    .carousel-caption {
        padding: 0 1rem;
    }

    .carousel-caption a.btn {
        padding: 10px 20px;
        font-size: 0.95rem;
    }
}

</style>
