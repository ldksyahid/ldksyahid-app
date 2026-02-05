{{-- Article Section - Fun & Modern Design --}}
<section class="article-fun py-5">
    <div class="container">
        {{-- Section Header --}}
        <div class="row mb-4 mb-lg-5 align-items-center justify-content-between wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="section-badge-fun">
                    <span class="badge-emoji">📝</span>
                    <span>Artikel</span>
                </div>
                <h2 class="section-title-fun">
                    Karya Tulis Kita
                    <span class="title-sparkle">✨</span>
                </h2>
                <p class="section-description-fun">
                    Hasil tulisan penuh semangat dari para anggota LDK Syahid. Yuk baca! 📚
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="/articles" class="btn-view-all">
                    <span>Lihat Semua</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Article Cards --}}
        <div class="article-grid">
            @forelse($postarticle as $key => $article)
            <div class="article-card-fun wow fadeInUp" data-wow-delay="{{ 0.1 + ($key * 0.1) }}s">
                {{-- Image --}}
                <a href="/articles/{{ $article->id }}" class="article-image-link">
                    <img src="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                         alt="{{ $article->title }}"
                         class="article-img">
                    {{-- Date Badge --}}
                    <div class="article-date-badge">
                        <span class="date-day">{{ \Carbon\Carbon::parse($article->dateevent)->format('d') }}</span>
                        <span class="date-month">{{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('MMM') }}</span>
                    </div>
                    {{-- Category Emoji --}}
                    <div class="article-emoji">📖</div>
                </a>

                {{-- Content --}}
                <div class="article-content">
                    {{-- Theme --}}
                    <span class="article-theme">{{ $article->theme ?? 'Artikel' }}</span>

                    {{-- Title --}}
                    <h5 class="article-title">
                        <a href="/articles/{{ $article->id }}">{{ $article->title }}</a>
                    </h5>

                    {{-- Writer --}}
                    <div class="article-writer">
                        <div class="writer-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="writer-name">{{ $article->writer }}</span>
                    </div>

                    {{-- Read Button --}}
                    <a href="/articles/{{ $article->id }}" class="article-read-btn">
                        <span>Baca</span>
                        <i class="fas fa-book-open"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state-fun">
                    <div class="empty-emoji">📭</div>
                    <h4>Belum Ada Artikel</h4>
                    <p>Artikel sedang dalam proses penulisan. Tunggu ya!</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    .article-fun {
        background: transparent;
    }

    /* Section Header */
    .section-badge-fun {
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

    .title-sparkle {
        display: inline-block;
        animation: sparkleRotate 2s ease-in-out infinite;
    }

    @keyframes sparkleRotate {
        0%, 100% { transform: rotate(0deg) scale(1); }
        50% { transform: rotate(15deg) scale(1.2); }
    }

    .section-description-fun {
        color: var(--secondary);
        font-size: 1rem;
    }

    /* View All Button */
    .btn-view-all {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        color: var(--primary);
        padding: 0.875rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 2px solid var(--primary-light);
    }

    .btn-view-all:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 167, 157, 0.3);
    }

    .btn-view-all i {
        transition: transform 0.3s ease;
    }

    .btn-view-all:hover i {
        transform: translateX(5px);
    }

    /* Article Grid */
    .article-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    /* Article Card */
    .article-card-fun {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        transition: all 0.4s ease;
    }

    .article-card-fun:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
    }

    /* Image */
    .article-image-link {
        display: block;
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .article-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .article-card-fun:hover .article-img {
        transform: scale(1.1);
    }

    .article-date-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: white;
        border-radius: 12px;
        padding: 0.5rem 0.75rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .date-day {
        display: block;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        line-height: 1;
    }

    .date-month {
        display: block;
        font-size: 0.7rem;
        color: var(--secondary);
        text-transform: uppercase;
    }

    .article-emoji {
        position: absolute;
        bottom: 15px;
        right: 15px;
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .article-card-fun:hover .article-emoji {
        transform: scale(1.1) rotate(10deg);
    }

    /* Content */
    .article-content {
        padding: 1.5rem;
    }

    .article-theme {
        display: inline-block;
        background: var(--primary-light);
        color: var(--primary);
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .article-title {
        font-family: var(--font-primary);
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .article-title a {
        color: var(--dark);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .article-title a:hover {
        color: var(--primary);
    }

    /* Writer */
    .article-writer {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .writer-avatar {
        width: 28px;
        height: 28px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 0.7rem;
    }

    .writer-name {
        color: var(--secondary);
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Read Button */
    .article-read-btn {
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
    }

    .article-read-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(0, 167, 157, 0.4);
        color: white;
    }

    /* Empty State */
    .empty-state-fun {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
    }

    .empty-emoji {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .empty-state-fun h4 {
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .empty-state-fun p {
        color: var(--secondary);
    }

    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .article-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .article-image-link {
            height: 150px;
        }

        .section-title-fun {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 575.98px) {
        .article-grid {
            grid-template-columns: 1fr;
        }

        .article-content {
            padding: 1rem;
        }

        .btn-view-all {
            width: 100%;
            justify-content: center;
        }
    }
</style>
