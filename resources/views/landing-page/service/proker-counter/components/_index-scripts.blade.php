{{-- ============================================================
     code.js by Yuda (moved from public/proker-counter-by-yuda-ext-rsrc/js/code.js)
     Must be a separate <script> block so the global functions
     (refreshValue, tambah_pelaksanaan, etc.) are declared before
     the DOMContentLoaded block below.
     ============================================================ --}}
<script>
const roundAccurately = (number, decimalPlaces) => Number(Math.round(number + "e" + decimalPlaces) + "e-" + decimalPlaces);
const average = arr => arr.reduce((acc,v) => acc + v) / arr.length;

function formatRupiah(input) {
  var raw = input.value.replace(/\D/g, '');
  input.value = raw ? raw.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
}
function parseRupiah(val) { return parseFloat((val || '').replace(/\./g, '')); }

var bahan_hitung = {"proker" : [{
  "namaproker" : "",
  "jumlah_pelaksanaan" : 1,
  "aspek_nilai" : {
    "sesuai_rencana" : {
      "deskripsi_program" : [{"deskripsi" : "", "terlaksana" : [false]}]
    },

    "sesuai_tujuansasaran" : {
      "tujuan" : [{"deskripsi" : "", "terlaksana" : [false]}],
      "sasaran" : [{"deskripsi" : "", "terlaksana" : [false]}]
    },

    "sesuai_waktutempat" : {
      "waktu" : {
        "tanggal" : [{"opsi" : 0, "persen" : 0}],
        "jam" : [{"opsi" : 0, "persen" : 0}]
      },
      "tempat" : [{"namatempat" : "", "sesuai" : [false]}]
    },

    "sesuai_parameter" : {
      "parameter" : [{"realisasi" : [0], "estimasi" : 0, "satuan" : ""}]
    },

    "efisiensi_dana" : {
      "estimasi_dana" : 0,
      "realisasi_dana" : [0],
      "skala_penurunan" : 4
    }
  },
  "total_persentase" : 0
}]}

var proker_tunggal = {
  "namaproker" : "",
  "jumlah_pelaksanaan" : 1,
  "aspek_nilai" : [{
    "sesuai_rencana" : {
      "deskripsi_program" : [{"deskripsi" : "", "terlaksana" : false}]
    },

    "sesuai_tujuansasaran" : {
      "tujuan" : [{"deskripsi" : "", "terlaksana" : false}],
      "sasaran" : [{"deskripsi" : "", "terlaksana" : false}]
    },

    "sesuai_waktutempat" : {
      "waktu" : {
        "tanggal" : {"opsi" : 0, "persen" : 0},
        "jam" : {"opsi" : 0, "persen" : 0}
      },
      "tempat" : [{"namatempat" : 0, "sesuai" : false}]
    },

    "sesuai_parameter" : {
      "parameter" : [{"realisasi" : 0, "estimasi" : 0, "satuan" : ""}]
    },

    "efisiensi_dana" : {
      "estimasi_dana" : 0,
      "realisasi_dana" : [0],
      "skala_penurunan" : 4
    }
  }],
  "total_persentase" : 0
}

function hitung_sesuai_rencana(){
  var rencana = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_rencana"]["deskripsi_program"];
  var pelaksanaan = [];
  var terlaksana = 0;

  rencana.forEach((rc, i) => {
    rc["terlaksana"].forEach((tr, i) => {
      if(tr){
        terlaksana += 1;
      }
    });

    pelaksanaan.push(terlaksana);
    terlaksana = 0;
  });

  var jumlah_pelaksanaan = parseInt(bahan_hitung["proker"][0]["jumlah_pelaksanaan"]);
  var hasil = pelaksanaan.map(x => roundAccurately((x/jumlah_pelaksanaan)*100, 2));

  return hasil;
}

function hitung_sesuai_tujuan(){
  var rencana = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_tujuansasaran"]["tujuan"];
  var pelaksanaan = [];
  var terlaksana = 0;

  rencana.forEach((rc, i) => {
    rc["terlaksana"].forEach((tr, i) => {
      if(tr){
        terlaksana += 1;
      }
    });

    pelaksanaan.push(terlaksana);
    terlaksana = 0;
  });

  var jumlah_pelaksanaan = parseInt(bahan_hitung["proker"][0]["jumlah_pelaksanaan"]);
  var hasil = pelaksanaan.map(x => roundAccurately((x/jumlah_pelaksanaan)*100, 2));

  return hasil;
}

function hitung_sesuai_sasaran(){
  var rencana = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_tujuansasaran"]["sasaran"];
  var pelaksanaan = [];
  var terlaksana = 0;

  rencana.forEach((rc, i) => {
    rc["terlaksana"].forEach((tr, i) => {
      if(tr){
        terlaksana += 1;
      }
    });

    pelaksanaan.push(terlaksana);
    terlaksana = 0;
  });

  var jumlah_pelaksanaan = parseInt(bahan_hitung["proker"][0]["jumlah_pelaksanaan"]);
  var hasil = pelaksanaan.map(x => roundAccurately((x/jumlah_pelaksanaan)*100, 2));

  return hasil;
}

function hitung_sesuai_waktutempat(){
  var tanggal = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["waktu"]["tanggal"];
  var jam = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["waktu"]["jam"];
  var tempat = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["tempat"];

  var jumlah_pelaksanaan = parseInt(bahan_hitung["proker"][0]["jumlah_pelaksanaan"]);
  var semua_tanggal = [];
  var semua_jam = [];
  var semua_tempat = [];
  var setiap_tempat = 0;

  tanggal.forEach((tgl, i) => {
    semua_tanggal.push(parseInt(tgl["persen"]));
  });

  jam.forEach((jm, i) => {
    semua_jam.push(parseInt(jm["persen"]));
  });

  tempat.forEach((tmp, i) => {
    tmp["sesuai"].forEach((suai, i) => {
      if(suai){
        setiap_tempat += 1;
      } else {
        setiap_tempat += 0.5;
      }
    });

    semua_tempat.push(setiap_tempat);
    setiap_tempat = 0;
  });

  var hasil_tanggal = semua_tanggal;
  var hasil_jam = semua_jam;
  var hasil_tempat = semua_tempat.map(x => roundAccurately((x/jumlah_pelaksanaan)*50, 2))

  return [hasil_tanggal, hasil_jam, hasil_tempat];
}

function hitung_sesuai_parameter(){
  var rencana = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_parameter"]["parameter"];
  var semua_estimasi = [];
  var semua_realisasi = [];

  rencana.forEach((rc, i) => {
    var estimasi = parseFloat(rc["estimasi"]);

    semua_estimasi.push(estimasi);

    var tiap_realisasi = [];
    var realisasi = 0;

    rc["realisasi"].forEach((re, j) => {
      realisasi = parseFloat(re);

      if(realisasi > semua_estimasi[i]){
        tiap_realisasi.push(semua_estimasi[i]);
      } else {
        tiap_realisasi.push(realisasi);
      }

      realisasi = 0;
    });
    semua_realisasi.push(roundAccurately(average(tiap_realisasi), 2));
  });

  var persen_parameter = semua_realisasi.map((x, i) => {
    return (x/semua_estimasi[i])*100;
  });

  return persen_parameter;
}

function hitung_estimasi_dana(esti, real, scale){
  var esti = esti;
  var real = real;
  var scale = scale;

  var seluruh_percent = [];
  var seluruh_result = [];

  real.forEach((rl, i) => {
    seluruh_percent[i] = rl / esti;

    seluruh_result[i] = 0;

    if (esti == 0) {
      seluruh_result[i] = 0;
    } else
    if (rl < esti) {
      seluruh_result[i] = seluruh_percent[i];
    } else if (rl > esti) {
      diff = seluruh_percent[i] - 1;
      seluruh_result[i] = 1 - diff*scale;

      if (seluruh_result[i] < 0 || seluruh_result[i] == 0) {
        seluruh_result[i] = 0;
      }
    } else {
      seluruh_result[i] = 1;
    }
  });
  return seluruh_result.map(x => roundAccurately(x*100, 2));
}

function tambah_pelaksanaan(nomorproker) {
  var parent = document.querySelector("article.proker div[id='proker_"+ nomorproker +"']");

  var direncanakan = parseInt(bahan_hitung["proker"][0]["jumlah_pelaksanaan"]);

  function cloneExecItem(wadah) {
    var item = wadah.querySelector("label.kk-exec-item");
    if (item) {
      var cl = item.cloneNode(true);
      cl.querySelector("input[name='terlaksana']").checked = false;
      var numSpan = cl.querySelector(".kk-exec-num");
      if (numSpan) numSpan.textContent = direncanakan + 1;
      return cl;
    }
    return wadah.querySelector("input[name='terlaksana']").cloneNode(true);
  }

  function cloneRealisasiItem(wadah) {
    var row = wadah.querySelector(".kk-realisasi-row");
    if (row) {
      var cl = row.cloneNode(true);
      var lbl = cl.querySelector(".kk-realisasi-label");
      if (lbl) lbl.textContent = "Ke-" + (direncanakan + 1);
      var inp = cl.querySelector("input");
      if (inp) inp.value = "";
      return cl;
    }
    return wadah.querySelector("input").cloneNode(true);
  }

  // Update ALL entries (deskripsi/tujuan/sasaran/tempat can be added multiple times)
  parent.querySelectorAll("div[class='deskripsi']").forEach(function(wadah) {
    wadah.appendChild(cloneExecItem(wadah));
  });
  parent.querySelectorAll("div[class='tujuan']").forEach(function(wadah) {
    wadah.appendChild(cloneExecItem(wadah));
  });
  parent.querySelectorAll("div[class='sasaran']").forEach(function(wadah) {
    wadah.appendChild(cloneExecItem(wadah));
  });
  parent.querySelectorAll("div[class='tempat']").forEach(function(wadah) {
    wadah.appendChild(cloneExecItem(wadah));
  });
  parent.querySelectorAll("div[class='parameter']").forEach(function(wadah) {
    wadah.appendChild(cloneRealisasiItem(wadah));
  });

  var wadah_tanggal = parent.querySelector("div[class='tanggal']");
  var wadah_jam = parent.querySelector("div[class='jam']");
  var wadah_akurasi = parent.querySelector("div[class='akurasi']");

  var clone_tanggal = wadah_tanggal.querySelector(".kk-wt-row").cloneNode(true);
  var tglRowLabel = clone_tanggal.querySelector(".kk-wt-row-label");
  if (tglRowLabel) tglRowLabel.textContent = "Ke-" + (direncanakan + 1);
  clone_tanggal.querySelectorAll("input[type='radio']").forEach(function(item) {
    item.setAttribute("name", "tanggal_"+ (direncanakan + 1));
    item.checked = false;
  });

  var clone_jam = wadah_jam.querySelector(".kk-wt-row").cloneNode(true);
  var jamRowLabel = clone_jam.querySelector(".kk-wt-row-label");
  if (jamRowLabel) jamRowLabel.textContent = "Ke-" + (direncanakan + 1);
  clone_jam.querySelectorAll("input[type='radio']").forEach(function(item) {
    item.setAttribute("name", "jam_"+ (direncanakan + 1));
    item.checked = false;
  });

  wadah_tanggal.appendChild(clone_tanggal);
  wadah_jam.appendChild(clone_jam);
  wadah_akurasi.appendChild(cloneRealisasiItem(wadah_akurasi));

  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_rencana"]["deskripsi_program"][0]["terlaksana"].push(false);
  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_tujuansasaran"]["tujuan"][0]["terlaksana"].push(false);
  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_tujuansasaran"]["sasaran"][0]["terlaksana"].push(false);
  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["tempat"][0]["sesuai"].push(false);
  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_parameter"]["parameter"][0]["realisasi"].push(0);
  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["waktu"]["tanggal"].push({"opsi": 0, "persen": 0});
  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["waktu"]["jam"].push({"opsi": 0, "persen": 0});
  bahan_hitung["proker"][0]["aspek_nilai"]["efisiensi_dana"]["realisasi_dana"].push(0);

  bahan_hitung["proker"][0]["jumlah_pelaksanaan"] += 1;
}

function kurang_pelaksanaan(nomorproker) {
  var parent = document.querySelector("article.proker div[id='proker_"+ nomorproker +"']");

  if (parseInt(bahan_hitung["proker"][0]["jumlah_pelaksanaan"]) <= 1) {
    return console.log("Cannot remove the only one child");
  }

  // Remove last exec item from ALL entries
  parent.querySelectorAll("div[class='deskripsi']").forEach(function(wadah) {
    if (wadah.lastElementChild) wadah.removeChild(wadah.lastElementChild);
  });
  parent.querySelectorAll("div[class='tujuan']").forEach(function(wadah) {
    if (wadah.lastElementChild) wadah.removeChild(wadah.lastElementChild);
  });
  parent.querySelectorAll("div[class='sasaran']").forEach(function(wadah) {
    if (wadah.lastElementChild) wadah.removeChild(wadah.lastElementChild);
  });
  parent.querySelectorAll("div[class='tempat']").forEach(function(wadah) {
    if (wadah.lastElementChild) wadah.removeChild(wadah.lastElementChild);
  });
  parent.querySelectorAll("div[class='parameter']").forEach(function(wadah) {
    if (wadah.lastElementChild) wadah.removeChild(wadah.lastElementChild);
  });

  var wadah_tanggal = parent.querySelector("div[class='tanggal']");
  var wadah_jam = parent.querySelector("div[class='jam']");
  var wadah_akurasi = parent.querySelector("div[class='akurasi']");

  wadah_tanggal.removeChild(wadah_tanggal.lastElementChild);
  wadah_jam.removeChild(wadah_jam.lastElementChild);
  wadah_akurasi.removeChild(wadah_akurasi.lastElementChild);

  bahan_hitung["proker"][0]["jumlah_pelaksanaan"] -= 1;

  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_rencana"]["deskripsi_program"][0]["terlaksana"].pop();
  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_tujuansasaran"]["tujuan"][0]["terlaksana"].pop();
  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_tujuansasaran"]["sasaran"][0]["terlaksana"].pop();
  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["waktu"]["tanggal"].pop();
  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["waktu"]["jam"].pop();
  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["tempat"][0]["sesuai"].pop();
  bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_parameter"]["parameter"][0]["realisasi"].pop();
  bahan_hitung["proker"][0]["aspek_nilai"]["efisiensi_dana"]["realisasi_dana"].pop();
}

function tambah_deskripsi(nomorproker){
  var parent = document.querySelector("article.proker div[id='proker_"+ nomorproker +"']");
  var child = parent.querySelector("div.rencana div.unsur");
  var blueprint_element = child.lastElementChild;

  var myRegexp = /_(.*)/;
  number = myRegexp.exec(blueprint_element.id)[1];
  number = parseFloat(number) + 1;

  var deskripsi = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_rencana"]["deskripsi_program"]
  deskripsi.push(deskripsi[0]);

  var new_element = document.createElement("div")
  new_element.setAttribute("id", "deskripsi_" + (number));
  new_element.innerHTML = blueprint_element.innerHTML;
  var entryNum = new_element.querySelector('.kk-entry-num');
  if (entryNum) entryNum.textContent = 'Ke-' + number;

  child.appendChild(new_element);
}

function kurang_deskripsi(nomorproker){
  var parent = document.querySelector("article.proker div[id='proker_"+ nomorproker +"']");
  var child = parent.querySelector("div.rencana div.unsur");
  var to_remove = child.lastElementChild;

  var myRegexp = /_(.*)/;
  number = myRegexp.exec(to_remove.id)[1];

  if (number == 1){
    return console.log("Cannot remove this node, this is the last node!");
  }

  var deskripsi = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_rencana"]["deskripsi_program"]
  deskripsi.pop();

  to_remove.remove();
}

function tambah_tujuan(nomorproker){
  var parent = document.querySelector("article.proker div[id='proker_"+ nomorproker +"']");
  var child = parent.querySelector("div.tujuansasaran div.tujuan");
  var blueprint_element = child.lastElementChild;

  var myRegexp = /_(.*)/;
  number = myRegexp.exec(blueprint_element.id)[1];
  number = parseFloat(number) + 1;

  var tujuan = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_tujuansasaran"]["tujuan"]
  tujuan.push(tujuan[0]);

  var new_element = document.createElement("div")
  new_element.setAttribute("id", "tujuan_" + (number));
  new_element.innerHTML = blueprint_element.innerHTML;
  var entryNum = new_element.querySelector('.kk-entry-num');
  if (entryNum) entryNum.textContent = 'Ke-' + number;

  child.appendChild(new_element);
}

function kurang_tujuan(nomorproker){
  var parent = document.querySelector("article.proker div[id='proker_"+ nomorproker +"']");
  var child = parent.querySelector("div.tujuansasaran div.tujuan");
  var to_remove = child.lastElementChild;

  var myRegexp = /_(.*)/;
  number = myRegexp.exec(to_remove.id)[1];

  if (number == 1){
    return console.log("Cannot remove this node, this is the last node!");
  }

  var tujuan = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_tujuansasaran"]["tujuan"]
  tujuan.pop();

  to_remove.remove();
}

function tambah_sasaran(nomorproker){
  var parent = document.querySelector("article.proker div[id='proker_"+ nomorproker +"']");
  var child = parent.querySelector("div.tujuansasaran div.sasaran");
  var blueprint_element = child.lastElementChild;

  var myRegexp = /_(.*)/;
  number = myRegexp.exec(blueprint_element.id)[1];
  number = parseFloat(number) + 1;

  var sasaran = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_tujuansasaran"]["sasaran"]
  sasaran.push(sasaran[0]);

  var new_element = document.createElement("div")
  new_element.setAttribute("id", "sasaran_" + (number));
  new_element.innerHTML = blueprint_element.innerHTML;
  var entryNum = new_element.querySelector('.kk-entry-num');
  if (entryNum) entryNum.textContent = 'Ke-' + number;

  child.appendChild(new_element);
}

function kurang_sasaran(nomorproker){
  var parent = document.querySelector("article.proker div[id='proker_"+ nomorproker +"']");
  var child = parent.querySelector("div.tujuansasaran div.sasaran");
  var to_remove = child.lastElementChild;

  var myRegexp = /_(.*)/;
  number = myRegexp.exec(to_remove.id)[1];

  if (number == 1){
    return console.log("Cannot remove this node, this is the last node!");
  }

  var sasaran = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_tujuansasaran"]["sasaran"]
  sasaran.pop();

  to_remove.remove();
}

function tambah_tempat(nomorproker){
  var parent = document.querySelector("article.proker div[id='proker_"+ nomorproker +"']");
  var child = parent.querySelector("div.waktutempat div.tempat");
  var blueprint_element = child.lastElementChild;

  var myRegexp = /_(.*)/;
  number = myRegexp.exec(blueprint_element.id)[1];
  number = parseFloat(number) + 1;

  var tempat = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["tempat"]
  tempat.push(tempat[0]);

  var new_element = document.createElement("div")
  new_element.setAttribute("id", "tempat_" + (number));
  new_element.innerHTML = blueprint_element.innerHTML;
  var entryNum = new_element.querySelector('.kk-entry-num');
  if (entryNum) entryNum.textContent = 'Ke-' + number;

  child.appendChild(new_element);
}

function kurang_tempat(nomorproker){
  var parent = document.querySelector("article.proker div[id='proker_"+ nomorproker +"']");
  var child = parent.querySelector("div.waktutempat div.tempat");
  var to_remove = child.lastElementChild;

  var myRegexp = /_(.*)/;
  number = myRegexp.exec(to_remove.id)[1];

  if (number == 1){
    return console.log("Cannot remove this node, this is the last node!");
  }

  var tempat = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["tempat"]
  tempat.pop();

  to_remove.remove();
}

function tambah_parameter(nomorproker){
  var parent = document.querySelector("article.proker div[id='proker_"+ nomorproker +"']");
  var child = parent.querySelector("div.parameter div.unsur");
  var blueprint_element = child.lastElementChild;

  var myRegexp = /_(.*)/;
  number = myRegexp.exec(blueprint_element.id)[1];
  number = parseFloat(number) + 1;

  var parameter = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_parameter"]["parameter"]
  parameter.push(parameter[0]);

  var new_element = document.createElement("div");
  new_element.setAttribute("id", "parameter_" + (number));
  new_element.innerHTML = blueprint_element.innerHTML;
  var entryNum = new_element.querySelector('.kk-entry-num');
  if (entryNum) entryNum.textContent = 'Ke-' + number;

  child.appendChild(new_element);
}

function kurang_parameter(nomorproker){
  var parent = document.querySelector("article.proker div[id='proker_"+ nomorproker +"']");
  var child = parent.querySelector("div.parameter div.unsur");
  var to_remove = child.lastElementChild;

  var myRegexp = /_(.*)/;
  number = myRegexp.exec(to_remove.id)[1];

  if (number == 1){
    return console.log("Cannot remove this node, this is the last node!");
  }

  var parameter = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_parameter"]["parameter"]
  parameter.pop();

  to_remove.remove();
}

function refreshValue(){
  var pelaksanaan = parseInt(bahan_hitung["proker"][0]["jumlah_pelaksanaan"]);
  document.querySelector("p[id='jumlah_pelaksanaan']").innerHTML = pelaksanaan;

  bahan_hitung["proker"][0]["namaproker"] = document.getElementById('proker1').value;

  // 0. Jumlah Pelaksanaan
  var parent = document.querySelector("article.proker div[id='proker_"+ 1 +"']");
  var child = parent.querySelector("p[id='jumlah_pelaksanaan']");
  child.innerHTML = bahan_hitung["proker"][0]["jumlah_pelaksanaan"];

  // 1. Kesesuaian Rencana
  var parent = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_rencana"]["deskripsi_program"];

  parent.forEach((item, i) => {
    var list_terlaksana = document.querySelectorAll("#deskripsi_" + parseFloat(i+1) + " input[type='checkbox']");
    var item_terlaksana = []
    list_terlaksana.forEach((list, j) => {
      item_terlaksana[j] = list.checked;
    });
    var item_deskripsi = document.querySelector("#deskripsi_" + parseFloat(i+1) + " input[type='text']").value

    parent[i] = {"deskripsi" : item_deskripsi, "terlaksana" : item_terlaksana};
  })

  // 2. Kesesuaian Tujuan dan Sasaran
  var parent = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_tujuansasaran"]["tujuan"];
  parent.forEach((item, i) => {
    var list_terlaksana = document.querySelectorAll("#tujuan_" + parseFloat(i+1) + " input[type='checkbox']");
    var item_terlaksana = []
    list_terlaksana.forEach((list, j) => {
      item_terlaksana[j] = list.checked;
    });

    var item_deskripsi = document.querySelector("#tujuan_" + parseFloat(i+1) + " input[type='text']").value
    parent[i] = {"deskripsi" : item_deskripsi, "terlaksana" : item_terlaksana};
  })

  var parent = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_tujuansasaran"]["sasaran"];
  parent.forEach((item, i) => {
    var list_terlaksana = document.querySelectorAll("#sasaran_" + parseFloat(i+1) + " input[type='checkbox']");
    var item_terlaksana = []
    list_terlaksana.forEach((list, j) => {
      item_terlaksana[j] = list.checked;
    });

    var item_deskripsi = document.querySelector("#sasaran_" + parseFloat(i+1) + " input[type='text']").value
    parent[i] = {"deskripsi" : item_deskripsi, "terlaksana" : item_terlaksana};
  })

  // 3. Kesesuaian waktu dan tempat
  var parent = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["waktu"]["tanggal"];

  parent.forEach((item, i) => {
    var list_tanggal = document.querySelectorAll("input[name^='tanggal_"+ (i+1) +"']");
    var list_id = [];
    var list_value = [];

    list_tanggal.forEach((item, i) => {
      if (item.checked){
        list_id[i] = item.id;
        list_value[i] = item.value;
      }
    });

    var filtered_id = list_id.filter(function (el) {return el != null});
    var filtered_value = list_value.filter(function (el) {return el != null});

    parent[i] = {"opsi" : filtered_id[0], "persen" : filtered_value[0]};
  })

  var parent = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["waktu"]["jam"];

  parent.forEach((item, i) => {
    var list_jam = document.querySelectorAll("input[name^='jam_"+ (i+1) +"']");
    var list_id = [];
    var list_value = [];

    list_jam.forEach((item, i) => {
      if (item.checked){
        list_id[i] = item.id;
        list_value[i] = item.value;
      }
    });

    var filtered_id = list_id.filter(function (el) {return el != null});
    var filtered_value = list_value.filter(function (el) {return el != null});

    parent[i] = {"opsi" : filtered_id[0], "persen" : filtered_value[0]};
  })

  // 3. tempat
  var parent = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_waktutempat"]["tempat"];
  parent.forEach((item, i) => {
    var list_terlaksana = document.querySelectorAll("#tempat_" + parseFloat(i+1) + " input[type='checkbox']");
    var item_terlaksana = []
    list_terlaksana.forEach((list, j) => {
      item_terlaksana[j] = list.checked;
    });
    var item_deskripsi = document.querySelector("#tempat_" + parseFloat(i+1) + " input[type='text']").value

    parent[i] = {"namatempat" : item_deskripsi, "sesuai" : item_terlaksana};
  })

  // 4. Kesesuaian Parameter Keberhasilan
  var parent = bahan_hitung["proker"][0]["aspek_nilai"]["sesuai_parameter"]["parameter"];

  parent.forEach((item, i) => {
    var list_realisasi = document.querySelectorAll("#parameter_" + parseFloat(i+1) + " input[id='realisasi_parameter']");
    var item_realisasi = [];
    list_realisasi.forEach((list, j) => {
      item_realisasi[j] = (list.value || '').replace(/\./g, '');
    });
    var item_estimasi = (document.querySelector("#parameter_" + parseFloat(i+1) + " input[id='estimasi_parameter']").value || '').replace(/\./g, '');
    var item_satuan = document.querySelector("#parameter_" + parseFloat(i+1) + " input[name='parameter']").value;

    parent[i] = {"realisasi" : item_realisasi, "estimasi" : item_estimasi, "satuan" : item_satuan};
  })

  // 5. Efisiensi Dana
  var parent = bahan_hitung["proker"][0]["aspek_nilai"];

  var list_realisasi_dana = document.querySelectorAll("div.efisiensi_dana input[id='realisasi_dana']");
  var item_realisasi_dana = [];
  list_realisasi_dana.forEach((list, j) => {
    item_realisasi_dana[j] = parseRupiah(list.value);
  });

  var item_estimasi = parseRupiah(document.querySelector("div.efisiensi_dana input[id='estimasi_dana']").value);
  var item_skalaturun = parseFloat(document.querySelector("div.efisiensi_dana input[id='skala_penurunan']").placeholder);

  var esti = item_estimasi;
  var real = item_realisasi_dana;
  var scale = item_skalaturun;

  parent["efisiensi_dana"] = {"estimasi_dana" : item_estimasi, "realisasi_dana" : item_realisasi_dana, "skala_penurunan" : item_skalaturun};

  // Helper: tampilkan '-' jika nilai NaN/undefined, gunakan 0 untuk kalkulasi
  function safeVal(v) { return (v === undefined || isNaN(v)) ? '-' : v; }
  function safeCalc(v) { return (v === undefined || isNaN(v)) ? 0 : v; }

  // Rekap semua total_persentase
  var persen_sesuai_rencana = hitung_sesuai_rencana();
  var rata_sesuai_rencana = roundAccurately(average(persen_sesuai_rencana), 2);
  document.querySelector("span[id='sesuai_rencana']").innerHTML = safeVal(rata_sesuai_rencana);

  var persen_sesuai_tujuan = hitung_sesuai_tujuan();
  var rata_sesuai_tujuan = roundAccurately(average(persen_sesuai_tujuan), 2);
  document.querySelector("span[id='sesuai_tujuan']").innerHTML = safeVal(rata_sesuai_tujuan/2);

  var persen_sesuai_sasaran = hitung_sesuai_sasaran();
  var rata_sesuai_sasaran = roundAccurately(average(persen_sesuai_sasaran), 2);
  document.querySelector("span[id='sesuai_sasaran']").innerHTML = safeVal(rata_sesuai_sasaran/2);

  var rata_sesuai_tujuansasaran = (rata_sesuai_tujuan + rata_sesuai_sasaran) / 2;
  document.querySelector("span[id='sesuai_tujuansasaran']").innerHTML = safeVal(roundAccurately(rata_sesuai_tujuansasaran, 2));

  var persen_sesuai_waktutempat = hitung_sesuai_waktutempat();
  var rata_sesuai_waktutempat = persen_sesuai_waktutempat.map(x => roundAccurately(average(x), 2));

  document.querySelector("span[id='sesuai_waktutempat']").innerHTML = safeVal(rata_sesuai_waktutempat[0] + rata_sesuai_waktutempat[1] + rata_sesuai_waktutempat[2]);
  document.querySelector("span[id='sesuai_waktu']").innerHTML = safeVal(rata_sesuai_waktutempat[0] + rata_sesuai_waktutempat[1]);
  document.querySelector("span[id='sesuai_tanggal']").innerHTML = safeVal(rata_sesuai_waktutempat[0]);
  document.querySelector("span[id='sesuai_jam']").innerHTML = safeVal(rata_sesuai_waktutempat[1]);
  document.querySelector("span[id='sesuai_tempat']").innerHTML = safeVal(rata_sesuai_waktutempat[2]);

  var persen_sesuai_parameter = hitung_sesuai_parameter();
  var rata_sesuai_parameter = roundAccurately(average(persen_sesuai_parameter), 2);
  document.querySelector("span[id='sesuai_parameter']").innerHTML = safeVal(rata_sesuai_parameter);

  var parameters = document.querySelectorAll('[id^=parameter_] > span.nilai');
  parameters.forEach((item, i) => {
    var v = persen_sesuai_parameter[i];
    item.innerHTML = safeVal(v);
  });

  var persen_estimasi_dana = hitung_estimasi_dana(esti, real, scale);
  var rata_sesuai_dana = roundAccurately(average(persen_estimasi_dana), 2);
  document.querySelector("span[id='efisiensi_dana']").innerHTML = safeVal(rata_sesuai_dana);

  var persen_proker = ((20/100)*safeCalc(rata_sesuai_rencana) +
                      (25/100)*safeCalc(rata_sesuai_tujuansasaran) +
                      (15/100)*safeCalc(rata_sesuai_waktutempat[0] + rata_sesuai_waktutempat[1] + rata_sesuai_waktutempat[2]) +
                      (30/100)*safeCalc(rata_sesuai_parameter) +
                      (10/100)*safeCalc(rata_sesuai_dana));

  document.querySelector("span[id='namaproker']").innerHTML = document.querySelector("input[id='proker1']").value;
  document.querySelector("span[id='persen_proker']").innerHTML = roundAccurately(persen_proker, 2);

  document.querySelector("td[id='sesuai_rencana']").innerHTML = roundAccurately((20/100)*safeCalc(rata_sesuai_rencana), 2);
  document.querySelector("td[id='sesuai_tujuansasaran']").innerHTML = roundAccurately((25/100)*safeCalc(rata_sesuai_tujuansasaran), 2);
  document.querySelector("td[id='sesuai_waktutempat']").innerHTML = roundAccurately((15/100)*safeCalc(rata_sesuai_waktutempat[0] + rata_sesuai_waktutempat[1] + rata_sesuai_waktutempat[2]), 2);
  document.querySelector("td[id='sesuai_parameter']").innerHTML = roundAccurately((30/100)*safeCalc(rata_sesuai_parameter), 2);
  document.querySelector("td[id='efisiensi_dana']").innerHTML = roundAccurately((10/100)*safeCalc(rata_sesuai_dana), 2);

  document.querySelector("td[id='persen_proker']").innerHTML = roundAccurately(persen_proker, 2);
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       SMOOTH ACCORDION
       ============================================================ */
    var accHeaders = document.querySelectorAll('.kk-acc-header');

    accHeaders.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('.kk-acc-item');
            item.classList.toggle('kk-open');
        });
    });

    /* ============================================================
       SCROLL LOCK HELPERS
       ============================================================ */
    var _touchBlock = null;
    var btt = document.querySelector('.back-to-top');

    function lockScroll() {
        document.documentElement.style.overflow = 'hidden';
        document.body.classList.add('kk-sheet-open');
        _touchBlock = function (e) {
            var sheet = document.getElementById('kk-bottom-sheet');
            if (sheet && sheet.contains(e.target)) return;
            e.preventDefault();
        };
        window.addEventListener('touchmove', _touchBlock, { passive: false });
        if (btt) { btt.style.opacity = '0'; btt.style.visibility = 'hidden'; }
    }

    function unlockScroll() {
        document.documentElement.style.overflow = '';
        document.body.classList.remove('kk-sheet-open');
        if (_touchBlock) {
            window.removeEventListener('touchmove', _touchBlock);
            _touchBlock = null;
        }
        if (btt) { btt.style.opacity = ''; btt.style.visibility = ''; }
    }

    /* ============================================================
       COPY URL HELPER (share feature)
       ============================================================ */
    function showCopyToast(ok) {
        if (typeof Swal === 'undefined') return;
        Swal.fire({
            toast: true, position: 'top-end',
            icon: ok ? 'success' : 'error',
            title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
            showConfirmButton: false, timer: 2500, timerProgressBar: true,
            customClass: { container: 'kk-swal-above' }
        });
    }

    /* ============================================================
       BOTTOM SHEET — SCORE RESULTS (mobile)
       ============================================================ */
    function buildScoreSheet() {
        function getSpan(id) {
            var el = document.querySelector('span[id="' + id + '"]');
            return el ? el.innerHTML : '-';
        }
        function getTd(id) {
            var el = document.querySelector('td[id="' + id + '"]');
            return el ? (el.innerHTML || '-') : '-';
        }

        var prokerName  = document.querySelector('span[id="namaproker"]');
        var nameText    = prokerName ? (prokerName.innerHTML || 'Program Kerja') : 'Program Kerja';
        var totalSpan   = document.querySelector('span[id="persen_proker"]');
        var totalVal    = totalSpan ? (totalSpan.innerHTML || '0') : '0';

        var rows = [
            { label: 'Kesesuaian Rencana',         bobot: '20%', id: 'sesuai_rencana' },
            { label: 'Kesesuaian Tujuan & Sasaran', bobot: '25%', id: 'sesuai_tujuansasaran' },
            { label: 'Waktu & Tempat',              bobot: '15%', id: 'sesuai_waktutempat' },
            { label: 'Parameter Keberhasilan',      bobot: '30%', id: 'sesuai_parameter' },
            { label: 'Akurasi Dana',                bobot: '10%', id: 'efisiensi_dana' },
        ];

        var rowsHtml = rows.map(function (r) {
            var tdVal = getTd(r.id);
            return '<tr>' +
                '<td style="padding:0.65rem 0.85rem;font-size:.83rem;color:#374151;border-bottom:1px solid rgba(0,167,157,.08)">' + r.label + '</td>' +
                '<td style="padding:0.65rem 0.5rem;font-size:.75rem;color:#9ca3af;text-align:center;border-bottom:1px solid rgba(0,167,157,.08)">' + r.bobot + '</td>' +
                '<td style="padding:0.65rem 0.85rem;font-size:.85rem;font-weight:700;color:#00a79d;text-align:right;border-bottom:1px solid rgba(0,167,157,.08)">' + tdVal + '%</td>' +
            '</tr>';
        }).join('');

        return '<div style="text-align:center;margin-bottom:1.25rem">' +
            '<p style="font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#9ca3af;margin:0 0 .2rem">Rekap Nilai</p>' +
            '<p style="font-size:1rem;font-weight:700;color:#1f2937;margin:0 0 .75rem">' + nameText + '</p>' +
            '<div style="display:inline-flex;align-items:center;justify-content:center;gap:.4rem;background:linear-gradient(135deg,#00a79d,#006D6D);border-radius:50rem;padding:.6rem 1.5rem">' +
                '<span style="color:#fff;font-size:.75rem;font-weight:600">Total Nilai</span>' +
                '<span style="color:#fff;font-size:1.35rem;font-weight:800">' + totalVal + '%</span>' +
            '</div>' +
        '</div>' +
        '<div style="border:2px solid rgba(0,167,157,.12);border-radius:16px;overflow:hidden;margin-bottom:1rem">' +
            '<table style="width:100%;border-collapse:collapse">' +
                '<thead><tr>' +
                    '<th style="padding:.6rem .85rem;background:rgba(0,167,157,.08);font-size:.68rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#00a79d;text-align:left">Kriteria</th>' +
                    '<th style="padding:.6rem .5rem;background:rgba(0,167,157,.08);font-size:.68rem;font-weight:700;text-transform:uppercase;color:#00a79d;text-align:center">Bobot</th>' +
                    '<th style="padding:.6rem .85rem;background:rgba(0,167,157,.08);font-size:.68rem;font-weight:700;text-transform:uppercase;color:#00a79d;text-align:right">Nilai</th>' +
                '</tr></thead>' +
                '<tbody>' + rowsHtml + '</tbody>' +
            '</table>' +
        '</div>' +
        '<div style="display:flex;gap:.65rem">' +
            '<button onclick="kkCopyUrl()" style="flex:1;display:flex;align-items:center;justify-content:center;gap:.4rem;border:1.5px solid rgba(0,167,157,.3);border-radius:50px;padding:.75rem;font-size:.8rem;font-weight:600;color:#00a79d;background:rgba(0,167,157,.08);cursor:pointer;transition:all .2s">' +
                '<i class="fas fa-link"></i><span>Salin URL</span>' +
            '</button>' +
            '<button onclick="kkShareWa()" style="flex:1;display:flex;align-items:center;justify-content:center;gap:.4rem;border:1.5px solid rgba(37,211,102,.28);border-radius:50px;padding:.75rem;font-size:.8rem;font-weight:600;color:#1da851;background:rgba(37,211,102,.08);cursor:pointer;transition:all .2s">' +
                '<i class="fab fa-whatsapp"></i><span>WhatsApp</span>' +
            '</button>' +
        '</div>';
    }

    function openSheet() {
        var content = document.getElementById('kk-bs-content');
        if (content) content.innerHTML = buildScoreSheet();
        document.getElementById('kk-bottom-sheet').scrollTop = 0;
        document.getElementById('kk-bs-backdrop').classList.add('active');
        document.getElementById('kk-bottom-sheet').classList.add('active');
        lockScroll();
    }

    function closeSheet() {
        document.getElementById('kk-bs-backdrop').classList.remove('active');
        document.getElementById('kk-bottom-sheet').classList.remove('active');
        unlockScroll();
    }

    var viewBtn = document.getElementById('kk-view-score-btn');
    if (viewBtn) viewBtn.addEventListener('click', openSheet);

    var bsClose    = document.getElementById('kk-bs-close');
    var bsBackdrop = document.getElementById('kk-bs-backdrop');
    if (bsClose)    bsClose.addEventListener('click', closeSheet);
    if (bsBackdrop) bsBackdrop.addEventListener('click', closeSheet);

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var bs = document.getElementById('kk-bottom-sheet');
        if (bs && bs.classList.contains('active')) closeSheet();
    });

    /* ============================================================
       SHARE HELPERS
       ============================================================ */
    window.kkCopyUrl = function () {
        var url = window.location.href;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(
                function () { showCopyToast(true); },
                function () { showCopyToast(false); }
            );
        } else {
            try {
                var ta = document.createElement('textarea');
                ta.value = url;
                ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;pointer-events:none';
                document.body.appendChild(ta); ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                showCopyToast(true);
            } catch (e) { showCopyToast(false); }
        }
    };

    window.kkShareWa = function () {
        var prokerName = document.querySelector('span[id="namaproker"]');
        var name = prokerName ? prokerName.innerHTML : '';
        var text = (name ? 'Nilai Proker "' + name + '": ' : 'Kalkulator Kestari LDK Syahid\n') + window.location.href;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };

}); /* end DOMContentLoaded */
</script>
