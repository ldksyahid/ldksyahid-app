@php
    $sekjenSignaturePath = public_path('assets/persuratan/ttd-sekjen.png');
    $sekjenSignatureUri = file_exists($sekjenSignaturePath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($sekjenSignaturePath))
        : null;
@endphp
@if ($sekjenSignatureUri)
    <img class="ttd-signature" src="{{ $sekjenSignatureUri }}" alt="Tanda tangan Sekretaris Jenderal">
@endif
