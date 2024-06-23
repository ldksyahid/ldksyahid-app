@extends('admin-page.template.body')

@section('head')
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>
@endsection


@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Edit Campaign</h5>
                <form role="form" action='/admin/service/celengansyahid/campaign/{{ $data->id }}/update' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="inputJudulCampaign" class="form-label required">Title</label>
                            <input type="text" class="form-control" id="inputJudulCampaign" name='judul' required value="{{old('judul', $data->judul)}}">
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="chooseKategoriCampaign" class="form-label required">Category</label>
                            <select class="form-select mb-3" aria-label="Default select" required name="kategori">
                                <option selected hidden value="{{old('kategori', $data->kategori)}}">{{ $data->kategori }}</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Kemanusiaan">Kemanusiaan</option>
                                <option value="Kesehatan">Kesehatan</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Sosial Dakwah">Sosial Dakwah</option>
                                <option value="Lingkungan">Lingkungan</option>
                            </select>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputLink" class="form-label required">Link</label>
                            <input type="text" class="form-control" id="inputLink" name='link' required style="text-transform: lowercase;" value="{{old('link', $data->link)}}">
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputProvinsiCampaign" class="form-label required">Province</label>
                            <select class="form-group mb-3 textSearch" aria-label="" name="provinsi" type='text' id="inputProvinsiCampaign" onchange="storeProvince()">
                                <option selected hidden value="{{old('provinsi', $data->provinsi)}}">{{strtoupper($data->provinsi)}}</option>
                                @foreach ($province as $id => $name)
                                    <option value="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="kota" class="form-label required">City</label>
                            <select class="mb-3 textSearch" aria-label="" name="kota" type='text' id="inputKotaCampaign">
                                <option selected hidden value="{{old('kota', $data->kota)}}">{{strtoupper($data->kota)}}</option>
                            </select>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="inputTargetBiaya" class="form-label">Cost Targets</label>
                            <input type="text" class="form-control" id="inputTargetBiaya" name='target_biaya' required value="{{old('target_biaya', LFC::formatRupiah($data->target_biaya))}}">
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="inputCerita" class="form-label required">Story Details</label>
                            <textarea class="form-control summernote" name="cerita" id="inputCerita" required>{{ $data->cerita }}</textarea>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="formFile" class="form-label required">Poster <span class="small">(1920 x 1080 Pixel)</label>
                            <br>
                            <div>
                                @if ($data->poster == !null)
                                <img id="framePoster" src="{{ asset($data->poster) }}" width="250px" height="150px" class="rounded mb-3 border"/>
                                @else
                                <img id="framePoster" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="250px" height="150px" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="poster" name ='poster'accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="previewPoster()">
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputDeadlineCampaign" class="form-label required">Deadline</label>
                            <input type="date" class="form-control" id="inputDeadlineCampaign" name='deadline' value="{{old('deadline', $data->deadline)}}" required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputTelpPJ" class="form-label required">PIC Contact</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputTelpPJ">+62</span>
                                <input type="text" class="form-control" id="inputTelpPJ" name='telp_pj' aria-describedby="inputTelpPJ" value="{{old('telp_pj', $data->telp_pj)}}" required>
                                <div class="invalid-feedback">
                                    This is a required question
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="inputTujuan" class="form-label required">Goals</label>
                            <textarea class="form-control" name="tujuan" id="inputTujuan" style="height: 100px;" required>{{ $data->tujuan }}</textarea>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="inputKabarTerbaru" class="form-label">Latest News</label>
                            <textarea class="form-control summernote" name="kabar_terbaru" id="inputKabarTerbaru">{{ $data->kabar_terbaru }}</textarea>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-12">
                            <label class="form-check-label" for="cekOrganisasi">Organizations other than UKM LDK Syahid ?</label>
                            @if ($data->nama_pj != null || $data->link_pj != null)
                                <input type="checkbox" class="form-check-input" id="cekOrganisasi" onclick="cekOrg()" checked>
                            @else
                                <input type="checkbox" class="form-check-input" id="cekOrganisasi" onclick="cekOrg()">
                            @endif
                        </div>
                        <div id="formOrganisasi" @if ($data->nama_pj == null || $data->link_pj == null)
                            style="display: none;"
                        @else
                            style="display: ;"
                        @endif>
                            <div class="row">
                                <div class="mb-3 col-12 col-lg-4"  >
                                    <label for="formFile" class="form-label">Organization Logo</label>
                                    <br>
                                    <div>
                                        @if ($data->logo_pj == !null)
                                        <img id="frameLogo" src="{{ asset($data->logo_pj) }}" width="50%" class="rounded mb-3 border"/>
                                        @else
                                        <img id="frameLogo" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="50%" class="rounded mb-3 border"/>
                                        @endif
                                    </div>
                                    <input class="form-control" type="file" id="poster" name ='logo_pj'accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="previewLogo()">
                                </div>
                                <div class="mb-3 col-12 col-lg-4" >
                                    <label for="inputNamaPJ" class="form-label">Organization Name</label>
                                    <input type="text" class="form-control" id="inputNamaPJ" name='nama_pj' value="{{old('nama_pj', $data->nama_pj)}}">
                                </div>
                                <div class="mb-3 col-12 col-lg-4"  >
                                    <label for="inputLinkPJ" class="form-label">Organization Profile Links</label>
                                    <input type="text" class="form-control" id="inputLinkPJ" name='link_pj' value="{{old('link_pj', $data->link_pj)}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a type="submit" class="btn btn-primary" href="/admin/service/celengansyahid/campaigns">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
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
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
             $('.summernote').summernote({
              height: 500,
              dialogsInBody: true,
              callbacks:{
                  onInit:function(){
                  $('body > .note-popover').hide();
                  }
               },
           });
        });
</script>
<script>
    const dengan_rupiah = document.querySelectorAll('#inputTargetBiaya');
    for (let i = 0; i < dengan_rupiah.length; i++) {
        dengan_rupiah[i].addEventListener('keyup', function(e)
        {
            dengan_rupiah[i].value = formatRupiah(this.value, 'Rp');
        });
    }
    function formatRupiah(angka, prefix)
        {
            var number_string = angka.replace(/[^\d]/g, '').toString(),
                split    = number_string.split(','),
                sisa     = split[0].length % 3,
                rupiah     = split[0].substr(0, sisa),
                ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
        }
</script>
<script>
    document.querySelector('#inputLink').addEventListener('keydown', (e) => {
    if (e.which === 188 || e.which === 32 || e.which === 188 || e.which === 186 || e.which === 187 || e.which === 190 || e.which === 191 || e.which === 192 || e.which === 219 || e.which === 220 || e.which === 221 || e.which === 222) {
        e.preventDefault();
    }
    });

</script>

<script>
function cekOrg() {
  var checkBox = document.getElementById("cekOrganisasi");
  var element = document.getElementById("formOrganisasi");
  if (checkBox.checked == true){
    element.style.display = "block";
  } else {
    element.style.display = "none";
  }
}
</script>

<script>
    const textSearch = document.querySelectorAll('.textSearch');

    for (let i = 0; i < textSearch.length; i++) {
        tom = new TomSelect(textSearch[i],{
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    }

    function storeProvince() {
        var provinsi_id = $("#inputProvinsiCampaign").val();
        var CSRF_TOKEN = '{{csrf_token()}}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            type: "post",
            url: "{{ url('/admin/service/celengansyahid/campaign/get-city') }}",
            data: {
                id: provinsi_id,
            },
            success: function(data) {
                console.log(data);

                tom.destroy();

                $('#inputKotaCampaign').empty();

                $.each(data, function (id, name) {
                    $('#inputKotaCampaign').append(new Option(name, id))
                })

                tom = new TomSelect('#inputKotaCampaign',{
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });

            },
            error: function(data){
                var errors = data.responseJSON;
                console.log(errors);
            }
        });

    }
</script>
<script>
function previewPoster() {
    framePoster.src=URL.createObjectURL(event.target.files[0]);
}
function previewLogo() {
    frameLogo.src=URL.createObjectURL(event.target.files[0]);
}
</script>

@endsection
