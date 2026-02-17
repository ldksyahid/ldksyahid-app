{{-- Contact Us Section - Modern & Elegant Design --}}
<section class="contact-section py-5">
    <div class="container">
        {{-- Header - Centered with Pulse Badge --}}
        <div class="text-center mb-5 contact-header-wrap">
            <div class="contact-badge">
                <span class="contact-badge__emoji">💬</span>
                <span>Hubungi Kami</span>
                <span class="contact-badge__pulse"></span>
            </div>
            <h2 class="contact-heading">
                Ada Pertanyaan?
                <span class="contact-heading__wave">👋</span>
            </h2>
            <p class="contact-subheading">
                Jika kamu memiliki pertanyaan, kritik, atau saran, jangan ragu untuk menghubungi kami ya!
            </p>
        </div>

        {{-- Main Content Grid --}}
        <div class="row g-4 g-lg-5 align-items-start">
            {{-- Left Side - Contact Info --}}
            <div class="col-lg-5">
                <div class="contact-info">
                    {{-- Quote Card --}}
                    <div class="contact-quote-card">
                        <div class="contact-quote-card__icon">📖</div>
                        <p class="contact-quote-card__text">
                            "Dan Kami tidak mengutus sebelum engkau (Muhammad), melainkan orang laki-laki yang Kami beri wahyu kepada mereka; maka bertanyalah kepada orang yang mempunyai pengetahuan jika kamu tidak mengetahui,"
                        </p>
                        <div class="contact-quote-card__source">
                            <span class="source-emoji">✨</span>
                            <span class="source-text">QS. An-Nahl 16: Ayat 43</span>
                        </div>
                    </div>

                    {{-- Contact Methods --}}
                    <div class="contact-methods">
                        <div class="contact-method-item">
                            <div class="contact-method-item__icon">
                                <span>📧</span>
                            </div>
                            <div class="contact-method-item__content">
                                <span class="contact-method-item__label">Email</span>
                                <a href="mailto:ldksyahid@uinjkt.ac.id" class="contact-method-item__value">
                                    ldksyahid@uinjkt.ac.id
                                </a>
                            </div>
                        </div>

                        <div class="contact-method-item">
                            <div class="contact-method-item__icon">
                                <span>📍</span>
                            </div>
                            <div class="contact-method-item__content">
                                <span class="contact-method-item__label">Lokasi</span>
                                <span class="contact-method-item__value">UIN Syarif Hidayatullah Jakarta</span>
                            </div>
                        </div>

                        <div class="contact-method-item">
                            <div class="contact-method-item__icon">
                                <span>🕒</span>
                            </div>
                            <div class="contact-method-item__content">
                                <span class="contact-method-item__label">Jam Operasional</span>
                                <span class="contact-method-item__value">Senin - Jumat, 08:00 - 17:00 WIB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side - Contact Form --}}
            <div class="col-lg-7">
                <div class="contact-form-card">
                    <div class="contact-form-card__header">
                        <span class="contact-form-card__emoji">✉️</span>
                        <h4 class="contact-form-card__title">Kirim Pesan</h4>
                        <p class="contact-form-card__subtitle">Kami akan segera membalas pesanmu!</p>
                    </div>

                    <form role="form"
                          action='/about/contact/message/store'
                          method='post'
                          enctype="multipart/form-data"
                          class="contact-form"
                          id="contact-form"
                          novalidate>
                        @csrf
                        @method('POST')

                        <div class="contact-form__row">
                            {{-- Name Input --}}
                            <div class="contact-form__group">
                                <label class="contact-form__label">
                                    <span class="label-emoji">👤</span>
                                    <span>Nama Kamu</span>
                                </label>
                                <input type="text"
                                       class="contact-form__input"
                                       id="contact-name"
                                       name="name"
                                       placeholder="Masukkan namamu"
                                       required/>
                            </div>

                            {{-- Email Input --}}
                            <div class="contact-form__group">
                                <label class="contact-form__label">
                                    <span class="label-emoji">📧</span>
                                    <span>Email Kamu</span>
                                </label>
                                <input type="email"
                                       class="contact-form__input"
                                       id="contact-email"
                                       name="email"
                                       placeholder="Masukkan emailmu"
                                       required/>
                            </div>
                        </div>

                        {{-- Subject Input --}}
                        <div class="contact-form__group">
                            <label class="contact-form__label">
                                <span class="label-emoji">📌</span>
                                <span>Subjek</span>
                            </label>
                            <input type="text"
                                   class="contact-form__input"
                                   id="contact-subject"
                                   name="subject"
                                   placeholder="Tentang apa pesanmu?"
                                   required/>
                        </div>

                        {{-- Message Textarea --}}
                        <div class="contact-form__group">
                            <label class="contact-form__label">
                                <span class="label-emoji">💭</span>
                                <span>Pesan</span>
                            </label>
                            <textarea class="contact-form__textarea"
                                      placeholder="Tulis pesanmu di sini..."
                                      name="message"
                                      id="contact-message"
                                      rows="4"
                                      required></textarea>
                        </div>

                        {{-- Submit Button --}}
                        <button class="contact-form__submit" type="submit">
                            <span class="btn-emoji">🚀</span>
                            <span>Kirim Pesan</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* ========================================
       CONTACT SECTION - MAIN STYLES
    ======================================== */
    .contact-section {
        background: transparent;
        position: relative;
        overflow: hidden;
    }

    /* ========================================
       HEADER - CENTERED WITH PULSE BADGE
    ======================================== */
    .contact-header-wrap {
        opacity: 0;
        transform: translateY(30px);
        animation: contactHeaderFadeIn 0.8s ease-out 0.2s forwards;
    }

    @keyframes contactHeaderFadeIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Pulse Badge - Matching About Section Style */
    .contact-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        background: rgba(0, 167, 157, 0.1);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(0, 167, 157, 0.2);
        border-radius: 50px;
        padding: 0.625rem 1.5rem;
        margin-bottom: 1.25rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--primary);
        position: relative;
        transition: all 0.3s ease;
    }

    .contact-badge__emoji {
        font-size: 1.25rem;
        animation: contactBadgeFloat 3s ease-in-out infinite;
    }

    @keyframes contactBadgeFloat {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-5px);
        }
    }

    .contact-badge__pulse {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        border: 2px solid var(--primary);
        border-radius: 50px;
        transform: translate(-50%, -50%);
        animation: contactBadgePulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        pointer-events: none;
    }

    @keyframes contactBadgePulse {
        0% {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
        100% {
            opacity: 0;
            transform: translate(-50%, -50%) scale(1.4);
        }
    }

    /* Section Heading */
    .contact-heading {
        font-family: var(--font-primary);
        font-size: 2.75rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .contact-heading__wave {
        display: inline-block;
        animation: contactWaveHand 1.5s ease-in-out infinite;
        transform-origin: 70% 70%;
    }

    @keyframes contactWaveHand {
        0%, 100% {
            transform: rotate(0deg);
        }
        25% {
            transform: rotate(20deg);
        }
        75% {
            transform: rotate(-10deg);
        }
    }

    .contact-subheading {
        color: var(--secondary);
        font-size: 1.1rem;
        line-height: 1.7;
        max-width: 600px;
        margin: 0 auto;
    }

    /* ========================================
       LEFT SIDE - CONTACT INFO
    ======================================== */
    .contact-info {
        opacity: 0;
        transform: translateX(-30px);
    }

    .contact-info.contact-animate-in {
        animation: contactSlideInLeft 0.8s ease-out forwards;
    }

    @keyframes contactSlideInLeft {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Quote Card */
    .contact-quote-card {
        background: linear-gradient(135deg, rgba(0, 167, 157, 0.08) 0%, rgba(0, 167, 157, 0.03) 100%);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(0, 167, 157, 0.15);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .contact-quote-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(0, 167, 157, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .contact-quote-card:hover::before {
        opacity: 1;
    }

    .contact-quote-card:hover {
        transform: translateY(-5px);
        border-color: rgba(0, 167, 157, 0.3);
        box-shadow: 0 12px 40px rgba(0, 167, 157, 0.15);
    }

    .contact-quote-card__icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        animation: contactQuoteFloat 4s ease-in-out infinite;
    }

    @keyframes contactQuoteFloat {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-8px) rotate(5deg);
        }
    }

    .contact-quote-card__text {
        color: var(--dark);
        font-size: 0.95rem;
        font-style: italic;
        line-height: 1.8;
        margin-bottom: 1.25rem;
        text-align: justify;
        position: relative;
        z-index: 1;
    }

    .contact-quote-card__source {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-gradient);
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .contact-quote-card__source:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 167, 157, 0.4);
    }

    .contact-quote-card__source .source-emoji {
        animation: contactSparkle 2s ease-in-out infinite;
    }

    @keyframes contactSparkle {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.7;
            transform: scale(1.2);
        }
    }

    /* Contact Methods */
    .contact-methods {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .contact-method-item {
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 20px;
        border: 2px solid rgba(0, 167, 157, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .contact-method-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-gradient);
        transform: scaleY(0);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .contact-method-item:hover {
        transform: translateX(8px);
        border-color: rgba(0, 167, 157, 0.3);
        box-shadow: 0 8px 30px rgba(0, 167, 157, 0.15);
        background: rgba(255, 255, 255, 0.9);
    }

    .contact-method-item:hover::before {
        transform: scaleY(1);
    }

    .contact-method-item__icon {
        flex-shrink: 0;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-light);
        border-radius: 14px;
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .contact-method-item:hover .contact-method-item__icon {
        transform: scale(1.1) rotate(5deg);
        background: linear-gradient(135deg, rgba(0, 167, 157, 0.2) 0%, rgba(0, 167, 157, 0.1) 100%);
    }

    .contact-method-item__content {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        flex: 1;
    }

    .contact-method-item__label {
        font-size: 0.8rem;
        color: var(--secondary);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .contact-method-item__value {
        font-weight: 600;
        color: var(--primary);
        font-size: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .contact-method-item__value:hover {
        color: var(--primary);
        text-decoration: underline;
    }

    /* ========================================
       RIGHT SIDE - CONTACT FORM
    ======================================== */
    .contact-form-card {
        background: linear-gradient(135deg, rgba(0, 167, 157, 0.05) 0%, rgba(255, 255, 255, 0.8) 100%);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(0, 167, 157, 0.15);
        border-radius: 28px;
        padding: 2.5rem;
        box-shadow: 0 20px 60px rgba(0, 167, 157, 0.08);
        opacity: 0;
        transform: translateX(30px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .contact-form-card.contact-animate-in {
        animation: contactSlideInRight 0.8s ease-out forwards;
    }

    @keyframes contactSlideInRight {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .contact-form-card:hover {
        border-color: rgba(0, 167, 157, 0.25);
        box-shadow: 0 25px 70px rgba(0, 167, 157, 0.12);
    }

    /* Form Header */
    .contact-form-card__header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .contact-form-card__emoji {
        font-size: 3rem;
        display: block;
        margin-bottom: 0.75rem;
        animation: contactFormEmojiFloat 3s ease-in-out infinite;
    }

    @keyframes contactFormEmojiFloat {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-10px) rotate(10deg);
        }
    }

    .contact-form-card__title {
        font-family: var(--font-primary);
        font-weight: 700;
        font-size: 1.75rem;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .contact-form-card__subtitle {
        color: var(--secondary);
        font-size: 0.95rem;
        margin: 0;
    }

    /* Form Styles */
    .contact-form__row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.25rem;
    }

    .contact-form__group {
        margin-bottom: 1.25rem;
    }

    .contact-form__label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.625rem;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.95rem;
    }

    .contact-form__label .label-emoji {
        font-size: 1.1rem;
    }

    .contact-form__input,
    .contact-form__textarea {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid rgba(0, 167, 157, 0.2);
        border-radius: 16px;
        font-size: 0.95rem;
        font-family: inherit;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(255, 255, 255, 0.9);
        color: var(--dark);
    }

    .contact-form__input:focus,
    .contact-form__textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(0, 167, 157, 0.1);
        background: white;
        transform: translateY(-2px);
    }

    .contact-form__input::placeholder,
    .contact-form__textarea::placeholder {
        color: rgba(0, 0, 0, 0.4);
    }

    .contact-form__textarea {
        resize: vertical;
        min-height: 140px;
        line-height: 1.6;
    }

    /* Submit Button */
    .contact-form__submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        width: 100%;
        background: var(--primary-gradient);
        color: white;
        padding: 1.125rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.05rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 25px rgba(0, 167, 157, 0.3);
        position: relative;
        overflow: hidden;
    }

    .contact-form__submit::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .contact-form__submit:hover::before {
        width: 300px;
        height: 300px;
    }

    .contact-form__submit:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(0, 167, 157, 0.4);
    }

    .contact-form__submit:active {
        transform: translateY(-2px);
    }

    .contact-form__submit .btn-emoji {
        font-size: 1.35rem;
        position: relative;
        z-index: 1;
    }

    .contact-form__submit span,
    .contact-form__submit i {
        position: relative;
        z-index: 1;
    }

    /* ========================================
       RESPONSIVE DESIGN
    ======================================== */
    @media (max-width: 991.98px) {
        .contact-heading {
            font-size: 2rem;
        }

        .contact-subheading {
            font-size: 1rem;
        }

        .contact-form__row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .contact-form-card {
            padding: 1.75rem;
            margin-top: 1rem;
        }

        .contact-quote-card {
            padding: 1.5rem;
        }

        .contact-quote-card__text {
            font-size: 0.9rem;
        }

        .contact-method-item {
            padding: 1.25rem;
        }

        .contact-form-card__emoji {
            font-size: 2.5rem;
        }

        .contact-form-card__title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 767.98px) {
        .contact-section {
            padding-top: 3rem !important;
            padding-bottom: 3rem !important;
        }

        .contact-heading {
            font-size: 1.75rem;
        }

        .contact-badge {
            font-size: 0.85rem;
            padding: 0.5rem 1.25rem;
        }

        .contact-form-card {
            padding: 1.5rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ========================================
        // INTERSECTION OBSERVER FOR ANIMATIONS
        // ========================================
        const contactObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('contact-animate-in');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Observe contact info and form card
        const contactInfo = document.querySelector('.contact-info');
        const contactFormCard = document.querySelector('.contact-form-card');

        if (contactInfo) contactObserver.observe(contactInfo);
        if (contactFormCard) contactObserver.observe(contactFormCard);

        // ========================================
        // FORM VALIDATION & ENHANCEMENT
        // ========================================
        const contactForm = document.getElementById('contact-form');

        if (contactForm) {
            // Add focus/blur animations to form inputs
            const formInputs = contactForm.querySelectorAll('.contact-form__input, .contact-form__textarea');

            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.classList.remove('focused');
                    }
                });
            });

            // Form submission handler (optional - can be enhanced with AJAX)
            contactForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('.contact-form__submit');
                const btnText = submitBtn.querySelector('span:not(.btn-emoji)');
                const originalText = btnText.textContent;

                // Disable button and show loading state
                submitBtn.disabled = true;
                btnText.textContent = 'Mengirim...';

                // Note: Form will submit normally. If you want AJAX, prevent default here
                // and handle with fetch/axios
            });
        }
    });
</script>
