@php
    $sekjenSignatureUri = \App\Models\SuratLog::getTtdSekjenBase64();
@endphp
@if ($sekjenSignatureUri)
    <img class="ttd-signature" src="{{ $sekjenSignatureUri }}" alt="Tanda tangan Sekretaris Jenderal">
@endif