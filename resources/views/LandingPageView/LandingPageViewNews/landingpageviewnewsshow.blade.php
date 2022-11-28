@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-2 col-md-6 wow fadeInLeft" data-wow-delay="0.5s">
                <div class="ps-4 text-center">
                    <h5 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('Y') }}</h5>
                    <h6 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('MMMM') }}</h6>
                    <h1 class="display-6 mb-0">{{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('DD') }}</h1>
                    <p class="mb-0">{{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('dddd') }}</p>
                </div>
            </div>
            <div class="col-lg-10 col-md-6 wow fadeInRight" data-wow-delay="0.5s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                    <h6 class="text-body mb-2">Dipublikasikan oleh {{ $postnews->publisher }}</h6>
                    <h1 class="display-6 mb-0" style="text-align: left">{{ $postnews->title }}</h1>
                </div>
            </div>
            <div class="wow fadeInUp " data-wow-delay="1.0s">
                <div class="col-lg-10 col-md-6 text-start">
                    <p class="mb-2 text-start"><i>Reporter</i> {{ $postnews->reporter }}; <i>Editor</i> {{ $postnews->editor }}</p>
                    <img src="{{ asset($postnews->picture) }}" alt="{{$postnews->title}}" class="img-fluid rounded">
                    <p class="mt-1 small text-center"><i>{{ $postnews->descpicture }}</i></p>
                </div>
                <div class="mb-1 col-lg-10 col-md-6" style="">
                    <p data-wow-delay="0.5s">{!! $postnews->body !!}</p>
                </div>
                <div class="text-start">
                    <a class="small text-uppercase" href="/news"><i class="fa fa-arrow-left mr-3"></i>Berita Lainnya</a>
                </div>
                <div class="col-lg-10 col-md-6 text-start">
                    <hr>
                </div>
                <div class="col-lg-12 col-md-6 wow fadeInRight text-start">
                    @forelse ($postnews->newscomments as $key => $comment)
                    @if ($key + 1 == 1)
                    <h3 class="mb-5 h4 font-weight-bold text-center"> {{ $postnews->newscomments->count() }}  Komentar</h3>
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
                            @if (!is_null(Auth::User()) && (Auth::User()->is($comment->user) || Auth::User()->is_admin == 1))
                            <form action="/newscomment/{{ $comment->id }}/destroy" method="post" id="form_delete_comment_news">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:{}" onclick="document.getElementById('form_delete_comment_news').submit(); return false;">Hapus Komentar Ini</a>
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
                            @if (!is_null(Auth::User()) && (Auth::User()->is($comment->user) || Auth::User()->is_admin == 1))
                            <form action="/newscomment/{{ $comment->id }}/destroy" method="post" id="form_delete_comment_news">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:{}" onclick="document.getElementById('form_delete_comment_news').submit(); return false;">Hapus Komentar Ini</a>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endif
                    @empty
                    <h3 class="mb-5 h4 font-weight-bold text-center">Belum ada Komentar</h3>
                    @endforelse
                    <div>
                        <Form action="/newscomment" class="p-5 bg-light col-lg-10 col-md-6" method='post' enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="postnews" value="{{$postnews->id}}" />
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
</div>

@endsection
