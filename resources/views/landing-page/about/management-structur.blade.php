@extends('landing-page.template.body')

@section('content')
<div style="display: none;">
    <audio src="{{ asset('audio/mars-ldksyahid.mp3') }}" type="audio/mpeg" autoplay loop></audio>
</div>

@forelse($poststructure as $key => $data)
<section class="py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <!-- Text Section -->
            <div class="col-lg-7 col-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="mb-4">
                    <h5 class="text-primary mb-2">Struktur Pengurus LDK Syahid {{ $data->batch }}</h5>
                    <h6 class="text-muted mb-3">Masa Bakti {{ $data->period }}</h6>
                    <h2 class="fw-bold mb-3">{{ $data->structureName }}</h2>
                    <p class="text-secondary" style="text-align: justify;">{{ $data->structureDescription }}</p>
                </div>
            </div>

            <!-- Image Section -->
            <div class="col-lg-5 col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                <img src="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id }}"
                    alt="Foto Pengurus LDK Syahid"
                    class="img-fluid"
                    style="max-width: 300px; border-radius: 12px;">
            </div>

            <!-- Full Width Structure Image -->
            <div class="col-12 wow fadeInUp" data-wow-delay="0.3s">
                <img src="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id_2 }}=s5000"
                    alt="Struktur Pengurus"
                    class="img-fluid shadow mt-5"
                    style="width: 100%; height: auto; border-radius: 16px;">
            </div>

        </div>
    </div>
</section>
@empty
<section class="py-5 text-center wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <h2 class="text-muted">Struktur Pengurus Belum Tersedia</h2>
    </div>
</section>
@endforelse
@endsection
