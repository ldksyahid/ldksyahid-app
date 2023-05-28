@extends('landing-page.template.body')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-9 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                    <h6 class="text-body mb-2">Kalkulator Kestari</h6>
                    <h1 class="display-6 mb-0">Mari Kami Bantu untuk Menghitung Nilai Program Kerja Divisimu</h1>
                    <p class="mb-0 mt-1" style="text-align: justify">
                        "Dan janganlah kamu mengikuti sesuatu yang tidak kamu ketahui. Karena pendengaran, penglihatan, dan hati nurani, semua itu akan diminta pertanggungjawabannya."

                        &#9679; (QS. Al-Isra' 17: Ayat 36)
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class=" mb-5 text-end">
                    <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="LDK Syahid" width="255px" height="255px">
                </div>
            </div>
        </div>
        <div class="fadeInUp wow" data-wow-delay="0.1s">
            <article class="proker content shadow">
              <!-- Update untuk multiproker sehingga dapat menghitung 1 divisi sekaligus akan ditambahkan di versi selanjutnya -->
              <!-- Versi yang sudah terintegrasi dengan hosting -->
              <!-- <div class="add_element">
                <button type="button" name="tambah_proker" onclick="tambah_proker(1), refreshValue()">+</button>
                <button type="button" name="kurang_proker" onclick="kurang_proker(1), refreshValue()">-</button>

                <button type="button" name="refresh" onclick="refreshCollapsible()">Refresh jika bisa dibuka</button>
              </div> -->
              <div id="proker_1">
                <button type="button" class="collapsible text-uppercase p-1">
                  <h2 class="m-1 ">Program Kerja #<span id="nomorproker" oninput="refreshValue()">1</span> | <span id=namaproker></span> | <span class="persentase nilai" id="persen_proker"></span></h2>
                </button>
                <div class="content collapcontent">
                  <input type="text" id="proker1" placeholder="Workshop Keadministrasian"
                         oninput="refreshValue()">

                  <div class="add_element">
                    <p>Jumlah Pelaksanaan</p>
                    <p id="jumlah_pelaksanaan">1</p>
                    <button type="button" class="border-0" style="width: 100px; margin: 5px" name="tambah_pelaksanaan" onclick="tambah_pelaksanaan(1), refreshValue()">+</button>
                    <button type="button" class="border-0" style="width: 100px; margin: 5px" name="kurang_pelaksanaan" onclick="kurang_pelaksanaan(1), refreshValue()">-</button>
                  </div>
                  <div class="resultproker">
                    <table>
                      <thead>
                        <br>
                        Kesimpulan Evaluasi
                      </thead>
                      <th>Konten Evaluasi</th>
                      <td>Bobot</td>
                      <tr>
                        <td>Kesesuaian Rencana</td>
                        <td>20</td>
                        <td id="sesuai_rencana" class="konteneval"></td>
                      </tr>
                      <tr>
                        <td>Kesesuaian Tujuan dan Sasaran</td>
                        <td>25</td>
                        <td id="sesuai_tujuansasaran" class="konteneval"></td>
                      </tr>
                      <tr>
                        <td>Kesesuaian Waktu dan Tempat</td>
                        <td>15</td>
                        <td id="sesuai_waktutempat" class="konteneval"></td>
                      </tr>
                      <tr>
                        <td>Kesesuaian Parameter Keberhasilan</td>
                        <td>30</td>
                        <td id="sesuai_parameter" class="konteneval"></td>
                      </tr>
                      <tr>
                        <td>Akurasi Dana</td>
                        <td>10</td>
                        <td id="efisiensi_dana" class="konteneval"></td>
                      </tr>
                      <tr style="border-top: 1px solid #0dcaf0">
                        <td colspan="2"><strong>Total</strong></td>
                        <td id="persen_proker" class="konteneval"></td>
                      </tr>

                    </table>
                  </div>
                  <div class="unsur rencana">
                    <h3 class="text-uppercase">Kesesuaian Rencana: <span class="persentase nilai" id="sesuai_rencana">-</span></h3>
                    <div class="unsur">
                      <div class="add_element">
                        <p>Deskripsi Program</p>
                        <button type="button" class="border-0" style="width: 100px; margin: 5px" name="tambah_deskripsi" onclick="tambah_deskripsi(1), refreshValue()">+</button>
                        <button type="button" class="border-0" style="width: 100px; margin: 5px" name="kurang_deskripsi" onclick="kurang_deskripsi(1), refreshValue()">-</button>
                      </div>

                      <div id="deskripsi_1">
                        <input type="text" name="target_1" placeholder="Memberikan Penyuluhan"
                               onchange="refreshValue()">
                        <div class="deskripsi">
                          <input type="checkbox" name="terlaksana"
                                 onchange="refreshValue()">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="unsur tujuansasaran">
                    <h3 class="text-uppercase">Kesesuaian Tujuan dan Sasaran: <span class="persentase nilai border-0" id="sesuai_tujuansasaran">-</span></h3>
                    <div class="unsur tujuan">
                      <div class="add_element">
                        <p>Tujuan <span class="nilai" id="sesuai_tujuan"></p>
                        <button type="button" class="border-0" style="width: 100px; margin: 5px" name="tambah_tujuan" onclick="tambah_tujuan(1), refreshValue()">+</button>
                        <button type="button" class="border-0" style="width: 100px; margin: 5px" name="kurang_tujuan" onclick="kurang_tujuan(1), refreshValue()">-</button>
                      </div>

                      <div id="tujuan_1">
                        <input type="text" name="target_1" placeholder="Memahami regulasi administrasi"
                               onchange="refreshValue()">
                        <div class="tujuan">
                          <input type="checkbox" name="terlaksana"
                                 onchange="refreshValue()">
                        </div>
                      </div>
                    </div>

                    <div class="unsur sasaran">
                      <div class="add_element">
                        <p>Sasaran <span class="nilai" id="sesuai_sasaran"></p>
                        <button type="button" class="border-0" style="width: 100px; margin: 5px" name="tambah_sasaran" onclick="tambah_sasaran(1), refreshValue()">+</button>
                        <button type="button" class="border-0" style="width: 100px; margin: 5px" name="kurang_sasaran" onclick="kurang_sasaran(1), refreshValue()">-</button>
                      </div>

                      <div id="sasaran_1">
                        <input type="text" name="target_1" placeholder="Pengurus LDK Syahid"
                               onchange="refreshValue()">
                        <div class="sasaran">
                          <input type="checkbox" name="terlaksana"
                                 onchange="refreshValue()">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="unsur waktutempat">
                    <h3 class="text-uppercase">Kesesuaian Waktu dan Tempat: <span class="persentase nilai" id="sesuai_waktutempat">-</span></h3>
                    <div class="unsur waktu">
                      <p>Waktu <span class="nilai" id="sesuai_waktu">-</span></p>
                      <div class="unsur tanggal">
                        <p>Tanggal <span class="nilai" id="sesuai_tanggal">-</span></p>
                        <p>Sesuai | &plusmn 1-7 hari | &plusmn 8-14 hari | ≥ 15 hari</p>
                        <div class="tanggal">
                          <div class="choices">
                            <input type="radio" name="tanggal_1" id="sesuai" value="25" onchange="refreshValue()">
                            <input type="radio" name="tanggal_1" id="telat1minggu" value="20" onchange="refreshValue()">
                            <input type="radio" name="tanggal_1" id="telat2minggu" value="15" onchange="refreshValue()">
                            <input type="radio" name="tanggal_1" id="telat3minggu" value="5" onchange="refreshValue()">
                          </div>
                        </div>

                        <p>Jam <span class="nilai" id="sesuai_jam">-</span></p>
                        <p>Sesuai | + 1-15 menit | + 16-30 menit | ≥ 31 menit</p>
                        <div class="jam">
                          <div class="choices">
                            <input type="radio" name="jam_1" id="sesuai" value="25" onchange="refreshValue()">
                            <input type="radio" name="jam_1" id="telatseperempat" value="20" onchange="refreshValue()">
                            <input type="radio" name="jam_1" id="telatsetengah" value="15" onchange="refreshValue()">
                            <input type="radio" name="jam_1" id="telatsejam" value="5" onchange="refreshValue()">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="unsur tempat">
                      <div class="add_element">
                        <p>Tempat <span class="nilai" id="sesuai_tempat">-</span></p>
                        <button type="button" class="border-0" style="width: 100px; margin: 5px" name="tambah_tempat" onclick="tambah_tempat(1), refreshValue()">+</button>
                        <button type="button" class="border-0" style="width: 100px; margin: 5px" name="kurang_tempat" onclick="kurang_tempat(1), refreshValue()">-</button>
                      </div>

                      <div id="tempat_1">
                        <input type="text" name="target_1" placeholder="Ruang RK-09"
                               onchange="refreshValue()">

                        <div class="tempat">
                          <input type="checkbox" name="terlaksana"
                                 onchange="refreshValue()">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="unsur parameter">
                    <h3 class="text-uppercase">Kesesuaian Parameter Keberhasilan: <span class="persentase nilai" id="sesuai_parameter">-</span></h3>

                    <div class="unsur">
                      <div class="add_element">
                        <p>Parameter</p>
                        <button type="button" class="border-0" style="width: 100px; margin: 5px" name="tambah_parameter" onclick="tambah_parameter(1), refreshValue()">+</button>
                        <button type="button" class="border-0" style="width: 100px; margin: 5px" name="kurang_parameter" onclick="kurang_parameter(1), refreshValue()">-</button>
                      </div>

                      <div id="parameter_1">
                        <span class="nilai"></span>
                        <br>
                        <input type="number" name="target_1" id="estimasi_parameter" placeholder="10 (estimasi)" min="1"
                               oninput="refreshValue()">
                        <input type="text" name="parameter" placeholder="anggota LDK Syahid"
                               onchange="refreshValue()">
                        <div class="parameter">
                          <input type="number" name="terlaksana" id="realisasi_parameter" placeholder="10 (realisasi)" min="1"
                                 oninput="refreshValue()">
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="unsur efisiensi_dana">
                    <h3 class="text-uppercase">Akurasi Dana: <span class="persentase nilai" id="efisiensi_dana">-</span></h3>

                    <div class="unsur">
                      <label for="estimation">Estimasi Dana</label>
                      <input type="number" name="estimation" id="estimasi_dana" placeholder="1000000" min=0
                             oninput="refreshValue()"
                             autocomplete=”off”>
                    </div>

                    <div class="unsur">
                      <label for="realization">Realisasi Dana</label>
                      <div class="akurasi">
                        <input type="number" name="realization" id="realisasi_dana" placeholder="990000"
                               oninput="refreshValue()"
                               autocomplete=”off”>
                      </div>
                    </div>

                    <div class="unsur">
                      <label for="scale">Skala Penurunan</label>
                      <input type="text" name="scale" id="skala_penurunan" placeholder="4" disabled>
                    </div>
                  </div>
                </div>
              </div>
            </article>
          </div>
          <div class="text-center fadeInDown wow" data-wow-delay="0.1s">
            <p>Kalkulator Kestari ini dibuat oleh Biro Kestari 25</p>
          </div>
    </div>
</div>

      <script>

        function refreshCollapsible(){
          var coll = document.getElementsByClassName("collapsible");
          var i;

          console.log(coll);
          for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
              this.classList.toggle("active");
              var content = this.nextElementSibling;
              if (content.style.display === "block") {
                content.style.display = "none";
              } else {
                content.style.display = "block";
              }
            });
          }
        }

        refreshCollapsible();
      </script>
@endsection

