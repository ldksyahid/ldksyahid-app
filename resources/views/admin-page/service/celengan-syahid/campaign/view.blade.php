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
                <h5 class="mb-4">Preview Campaign</h5>
                <form role="form" action='#' method='post' enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col col-lg-12">
                            <label for="inputJudulCampaign" class="form-label required">Title</label>
                            <input type="text" class="form-control" id="inputJudulCampaign" name='judul' required value="{{old('judul', $data->judul)}}" disabled>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="chooseKategoriCampaign" class="form-label required">Category</label>
                            <select class="form-select mb-3" aria-label="Default select" required name="kategori" disabled>
                                <option selected hidden value="{{old('kategori', $data->kategori)}}">{{ $data->kategori }}</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Kemanusiaan">Kemanusiaan</option>
                                <option value="Kesehatan">Kesehatan</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Sosial Dakwah">Sosial Dakwah</option>
                                <option value="Lingkungan">Lingkungan</option>
                            </select>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="inputLink" class="form-label required">Link</label>
                            <input type="text" class="form-control" id="inputLink" name='link' required style="text-transform: lowercase;" value="{{old('link', $data->link)}}" disabled>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="inputProvinsiCampaign" class="form-label required">Province</label>
                            <select class="form-group mb-3 textSearch" aria-label="" name="provinsi" type='text' id="inputProvinsiCampaign" onchange="storeProvince()" disabled>
                                <option selected hidden value="{{old('provinsi', $data->provinsi)}}">{{strtoupper($data->provinsi)}}</option>
                                @foreach ($province as $id => $name)
                                    <option value="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="kota" class="form-label required">City</label>
                            <select class="mb-3 textSearch" aria-label="" name="kota" type='text' id="inputKotaCampaign" disabled>
                                <option selected hidden value="{{old('kota', $data->kota)}}">{{strtoupper($data->kota)}}</option>
                            </select>
                        </div>
                        <div class="mb-3 col col-lg-12">
                            <label for="inputTargetBiaya" class="form-label">Cost Targets</label>
                            <input type="text" class="form-control" id="inputTargetBiaya" name='target_biaya' required value="{{old('target_biaya', LFC::formatRupiah($data->target_biaya))}}" disabled>
                        </div>
                        <div class="mb-3 col col-lg-12">
                            <label for="inputCerita" class="form-label required">Story Details</label>
                            <div class="border p-3 rounded">
                                {!! $data->cerita !!}
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-4">
                            <label for="formFile" class="form-label required">Poster (1920 x 1080 Pixel)</label>
                            <br>
                            <div>
                                @if ($data->poster == !null)
                                <img id="framePoster" src="{{ asset($data->poster) }}" width="250px" height="150px" class="rounded mb-3 border"/>
                                @else
                                <img id="framePoster" src="{{ asset('Images/Icons/add_image.svg') }}" width="250px" height="150px" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="poster" name ='poster'accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="previewPoster()" disabled>
                        </div>
                        <div class="mb-3 col col-lg-4">
                            <label for="inputDeadlineCampaign" class="form-label required">Deadline</label>
                            <input type="date" class="form-control" id="inputDeadlineCampaign" name='deadline' value="{{old('deadline', $data->deadline)}}" disabled>
                        </div>
                        <div class="mb-3 col col-lg-4">
                            <label for="inputTelpPJ" class="form-label required">PIC Contact</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputTelpPJ">+62</span>
                                <input type="text" class="form-control" id="inputTelpPJ" name='telp_pj' aria-describedby="inputTelpPJ" value="{{old('telp_pj', $data->telp_pj)}}" disabled>
                                <div class="invalid-feedback">
                                    This is a required question
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-12">
                            <label for="inputTujuan" class="form-label required">Goals</label>
                            <textarea class="form-control" name="tujuan" id="inputTujuan" style="height: 100px;" disabled>{{ $data->tujuan }}</textarea>
                        </div>
                        <div class="mb-3 col col-lg-12">
                            <label for="inputKabarTerbaru" class="form-label">Latest News</label>
                            <div class="border p-3 rounded">
                                {!! $data->kabar_terbaru !!}
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-12">
                            <label class="form-check-label" for="cekOrganisasi">Organizations other than UKM LDK Syahid ?</label>
                            @if ($data->nama_pj != null || $data->link_pj != null)
                                <input type="checkbox" class="form-check-input" id="cekOrganisasi" onclick="cekOrg()" checked disabled>
                            @else
                                <input type="checkbox" class="form-check-input" id="cekOrganisasi" onclick="cekOrg()" disabled>
                            @endif
                        </div>
                        <div id="formOrganisasi" @if ($data->nama_pj == null || $data->link_pj == null)
                            style="display: none;"
                        @else
                            style="display: ;"
                        @endif>
                            <div class="row">
                                <div class="mb-3 col col-lg-4"  >
                                    <label for="formFile" class="form-label">Organization Logo</label>
                                    <br>
                                    <div>
                                        @if ($data->logo_pj == !null)
                                        <img id="frameLogo" src="{{ asset($data->logo_pj) }}" width="50%" class="rounded mb-3 border"/>
                                        @else
                                        <img id="frameLogo" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                        @endif
                                    </div>
                                    <input class="form-control" type="file" id="poster" name ='logo_pj'accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                                </div>
                                <div class="mb-3 col col-lg-4" >
                                    <label for="inputNamaPJ" class="form-label">Organization Name</label>
                                    <input type="text" class="form-control" id="inputNamaPJ" name='nama_pj' value="{{old('nama_pj', $data->nama_pj)}}" disabled>
                                </div>
                                <div class="mb-3 col col-lg-4"  >
                                    <label for="inputLinkPJ" class="form-label">Organization Profile Links</label>
                                    <input type="text" class="form-control" id="inputLinkPJ" name='link_pj' value="{{old('link_pj', $data->link_pj)}}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a type="submit" class="btn btn-primary" href="/admin/service/celengansyahid/campaigns"><i class="fa fa-arrow-left"></i> Back</a>
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
@endsection
