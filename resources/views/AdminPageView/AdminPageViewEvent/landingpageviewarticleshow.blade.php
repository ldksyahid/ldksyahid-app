@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')
@section('openGraph')
<meta property="og:title" content="{{ $postarticle->title }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:image" content="{{ asset($postarticle->poster) }}" />
<meta property="og:description" content="{{ $postarticle->theme }}" />
@endsection
@section('content')
<!-- Article Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-lg-2 col-md-6 wow fadeInLeft" data-wow-delay="0.5s">
                <div class="ps-4 mb-5 text-center">
                    <h5 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postarticle->dateevent )->format('Y') }}</h5>
                    <h6 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('MMMM') }}</h6>
                    <h1 class="display-6 mb-0">{{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('DD') }}</h1>
                    <p class="mb-0">{{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('dddd') }}</p>
                </div>
            </div>
            <div class="col-lg-10 col-md-6 wow fadeInRight" data-wow-delay="0.5s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                <h6 class="text-body text-uppercase mb-2">{{ $postarticle->theme }}</h6>
                <h1 class="display-6 mb-4" style="text-align: left">{{ $postarticle->title }}</h1>
                <h6 class="text-body mb-0">Penulis : {{ $postarticle->writer }}</h6>
                <h6 class="text-body mb-0">Editor  : {{ $postarticle->editor }}</h6>
                </div>
            </div>
            <iframe style="width:1080px;height:600px" src="{{ $postarticle->embedpdf }}"  seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" ></iframe>
            {{-- <iframe src="{{ $postarticle->embedpdf }}" width="500" height="600" allow="autoplay"></iframe> --}}
            <div class="text-start">
                <a class="small text-uppercase" href="/article"><i class="fa fa-arrow-left ms-3"></i>Artikel Lainnya</a>
            </div>
            <hr>
            <div class="col-lg-12 col-md-6 wow fadeInRight text-start">
                @forelse ($postarticle->articlecomments as $key => $comment)
                @if ($key + 1 == 1)
                <h3 class="mb-5 h4 font-weight-bold text-center"> {{ $postarticle->articlecomments->count() }} Komentar</h3>
                <div class="my-5">
                    <div class="m-2">
                        @if ($comment->user->profile == null || $comment->user->profile->profilepicture == null)
                            <img class="rounded-circle" src="{{ Avatar::create($comment->user->name)->setFontFamily('Comic Sans MS')->setDimension(600)->setFontSize(325)->toBase64() }}" alt="" style="width: 70px; height: 70px;">
                        @else
                            <img class="rounded-circle" src="/{{$comment->user->profile->profilepicture}}" alt="" style="width: 70px; height: 70px;">
                        @endif
                    </div>
                    <div class="comment-body">
                        <h4>{{$comment->user->name}}</h4>
                        <div class="meta mb-2">{{ \Carbon\Carbon::parse( $comment->created_at )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $comment->created_at )->isoFormat('D') }} {{ \Carbon\Carbon::parse( $comment->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $comment->created_at )->isoFormat('Y') }} Pada Pukul {{ \Carbon\Carbon::parse( $comment->created_at )->format('H:i') }}</div>
                        <div>
                            <p style="text-align: justify">{!!  $comment->body !!}</p>
                        </div>
                        @if (!is_null(Auth::User()) && (Auth::User()->is($comment->user) || LFC::getRoleName(auth()->user()->getRoleNames()) == 'Superadmin'))
                            <form action="/articlecomment/{{ $comment->id }}/destroy" method="post" id="form_delete_comment_article">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:{}" onclick="document.getElementById('form_delete_comment_article').submit(); return false;">Hapus Komentar Ini</a>
                            </form>
                        @endif
                    </div>
                </div>
                @else
                <div class="my-5">
                    <div class="m-2">
                        @if ($comment->user->profile == null || $comment->user->profile->profilepicture == null)
                            <img class="rounded-circle" src="{{ Avatar::create($comment->user->name)->setFontFamily('Comic Sans MS')->setDimension(600)->setFontSize(325)->toBase64() }}" alt="" style="width: 70px; height: 70px;">
                        @else
                            <img class="rounded-circle" src="/{{$comment->user->profile->profilepicture}}" alt="" style="width: 70px; height: 70px;">
                        @endif
                    </div>
                    <div class="comment-body">
                        <h4>{{$comment->user->name}}</h4>
                        <div class="meta mb-2">{{ \Carbon\Carbon::parse( $comment->created_at )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $comment->created_at )->isoFormat('D') }} {{ \Carbon\Carbon::parse( $comment->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $comment->created_at )->isoFormat('Y') }} Pada Pukul {{ \Carbon\Carbon::parse( $comment->created_at )->format('H:i') }}</div>
                        <div>
                            <p style="text-align: justify">{!!  $comment->body !!}</p>
                        </div>
                        @if (!is_null(Auth::User()) && (Auth::User()->is($comment->user) || LFC::getRoleName(auth()->user()->getRoleNames()) == 'Superadmin'))
                            <form action="/articlecomment/{{ $comment->id }}/destroy" method="post" id="form_delete_comment_article">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:{}" onclick="document.getElementById('form_delete_comment_article').submit(); return false;">Hapus Komentar Ini</a>
                            </form>
                        @endif
                    </div>
                </div>
                @endif
                @empty
                <h3 class="mb-5 h4 font-weight-bold text-center">Belum ada Komentar</h3>
                @endforelse
                <div>
                    <Form action="/articlecomment" class="p-5 bg-light" method='post' enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="postarticle" value="{{$postarticle->id}}" />
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control border-0 bg-light" placeholder="Leave a message here" id="body" name="body" style="height: 150px; width:100%"></textarea>
                                    <label for="body">Komentar dari Kamu</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary py-3 px-5" type="submit">
                                Kirim Komentarmu
                                </button>
                            </div>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Article End -->
@endsection
{{-- @section('scripts')
<script>
    // ===== START CRUD ARTICLE COMMENT  =====
    // untuk load komentar artikel
    $(document).ready(function(){
        read();
    });


    //untuk read komentar artikel
    function read() {
        $.get("{{ url('/articlecomment/read') }}", {}, function(data, status){
            $('#readArticleComments').html(data);
        });
    }

    // untuk menyimpan komentar artikel
    function articleCommentStore() {
        var articlecomment = $("#articlecomment").val();
        console.log(articlecomment);
        $.ajax({
            type: "post",
            url: "{{ url('/articlecomment') }}",
            data: {
                body : articlecomment,
            },
            success: function(data) {
                read();
            }
        });
    }
    // ===== END CRUD ARTICLE COMMENT  =====
</script>
@endsection --}}
