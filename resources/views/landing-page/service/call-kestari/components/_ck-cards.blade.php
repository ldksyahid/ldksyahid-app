{{-- ===========================================================
     CALL KESTARI CARDS PARTIAL
     Rendered on initial load AND via AJAX response.
     Variables required: $data (LengthAwarePaginator)
     =========================================================== --}}

@if($data->isEmpty())

    {{-- ── Empty State ──────────────────────────────────────────── --}}
    <div class="ck-empty-state">
        <div class="ck-empty-icon">
            <i class="fas fa-phone-slash"></i>
        </div>
        <h4 class="ck-empty-title">Tautan Tidak Ditemukan</h4>
        <p class="ck-empty-sub">Coba ubah kata kunci pencarian atau hapus filter yang aktif</p>
    </div>

@else

    @php
        /**
         * Detect icon type based on the link URL.
         * Returns a Font Awesome class string.
         */
        function ckDetectIcon(string $link): string {
            if (str_contains($link, 'wa.me') || str_contains($link, 'whatsapp.com')) return 'fab fa-whatsapp';
            if (str_starts_with($link, 'tel:'))    return 'fas fa-phone';
            if (str_starts_with($link, 'mailto:')) return 'fas fa-envelope';
            if (str_contains($link, 'instagram.com')) return 'fab fa-instagram';
            if (str_contains($link, 'youtube.com') || str_contains($link, 'youtu.be')) return 'fab fa-youtube';
            if (str_contains($link, 't.me') || str_contains($link, 'telegram.me') || str_contains($link, 'telegram.org')) return 'fab fa-telegram';
            if (str_contains($link, 'twitter.com') || str_contains($link, 'x.com')) return 'fab fa-x-twitter';
            if (str_contains($link, 'facebook.com') || str_contains($link, 'fb.me')) return 'fab fa-facebook';
            return 'fas fa-external-link-alt';
        }
    @endphp

    {{-- ── Desktop Grid ─────────────────────────────────────────── --}}
    <div class="ck-grid">
        @foreach($data as $item)
        @php
            $icon       = ckDetectIcon($item->link);
            $displayUrl = filter_var($item->link, FILTER_VALIDATE_URL)
                ? (parse_url($item->link, PHP_URL_HOST) ?: $item->link)
                : $item->link;
        @endphp
        <div class="ck-card" style="animation-delay: {{ number_format(($loop->index % 3) * 0.08, 2) }}s">
            {{-- Icon area --}}
            <div class="ck-card-icon-wrap">
                <div class="ck-card-icon">
                    <i class="{{ $icon }}"></i>
                </div>
            </div>

            {{-- Body --}}
            <div class="ck-card-body">
                <div class="ck-card-name">{{ $item->buttonName }}</div>
                <div class="ck-card-link">{{ $displayUrl }}</div>

                {{-- Footer: Share + CTA --}}
                <div class="ck-card-footer">
                    <div class="ck-card-share-row">
                        <button class="ck-share-btn ck-share-copy"
                                data-url="{{ $item->link }}"
                                onclick="ckCopyUrl(this.dataset.url, event)">
                            <i class="fas fa-link"></i><span>Salin URL</span>
                        </button>
                        <button class="ck-share-btn ck-share-wa"
                                data-url="{{ $item->link }}"
                                data-name="{{ $item->buttonName }}"
                                onclick="ckShareWa(this.dataset.url, this.dataset.name, event)">
                            <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                        </button>
                    </div>
                    <a href="{{ $item->link }}" target="_blank" rel="noopener" class="ck-cta-btn">
                        <i class="fas fa-arrow-right"></i><span>Buka</span>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Mobile List ───────────────────────────────────────────── --}}
    <div class="ck-mobile-list">
        @foreach($data as $item)
        @php
            $icon       = ckDetectIcon($item->link);
            $displayUrl = filter_var($item->link, FILTER_VALIDATE_URL)
                ? (parse_url($item->link, PHP_URL_HOST) ?: $item->link)
                : $item->link;
        @endphp
        <div class="ck-m-card"
             onclick="ckOpenSheet(this)"
             data-name="{{ $item->buttonName }}"
             data-link="{{ $item->link }}"
             data-icon="{{ $icon }}"
             data-display-link="{{ $displayUrl }}"
             style="animation-delay: {{ number_format($loop->index * 0.05, 2) }}s">
            <div class="ck-m-icon">
                <i class="{{ $icon }}"></i>
            </div>
            <div class="ck-m-info">
                <p class="ck-m-name">{{ $item->buttonName }}</p>
                <p class="ck-m-link">{{ $displayUrl }}</p>
                <span class="ck-m-hint"><i class="fas fa-info-circle"></i> Ketuk untuk detail</span>
            </div>
            <i class="fas fa-chevron-right ck-m-arrow"></i>
        </div>
        @endforeach
    </div>

@endif
