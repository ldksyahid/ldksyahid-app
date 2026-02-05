{{-- News Section - Fun & Modern Design --}}
<section class="news-fun py-5">
    <div class="container">
        {{-- Section Header --}}
        <div class="row mb-4 mb-lg-5 align-items-center justify-content-between wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="section-badge-news">
                    <span class="badge-emoji">📰</span>
                    <span>Berita</span>
                </div>
                <h2 class="section-title-fun">
                    Berita Terbaru
                    <span class="title-emoji-news">🔥</span>
                </h2>
                <p class="section-description-fun">
                    Info terkini dari LDK Syahid. Jangan sampai ketinggalan ya!
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="/news" class="btn-view-all-news">
                    <span>Semua Berita</span>
                    <i class="fas fa-newspaper"></i>
                </a>
            </div>
        </div>

        {{-- News Cards --}}
        <div class="news-list">
            @forelse($postnews as $key => $news)
            <div class="news-card-fun wow fadeInUp" data-wow-delay="{{ 0.1 + ($key * 0.1) }}s">
                <div class="news-card-inner">
                    {{-- Image --}}
                    <a href="/news/{{ $news->id }}" class="news-image-link">
                        <img src="https://lh3.googleusercontent.com/d/{{ $news->gdrive_id }}"
                             alt="{{ $news->title }}"
                             class="news-img">
                        <div class="news-emoji-badge">📰</div>
                    </a>

                    {{-- Content --}}
                    <div class="news-content">
                        {{-- Date --}}
                        <div class="news-date-tag">
                            <i class="far fa-calendar-alt"></i>
                            <span class="d-none d-md-inline">{{ \Carbon\Carbon::parse($news->datepublish)->isoFormat('dddd, D MMMM Y') }}</span>
                            <span class="d-md-none">{{ \Carbon\Carbon::parse($news->datepublish)->isoFormat('D MMM Y') }}</span>
                        </div>

                        {{-- Title --}}
                        <h4 class="news-title">
                            <a href="/news/{{ $news->id }}">{{ $news->title }}</a>
                        </h4>

                        {{-- Meta (Desktop) --}}
                        <div class="news-meta d-none d-md-flex">
                            <div class="meta-item">
                                <i class="fas fa-user"></i>
                                <span>{{ $news->reporter }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-edit"></i>
                                <span>{{ $news->editor }}</span>
                            </div>
                        </div>

                        {{-- Excerpt (Desktop) --}}
                        <p class="news-excerpt d-none d-lg-block">
                            {!! substr(strip_tags($news->body), 0, 120) !!}...
                        </p>

                        {{-- Read Button --}}
                        <a href="/news/{{ $news->id }}/show" class="news-read-btn">
                            <span class="d-none d-md-inline">Baca Selengkapnya</span>
                            <span class="d-md-none">Baca</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state-news">
                <div class="empty-emoji">📭</div>
                <h4>Belum Ada Berita</h4>
                <p>Berita terbaru akan segera hadir. Stay tuned!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    .news-fun {
        background: transparent;
    }

    /* Section Badge */
    .section-badge-news {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        border: 1px solid rgba(0, 167, 157, 0.2);
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary);
    }

    .section-title-fun {
        font-family: var(--font-primary);
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .title-emoji-news {
        display: inline-block;
        animation: fireAnimation 0.5s ease-in-out infinite alternate;
    }

    @keyframes fireAnimation {
        0% { transform: scale(1); }
        100% { transform: scale(1.2); }
    }

    .section-description-fun {
        color: var(--secondary);
        font-size: 1rem;
    }

    /* View All Button */
    .btn-view-all-news {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: var(--primary-gradient);
        color: white;
        padding: 0.875rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
        transition: all 0.3s ease;
    }

    .btn-view-all-news:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 167, 157, 0.4);
        color: white;
    }

    /* News List */
    .news-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* News Card */
    .news-card-fun {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        transition: all 0.4s ease;
    }

    .news-card-fun:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    }

    .news-card-inner {
        display: flex;
        align-items: stretch;
    }

    /* Image */
    .news-image-link {
        position: relative;
        width: 35%;
        min-height: 200px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .news-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .news-card-fun:hover .news-img {
        transform: scale(1.1);
    }

    .news-emoji-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        width: 45px;
        height: 45px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Content */
    .news-content {
        flex: 1;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
    }

    .news-date-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        color: var(--primary);
        padding: 0.375rem 0.875rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        width: fit-content;
    }

    .news-title {
        font-family: var(--font-primary);
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .news-title a {
        color: var(--dark);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .news-title a:hover {
        color: var(--primary);
    }

    /* Meta */
    .news-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        color: var(--secondary);
        font-size: 0.85rem;
    }

    .meta-item i {
        color: var(--primary);
        font-size: 0.75rem;
    }

    /* Excerpt */
    .news-excerpt {
        color: var(--secondary);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    /* Read Button */
    .news-read-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-gradient);
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-top: auto;
        width: fit-content;
    }

    .news-read-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0, 167, 157, 0.4);
        color: white;
    }

    .news-read-btn i {
        transition: transform 0.3s ease;
    }

    .news-read-btn:hover i {
        transform: translateX(5px);
    }

    /* Empty State */
    .empty-state-news {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
    }

    .empty-state-news .empty-emoji {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .empty-state-news h4 {
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .empty-state-news p {
        color: var(--secondary);
    }

    /* Mobile Responsive */
    @media (max-width: 767.98px) {
        .news-image-link {
            width: 40%;
            min-height: 150px;
        }

        .news-content {
            padding: 1rem;
        }

        .news-title {
            font-size: 0.95rem;
        }

        .news-emoji-badge {
            width: 35px;
            height: 35px;
            font-size: 1.1rem;
            top: 10px;
            left: 10px;
        }

        .section-title-fun {
            font-size: 1.5rem;
        }

        .btn-view-all-news {
            width: 100%;
            justify-content: center;
        }
    }
</style>
