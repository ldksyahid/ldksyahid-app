<style>
@page { margin: 0; }

/* ── GLOBAL ── */
body {
    margin: 0;
    color: #000;
    font-family: "Times New Roman", Times, serif;
    font-size: 12pt;
    line-height: 1.15;
}

/* ── BACKGROUND KOP ── */
.page-bg {
    position: fixed;
    top: 0; left: 0;
    width: 210mm; height: 297mm;
    z-index: -1;
}

/* ── WRAPPER KONTEN
   padding-top menggantikan position:absolute agar konten
   panjang tidak terpotong & halaman bisa overflow.
   padding-bottom kecil saja — verifikasi QR sudah punya margin sendiri ── */
.content {
    padding: 53mm 25mm 22mm 25mm;
}

/* ── HEADER META (Nomor / Lampiran / Hal) ── */
.meta {
    width: 100%;
    margin: 0 0 16pt 0;
    border-collapse: collapse;
}
.meta td {
    padding: 0 0 3pt 0;
    vertical-align: top;
}
.meta-label { width: 22mm; }
.meta-sep   { width:  4mm; }
.date-cell  { text-align: right; white-space: nowrap; }

/* ── BODY SURAT ── */
.body-surat {
    margin-left: 26mm;
    text-align: justify;
}

/* Semua <p>: justify + jarak bawah 8pt */
p {
    margin: 0 0 8pt 0;
    text-align: justify;
}

/* Indentasi awal paragraf */
.indent { text-indent: 9mm; }

/* ── ALAMAT PENERIMA ── */
.recipient {
    margin-bottom: 12pt;
    text-align: left;
}
.recipient p { margin-bottom: 0; }

/* ── SALAM ── */
.salam {
    font-weight: bold;
    font-style: italic;
    margin: 0 0 10pt 0;
    text-align: left;
}
.salam-penutup {
    font-weight: bold;
    font-style: italic;
    margin: 10pt 0 0 0;
    text-align: left;
}

/* ── TABEL IDENTITAS (Hari/Tanggal, Waktu, Tempat, dst) ── */
.identity {
    width: 100%;
    margin: 4pt 0 8pt 0;
    border-collapse: collapse;
}
.identity td {
    padding: 1pt 0;
    vertical-align: top;
    line-height: 1.15;
    font-size: 12pt;
}
/* Default lebar label — bisa di-override per template */
.identity-label { width: 38mm; }
.identity-sep   { width:  5mm; }

/* ── LIST (ol/ul) dalam isi surat ── */
ol, ul {
    margin: 4pt 0 10pt 0;
    padding-left: 14mm;
}
ol li, ul li {
    margin-bottom: 3pt;
    line-height: 1.15;
}

/* ── TANDA TANGAN ── */
.signature-table {
    width: 100%;
    margin-top: 14pt;
    border-collapse: collapse;
    page-break-inside: avoid;
}
.signature-table td { padding: 0; }

.ttd-cell {
    width: 50%;
    text-align: center;
    vertical-align: bottom;   /* dompdf support vertical-align pada td */
    line-height: 1.4;
    padding-bottom: 0;
}

/* Ruang TTD: dompdf tidak support flex, pakai block + height */
.ttd-space {
    height: 16mm;
    display: block;
    text-align: center;
}
.ttd-space img {
    width: 14mm;
    height: 14mm;
    display: block;
    margin: 2mm auto 0 auto;  /* push QR ke atas sedikit dari bawah */
}

/* ── KOTAK VERIFIKASI QR (footer surat) ── */
.verification {
    width: 68mm;
    margin-top: 8pt;
    border: 0.5px solid #36aaa1;
    border-collapse: collapse;
    color: #444;
    font-family: "DejaVu Sans", Arial, sans-serif;
    font-size: 6pt;
    line-height: 1.25;
    page-break-inside: avoid;
    page-break-before: avoid;
}
.verification td {
    padding: 2pt;
    vertical-align: middle;
}
.verification .qr-cell {
    width: 14mm;
    text-align: center;
    border-right: 0.5px solid #36aaa1;
}
.verification .qr-cell img {
    width: 12mm;
    height: 12mm;
    display: block;
    margin: 0 auto;
}
.verification p {
    margin: 0 0 1pt 0;
    text-align: left;
    font-size: 6pt;
    line-height: 1.25;
}
.verification-url {
    word-break: break-all;
    color: #1a6eb5;
}
</style>