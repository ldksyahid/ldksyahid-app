<style>
@page { margin: 0; }

body {
    margin: 0;
    color: #000;
    font-family: "Times New Roman", Times, serif;
    font-size: 11pt;
    line-height: 1.15;
}

.page-bg {
    position: fixed; 
    top: 0; 
    left: 0;
    width: 210mm; 
    height: 297mm;
    z-index: -1;   
}

/* Jarak atas 52mm seimbang di bawah kaligrafi Basmallah */
.content {
    padding: 52mm 22mm 12mm 22mm;
}

.meta {
    width: 100%;
    margin: 0 0 9pt 0;
    border-collapse: collapse;
}
.meta td {
    padding: 0 0 2.5pt 0;
    vertical-align: top;
}
.meta-label { width: 22mm; }
.meta-sep   { width:  4mm; text-align: left; }
.date-cell  { text-align: right; white-space: nowrap; }

/* ── BODY SURAT (Rata lurus dengan titik dua meta header di atas: 22mm + 4mm = 26mm) ── */
.body-surat {
    margin-left: 26mm;
    text-align: justify;
}

p {
    margin: 0 0 4.5pt 0;
    text-align: justify;
    line-height: 1.15;
}

/* Indentasi paragraf (tab/menjorok ke dalam 8mm) */
.indent { text-indent: 8mm; }

/* ── ALAMAT PENERIMA ── */
.recipient {
    margin-left: 0;
    margin-bottom: 8pt;
    text-align: left;
}
.recipient p { margin-bottom: 0; }

/* ── SALAM ── */
.salam {
    font-weight: bold;
    font-style: italic;
    margin: 0 0 6pt 0;
    text-align: left;
}
.salam-penutup {
    font-weight: bold;
    font-style: italic;
    margin: 7pt 0 0 0;
    text-align: left;
}

/* ── TABEL IDENTITAS / RINCIAN ACARA (Sejajar dengan indentasi paragraf: 8mm) ── */
.identity {
    width: 100%;
    margin: 3pt 0 4.5pt 8mm;
    border-collapse: collapse;
}
.identity td {
    padding: 0.8pt 0;
    vertical-align: top;
    line-height: 1.15;
    font-size: 11pt;
}
.identity-label { width: 34mm; }
.identity-sep   { width:  3mm; text-align: left; padding-right: 1mm; }

/* ── LIST (ol/ul) dalam isi surat ── */
ol, ul {
    margin: 3pt 0 7pt 0;
    padding-left: 10mm;
}
ol li, ul li {
    margin-bottom: 2pt;
    line-height: 1.15;
}

/* ── TANDA TANGAN (14pt setelah wasalam) ── */
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
    vertical-align: bottom;  
    line-height: 1.2;
    padding-bottom: 0;
}

.ttd-space {
    height: 18mm;
    display: block;
    text-align: center;
}
.ttd-space img {
    width: 16mm;
    height: 16mm;
    display: block;
    margin: 0 auto;
}
.ttd-space img.ttd-signature {
    width: auto;
    height: 18mm;
    max-width: 30mm;
    display: block;
    margin: 0 auto;
}

/* ── TTD KHUSUS WAREK (Fasilitas Kampus Bersama) ── */
.signature-table--warek {
    width: 50%;
    margin: 7pt auto 0 auto;
    border-collapse: collapse;
    page-break-inside: avoid;
}
.signature-table--warek .ttd-cell { width: 100%; }

.ttd-caret {
    font-size: 13pt;
    font-weight: bold;
    color: #999;
}

/* ── KOTAK VERIFIKASI QR (footer surat) ── */
.verification {
    width: 68mm;
    margin-top: 5pt;
    border: 0.5px solid #36aaa1;
    border-collapse: collapse;
    color: #444;
    font-family: "DejaVu Sans", Arial, sans-serif;
    font-size: 5.5pt;
    line-height: 1.15;
    page-break-inside: avoid;
    page-break-before: avoid;
}
.verification td {
    padding: 1.5pt;
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
    font-size: 5.5pt;
    line-height: 1.15;
}
.verification-url {
    word-break: break-all;
    color: #1a6eb5;
}
</style>