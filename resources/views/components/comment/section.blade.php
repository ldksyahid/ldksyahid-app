{{--
    Reusable comment section component (replaces Disqus).

    Required params:
      $cmtType  — 'article' | 'news' | 'event' | 'catalogBook'
      $cmtId    — integer, primary key of the content

    Optional params:
      $cmtTitle — section heading  (default: 'Komentar')
      $cmtDesc  — subtitle text below heading
--}}
@php
    $cmtTitle = $cmtTitle ?? 'Komentar';
    $cmtDesc  = $cmtDesc  ?? '';
@endphp

<div class="cmt-section"
     id="cmt-section"
     data-type="{{ $cmtType }}"
     data-id="{{ $cmtId }}"
     data-csrf="{{ csrf_token() }}"
     data-auth="{{ auth()->check() ? '1' : '0' }}"
     data-login-url="{{ route('login') }}"
     data-store-url="{{ route('comment.store') }}"
     data-index-url="{{ route('comment.index') }}"
     data-react-url="{{ route('comment.react', ':id') }}"
     data-upload-url="{{ route('comment.upload-media') }}"
     data-gif-url="{{ route('gif.search') }}"
     data-cat-url="{{ route('gif.categories') }}"
     data-update-url="{{ route('comment.update', ':id') }}"
     data-delete-url="{{ route('comment.destroy', ':id') }}">

    {{-- Heading --}}
    <h3 class="cmt-title">
        <i class="fas fa-comments"></i>
        {{ $cmtTitle }}
    </h3>

    @if($cmtDesc)
    <p class="cmt-desc">{{ $cmtDesc }}</p>
    @endif

    {{-- Comment form (authenticated users only) --}}
    @auth
    <div class="cmt-form-wrap">
        <div class="cmt-form-avatar">
            @if(auth()->user()->profile && auth()->user()->profile->profilepicture)
                <img class="cmt-avatar-img"
                     src="https://lh3.googleusercontent.com/d/{{ auth()->user()->profile->gdrive_id }}"
                     alt="{{ auth()->user()->name }}" loading="lazy">
            @elseif(auth()->user()->profile && auth()->user()->profile->googleAvatar)
                <img class="cmt-avatar-img"
                     src="{{ auth()->user()->profile->googleAvatar }}"
                     alt="{{ auth()->user()->name }}" loading="lazy">
            @else
                <div class="cmt-avatar-placeholder">
                    {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
        </div>

        <div class="cmt-form-body">
            <textarea id="cmt-input"
                      class="cmt-textarea"
                      placeholder="Tulis komentar… (Ctrl+Enter untuk kirim)"
                      rows="3"
                      maxlength="2000"></textarea>

            {{-- Media preview --}}
            <div class="cmt-media-preview-wrap" id="cmt-media-preview-main" style="display:none">
                <button type="button" class="cmt-media-remove" data-target="main">
                    <i class="fas fa-times"></i>
                </button>
                <img id="cmt-media-img-main" src="" alt="" class="cmt-media-thumb">
            </div>

            <div class="cmt-form-footer">
                <div class="cmt-media-toolbar">
                    <button class="cmt-media-btn" data-action="img" data-target="main"
                            type="button" title="Tambah gambar">
                        <i class="fas fa-image"></i>
                    </button>
                    <button class="cmt-media-btn cmt-gif-open-btn" data-action="gif"
                            data-target="main" type="button" title="Tambah GIF / Stiker">
                        <span class="cmt-gif-icon-wrap">
                            <span class="cmt-gif-icon-text">GIF</span>
                            <span class="cmt-gif-sep">·</span>
                            <span class="cmt-gif-icon-text cmt-stk-text">Stiker</span>
                        </span>
                    </button>
                </div>
                <div class="cmt-form-controls">
                    <span id="cmt-char-count" class="cmt-char">0 / 2000</span>
                    <button id="cmt-submit-btn" class="cmt-btn-submit" type="button">
                        <i class="fas fa-paper-plane"></i> Kirim
                    </button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="cmt-login-prompt">
        <i class="fas fa-lock cmt-login-icon"></i>
        <p>
            <a href="{{ route('login') }}?redirect={{ urlencode(url()->current() . '#cmt-section') }}"
               class="cmt-login-link">Masuk</a>
            terlebih dahulu untuk berkomentar.
        </p>
    </div>
    @endauth

    <div class="cmt-divider"></div>

    {{-- Comment list (populated via AJAX) --}}
    <div id="cmt-list" class="cmt-list">
        <div class="cmt-loading">
            <i class="fas fa-spinner fa-spin"></i> Memuat komentar…
        </div>
    </div>

</div>

{{-- Shared hidden file input --}}
<input type="file" id="cmt-shared-file" accept="image/*,image/gif" style="display:none" aria-hidden="true">

{{-- ══════════════════════════════════════════════════════
     GIF / STIKER PICKER MODAL
     (like GIPHY-style with tabs + categories)
═══════════════════════════════════════════════════════ --}}
<div class="cmt-gif-modal" id="cmt-gif-modal" style="display:none" aria-hidden="true">
    <div class="cmt-gif-backdrop" id="cmt-gif-backdrop"></div>
    <div class="cmt-gif-dialog">

        {{-- Header --}}
        <div class="cmt-gif-header">
            <div class="cmt-gif-tabs" role="tablist">
                <button class="cmt-gif-tab active" data-tab="gifs"
                        role="tab" type="button">GIF</button>
                <button class="cmt-gif-tab" data-tab="stickers"
                        role="tab" type="button">Stiker</button>
            </div>
            <button type="button" class="cmt-gif-close" id="cmt-gif-close"
                    aria-label="Tutup">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Search --}}
        <div class="cmt-gif-search-wrap">
            <i class="fas fa-search cmt-gif-search-icon"></i>
            <input type="text" id="cmt-gif-q" class="cmt-gif-input"
                   placeholder="Cari GIF atau stiker…" autocomplete="off">
            <button class="cmt-gif-clear" id="cmt-gif-clear" type="button"
                    style="display:none" title="Hapus pencarian">
                <i class="fas fa-times-circle"></i>
            </button>
        </div>

        {{-- Category chips (Trending + others from GIPHY API) --}}
        <div class="cmt-gif-chips" id="cmt-gif-chips">
            <button class="cmt-gif-chip active" data-q="" type="button">
                🔥 Trending
            </button>
            {{-- More chips loaded via JS from GIPHY categories --}}
        </div>

        {{-- GIF Grid --}}
        <div id="cmt-gif-grid" class="cmt-gif-grid">
            <div class="cmt-gif-hint">
                <i class="fas fa-images"></i>
                <p>Memuat GIF populer…</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="cmt-gif-footer">
            Powered by <img src="https://media.giphy.com/static/img/giphy_logo_mark_black.png"
                            alt="GIPHY" class="cmt-giphy-logo" height="16"
                            onerror="var s=document.createElement('strong');s.textContent='GIPHY';s.style.color='#00ff99';s.style.letterSpacing='.5px';this.replaceWith(s)">
        </div>

    </div>
</div>
