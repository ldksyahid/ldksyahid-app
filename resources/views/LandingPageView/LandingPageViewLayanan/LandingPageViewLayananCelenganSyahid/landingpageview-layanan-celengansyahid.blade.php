@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- Appointment Start -->
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img class="w-100" src="{{ asset('Images/fixImage/billboardimage/jumbotron.png') }}" alt="Image"/>
            </div>
        </div>
    </div>
</div>
<div class="container-xl" style="margin-top: -70px;">
        <div class="row g-5">
            <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                    <h6 class="text-body text-uppercase mb-2">Celengan Syahid</h6>
                    <h1 class="display-6 mb-0">
                        Mari Bantu Mereka yang Membutuhkan
                    </h1>
                </div>
                <p class="mb-0">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, laborum.
                </p>
            </div>
            <div class="col-lg-12 col-md-6 wow fadeInUp py-1" data-wow-delay="0.5s" style="margin-bottom: 0px;">
                <div class="row">
                    <div class="col">
                        <h6 class="text-body" style="display: inline-block; margin-right:10px;">Filter</h6>
                        <form style="display: inline-block">
                            <div class="multiselect">
                                <div class="selectBox" onclick="showCheckboxes  ()">
                                    <select class="rounded-pill">
                                        <option>Kategori</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="checkboxes">
                                    <label for="one">
                                    <input type="checkbox" id="one" />First checkbox</label>
                                    <label for="two">
                                    <input type="checkbox" id="two" />Second checkbox</label>
                                    <label for="three">
                                    <input type="checkbox" id="three" />Third checkbox</label>
                                </div>
                            </div>
                        </form>
                        <form style="display: inline-block">
                            <div class="multiselect">
                                <div class="selectBox" onclick="showCheckboxes()">
                                    <select class="rounded-pill">
                                        <option>Wilayah</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="checkboxes">
                                    <label for="one">
                                    <input type="checkbox" id="one" />First checkbox</label>
                                    <label for="two">
                                    <input type="checkbox" id="two" />Second checkbox</label>
                                    <label for="three">
                                    <input type="checkbox" id="three" />Third checkbox</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col text-end">
                        <h6 class="text-body"  style="display:inline-block; margin-right:10px">Urutkan</h6>
                        <select class="form rounded-pill select-opt" id="monthselectore">
                            <option value="">Terbaru</option>
                            <option value="">Terlama</option>
                            <option value="">Sisa Hari Ini</option>
                        </select>

                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <h6 class="text-body">Menampilkan 12 dari 62 <i>campaign</i></h6>
                <div class="col-md-4 mt-3">
                    <div class="card p-3 mb-2">
                        <img src="{{ asset('Images/fixImage/dummy/excamp.png') }}" alt="">
                        <div class="mt-3">
                            <div class="badge" style="margin-left:-8px;"> <span>Sosial Dakwah</span> </div>
                            <h5 class="text-body"><a href="">Pojok Baca Pelosok Negeri : Membangun Bangsa Dengan Literasi</a></h5>
                            <p>
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse, odio.
                            </p>
                            <div class="mt-3">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row align-items-center">
                                        <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="25" height="25">
                                        <div class="ms-2 c-details">
                                            <h6 style="font-size: 16px" class="mb-0 text-body"><a href="" target="_blank">UKM LDK Syahid</a></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress mt-3">
                                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><strong>50%</strong></div>
                                </div>
                                <div class="mt-0">
                                    <div class="row">
                                        <div class="col text-start">
                                            <p>
                                                <span style="font-size: 12px;">Terkumpul</span>
                                                <br>
                                                <span style=" color:#00a79d;">
                                                    <strong>Rp. 23.000,-</strong>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col text-end">
                                            <p>
                                                <span style="font-size: 12px;">Sisa Hari</span>
                                                <br>
                                                <span>
                                                    <strong>365</strong>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-6 wow fadeInUp text-center" data-wow-delay="0.5s">
                <div class="pagination">
                    <a href="#">&laquo;</a>
                    <a href="#">1</a>
                    <a href="#" class="active">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">5</a>
                    <a href="#">6</a>
                    <a href="#">&raquo;</a>
                  </div>
            </div>
        </div>

</div>
<!-- Appointment End -->
@endsection

@section('scripts')
<script>
    // Pemanggilan Validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script>
var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>
@endsection
