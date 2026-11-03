<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title id="html-title">{{ $judulWebsite }}</title>
  <link rel="icon" href="{{ $logoWebsite }}">

  {{-- Open Graph Meta Tags --}}
  <meta property="og:title" content="{{ $judulWebsite }}">
  <meta property="og:description" content="Portal FORDATA LDK Syahid UIN Syarif Hidayatullah Jakarta">
  <meta property="og:image" content="{{ $gambarHeaderPusat }}">
  <meta property="og:url" content="{{ $linkFordata }}">
  <meta property="og:type" content="website">

  {{-- Fonts & CSS --}}
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

  <style>
    body,
    h1,
    h2,
    h3,
    p,
    input,
    button {
      font-family: "Montserrat", sans-serif;
    }

    body,
    html {
      min-height: 100%;
      margin: 0;
      padding: 0;
    }

    .bgimg {
      background-color: #f3a81b25;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: background-color 0.3s ease;
    }

    .portal-container {
      width: 100%;
      max-width: 680px;
      margin: 0 auto;
      padding: 16px;
      text-align: center;
    }

    .header-banner {
      display: block;
      margin: 0 auto;
      padding: 16px 8px 8px;
      max-width: 100%;
      width: 580px;
      height: auto;
      border-radius: 12px;
      transition: opacity 0.25s ease;
    }

    .portal-title {
      font-weight: 700;
      font-size: 1.5rem;
      margin: 16px 0 8px;
    }

    .divider {
      margin: 12px auto 20px;
      width: 60%;
      max-width: 280px;
      border-top: 2px solid #ccc;
    }

    .form-group {
      margin-bottom: 14px;
    }

    .form-label {
      font-weight: 600;
      font-size: 0.85rem;
      margin-bottom: 6px;
      display: block;
    }

    .nim-input-group {
      display: flex;
      justify-content: center;
      gap: 6px;
      max-width: 280px;
      margin: 0 auto;
    }

    .btn-action {
      background-color: #616161;
      color: #fff;
      border: none;
      padding: 8px 18px;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.2s, transform 0.1s;
    }

    .btn-action:hover {
      background-color: #000;
      color: #fff;
    }

    .btn-action:active {
      transform: scale(0.98);
    }

    .btn-logout {
      background-color: #757575;
      font-size: 0.75rem;
      padding: 5px 12px;
    }

    .btn-logout:hover {
      background-color: #d32f2f;
    }

    .spinner {
      border: 4px solid #f3f3f3;
      border-top: 4px solid #f3a81b;
      border-radius: 50%;
      width: 32px;
      height: 32px;
      animation: spin 1s linear infinite;
      margin: 12px auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.45);
      backdrop-filter: blur(2px);
    }

    .modal-content {
      background-color: #fff;
      margin: 15% auto;
      padding: 24px;
      border-radius: 10px;
      width: 90%;
      max-width: 420px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
      position: relative;
    }

    .close {
      position: absolute;
      right: 16px;
      top: 10px;
      color: #888;
      font-size: 26px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover {
      color: #000;
    }

    .footer-credit {
      padding: 16px;
      font-size: 0.75rem;
      color: #666;
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      flex-wrap: wrap;
      gap: 8px;
    }
  </style>
</head>

<body>
  <div class="bgimg w3-animate-opacity" id="hemmaindiv">
    <div class="portal-container">
      {{-- Banner Header --}}
      <img id="headerimg"
           src="{{ $gambarHeaderPusat }}"
           alt="Header Banner FORDATA"
           class="header-banner">

      <h1 id="judul-portal" class="portal-title">{{ $judulWebsite }}</h1>
      <hr class="divider">

      {{-- Loading State --}}
      <div id="loading" style="display: none;">
        <div class="spinner"></div>
        <p class="w3-small" style="text-align: center;">Sedang mengambil data.. Mohon sabar sebentar ya..</p>
      </div>

      {{-- Form Awal --}}
      <div id="awalan">
        <p id="kata2" class="w3-small" style="margin-bottom: 16px;">
          Assalamu'alaikum Saudaraku<br>Silahkan masukkan NIM dan Tanggal Lahir kamu yaa
        </p>

        <form id="myform" class="w3-container" style="display: none;" onsubmit="return false;">
          <div class="form-group">
            <label class="form-label" for="nim">NIM:</label>
            <div class="nim-input-group">
              <input id="nim" name="nim" class="w3-input w3-border w3-round" type="number"
                     style="text-align: center;" placeholder="Nomor Induk Mahasiswa" required />
              <button type="button" id="cek" class="btn-action">Cek</button>
            </div>
          </div>

          <div class="form-group" style="margin-top: 12px;">
            <label class="form-label" for="ultah">Tanggal Lahir:</label>
            <input id="ultah" name="ultah" class="w3-input w3-border w3-round" type="date"
                   style="text-align: center; max-width: 280px; margin: 0 auto;"
                   min="1990-01-01" max="2026-12-31" required />
          </div>

          <div style="margin-top: 20px;">
            <button id="login" type="submit" class="btn-action" style="padding: 10px 32px;">Login</button>
          </div>
        </form>
      </div>

      {{-- State: Cocok / Siap Mengisi (Bismillah) --}}
      <div id="bismillah" style="display: none;">
        <p class="w3-small">
          Assalamu'alaikum saudaraku<br>
          <b id="dari-awal-ga"></b>
        </p>

        <p id="sebar_p" class="w3-small" style="margin: 16px 0;">
          Tolong ingatkan temen-temen kamu untuk ngisi ini dulu yaa, syukron 🙏<br><br>
          <a id="sebar"
             href="https://api.whatsapp.com/send?text={{ rawurlencode($teksShareFordata) }}"
             target="_blank"
             rel="noopener noreferrer"
             class="btn-action" style="font-size: 0.85rem;">
            Ingatkan temanmu
          </a>
        </p>

        <div style="margin-top: 16px;">
          <a href="javascript:void(0)" id="gform"
             class="btn-action"
             style="font-size: 0.95rem; padding: 12px 28px; background-color: #2e7d32;">
            Isi FORDATA
          </a>
        </div>
      </div>

      {{-- State: Sudah Mengisi (Closed) --}}
      <div id="closed" style="display: none;">
        <p class="w3-small" style="line-height: 1.6;">
          Assalamu'alaikum saudaraku<br>
          Alhamdulillah kamu sudah submit {{ $sekarangFordata }} sebelumnya. Jazakumullah khair ya<br>
          Jangan lupa follow media sosial <span id="nama-lembaga-closed">LDK Syahid</span> yaa<br><br>
          <a id="linktree-btn" href="https://linktr.ee/ldksyahidjkt" target="_blank"
             class="btn-action">Buka Linktr.ee</a>
        </p>
      </div>
    </div>

    {{-- Footer --}}
    <div class="footer-credit">
      <div>
        Dibuat dengan mengharap Ridho Allah &#128591;
      </div>
      <div id="kel" style="display: none;">
        <button id="keluar" type="button" class="btn-action btn-logout">Keluar</button>
      </div>
    </div>
  </div>

  {{-- Modal Hasil Cek NIM --}}
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h3 style="font-size: 1.1rem; font-weight: 700; margin-top: 0; text-align: center;">Informasi NIM</h3>
      <p id="nnnim" style="text-align: center; font-size: 0.95rem; line-height: 1.5; margin-bottom: 0;"></p>
    </div>
  </div>

  <script>
    const CONFIG = {
      headerPusat: "{{ $gambarHeaderPusat }}",
      headerCSI: "{{ $gambarHeaderCSI }}",
      judulPusat: "FORDATA 2 - LDK Syahid",
      judulCSI: "FORDATA 2 - CSI FEB",
      checkUrl: "{{ route('fordata.check') }}",
      adminPusat: "{{ $kontakAdminPusat }}",
      adminCSI: "{{ $kontakAdminCSI }}",
      sekarangFordata: "{{ $sekarangFordata }}",
    };

    var nim = null;
    var ultah = null;
    var bolehlanjut = 0;
    var exportnim = {};
    var anak_mana = ["", ""];
    var yasabar = 0;

    try {
      nim = localStorage.getItem("fordata_nim") || localStorage.getItem("nim");
      ultah = localStorage.getItem("fordata_ultah") || localStorage.getItem("ultah");
    } catch(e) {
      console.log(e);
    }

    const myForm = document.getElementById('myform');
    const modal = document.getElementById("myModal");
    const btnCek = document.getElementById("cek");
    const spanClose = document.getElementsByClassName("close")[0];
    const btnKeluar = document.getElementById('keluar');

    btnKeluar.addEventListener('click', function() {
      keluarin();
      window.location.reload();
    });

    if (!nim) {
      myForm.style.display = 'block';
      myForm.addEventListener('submit', function(event) {
        event.preventDefault();
        anak_mana = cek();
        if (bolehlanjut) {
          nim = document.getElementById('nim').value.trim();
          ultah = document.getElementById('ultah').value.trim();
          try {
            localStorage.setItem("fordata_nim", nim);
            localStorage.setItem("fordata_ultah", ultah);
            localStorage.setItem("nim", nim);
            localStorage.setItem("ultah", ultah);
          } catch(e) { console.log(e); }
          serpersaided();
        } else {
          modal.style.display = "block";
        }
      });
    } else {
      document.getElementById('kel').style.display = 'block';
      document.getElementById('nim').value = nim;
      document.getElementById('ultah').value = ultah;
      anak_mana = cek();
      serpersaided();
    }

    function serpersaided() {
      document.getElementById('awalan').style.display = 'none';
      document.getElementById('loading').style.display = 'block';

      var anakmana = (anak_mana && anak_mana[0] === "Fakultas Ekonomi dan Bisnis (FEB)") ? 'csi' : 'pusat';

      yasabar = 3;
      timer();

      const params = new URLSearchParams({
        nim: nim,
        ultah: ultah,
        exportnim: JSON.stringify(exportnim),
        anakmana: anakmana
      });

      fetch(`${CONFIG.checkUrl}?${params.toString()}`, {
        method: "GET",
        headers: {
          "Accept": "application/json"
        }
      })
      .then(function(res) {
        if (!res.ok) {
          throw new Error('Server mengembalikan status ' + res.status);
        }
        return res.json();
      })
      .then(function(data) {
        antiredir(data);
      })
      .catch(function(err) {
        yahgagal(err);
      });
    }

    function timer() {
      setTimeout(function() {
        yasabar -= 0.5;
        if (yasabar > 0) timer();
      }, 500);
    }

    function antiredir(obj) {
      if (yasabar <= 0) {
        document.getElementById('loading').style.display = 'none';

        try {
          if (obj.ui) {
            document.getElementById(obj.ui).style.display = 'block';
          }
        } catch(e) {}

        if (obj.gambar) {
          document.getElementById('headerimg').src = obj.gambar;
        }
        if (obj.lembaga) {
          document.getElementById('judul-portal').innerHTML = 'FORDATA 2 - ' + obj.lembaga;
          var closedEl = document.getElementById('nama-lembaga-closed');
          if (closedEl) closedEl.innerHTML = obj.lembaga;
        }
        if (obj.linktree) {
          var linktreeEl = document.getElementById('linktree-btn');
          if (linktreeEl) linktreeEl.href = obj.linktree;
        }

        if (obj.ui === 'awalan') {
          // Tanggal lahir tidak cocok atau NIM belum terdaftar
          document.getElementById('kata2').innerHTML += '<br>' + obj.teks;
          document.getElementById('myform').style.display = 'block';
          document.getElementById('nim').value = nim || '';
          document.getElementById('ultah').value = ultah || '';
        }

        if (obj.ui === 'closed') {
          // Sudah submit sebelumnya
        }

        if (obj.ui === 'bismillah') {
          document.getElementById('dari-awal-ga').innerHTML = obj.teks;
          bolehinklikgform(obj);
          document.getElementById('sebar').addEventListener('click', function() {
            document.getElementById('sebar_p').style.display = 'none';
            bolehinklikgform(obj);
          });
        }

        document.getElementById('kata2').style.display = 'block';
        document.getElementById('kel').style.display = 'block';
      } else {
        setTimeout(function() {
          antiredir(obj);
        }, yasabar * 1000);
      }
    }

    function yahgagal(err) {
      var errorMsg = (err && err.message) ? err.message : (err || 'Koneksi gagal');
      console.error("Server Error:", err);

      if (yasabar <= 0) {
        var adminWA = (anak_mana && anak_mana[0] === "Fakultas Ekonomi dan Bisnis (FEB)") ? CONFIG.adminCSI : CONFIG.adminPusat;
        document.getElementById('loading').innerHTML =
          'Wah afwan ada kendala di server: <br><span style="color:#d32f2f; font-size:12px;">' + errorMsg + '</span><br><br>' +
          '<a href="javascript:window.location.reload(true)" class="btn-action" style="font-size:0.8rem; margin-right:6px;">Refresh Laman</a>' +
          '<a href="https://api.whatsapp.com/send?phone=' + adminWA + '&text=Lapor%20Kendala%20Fordata%20:%20' + encodeURIComponent(errorMsg) + '" target="_blank" class="btn-action" style="font-size:0.8rem; background-color:#25d366;">Laporkan ke Admin</a>';
      } else {
        setTimeout(function() {
          yahgagal(err);
        }, yasabar * 1000);
      }
    }

    function bolehinklikgform(obj) {
      const gformBtn = document.getElementById('gform');
      gformBtn.classList.remove('w3-disabled');
      gformBtn.href = obj.link;
      gformBtn.target = "_blank";
    }

    function keluarin() {
      try {
        localStorage.removeItem("fordata_nim");
        localStorage.removeItem("fordata_ultah");
        localStorage.removeItem("nim");
        localStorage.removeItem("ultah");
      } catch(e) { console.log(e); }
    }

    function validateNIM(rawNim) {
      var nimStr = (rawNim || '').toString().trim();
      var vnim = '{';

      const prodiMapping2025 = {
        "01": { fakultas: "Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", prodi: "Pendidikan Agama Islam" },
        "02": { fakultas: "Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", prodi: "Pendidikan Bahasa Arab" },
        "03": { fakultas: "Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", prodi: "Pendidikan Bahasa dan Sastra Indonesia" },
        "04": { fakultas: "Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", prodi: "Pendidikan Bahasa Inggris" },
        "05": { fakultas: "Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", prodi: "Pendidikan Ilmu Pengetahuan Sosial" },
        "06": { fakultas: "Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", prodi: "Pendidikan Matematika" },
        "07": { fakultas: "Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", prodi: "Pendidikan Biologi" },
        "08": { fakultas: "Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", prodi: "Pendidikan Kimia" },
        "09": { fakultas: "Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", prodi: "Pendidikan Fisika" },
        "10": { fakultas: "Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", prodi: "Manajemen Pendidikan" },
        "11": { fakultas: "Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", prodi: "Pendidikan Guru Madrasah Ibtidaiyah" },
        "12": { fakultas: "Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", prodi: "Pendidikan Islam Anak Usia Dini" },
        "13": { fakultas: "Fakultas Adab dan Humaniora (FAH)", prodi: "Bahasa dan Sastra Arab" },
        "14": { fakultas: "Fakultas Adab dan Humaniora (FAH)", prodi: "Sejarah Peradaban Islam" },
        "15": { fakultas: "Fakultas Adab dan Humaniora (FAH)", prodi: "Tarjamah" },
        "16": { fakultas: "Fakultas Adab dan Humaniora (FAH)", prodi: "Bahasa dan Sastra Inggris" },
        "17": { fakultas: "Fakultas Adab dan Humaniora (FAH)", prodi: "Ilmu Perpustakaan" },
        "18": { fakultas: "Fakultas Ushuluddin (FU)", prodi: "Studi Agama-Agama" },
        "19": { fakultas: "Fakultas Ushuluddin (FU)", prodi: "Aqidah dan Filsafat Islam" },
        "20": { fakultas: "Fakultas Ushuluddin (FU)", prodi: "Ilmu Al-Quran dan Tafsir" },
        "21": { fakultas: "Fakultas Ushuluddin (FU)", prodi: "Ilmu Hadist" },
        "22": { fakultas: "Fakultas Ushuluddin (FU)", prodi: "Ilmu Tasawuf" },
        "23": { fakultas: "Fakultas Syariah dan Hukum (FSH)", prodi: "Perbandingan Mazhab dan Hukum" },
        "24": { fakultas: "Fakultas Syariah dan Hukum (FSH)", prodi: "Hukum Keluarga Islam" },
        "25": { fakultas: "Fakultas Syariah dan Hukum (FSH)", prodi: "Ilmu hukum" },
        "26": { fakultas: "Fakultas Syariah dan Hukum (FSH)", prodi: "Hukum Ekonomi Syariah" },
        "27": { fakultas: "Fakultas Syariah dan Hukum (FSH)", prodi: "Hukum Tatanegara" },
        "28": { fakultas: "Fakultas Syariah dan Hukum (FSH)", prodi: "Hukum Pidana Islam" },
        "29": { fakultas: "Fakultas Dakwah dan Ilmu Komunikasi (FIDIKOM)", prodi: "Komunikasi dan Penyiaran Islam" },
        "30": { fakultas: "Fakultas Dakwah dan Ilmu Komunikasi (FIDIKOM)", prodi: "Jurnalistik" },
        "31": { fakultas: "Fakultas Dakwah dan Ilmu Komunikasi (FIDIKOM)", prodi: "Bimbingan dan Penyuluhan Islam" },
        "32": { fakultas: "Fakultas Dakwah dan Ilmu Komunikasi (FIDIKOM)", prodi: "Manajemen Dakwah" },
        "33": { fakultas: "Fakultas Dakwah dan Ilmu Komunikasi (FIDIKOM)", prodi: "Pengembangan Masyarakat Islam" },
        "34": { fakultas: "Fakultas Dakwah dan Ilmu Komunikasi (FIDIKOM)", prodi: "Kesejahteraan Sosial" },
        "35": { fakultas: "Fakultas Dirasat Islamiyah (FDI)", prodi: "Dirasat Islamiyah" },
        "36": { fakultas: "Fakultas Psikologi (FPSI)", prodi: "Psikologi" },
        "37": { fakultas: "Fakultas Ekonomi dan Bisnis (FEB)", prodi: "Manajemen" },
        "38": { fakultas: "Fakultas Ekonomi dan Bisnis (FEB)", prodi: "Akuntansi" },
        "39": { fakultas: "Fakultas Ekonomi dan Bisnis (FEB)", prodi: "Ekonomi Pembangunan" },
        "40": { fakultas: "Fakultas Ekonomi dan Bisnis (FEB)", prodi: "Perbankan Syariah" },
        "41": { fakultas: "Fakultas Ekonomi dan Bisnis (FEB)", prodi: "Ekonomi Syariah" },
        "42": { fakultas: "Fakultas Sains dan Teknologi (FST)", prodi: "Teknik Informatika" },
        "43": { fakultas: "Fakultas Sains dan Teknologi (FST)", prodi: "Agribisnis" },
        "44": { fakultas: "Fakultas Sains dan Teknologi (FST)", prodi: "Sistem Informatika" },
        "45": { fakultas: "Fakultas Sains dan Teknologi (FST)", prodi: "Matematika" },
        "47": { fakultas: "Fakultas Sains dan Teknologi (FST)", prodi: "Kimia" },
        "50": { fakultas: "Fakultas Ilmu Kesehatan (FIKES)", prodi: "Kesehatan Masyarakat" },
        "51": { fakultas: "Fakultas Ilmu Kesehatan (FIKES)", prodi: "Farmasi" },
        "54": { fakultas: "Fakultas Ilmu Sosial dan Ilmu Politik (FISIP)", prodi: "Ilmu Politik" },
        "55": { fakultas: "Fakultas Ilmu Sosial dan Ilmu Politik (FISIP)", prodi: "Ilmu Hubungan Internasional" }
      };

      // Deteksi format 2025+ (10 digit: 1XX1XX0XXX)
      if (nimStr.length === 10 && nimStr[0] === '1' && nimStr[3] === '1' && nimStr[6] === '0') {
        const angkatanCode = nimStr.slice(1, 3);
        const prodiCode = nimStr.slice(4, 6);
        const angkatan = 2000 + Number(angkatanCode);

        vnim += '"angkatan":"' + angkatan + '"';
        vnim += ',"ang_form":0';

        if (prodiMapping2025[prodiCode]) {
          const prodiInfo = prodiMapping2025[prodiCode];
          vnim += ',"id_fak":0';
          vnim += ',"fakultas":"' + prodiInfo.fakultas + '"';
          vnim += ',"jurusan":"' + prodiInfo.prodi + '"';
          vnim += ',"nim_format":"2025+"';
        } else {
          vnim += ',"status":0}';
          return JSON.parse(vnim);
        }
      } else {
        // Format lama 2018-2024 (14 digit)
        var parseNim = nimStr;
        if (Number(parseNim.slice(1, 2)) > 1) { parseNim = "0" + parseNim; }
        vnim += '"angkatan":"' + (Number(parseNim.slice(2, 4)) + 2000) + '"';
        vnim += ',"ang_form":0';
        vnim += ',"nim_format":"2018-2024"';

        var id_fak = Number(["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "13"].indexOf(parseNim.slice(4, 6)));
        vnim += ',"id_fak":' + id_fak + '';
        vnim += ',"fakultas":"' + (["Fakultas Ilmu Tarbiyah dan Keguruan (FITK)", "Fakultas Adab dan Humaniora (FAH)", "Fakultas Ushuluddin (FU)", "Fakultas Syariah dan Hukum (FSH)", "Fakultas Dakwah dan Ilmu Komunikasi (FIDIKOM)", "Fakultas Dirasat Islamiyah (FDI)", "Fakultas Psikologi (FPSI)", "Fakultas Ekonomi dan Bisnis (FEB)", "Fakultas Sains dan Teknologi (FST)", "Fakultas Ilmu Kesehatan (FIKES)", "Fakultas Ilmu Sosial dan Ilmu Politik (FISIP)", "Fakultas Kedokteran (FK)"][id_fak]) + '"';

        var temp_jur;
        if (Number(parseNim.slice(0, 1)) == 0) {
          temp_jur = (["0101", "0102", "0103", "0104", "0105", "0107", "0108", "0109", "0106", "0110", "0111", "0112", "0201", "0202", "0203", "0205", "0204", "0301", "0302", "0303", "0304", "0305", "0401", "0402", "0405", "0406", "0403", "0404", "0501", "0502", "0503", "0504", "0505", "0506", "0601", "0701", "0801", "0802", "0803", "0804", "0805", "0901", "0902", "0903", "0904", "0905", "0906", "0906", "0907", "1001", "1002", "1003", "1101", "1102", "1103", "1301"].indexOf(parseNim.slice(4, 8)));
        } else {
          temp_jur = (["0110", "0120", "0130", "0140", "0150", "0161", "0162", "0163", "0170", "0182", "0183", "0184", "0210", "0220", "0240", "0251", "0260", "0321", "0331", "0340", "0360", "0380", "0430", "0440", "0453", "0454", "0480", "0490", "0510", "0511", "0520", "0530", "0540", "0541", "0600", "0700", "0810", "0820", "0840", "0850", "0860", "0910", "0920", "0930", "0940", "0950", "0960", "0970", "0980", "1010", "1020", "1040", "1110", "1120", "1130", "1330"].indexOf(parseNim.slice(4, 8)));
        }
        vnim += ',"jurusan":"' + ["Pendidikan Agama Islam", "Pendidikan Bahasa Arab", "Pendidikan Bahasa dan Sastra Indonesia", "Pendidikan Bahasa Inggris", "Pendidikan Ilmu Pengetahuan Sosial", "Pendidikan Biologi", "Pendidikan Kimia", "Pendidikan Fisika", "Pendidikan Matematika", "Manajemen Pendidikan", "Pendidikan Guru Madrasah Ibtidaiyah", "Pendidikan Islam Anak Usia Dini", "Bahasa dan Sastra Arab", "Sejarah dan Kebudayaan Islam", "Tarjamah", "Ilmu Perpustakaan", "Bahasa dan Sastra Inggris", "Studi Agama-Agama", "Aqidah dan Filsafat Islam", "Ilmu Al-Quran dan Tafsir", "Ilmu Hadist", "Ilmu Tasawuf", "Perbandingan Mazhab dan Hukum", "Hukum Keluarga Islam", "Hukum Tatanegara", "Hukum Pidana Islam", "Ilmu hukum", "Hukum Ekonomi Syariah", "Komunikasi dan Penyiaran Islam", "Jurnalistik", "Bimbingan dan Penyuluhan Islam", "Manajemen Dakwah", "Pengembangan Masyarakat Islam", "Kesejahteraan Sosial", "Dirasat Islamiyah", "Psikologi", "Manajemen", "Akuntansi", "Studi pembangunan", "Perbankan Syariah", "Ekonomi Syariah", "Teknik Informatika", "Agribisnis", "Sistem Informatika", "Matematika", "Biologi", "Kimia", "Fisika", "Teknik Pertambangan", "Kesehatan Masyarakat", "Farmasi", "Ilmu Keperawatan", "Sosiologi", "Ilmu Politik", "Ilmu Hubungan Internasional", "Kedokteran"][temp_jur] + '"';
      }

      vnim += ',"nim":"' + nimStr + '"';
      vnim += ',"status":1}';
      vnim = JSON.parse(vnim);

      if (vnim.angkatan < 2018 || 2050 < vnim.angkatan) { vnim.status = 0; }
      if (!vnim.fakultas || vnim.fakultas === "undefined") { vnim.status = 0; }
      if (!vnim.jurusan || vnim.jurusan === "undefined") { vnim.status = 0; }

      return vnim;
    }

    function cek() {
      bolehlanjut = 0;
      var nnim = document.getElementById('nim').value.trim();
      if (!nnim) {
        nnim = nim || '';
      }

      const nimLen = nnim.length;
      const isFormat2025Plus = (nimLen === 10 && nnim[0] === '1' && nnim[3] === '1' && nnim[6] === '0');
      const isFormatLama = (nimLen === 14);

      if (nimLen < 10) {
        document.getElementById('nnnim').innerHTML = 'Yak terusin dulu... Masih kurang angkanya';
      } else if (isFormat2025Plus || isFormatLama) {
        var datanim = validateNIM(nnim);
        if (datanim.status === 1) {
          document.getElementById('nnnim').innerHTML = 'Angkatan ' + datanim.angkatan + '<br><b>' + datanim.fakultas + '</b><br>Jurusan ' + datanim.jurusan;
          bolehlanjut = 1;
          exportnim = {
            "fakultas": datanim.fakultas,
            "angkatan": datanim.angkatan,
            "jurusan": datanim.jurusan,
            "nim": nnim
          };

          // Dynamic branding: Switch banner and title based on faculty
          if (datanim.fakultas === "Fakultas Ekonomi dan Bisnis (FEB)") {
            document.getElementById('headerimg').src = CONFIG.headerCSI;
            document.getElementById('judul-portal').innerHTML = CONFIG.judulCSI;
            document.getElementById('html-title').innerHTML = CONFIG.judulCSI;
          } else {
            document.getElementById('headerimg').src = CONFIG.headerPusat;
            document.getElementById('judul-portal').innerHTML = CONFIG.judulPusat;
            document.getElementById('html-title').innerHTML = CONFIG.judulPusat;
          }

          return [datanim.fakultas, datanim.angkatan];
        } else {
          document.getElementById('nnnim').innerHTML = 'Format NIM tidak dikenali, coba periksa kembali ya';
        }
      } else {
        document.getElementById('nnnim').innerHTML = 'Cek format NIM kamu (10 digit untuk 2025+ atau 14 digit untuk angkatan sebelumnya)';
      }

      return ["", ""];
    }

    btnCek.onclick = function() {
      cek();
      modal.style.display = "block";
    };

    spanClose.onclick = function() {
      modal.style.display = "none";
    };

    window.onclick = function(event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    };
  </script>
</body>

</html>

