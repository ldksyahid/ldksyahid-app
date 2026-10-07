@include('pdf.components._index-styles')
<style>
.page-break {
    page-break-before: always;
}

.lampiran-page {
    margin-top: 0;
}

.lampiran-tag {
    font-weight: bold;
    font-size: 11pt;
    margin-bottom: 4pt;
    text-align: left;
}

.lampiran-title {
    text-align: center;
    font-weight: bold;
    font-size: 11.5pt;
    margin-bottom: 2pt;
    text-transform: uppercase;
}

.lampiran-subtitle {
    text-align: center;
    font-weight: bold;
    font-size: 11pt;
    margin-bottom: 10pt;
}

.lampiran-nomor {
    text-align: center;
    font-size: 11pt;
    margin-bottom: 8pt;
}

/* Tabel Rundown / Susunan Acara */
.rundown-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 8pt;
    margin-bottom: 12pt;
    font-size: 9.5pt;
}
.rundown-table th, .rundown-table td {
    border: 1px solid #000;
    padding: 3.5pt 5pt;
    vertical-align: middle;
    line-height: 1.2;
}
.rundown-table th {
    background-color: #f0f0f0;
    text-align: center;
    font-weight: bold;
    font-size: 10pt;
}
.rundown-table td.col-time {
    width: 28mm;
    text-align: center;
    white-space: nowrap;
}
.rundown-table td.col-act {
    text-align: left;
}
.rundown-table td.col-person {
    width: 42mm;
    text-align: left;
}
.rundown-section-row td {
    background-color: #f7f7f7;
    font-weight: bold;
    text-align: left;
    padding-left: 8pt;
}

/* Tabel Identitas di Lampiran */
.table-identitas {
    width: 100%;
    margin: 4pt 0 6pt 0;
    border-collapse: collapse;
    font-size: 10.5pt;
}
.table-identitas td {
    padding: 1.5pt 0;
    vertical-align: top;
    line-height: 1.2;
}
.table-identitas .id-label { width: 38mm; }
.table-identitas .id-sep   { width: 4mm; text-align: left; }

/* Komitmen & Kepatuhan */
.list-komitmen {
    margin: 4pt 0 6pt 0;
    padding-left: 18pt;
    text-align: justify;
}
.list-komitmen li {
    margin-bottom: 2.5pt;
    line-height: 1.2;
    font-size: 9.5pt;
}

.list-sanksi {
    margin: 3pt 0 6pt 0;
    padding-left: 18pt;
    text-align: justify;
}
.list-sanksi li {
    margin-bottom: 2pt;
    line-height: 1.2;
    font-size: 9.5pt;
}

/* Tanda Tangan Lampiran (Kiri & Kanan) */
.signature-lampiran {
    width: 100%;
    margin-top: 10pt;
    border-collapse: collapse;
    page-break-inside: avoid;
}
.signature-lampiran td {
    width: 50%;
    text-align: center;
    vertical-align: top;
    font-size: 10.5pt;
    line-height: 1.2;
}
.signature-lampiran-single {
    width: 50%;
    margin: 10pt 0 0 auto;
    border-collapse: collapse;
    page-break-inside: avoid;
}
.signature-lampiran-single td {
    width: 100%;
    text-align: center;
    vertical-align: top;
    font-size: 10.5pt;
    line-height: 1.2;
}
</style>
