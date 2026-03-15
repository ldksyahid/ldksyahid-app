{{-- ================================================================
     SKELETON CARDS — shared buildSkeleton() helper
     Usage: @include('components.skeleton-cards.scripts')
     Supports types: campaign, article, book, event, news
     ================================================================ --}}
<script>
if (typeof window.buildSkeleton === 'undefined') {
    /**
     * buildSkeleton(type, desktopCount, mobileCount)
     *
     * Returns an HTML string with two wrappers:
     *   1. d-none d-lg-block  — desktop grid / list
     *   2. d-lg-none          — mobile horizontal carousel
     *
     * @param  {string} type          'campaign' | 'article' | 'book' | 'event' | 'news'
     * @param  {number} desktopCount  Number of desktop skeleton cards (default 3)
     * @param  {number} mobileCount   Number of mobile skeleton cards  (default 3)
     * @return {string} HTML
     */
    window.buildSkeleton = function (type, desktopCount, mobileCount) {
        var dc = desktopCount || 3;
        var mc = mobileCount  || 3;
        var desktop = '', mobile = '';

        /* ── campaign ────────────────────────────────────────── */
        if (type === 'campaign') {
            for (var i = 0; i < dc; i++) {
                desktop +=
                    '<div class="sk-campaign-card">' +
                        '<div class="sk-campaign-img sk-base"></div>' +
                        '<div class="sk-campaign-body">' +
                            '<div class="sk-campaign-org  sk-base"></div>' +
                            '<div class="sk-campaign-ttl  sk-base"></div>' +
                            '<div class="sk-campaign-ttl2 sk-base"></div>' +
                            '<div class="sk-campaign-prog sk-base"></div>' +
                            '<div class="sk-campaign-stat sk-base"></div>' +
                            '<div class="sk-campaign-btn  sk-base"></div>' +
                        '</div>' +
                    '</div>';
            }
            for (var j = 0; j < mc; j++) {
                mobile +=
                    '<div class="sk-campaign-mcard">' +
                        '<div class="sk-campaign-mimg  sk-base"></div>' +
                        '<div class="sk-campaign-mbody">' +
                            '<div class="sk-campaign-mttl  sk-base"></div>' +
                            '<div class="sk-campaign-msub  sk-base"></div>' +
                            '<div class="sk-campaign-mprog sk-base"></div>' +
                        '</div>' +
                    '</div>';
            }
            return '<div class="d-none d-lg-block"><div class="sk-campaign-grid">'  + desktop + '</div></div>' +
                   '<div class="d-lg-none"><div class="sk-campaign-carousel">'       + mobile  + '</div></div>';
        }

        /* ── article ─────────────────────────────────────────── */
        if (type === 'article') {
            for (var i = 0; i < dc; i++) {
                desktop +=
                    '<div class="sk-article-card">' +
                        '<div class="sk-article-img sk-base"></div>' +
                        '<div class="sk-article-body">' +
                            '<div class="sk-article-badge sk-base"></div>' +
                            '<div class="sk-article-ttl   sk-base"></div>' +
                            '<div class="sk-article-ttl2  sk-base"></div>' +
                            '<div class="sk-article-people">' +
                                '<div class="sk-article-avatar sk-base"></div>' +
                                '<div class="sk-article-pinfo">' +
                                    '<div class="sk-article-plabel sk-base"></div>' +
                                    '<div class="sk-article-pname  sk-base"></div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="sk-article-btn sk-base"></div>' +
                        '</div>' +
                    '</div>';
            }
            for (var j = 0; j < mc; j++) {
                mobile +=
                    '<div class="sk-article-mcard">' +
                        '<div class="sk-article-mimg sk-base"></div>' +
                        '<div class="sk-article-mbody">' +
                            '<div class="sk-article-mtheme sk-base"></div>' +
                            '<div class="sk-article-mttl   sk-base"></div>' +
                            '<div class="sk-article-mttl2  sk-base"></div>' +
                            '<div class="sk-article-mpeople">' +
                                '<div class="sk-article-mavatar sk-base"></div>' +
                                '<div class="sk-article-mpinfo">' +
                                    '<div class="sk-article-mplabel sk-base"></div>' +
                                    '<div class="sk-article-mpname  sk-base"></div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
            }
            return '<div class="d-none d-lg-block"><div class="sk-article-grid">'  + desktop + '</div></div>' +
                   '<div class="d-lg-none"><div class="sk-article-carousel">'       + mobile  + '</div></div>';
        }

        /* ── book ────────────────────────────────────────────── */
        if (type === 'book') {
            for (var i = 0; i < dc; i++) {
                desktop +=
                    '<div class="sk-book-card">' +
                        '<div class="sk-book-cover sk-base"></div>' +
                        '<div class="sk-book-content">' +
                            '<div class="sk-book-ttl sk-base"></div>' +
                            '<div class="sk-book-meta-row">' +
                                '<div class="sk-book-meta-date  sk-base"></div>' +
                                '<div class="sk-book-meta-badge sk-base"></div>' +
                            '</div>' +
                            '<div class="sk-book-tabs-nav">' +
                                '<div class="sk-book-tab sk-book-tab-1 sk-base"></div>' +
                                '<div class="sk-book-tab sk-book-tab-2 sk-base"></div>' +
                            '</div>' +
                            '<div class="sk-book-specs">' +
                                '<div class="sk-book-spec-row"><div class="sk-book-spec-label sk-base"></div><div class="sk-book-spec-val sk-base"></div></div>' +
                                '<div class="sk-book-spec-row"><div class="sk-book-spec-label sk-base"></div><div class="sk-book-spec-val sk-base"></div></div>' +
                                '<div class="sk-book-spec-row"><div class="sk-book-spec-label sk-base"></div><div class="sk-book-spec-val sk-base"></div></div>' +
                                '<div class="sk-book-spec-row"><div class="sk-book-spec-label sk-base"></div><div class="sk-book-spec-val sk-base"></div></div>' +
                                '<div class="sk-book-spec-row"><div class="sk-book-spec-label sk-base"></div><div class="sk-book-spec-val sk-base"></div></div>' +
                            '</div>' +
                            '<div class="sk-book-actions">' +
                                '<div class="sk-book-btn    sk-base"></div>' +
                                '<div class="sk-book-btn-sm sk-base"></div>' +
                                '<div class="sk-book-btn-sm sk-base"></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
            }
            for (var j = 0; j < mc; j++) {
                mobile +=
                    '<div class="sk-book-mcard">' +
                        '<div class="sk-book-mcover sk-base"></div>' +
                        '<div class="sk-book-mbody">' +
                            '<div class="sk-book-mttl  sk-base"></div>' +
                            '<div class="sk-book-mauth sk-base"></div>' +
                            '<div class="sk-book-mhint sk-base"></div>' +
                        '</div>' +
                    '</div>';
            }
            return '<div class="d-none d-lg-block"><div class="sk-book-list">'  + desktop + '</div></div>' +
                   '<div class="d-lg-none"><div class="sk-book-carousel">'      + mobile  + '</div></div>';
        }

        /* ── event ───────────────────────────────────────────── */
        if (type === 'event') {
            for (var i = 0; i < dc; i++) {
                desktop +=
                    '<div class="sk-event-card">' +
                        '<div class="sk-event-img sk-base"></div>' +
                        '<div class="sk-event-body">' +
                            '<div class="sk-event-div   sk-base"></div>' +
                            '<div class="sk-event-ttl   sk-base"></div>' +
                            '<div class="sk-event-ttl2  sk-base"></div>' +
                            '<div class="sk-event-meta  sk-base"></div>' +
                            '<div class="sk-event-meta2 sk-base"></div>' +
                            '<div class="sk-event-btn   sk-base"></div>' +
                        '</div>' +
                    '</div>';
            }
            for (var j = 0; j < mc; j++) {
                mobile +=
                    '<div class="sk-event-mcard">' +
                        '<div class="sk-event-mimg sk-base"></div>' +
                        '<div class="sk-event-mbody">' +
                            '<div class="sk-event-mdiv  sk-base"></div>' +
                            '<div class="sk-event-mttl  sk-base"></div>' +
                            '<div class="sk-event-mttl2 sk-base"></div>' +
                        '</div>' +
                    '</div>';
            }
            return '<div class="d-none d-lg-block"><div class="sk-event-grid">'  + desktop + '</div></div>' +
                   '<div class="d-lg-none"><div class="sk-event-carousel">'       + mobile  + '</div></div>';
        }

        /* ── gallery ─────────────────────────────────────────── */
        if (type === 'gallery') {
            for (var i = 0; i < dc; i++) {
                desktop +=
                    '<div class="sk-gallery-card">' +
                        '<div class="sk-gallery-header sk-base"></div>' +
                        '<div class="sk-gallery-body">' +
                            '<div class="sk-gallery-ttl   sk-base"></div>' +
                            '<div class="sk-gallery-desc  sk-base"></div>' +
                            '<div class="sk-gallery-desc2 sk-base"></div>' +
                            '<div class="sk-gallery-photos">' +
                                '<div class="sk-gallery-photo sk-base"></div>' +
                                '<div class="sk-gallery-photo sk-base"></div>' +
                                '<div class="sk-gallery-photo sk-base"></div>' +
                                '<div class="sk-gallery-photo sk-base"></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
            }
            for (var j = 0; j < mc; j++) {
                mobile +=
                    '<div class="sk-gallery-mcard">' +
                        '<div class="sk-gallery-mthumb sk-base"></div>' +
                        '<div class="sk-gallery-mbody">' +
                            '<div class="sk-gallery-mttl   sk-base"></div>' +
                            '<div class="sk-gallery-mdesc  sk-base"></div>' +
                            '<div class="sk-gallery-mdesc2 sk-base"></div>' +
                        '</div>' +
                    '</div>';
            }
            return '<div class="d-none d-lg-block"><div class="sk-gallery-list">'  + desktop + '</div></div>' +
                   '<div class="d-lg-none"><div class="sk-gallery-mlist">'         + mobile  + '</div></div>';
        }

        /* ── news ────────────────────────────────────────────── */
        if (type === 'news') {
            for (var i = 0; i < dc; i++) {
                desktop +=
                    '<div class="sk-news-card">' +
                        '<div class="sk-news-img sk-base"></div>' +
                        '<div class="sk-news-body">' +
                            '<div class="sk-news-pub  sk-base"></div>' +
                            '<div class="sk-news-ttl  sk-base"></div>' +
                            '<div class="sk-news-ttl2 sk-base"></div>' +
                            '<div class="sk-news-exc  sk-base"></div>' +
                            '<div class="sk-news-exc2 sk-base"></div>' +
                            '<div class="sk-news-people">' +
                                '<div class="sk-news-avatar sk-base"></div>' +
                                '<div class="sk-news-pinfo">' +
                                    '<div class="sk-news-plabel sk-base"></div>' +
                                    '<div class="sk-news-pname  sk-base"></div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="sk-news-btn sk-base"></div>' +
                        '</div>' +
                    '</div>';
            }
            for (var j = 0; j < mc; j++) {
                mobile +=
                    '<div class="sk-news-mcard">' +
                        '<div class="sk-news-mimg sk-base"></div>' +
                        '<div class="sk-news-mbody">' +
                            '<div class="sk-news-mpub  sk-base"></div>' +
                            '<div class="sk-news-mttl  sk-base"></div>' +
                            '<div class="sk-news-mttl2 sk-base"></div>' +
                            '<div class="sk-news-mpeople">' +
                                '<div class="sk-news-mavatar sk-base"></div>' +
                                '<div class="sk-news-mpinfo">' +
                                    '<div class="sk-news-mplabel sk-base"></div>' +
                                    '<div class="sk-news-mpname  sk-base"></div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
            }
            return '<div class="d-none d-lg-block"><div class="sk-news-grid">'  + desktop + '</div></div>' +
                   '<div class="d-lg-none"><div class="sk-news-carousel">'       + mobile  + '</div></div>';
        }

        /* ── callkestari ─────────────────────────────────────── */
        if (type === 'callkestari') {
            for (var i = 0; i < dc; i++) {
                desktop +=
                    '<div class="sk-ck-card">' +
                        '<div class="sk-ck-icon-wrap">' +
                            '<div class="sk-ck-icon sk-base"></div>' +
                        '</div>' +
                        '<div class="sk-ck-body">' +
                            '<div class="sk-ck-name  sk-base"></div>' +
                            '<div class="sk-ck-link  sk-base"></div>' +
                            '<div class="sk-ck-link2 sk-base"></div>' +
                            '<div class="sk-ck-footer">' +
                                '<div class="sk-ck-share  sk-base"></div>' +
                                '<div class="sk-ck-share2 sk-base"></div>' +
                                '<div class="sk-ck-cta    sk-base"></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
            }
            for (var j = 0; j < mc; j++) {
                mobile +=
                    '<div class="sk-ck-mcard">' +
                        '<div class="sk-ck-micon sk-base"></div>' +
                        '<div class="sk-ck-minfo">' +
                            '<div class="sk-ck-mname sk-base"></div>' +
                            '<div class="sk-ck-mlink sk-base"></div>' +
                        '</div>' +
                        '<div class="sk-ck-marrow sk-base"></div>' +
                    '</div>';
            }
            return '<div class="d-none d-md-block"><div class="sk-ck-grid">'  + desktop + '</div></div>' +
                   '<div class="d-md-none"><div class="sk-ck-mlist">'         + mobile  + '</div></div>';
        }

        return ''; /* unknown type */
    };
}
</script>
