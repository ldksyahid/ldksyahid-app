{{-- Contact Us Section - Modern & Elegant Design --}}
<section class="contact-section py-5">
    <div class="container">
        {{-- Header - Badge Style Like Testimony --}}
        <div class="text-center mb-5 contact-header-wrap">
            <div class="contact-badge mb-3">
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
                                <a href="mailto:ldk.ormawa@apps.uinjkt.ac.id" class="contact-method-item__value">
                                    ldk.ormawa@apps.uinjkt.ac.id
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
                                <span class="contact-method-item__value">24 Jam</span>
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
                                    <span>Nama Kamu <span class="required-mark">*</span></span>
                                </label>
                                <input type="text"
                                       class="contact-form__input"
                                       id="contact-name"
                                       name="name"
                                       placeholder="Masukkan namamu"
                                       required
                                       minlength="3"
                                       maxlength="100"/>
                                <span class="contact-form__error">Nama wajib diisi (minimal 3 karakter)</span>
                            </div>

                            {{-- Email Input --}}
                            <div class="contact-form__group">
                                <label class="contact-form__label">
                                    <span class="label-emoji">📧</span>
                                    <span>Email Kamu <span class="required-mark">*</span></span>
                                </label>
                                <input type="email"
                                       class="contact-form__input"
                                       id="contact-email"
                                       name="email"
                                       placeholder="Masukkan emailmu"
                                       required
                                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"/>
                                <span class="contact-form__error">Email wajib diisi dengan format yang benar</span>
                            </div>
                        </div>

                        {{-- Subject Input --}}
                        <div class="contact-form__group">
                            <label class="contact-form__label">
                                <span class="label-emoji">📌</span>
                                <span>Subjek <span class="required-mark">*</span></span>
                            </label>
                            <input type="text"
                                   class="contact-form__input"
                                   id="contact-subject"
                                   name="subject"
                                   placeholder="Tentang apa pesanmu?"
                                   required
                                   minlength="5"
                                   maxlength="200"/>
                            <span class="contact-form__error">Subjek wajib diisi (minimal 5 karakter)</span>
                        </div>

                        {{-- Message Textarea --}}
                        <div class="contact-form__group">
                            <label class="contact-form__label">
                                <span class="label-emoji">💭</span>
                                <span>Pesan <span class="required-mark">*</span></span>
                            </label>
                            <textarea class="contact-form__textarea"
                                      placeholder="Tulis pesanmu di sini..."
                                      name="message"
                                      id="contact-message"
                                      rows="4"
                                      required
                                      minlength="10"
                                      maxlength="1000"></textarea>
                            <span class="contact-form__error">Pesan wajib diisi (minimal 10 karakter)</span>
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
       HEADER - CENTERED WITH BADGE
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

    /* Badge Style */
    .contact-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        border: 1px solid rgba(0, 167, 157, 0.2);
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--primary);
    }

    .contact-badge__emoji {
        font-size: 1.1rem;
    }

    .contact-badge__pulse {
        width: 8px;
        height: 8px;
        background: var(--primary);
        border-radius: 50%;
        animation: contactBadgePulse 2s ease-in-out infinite;
    }

    @keyframes contactBadgePulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.5;
            transform: scale(1.5);
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
        border: 2px solid transparent;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .contact-method-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 167, 157, 0.06) 0%, rgba(0, 167, 157, 0.02) 100%);
        opacity: 0;
        transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 20px;
        pointer-events: none;
    }

    .contact-method-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 167, 157, 0.15);
        background: rgba(255, 255, 255, 0.9);
    }

    .contact-method-item:hover::before {
        opacity: 1;
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

    .required-mark {
        color: #ef4444;
        font-weight: 700;
        margin-left: 0.125rem;
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
        height: 52px;
        box-sizing: border-box;
        display: block;
        line-height: 1.5;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
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
        height: auto;
        line-height: 1.6;
    }

    /* Validation States */
    .contact-form__error {
        display: none;
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.375rem;
        font-weight: 500;
    }

    .contact-form__input.invalid,
    .contact-form__textarea.invalid {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.05);
    }

    .contact-form__input.invalid:focus,
    .contact-form__textarea.invalid:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    .contact-form__group.has-error .contact-form__error {
        display: block;
    }

    .contact-form__input.valid,
    .contact-form__textarea.valid {
        border-color: #10b981;
    }

    .contact-form__input.valid:focus,
    .contact-form__textarea.valid:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
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
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #00d4c4 0%, var(--primary) 100%);
        opacity: 0;
        transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50px;
    }

    .contact-form__submit:hover::before {
        opacity: 1;
    }

    .contact-form__submit:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(0, 167, 157, 0.5);
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
            const formInputs = contactForm.querySelectorAll('.contact-form__input, .contact-form__textarea');

            // Real-time validation
            formInputs.forEach(input => {
                // Focus/blur animations
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    validateField(this);
                    if (!this.value) {
                        this.parentElement.classList.remove('focused');
                    }
                });

                // Input validation
                input.addEventListener('input', function() {
                    if (this.classList.contains('invalid')) {
                        validateField(this);
                    }
                });
            });

            // Validate individual field
            function validateField(field) {
                const parent = field.closest('.contact-form__group');

                if (!field.validity.valid || field.value.trim() === '') {
                    field.classList.add('invalid');
                    field.classList.remove('valid');
                    parent.classList.add('has-error');
                } else {
                    field.classList.remove('invalid');
                    field.classList.add('valid');
                    parent.classList.remove('has-error');
                }
            }

            // Form submission handler
            contactForm.addEventListener('submit', function(e) {
                let isValid = true;

                // Validate all fields
                formInputs.forEach(input => {
                    validateField(input);
                    if (!input.validity.valid || input.value.trim() === '') {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();

                    // Scroll to first error
                    const firstError = contactForm.querySelector('.contact-form__input.invalid, .contact-form__textarea.invalid');
                    if (firstError) {
                        firstError.focus();
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }

                    return false;
                }

                // Show loading state
                const submitBtn = this.querySelector('.contact-form__submit');
                const btnText = submitBtn.querySelector('span:not(.btn-emoji)');

                submitBtn.disabled = true;
                btnText.textContent = 'Mengirim...';
            });
        }
    });
</script>
