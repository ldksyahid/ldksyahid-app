// =========================================================================
// SCRIPT GOOGLE APPS SCRIPT - FORDATA 2 (PUSAT & CSI FEB)
// =========================================================================

// --- Setting Variable (Silahkan sesuaikan saat taurits / periode baru) ---

const judulWebsiteviaAppScript = "FORDATA 2 - LDK Syahid";

// Gambar Banner & Logo
const logoWebsiteviaAppScript = "https://i.ibb.co.com/6cZDZznZ/FORDATA.png";
const gambarHeaderPusat = "https://i.ibb.co.com/6cZDZznZ/FORDATA.png"; // Header LDK Syahid Pusat
const gambarHeaderCSI = "https://i.ibb.co.com/ksSX0bK0/FORDATA-1600-x-400-px.png"; // Header CSI FEB
const gambarHeaderDiPortalAppScript = gambarHeaderPusat; // Default halaman depan adalah Pusat

const linkFordataviaAppScript = "http://ldksyah.id/fordata";

const teksShareFordata =
  `Assalamu'alaikum, gais
Yuk isi FORDATA {{linkFordata}}`; // Bagian {{linkFordata}} jangan diubah

const sekarangFordataBerapa = "#2 2026";

const kontakAdminCSI = "6285814010759";
const kontakAdminPusat = "6285779446994";

// [CATATAN PENTING] URL Google Form di bawah ini sudah dikonversi dari shortlink forms.gle
// menjadi URL '/viewform?usp=pp_url' agar parameter pre-fill (?entry...) TIDAK hilang saat redirect!
const linkGformCSI = "https://docs.google.com/forms/d/e/1FAIpQLSfuO3WOh_RqzW5-2U0PpycNzoyqds5302I5WDc12w5o9r6fgg/viewform?usp=pp_url";
const linkGformPusat = "https://docs.google.com/forms/d/e/1FAIpQLSezmiBcSHpNpyHJ9FyjzeJAtjwhsNCfhYXueF3VKKvs_tMJ6A/viewform?usp=pp_url";

// Spreadsheet Database (GSheet)
const linkGSheetPusat = 'https://docs.google.com/spreadsheets/d/1SR3V1orMBEpU4E_8yc3BueFKMxP17xVnSa1DMv_0ITs/edit';
const linkGSheetCSI = 'https://docs.google.com/spreadsheets/d/1OL7OjLsh6h5WKg40z7qJQst6nW5raYZd8hmH_NPPmoY/edit';

// Sheet Response (Tempat submit FORDATA 2 tahun ini untuk cek agar tidak dobel)
const namaSheetResponsePusat = 'FORDATA 2';
const namaKolomNIMdiSheetResponsePusat = "NIM";

const namaSheetResponseCSI = 'FORDATA 2 CSI';
const namaKolomNIMdiSheetResponseCSI = "NIM";

// Sheet Jawaban Sebelumnya (Sumber autofill kader lama)
// [PERIKSA INI] Jika data sebelumnya diambil dari FORDATA 1, sesuaikan nama tab ini (misal 'FORDATA 1' atau 'FORDATA KDR 30')
const namaSheetJawabanDuluPusat = 'FORDATA KDR 30';
const namaSheetJawabanDuluCSI = 'CSI FEB 2026';


// =========================================================================
// Pesan Tampilan UI
// =========================================================================

const kata2KetikaUltahGaCocok = "<br>NIM dan tanggal lahir kamu tidak cocok dengan data yang kamu isi di FORDATA Tahun Sebelumnya atau Pendaftaran Ekspresi, silahkan periksa ulang yaa atau <a href='https://wa.me/{{kontakAdmin}}' target='_blank'>kontak PSDM</a>";

const kata2KetikaUltahCocok = "Selamat mengisi FORDATA {{fordataBerapa}}, kamu ga perlu ngisi dari awal kok *kalau ga otomatis terisi, coba pencet clear form lalu klik tombol Isi Fordata dibawah ini lagi, ya".replace("{{fordataBerapa}}", sekarangFordataBerapa);

const kata2KetikaNimGaTerdaftar = "Selamat mengisi FORDATA {{fordataBerapa}}, sepertinya kamu belum mengisi FORDATA tahun sebelumnya ya, jika kamu merasa sudah mengisi, silahkan <a href='https://wa.me/{{kontakAdmin}}' target='_blank'>hubungi panitia</a>".replace("{{fordataBerapa}}", sekarangFordataBerapa);


// =========================================================================
// Mapping Entry Google Form & Header Kolom Google Sheet
// Format: [ "ID_ENTRY_GFORM", "NAMA_KOLOM_PERSIS_DI_GSHEET_JAWABAN_DULU", "ALTERNATIF_KOLOM_CSI (opsional)" ]
// Kolom yg tidak ada di sheet lama (hobi, keahlian) → akan bernilai '' → aman, form tidak crash
// =========================================================================
const entryGform = {
  fakultas:     "992920414",
  jurusan:      "808621979",
  angkatan:     "1034879517",
  nim:          "1537316170",

  // Kolom yang SAMA persis di kedua GSheet (Pusat & CSI)
  email:        ["738566889", "Email"],
  namalengkap:  ["880820588", "Nama lengkap kamu siapa deh?", "Nama lengkap kamu siapa?"],
  namapanggilan:["404908811", "Aku bisa panggil kamu apa nih?"],
  jeniskelamin: ["2109452605", "Kamu ikhwan atau akhwat?"],
  ultah:        ["291564612", "Kamu lahirnya kapan?"],
  // Nomor WA — ada 4 varian di sheet lama: uppercase/lowercase HP, ada/tidak spasi sebelum ?
  nomorwhatsapp:["1758172285",
    "Ohya, nomor Whatsapp/HP kamu berapa?",
    "Ohya, nomor Whatsapp/HP kamu berapa ?",
    "Ohya, nomor Whatsapp/hp kamu berapa ?",
    "Ohya, nomor Whatsapp/hp kamu berapa?"],
  // Pusat: "...berat? Kalau..." | CSI: "...berat ? Kalau..."
  penyakit:     ["1222049691", "Apakah kamu punya riwayat penyakit berat? Kalau punya, apa penyakitnya?", "Apakah kamu punya riwayat penyakit berat ? Kalau punya, apa penyakitnya?"],
  // Pusat: spasi normal | CSI: "Nama Jalan/Kampung/Blok  RT/RW   No. Rumah" (spasi ganda)
  jalanrumah:   ["412137909", "Nama Jalan/Kampung/Blok RT/RW No. Rumah", "Nama Jalan/Kampung/Blok  RT/RW   No. Rumah"],
  kelurahan:    ["357889852", "Desa/Kelurahan"],
  kecamatan:    ["652702124", "Kecamatan"],
  kota:         ["1173930154", "Kota/Kabupaten"],
  provinsi:     ["445019955", "Provinsi"],
  namaortu:     ["2000779735", "Nama Orangtua kamu siapa?"],
  nomorortu:    ["784846344", "Boleh aku minta nomor hp orang tua kamu? Atau kerabat lain juga boleh"],
  anakke:       ["376557937", "Kamu anak ke berapa dari berapa bersaudara?"],
  // hobi & keahlian tidak ada di FORDATA KDR 30 maupun CSI FEB 2026 → kosong, tidak crash
  hobi:         ["527943920", "Hobi kamu apa sih?"],
  keahlian:     ["160500635", "Keahlian apa yang kamu miliki?"],
  minat:        ["20457596", "Bidang KMB yang kamu minati apa?"],
  lembagaquran: ["2011352219", "Kalo pernah/sedang mengikuti, kamu peserta/pengajar di Lembaga apa?"],
  sd:           ["1556889258", "SD/MI"],
  smp:          ["1558249254", "SMP/MTs"],
  sma:          ["1239405934", "SMA/MA"],
  organisasi:   ["439307542", "Organisasi yang pernah dan sedang kamu ikuti apa aja?"],
  ipsem1:       ["247429800", "Semester 1"],
  ipsem2:       ["552970496", "Semester 2"],
  ipsem3:       ["734396434", "Semester 3"],
  ipsem4:       ["767855696", "Semester 4"],
  ipsem5:       ["644862622", "Semester 5"],
  // CSI FEB 2026 tidak punya "Semester 6" → akan kosong, tidak crash
  ipsem6:       ["306496671", "Semester 6"],
  // Pusat: "...beasiswa? Kalo iya, beasiswa apa?" | CSI: "...beasiswa ? Kalo iya, beasiswa apa ?"
  beasiswa:     ["1119026453", "Apakah saat ini kamu sedang menerima beasiswa? Kalo iya, beasiswa apa?", "Apakah saat ini kamu sedang menerima beasiswa ? Kalo iya, beasiswa apa ?"],
  // Pusat KDR 30 & CSI FEB 2026 masih pakai teks lama → primary pakai versi lama, alt pakai versi baru (FORDATA 2 2026)
  prestasi:     ["223806883", "Boleh cerita prestasi apa saja yang kamu dapat? (rentang waktu des 2021-feb 2022). Prestasi boleh berupa beasiswa, volunteer, student exchange, SAA, juara lomba dll", "Boleh cerita prestasi apa saja yang kamu dapat? (rentang waktu April 2026 - November 2026)\n\nPrestasi boleh berupa beasiswa, volunteer, student exchange, SAA, juara lomba dll"],

  keberhasilan: ["302212257", "Apa keberhasilan terbesar kamu sampai saat ini?"]
};


// =========================================================================
// Fungsi Utama Aplikasi Web (doGet)
// =========================================================================

function doGet(e) {
  // Cegah error saat fungsi dijalankan manual via tombol Run di editor Apps Script
  e = e || { parameter: {} };
  e.parameter = e.parameter || {};

  // Callback untuk komunikasi AJAX dari website portal
  if (e.parameter.callback == "antiredir") {
    var exportnimObj = {};
    try {
      exportnimObj = JSON.parse(e.parameter.exportnim || "{}");
    } catch(err) {
      exportnimObj = {};
    }

    var result = logic(e.parameter.nim, e.parameter.ultah, exportnimObj, e.parameter.anakmana);
    return ContentService
      .createTextOutput(e.parameter.callback + "(" + JSON.stringify(result) + ")")
      .setMimeType(ContentService.MimeType.JAVASCRIPT);
  }

  var a;
  try {
    a = HtmlService.createTemplateFromFile('hem');
  } catch(err) {
    return ContentService.createTextOutput("API FORDATA 2 Aktif. Gunakan parameter web untuk mengakses.");
  }

  if (e.parameter.callback == "ambiil") {
    return ContentService
      .createTextOutput(a.getRawContent())
      .setMimeType(ContentService.MimeType.JAVASCRIPT);
  }

  a.judulWebsite = judulWebsiteviaAppScript;
  a.logoWebsite = logoWebsiteviaAppScript;
  a.fordataBerapa = sekarangFordataBerapa;
  a.teksFordata = teksShareFordata.replace("{{linkFordata}}", linkFordataviaAppScript);
  a.judulPortal = judulWebsiteviaAppScript;
  a.gambarHeaderPortal = gambarHeaderDiPortalAppScript;

  return a.evaluate()
    .setTitle(judulWebsiteviaAppScript)
    .setFaviconUrl(logoWebsiteviaAppScript)
    .addMetaTag('viewport', 'width=device-width, initial-scale=1');
}


// =========================================================================
// Logika Verifikasi & Penyusunan URL Pre-fill
// =========================================================================

function logic(u, t, exportnim, anak_mana) {
  exportnim = exportnim || {};
  var nim = (u || "").toString().trim();
  var ultah = (t || "").toString().trim();
  var data = getData(nim, ultah, anak_mana);

  var kontakAdmin = (anak_mana == 'csi') ? kontakAdminCSI : kontakAdminPusat;
  var linkGform   = (anak_mana == 'csi') ? linkGformCSI   : linkGformPusat;
  var gambarHeader = (anak_mana == 'csi') ? gambarHeaderCSI : gambarHeaderPusat;
  var namaLembaga = (anak_mana == 'csi') ? "CSI FEB" : "LDK Syahid";
  var linktreeUrl = (anak_mana == 'csi') ? "https://linktr.ee/CSIFEB" : "https://linktr.ee/ldksyahidjkt";

  // Jika database gagal dibuka
  if (!data) {
    return {
      "ui": "awalan",
      "teks": "Afwan, database sedang tidak dapat diakses. Silahkan <a href='https://wa.me/" + kontakAdmin + "' target='_blank'>kontak panitia</a> ya.",
      "link": { "nim": "", "ultah": "" },
      "gambar": gambarHeader,
      "lembaga": namaLembaga,
      "linktree": linktreeUrl
    };
  }

  // Jika sudah mengisi FORDATA 2 sebelumnya
  if (data.link === "udah_ngisi") {
    return {
      "ui": "closed",
      "gambar": gambarHeader,
      "lembaga": namaLembaga,
      "linktree": linktreeUrl
    };
  }

  const entryNim = 
    `&entry.${entryGform.fakultas}=` + encodeURIComponent(exportnim.fakultas || '') +
    `&entry.${entryGform.jurusan}=`  + encodeURIComponent(exportnim.jurusan || '') +
    `&entry.${entryGform.angkatan}=` + encodeURIComponent(exportnim.angkatan || '') +
    `&entry.${entryGform.nim}=`      + encodeURIComponent(exportnim.nim || nim);

  // Jika data NIM ditemukan di database sebelumnya (kader lama)
  if (data.link) {
    var cek_data_ultah = formatTanggalKeISO(data.ultah);

    // Cocokkan tanggal lahir
    if (!cek_data_ultah || ultah !== cek_data_ultah) {
      return {
        "ui": "awalan",
        "teks": kata2KetikaUltahGaCocok.replace("{{kontakAdmin}}", kontakAdmin),
        "link": { "nim": "", "ultah": "" },
        "gambar": gambarHeader,
        "lembaga": namaLembaga,
        "linktree": linktreeUrl
      };
    }

    return {
      "ui": "bismillah",
      "teks": kata2KetikaUltahCocok.replace("{{kontakAdmin}}", kontakAdmin),
      "link": linkGform + data.link + entryNim,
      "gambar": gambarHeader,
      "lembaga": namaLembaga,
      "linktree": linktreeUrl
    };
  }

  // Jika NIM tidak ditemukan (kader baru)
  return {
    "ui": "bismillah",
    "teks": kata2KetikaNimGaTerdaftar.replace("{{kontakAdmin}}", kontakAdmin),
    "link": linkGform + entryNim,
    "gambar": gambarHeader,
    "lembaga": namaLembaga,
    "linktree": linktreeUrl
  };
}


// =========================================================================
// Pengambilan Data dari Google Spreadsheet
// =========================================================================

function getData(nim, ultahinput, anak_mana) {
  var linkGSheet = (anak_mana == 'csi') ? linkGSheetCSI : linkGSheetPusat;
  var namaSheetResponse = (anak_mana == 'csi') ? namaSheetResponseCSI : namaSheetResponsePusat;
  var namaKolomNIM = (anak_mana == 'csi') ? namaKolomNIMdiSheetResponseCSI : namaKolomNIMdiSheetResponsePusat;
  var namaSheetJawabanDulu = (anak_mana == 'csi') ? namaSheetJawabanDuluCSI : namaSheetJawabanDuluPusat;

  try {
    var s = SpreadsheetApp.openByUrl(linkGSheet);

    // 1. CEK APAKAH SUDAH MENGISI DI SHEET RESPONSE TAHUN INI
    var f = s.getSheetByName(namaSheetResponse);
    if (f) {
      var lastRow = f.getLastRow();
      if (lastRow > 1) {
        var headerRow = f.getRange(1, 1, 1, Math.min(f.getLastColumn(), 100)).getValues()[0];
        var colIdxNIM = headerRow.findIndex(h => h.toString().trim() === namaKolomNIM);

        if (colIdxNIM !== -1) {
          var nimValues = f.getRange(2, colIdxNIM + 1, lastRow - 1, 1).getValues();
          for (var i = 0; i < nimValues.length; i++) {
            if (nimValues[i][0] && nimValues[i][0].toString().trim() === nim) {
              return { "ultah": new Date(0), "link": "udah_ngisi" };
            }
          }
        }
      }
    }

    // 2. CEK JAWABAN TAHUN SEBELUMNYA UNTUK AUTO-FILL
    var sheetDulu = s.getSheetByName(namaSheetJawabanDulu);
    if (!sheetDulu) {
      Logger.log("Sheet jawaban dulu '" + namaSheetJawabanDulu + "' tidak ditemukan!");
      return { "ultah": new Date(0), "link": "" };
    }

    var values = sheetDulu.getDataRange().getValues();
    if (values.length < 2) {
      return { "ultah": new Date(0), "link": "" };
    }

    var heads = values.shift().map(h => h.toString().trim());
    var obj = values.map(r => (heads.reduce((o, k, i) => (o[k] = r[i] !== undefined ? r[i] : '', o), {})));

    var link_var = "";
    var ultah = new Date(0);

    obj.some(function(row) {
      // Fleksibel mencari kolom NIM
      var rowNim = (row[namaKolomNIM] !== undefined ? row[namaKolomNIM] : (row["NIM"] || row["Nomor Induk Mahasiswa"] || "")).toString().trim();

      if (rowNim === nim) {
        ultah = row[entryGform.ultah[1]];

        // Helper: coba SEMUA varian header (index [1], [2], [3], ...) sampai ada yang cocok di row
        function ambil(cfg) {
          if (!Array.isArray(cfg)) return '';
          for (var i = 1; i < cfg.length; i++) {
            var val = row[cfg[i]];
            if (val !== undefined && val !== '') return val;
          }
          return '';
        }

        // Susun parameter URL prefill
        link_var =
          `&entry.${entryGform.ultah[0]}=`        + encodeURIComponent(ultahinput || '') +
          `&entry.${entryGform.email[0]}=`        + encodeURIComponent(ambil(entryGform.email)) +
          `&entry.${entryGform.namalengkap[0]}=`  + encodeURIComponent(ambil(entryGform.namalengkap)) +
          `&entry.${entryGform.namapanggilan[0]}=`+ encodeURIComponent(ambil(entryGform.namapanggilan)) +
          `&entry.${entryGform.jeniskelamin[0]}=` + encodeURIComponent(ambil(entryGform.jeniskelamin)) +
          `&entry.${entryGform.nomorwhatsapp[0]}=`+ encodeURIComponent(ambil(entryGform.nomorwhatsapp)) +
          `&entry.${entryGform.penyakit[0]}=`     + encodeURIComponent(ambil(entryGform.penyakit)) +
          `&entry.${entryGform.jalanrumah[0]}=`   + encodeURIComponent(ambil(entryGform.jalanrumah)) +
          `&entry.${entryGform.kelurahan[0]}=`    + encodeURIComponent(ambil(entryGform.kelurahan)) +
          `&entry.${entryGform.kecamatan[0]}=`    + encodeURIComponent(ambil(entryGform.kecamatan)) +
          `&entry.${entryGform.kota[0]}=`         + encodeURIComponent(ambil(entryGform.kota)) +
          `&entry.${entryGform.provinsi[0]}=`     + encodeURIComponent(ambil(entryGform.provinsi)) +
          `&entry.${entryGform.namaortu[0]}=`     + encodeURIComponent(ambil(entryGform.namaortu)) +
          `&entry.${entryGform.nomorortu[0]}=`    + encodeURIComponent(ambil(entryGform.nomorortu)) +
          `&entry.${entryGform.anakke[0]}=`       + encodeURIComponent(ambil(entryGform.anakke)) +
          `&entry.${entryGform.hobi[0]}=`         + encodeURIComponent(ambil(entryGform.hobi)) +
          `&entry.${entryGform.keahlian[0]}=`     + encodeURIComponent(ambil(entryGform.keahlian)) +
          `&entry.${entryGform.minat[0]}=`        + encodeURIComponent(ambil(entryGform.minat)) +
          `&entry.${entryGform.lembagaquran[0]}=` + encodeURIComponent(ambil(entryGform.lembagaquran)) +
          `&entry.${entryGform.sd[0]}=`           + encodeURIComponent(ambil(entryGform.sd)) +
          `&entry.${entryGform.smp[0]}=`          + encodeURIComponent(ambil(entryGform.smp)) +
          `&entry.${entryGform.sma[0]}=`          + encodeURIComponent(ambil(entryGform.sma)) +
          `&entry.${entryGform.organisasi[0]}=`   + encodeURIComponent(ambil(entryGform.organisasi)) +
          `&entry.${entryGform.ipsem1[0]}=`       + encodeURIComponent(ambil(entryGform.ipsem1)) +
          `&entry.${entryGform.ipsem2[0]}=`       + encodeURIComponent(ambil(entryGform.ipsem2)) +
          `&entry.${entryGform.ipsem3[0]}=`       + encodeURIComponent(ambil(entryGform.ipsem3)) +
          `&entry.${entryGform.ipsem4[0]}=`       + encodeURIComponent(ambil(entryGform.ipsem4)) +
          `&entry.${entryGform.ipsem5[0]}=`       + encodeURIComponent(ambil(entryGform.ipsem5)) +
          `&entry.${entryGform.ipsem6[0]}=`       + encodeURIComponent(ambil(entryGform.ipsem6)) +
          `&entry.${entryGform.beasiswa[0]}=`     + encodeURIComponent(ambil(entryGform.beasiswa)) +
          `&entry.${entryGform.prestasi[0]}=`     + encodeURIComponent(ambil(entryGform.prestasi)) +
          `&entry.${entryGform.keberhasilan[0]}=` + encodeURIComponent(ambil(entryGform.keberhasilan));

        return true;
      }
      return false;
    });

    return { "ultah": ultah, "link": link_var };
  } catch (e) {
    Logger.log("Error getData: " + e.toString());
    return null;
  }
}


// =========================================================================
// Fungsi Helper: Konversi Tanggal Kebal Error
// =========================================================================

function formatTanggalKeISO(val) {
  if (!val) return "";
  try {
    if (val instanceof Date) {
      return new Date(val.getTime() - val.getTimezoneOffset() * 60000).toISOString().slice(0, 10);
    }
    var str = val.toString().trim();
    // Format YYYY-MM-DD
    if (/^\d{4}-\d{2}-\d{2}$/.test(str)) {
      return str;
    }
    // Format DD/MM/YYYY atau DD-MM-YYYY
    var parts = str.split(/[\/\-]/);
    if (parts.length === 3) {
      if (parts[0].length === 2 && parts[2].length === 4) {
        return parts[2] + "-" + parts[1].padStart(2, '0') + "-" + parts[0].padStart(2, '0');
      }
    }
    var d = new Date(str);
    if (!isNaN(d.getTime())) {
      return new Date(d.getTime() - d.getTimezoneOffset() * 60000).toISOString().slice(0, 10);
    }
  } catch(e) {}
  return "";
}


// =========================================================================
// FUNGSI CEK SINKRONISASI (Jalankan ini dari menu Run untuk mendiagnosis)
// =========================================================================

function cekSinkronisasi() {
  Logger.log("=== MEMULAI PENGECEKAN SINKRONISASI PUSAT ===");
  cekPerCabang(linkGSheetPusat, namaSheetResponsePusat, namaKolomNIMdiSheetResponsePusat, namaSheetJawabanDuluPusat);

  Logger.log("\n=== MEMULAI PENGECEKAN SINKRONISASI CSI ===");
  cekPerCabang(linkGSheetCSI, namaSheetResponseCSI, namaKolomNIMdiSheetResponseCSI, namaSheetJawabanDuluCSI);
}

function cekPerCabang(urlSpreadsheet, sheetRespName, colNimName, sheetDuluName) {
  // Jika tidak sengaja di-run langsung dari dropdown tanpa parameter, alihkan ke cekSinkronisasi
  if (!urlSpreadsheet) {
    return cekSinkronisasi();
  }

  var s;
  try {
    s = SpreadsheetApp.openByUrl(urlSpreadsheet);
  } catch(e) {
    Logger.log("❌ URL Spreadsheet tidak bisa dibuka: " + urlSpreadsheet);
    Logger.log("   Penyebab: " + e.message);
    Logger.log("   👉 Solusi: Pastikan akun Google yang menjalankan script ini sudah diberikan akses ('Editor' atau 'Viewer') ke Google Spreadsheet tersebut, atau buka akses link menjadi 'Anyone with the link can view'.");
    return;
  }

  // 1. Cek Sheet Response
  var sResp = s.getSheetByName(sheetRespName);
  if (!sResp) {
    Logger.log("❌ Sheet Response '" + sheetRespName + "' TIDAK DITEMUKAN!");
  } else {
    var headers = sResp.getRange(1, 1, 1, Math.min(sResp.getLastColumn(), 50)).getValues()[0].map(h => h.toString().trim());
    if (headers.indexOf(colNimName) === -1) {
      Logger.log("❌ Kolom NIM '" + colNimName + "' tidak ditemukan di sheet '" + sheetRespName + "'!");
    } else {
      Logger.log("✅ Sheet Response '" + sheetRespName + "' & Kolom NIM OK.");
    }
  }

  // 2. Cek Sheet Jawaban Dulu
  var sDulu = s.getSheetByName(sheetDuluName);
  if (!sDulu) {
    Logger.log("❌ Sheet Jawaban Dulu '" + sheetDuluName + "' TIDAK DITEMUKAN!");
    return;
  }

  var headersDulu = sDulu.getDataRange().getValues()[0].map(h => h.toString().trim());
  Logger.log("🔍 Memeriksa kecocokan nama kolom di '" + sheetDuluName + "':");

  var adaError = false;
  var kolomBermasalah = [];
  for (var key in entryGform) {
    if (Array.isArray(entryGform[key])) {
      var cfg = entryGform[key];

      // Cek semua varian header (index 1, 2, 3, ...)
      var cocokIdx = -1;
      for (var vi = 1; vi < cfg.length; vi++) {
        var h = cfg[vi] ? cfg[vi].trim() : '';
        if (h && headersDulu.indexOf(h) !== -1) {
          cocokIdx = vi;
          break;
        }
      }

      if (cocokIdx === -1) {
        adaError = true;
        kolomBermasalah.push(key);
        var semuaVarian = cfg.slice(1).map(function(v){ return '"' + v + '"'; }).join(', ');
        Logger.log("   ❌ [KOLOM TIDAK COCOK] '" + key + "': " + semuaVarian);
      } else if (cocokIdx > 1) {
        Logger.log("   ⚠️  [PAKAI VARIAN-" + cocokIdx + "]   '" + key + "': pakai \"" + cfg[cocokIdx] + "\"");
      }
    }
  }

  if (!adaError) {
    Logger.log("🎉 SEMUA KOLOM COCOK DENGAN GSHEET!");
  } else {
    Logger.log("\n💡 DAFTAR NAMA KOLOM DI GSHEET '" + sheetDuluName + "' YANG KEMUNGKINAN MERUPAKAN PASANGANNYA:");
    headersDulu.forEach(function(h, idx) {
      var low = h.toLowerCase();
      if (low.includes('hobi') || low.includes('minat') || low.includes('ahli') || low.includes('keahlian') || low.includes('skill') || low.includes('quran') || low.includes('lembaga') || low.includes('tahfidz') || low.includes('bakat')) {
        Logger.log("   👉 Kolom [" + (idx + 1) + "]: \"" + h + "\"");
      }
    });

    Logger.log("\n📋 URUTAN LENGKAP KOLOM [15 s/d 30] DI SHEET '" + sheetDuluName + "':");
    for (var i = 14; i < Math.min(headersDulu.length, 30); i++) {
      Logger.log("   Kolom [" + (i + 1) + "]: \"" + headersDulu[i] + "\"");
    }
  }
}

// Fungsi bantu untuk mencetak seluruh nama kolom di sheet FORDATA KDR 30
function tampilkanSemuaKolom() {
  var s = SpreadsheetApp.openByUrl(linkGSheetPusat);
  var sheet = s.getSheetByName(namaSheetJawabanDuluPusat);
  if (!sheet) {
    Logger.log("Sheet " + namaSheetJawabanDuluPusat + " tidak ditemukan!");
    return;
  }
  var headers = sheet.getDataRange().getValues()[0];
  Logger.log("=== DAFTAR SEMUA KOLOM DI " + namaSheetJawabanDuluPusat + " (" + headers.length + " kolom) ===");
  headers.forEach(function(h, i) {
    Logger.log("[" + (i + 1) + "] " + h);
  });
}


