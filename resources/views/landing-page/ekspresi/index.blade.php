<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <meta property="og:title" content="Ekspresi &#9679; LDK Syahid" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="https://lh3.googleusercontent.com/d/1ZUo19ZkNHE_fkWp4wiEpzr2Zjvca-VCm" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="300" />
    <meta property="og:description" content="Eksplorasi Potensi Diri Islami" />

    <title>Ekspresi &#9679; LDK Syahid</title>

    <link href="https://lh3.googleusercontent.com/d/1ZUo19ZkNHE_fkWp4wiEpzr2Zjvca-VCm" rel="icon">
    <link href="https://lh3.googleusercontent.com/d/1ZUo19ZkNHE_fkWp4wiEpzr2Zjvca-VCm" rel="apple-touch-icon">


    @include('landing-page.ekspresi._index-styles')
    @include('landing-page.ekspresi.template._body-styles')

    <!-- =======================================================
    * Template Name: Arsha
    * Updated: Jul 27 2023 with Bootstrap v5.3.1
    * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>
    @include('landing-page.ekspresi.template.nav-bar')
    @include('landing-page.ekspresi.template.body')
    @include('landing-page.ekspresi.template.footer')
    @include('landing-page.ekspresi._index-scripts')
    @include('landing-page.ekspresi.template._body-scripts')
</body>

</html>