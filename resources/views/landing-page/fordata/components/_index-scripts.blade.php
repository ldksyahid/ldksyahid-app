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
  const btnCloseModal = document.getElementById("modal-close");
  const btnOkModal = document.getElementById("modal-ok-btn");
  const btnKeluar = document.getElementById('keluar');
  const nimInput = document.getElementById('nim');
  const ultahInput = document.getElementById('ultah');
  const nimBadge = document.getElementById('nim-badge');
  const nimBadgeText = document.getElementById('nim-badge-text');

  btnKeluar.addEventListener('click', function() {
    keluarin();
    window.location.reload();
  });

  // Real-time NIM check saat user selesai mengetik (on input / on blur)
  nimInput.addEventListener('input', function() {
    const val = this.value.trim();
    if (val.length === 10 || val.length === 14) {
      cek(false);
    } else {
      nimBadge.style.display = 'none';
    }
  });

  if (!nim) {
    myForm.style.display = 'block';
    myForm.addEventListener('submit', function(event) {
      event.preventDefault();
      anak_mana = cek(true);
      if (bolehlanjut) {
        nim = nimInput.value.trim();
        ultah = ultahInput.value.trim();
        try {
          localStorage.setItem("fordata_nim", nim);
          localStorage.setItem("fordata_ultah", ultah);
          localStorage.setItem("nim", nim);
          localStorage.setItem("ultah", ultah);
        } catch(e) { console.log(e); }
        serpersaided();
      }
    });
  } else {
    document.getElementById('kel').style.display = 'block';
    nimInput.value = nim;
    ultahInput.value = ultah;
    anak_mana = cek(false);
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
        const alertBox = document.getElementById('alert-awalan');
        alertBox.style.display = 'block';
        document.getElementById('kata2').innerHTML = obj.teks;
        document.getElementById('awalan').style.display = 'block';
        myForm.style.display = 'block';
        nimInput.value = nim || '';
        ultahInput.value = ultah || '';
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
        '<div class="result-box warning" style="text-align:center;">' +
        '<i class="fa-solid fa-triangle-exclamation" style="font-size:1.5rem; display:block; margin-bottom:8px; color:#d97706;"></i>' +
        '<strong>Wah afwan ada kendala di server:</strong><br>' +
        '<span style="font-size:12px; color:#b91c1c;">' + errorMsg + '</span><br><br>' +
        '<div style="display:flex; gap:8px; justify-content:center; flex-wrap:wrap;">' +
        '<a href="javascript:window.location.reload(true)" class="btn-primary-action" style="width:auto; height:38px; font-size:0.8rem; padding:0 16px;">Refresh Laman</a>' +
        '<a href="https://api.whatsapp.com/send?phone=' + adminWA + '&text=Lapor%20Kendala%20Fordata%20:%20' + encodeURIComponent(errorMsg) + '" target="_blank" class="btn-primary-action btn-wa-share" style="width:auto; height:38px; font-size:0.8rem; padding:0 16px;">Laporkan ke Admin</a>' +
        '</div></div>';
    } else {
      setTimeout(function() {
        yahgagal(err);
      }, yasabar * 1000);
    }
  }

  function bolehinklikgform(obj) {
    const gformBtn = document.getElementById('gform');
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

  function cek(openModalIfError = false) {
    bolehlanjut = 0;
    var nnim = nimInput.value.trim();
    if (!nnim) {
      nnim = nim || '';
    }

    const nimLen = nnim.length;
    const isFormat2025Plus = (nimLen === 10 && nnim[0] === '1' && nnim[3] === '1' && nnim[6] === '0');
    const isFormatLama = (nimLen === 14);

    if (nimLen < 10) {
      document.getElementById('nnnim').innerHTML = '<span style="color:#d97706;"><i class="fa-solid fa-circle-info"></i> Masih kurang digit angkanya, lanjutkan yaa...</span>';
      nimBadge.style.display = 'none';
      if (openModalIfError) modal.style.display = "flex";
    } else if (isFormat2025Plus || isFormatLama) {
      var datanim = validateNIM(nnim);
      if (datanim.status === 1) {
        bolehlanjut = 1;
        exportnim = {
          "fakultas": datanim.fakultas,
          "angkatan": datanim.angkatan,
          "jurusan": datanim.jurusan,
          "nim": nnim
        };

        // Update inline badge
        nimBadge.style.display = 'block';
        nimBadgeText.innerHTML = `<strong>Angkatan ${datanim.angkatan}</strong> • ${datanim.fakultas} — ${datanim.jurusan}`;

        // Update modal content
        document.getElementById('nnnim').innerHTML =
          `<div style="background:#f3f4f6; padding:12px; border-radius:12px; margin-bottom:8px;">` +
          `<div style="font-weight:700; color:#111827; font-size:1.05rem;">Angkatan ${datanim.angkatan}</div>` +
          `<div style="color:#4b5563; font-weight:600; margin-top:2px;">${datanim.fakultas}</div>` +
          `<div style="color:#6b7280; font-size:0.85rem;">${datanim.jurusan}</div>` +
          `</div>`;

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
        document.getElementById('nnnim').innerHTML = '<span style="color:#dc2626;"><i class="fa-solid fa-triangle-exclamation"></i> Format NIM tidak dikenali, coba periksa kembali ya</span>';
        nimBadge.style.display = 'none';
        if (openModalIfError) modal.style.display = "flex";
      }
    } else {
      document.getElementById('nnnim').innerHTML = '<span style="color:#d97706;"><i class="fa-solid fa-circle-question"></i> Periksa format NIM kamu (10 digit untuk 2025+ atau 14 digit untuk angkatan sebelumnya)</span>';
      nimBadge.style.display = 'none';
      if (openModalIfError) modal.style.display = "flex";
    }

    return ["", ""];
  }

  btnCek.onclick = function() {
    cek(false);
    modal.style.display = "flex";
  };

  btnCloseModal.onclick = function() {
    modal.style.display = "none";
  };

  btnOkModal.onclick = function() {
    modal.style.display = "none";
    if (bolehlanjut) {
      ultahInput.focus();
    }
  };

  window.onclick = function(event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  };
</script>
