{{-- KMB Class Section - Fun & Modern Design --}}
<section class="kmb-fun py-5">
    <div class="container">
        {{-- Section Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="section-badge-fun">
                <span class="badge-emoji">🎨</span>
                <span>Yuk Ikut KMB!</span>
            </div>
            <h2 class="section-title-fun">
                Kelas Minat Bakat
                <span class="title-emoji">✨</span>
            </h2>
            <p class="section-description-fun">
                Kembangkan bakat dan potensimu bersama kami! Ada banyak kelas seru yang menunggumu.
            </p>
        </div>

        {{-- KMB Cards --}}
        @php
            $kelas = [
                [
                    'img' => 'https://lh3.googleusercontent.com/d/1Libi_zhvvc5nC5IU10puFt_p28fRi5vG',
                    'title' => 'Kepenulisan Fiksi',
                    'icon' => '✍️',
                    'color' => '#6366f1',
                    'light' => '#eef2ff',
                    'desc' => 'Tulis cerpen, puisi, novel, dan karya fiksi lainnya!'
                ],
                [
                    'img' => 'https://lh3.googleusercontent.com/d/1tl4ZDZRMmAzi0MOGYJkXk-0WYSLWIBIy',
                    'title' => 'Kepenulisan Non Fiksi',
                    'icon' => '📚',
                    'color' => '#10b981',
                    'light' => '#ecfdf5',
                    'desc' => 'Asah kemampuan menulis esai dan karya ilmiah!'
                ],
                [
                    'img' => 'https://lh3.googleusercontent.com/d/16rCOS6itQtju7N6ELYwQpLTkAESQ9PEd',
                    'title' => 'Entrepreneur',
                    'icon' => '💼',
                    'color' => '#f59e0b',
                    'light' => '#fffbeb',
                    'desc' => 'Jadi pengusaha muda yang kreatif dan inovatif!'
                ],
                [
                    'img' => 'https://lh3.googleusercontent.com/d/1lfwpEtfLepTOcmu6DcZlmX-7RY01g_Lv',
                    'title' => 'Public Speaking',
                    'icon' => '🎤',
                    'color' => '#ef4444',
                    'light' => '#fef2f2',
                    'desc' => 'Percaya diri berbicara di depan umum!'
                ],
                [
                    'img' => 'https://lh3.googleusercontent.com/d/126xPzrizaxfbhH0iQj0rjFh9n19JlI3Y',
                    'title' => 'Desain Grafis',
                    'icon' => '🎨',
                    'color' => '#8b5cf6',
                    'light' => '#f5f3ff',
                    'desc' => 'Ciptakan desain visual yang keren dan menarik!'
                ],
            ];
        @endphp

        <div class="kmb-grid">
            @foreach($kelas as $key => $kmb)
            <div class="kmb-card-fun wow fadeInUp" data-wow-delay="{{ 0.1 + ($key * 0.1) }}s" style="--accent-color: {{ $kmb['color'] }}; --light-color: {{ $kmb['light'] }};">
                {{-- Floating emoji decoration --}}
                <div class="kmb-deco">{{ $kmb['icon'] }}</div>

                {{-- Image --}}
                <div class="kmb-image-wrapper">
                    <img src="{{ $kmb['img'] }}" alt="{{ $kmb['title'] }}" class="kmb-image">
                    <div class="kmb-emoji-badge">{{ $kmb['icon'] }}</div>
                </div>

                {{-- Content --}}
                <div class="kmb-content">
                    <h5 class="kmb-title">{{ $kmb['title'] }}</h5>
                    <p class="kmb-desc">{{ $kmb['desc'] }}</p>
                </div>

                {{-- Hover overlay --}}
                <div class="kmb-overlay">
                    <span class="kmb-overlay-emoji">{{ $kmb['icon'] }}</span>
                    <span class="kmb-overlay-text">Gabung Sekarang!</span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- CTA --}}
        <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.5s">
            <div class="kmb-cta-box">
                <span class="cta-emoji">🌟</span>
                <span class="cta-text">Tunggu apa lagi? Kembangkan potensimu bersama KMB!</span>
            </div>
        </div>
    </div>
</section>

<style>
    .kmb-fun {
        background: transparent;
        position: relative;
    }

    /* Section Badge */
    .section-badge-fun {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        border: 1px solid rgba(0, 167, 157, 0.2);
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary);
    }

    .section-title-fun {
        font-family: var(--font-primary);
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .title-emoji {
        display: inline-block;
        animation: bounce 1s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .section-description-fun {
        color: var(--secondary);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* KMB Grid */
    .kmb-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    /* KMB Card */
    .kmb-card-fun {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .kmb-card-fun::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--accent-color);
    }

    .kmb-card-fun:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
    }

    /* Decoration */
    .kmb-deco {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.5rem;
        opacity: 0.2;
        transition: all 0.3s ease;
    }

    .kmb-card-fun:hover .kmb-deco {
        opacity: 0.5;
        transform: rotate(15deg) scale(1.2);
    }

    /* Image */
    .kmb-image-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto 1rem;
    }

    .kmb-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid var(--light-color);
        transition: all 0.3s ease;
    }

    .kmb-card-fun:hover .kmb-image {
        border-color: var(--accent-color);
        transform: scale(1.05);
    }

    .kmb-emoji-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 36px;
        height: 36px;
        background: var(--accent-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border: 3px solid white;
    }

    /* Content */
    .kmb-title {
        font-family: var(--font-primary);
        font-weight: 700;
        font-size: 1rem;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .kmb-desc {
        color: var(--secondary);
        font-size: 0.85rem;
        margin: 0;
        line-height: 1.5;
    }

    /* Overlay */
    .kmb-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: var(--accent-color);
        padding: 1rem;
        transform: translateY(100%);
        transition: transform 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .kmb-card-fun:hover .kmb-overlay {
        transform: translateY(0);
    }

    .kmb-overlay-emoji {
        font-size: 1.25rem;
    }

    .kmb-overlay-text {
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* CTA Box */
    .kmb-cta-box {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: var(--primary-gradient);
        border: none;
        border-radius: 50px;
        padding: 1rem 2rem;
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
    }

    .kmb-cta-box .cta-emoji {
        font-size: 1.5rem;
        animation: bounce 1s ease-in-out infinite;
    }

    .kmb-cta-box .cta-text {
        color: white;
        font-weight: 600;
    }

    /* Mobile Responsive */
    @media (max-width: 767.98px) {
        .kmb-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .kmb-card-fun {
            padding: 1rem;
        }

        .kmb-image-wrapper {
            width: 70px;
            height: 70px;
        }

        .kmb-emoji-badge {
            width: 28px;
            height: 28px;
            font-size: 0.8rem;
        }

        .kmb-title {
            font-size: 0.85rem;
        }

        .kmb-desc {
            display: none;
        }

        .section-title-fun {
            font-size: 1.75rem;
        }

        .kmb-cta-box {
            flex-direction: column;
            padding: 1rem 1.5rem;
        }
    }
</style>
