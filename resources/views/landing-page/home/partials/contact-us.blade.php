{{-- Contact Us Section - Fun & Modern Design --}}
<section class="contact-fun py-5">
    <div class="container">
        <div class="contact-wrapper wow fadeIn" data-wow-delay="0.1s">
            <div class="row g-4 g-lg-5 align-items-center">
                {{-- Left Side - Info --}}
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="contact-info">
                        <div class="section-badge-contact">
                            <span class="badge-emoji">💬</span>
                            <span>Hubungi Kami</span>
                        </div>
                        <h2 class="section-title-fun">
                            Ada Pertanyaan?
                            <span class="title-wave">👋</span>
                        </h2>
                        <p class="contact-description">
                            Jika kamu memiliki pertanyaan, kritik, atau saran, jangan ragu untuk menghubungi kami ya! 😊
                        </p>

                        {{-- Quote Card --}}
                        <div class="quote-card-fun">
                            <div class="quote-icon">📖</div>
                            <p class="quote-text">
                                "Dan Kami tidak mengutus sebelum engkau (Muhammad), melainkan orang laki-laki yang Kami beri wahyu kepada mereka; maka bertanyalah kepada orang yang mempunyai pengetahuan jika kamu tidak mengetahui,"
                            </p>
                            <div class="quote-source">
                                <span class="source-emoji">✨</span>
                                <span class="source-text">QS. An-Nahl 16: Ayat 43</span>
                            </div>
                        </div>

                        {{-- Contact Methods --}}
                        <div class="contact-methods">
                            <div class="method-item">
                                <div class="method-icon">📧</div>
                                <div class="method-info">
                                    <span class="method-label">Email</span>
                                    <span class="method-value">ldksyahid@uinjkt.ac.id</span>
                                </div>
                            </div>
                            <div class="method-item">
                                <div class="method-icon">📍</div>
                                <div class="method-info">
                                    <span class="method-label">Lokasi</span>
                                    <span class="method-value">UIN Jakarta</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side - Form --}}
                <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="form-card-fun">
                        <div class="form-header">
                            <span class="form-emoji">✉️</span>
                            <h4 class="form-title">Kirim Pesan</h4>
                            <p class="form-subtitle">Kami akan segera membalas pesanmu!</p>
                        </div>

                        <form role="form"
                              action='/about/contact/message/store'
                              method='post'
                              enctype="multipart/form-data"
                              class="contact-form-fun"
                              novalidate>
                            @csrf
                            @method('POST')

                            <div class="form-row">
                                {{-- Name --}}
                                <div class="form-group-fun">
                                    <label class="form-label-fun">
                                        <span class="label-emoji">👤</span>
                                        <span>Nama Kamu</span>
                                    </label>
                                    <input type="text"
                                           class="form-input-fun"
                                           id="contact-name"
                                           name="name"
                                           placeholder="Masukkan namamu"
                                           required/>
                                </div>

                                {{-- Email --}}
                                <div class="form-group-fun">
                                    <label class="form-label-fun">
                                        <span class="label-emoji">📧</span>
                                        <span>Email Kamu</span>
                                    </label>
                                    <input type="email"
                                           class="form-input-fun"
                                           id="contact-email"
                                           name="email"
                                           placeholder="Masukkan emailmu"
                                           required/>
                                </div>
                            </div>

                            {{-- Subject --}}
                            <div class="form-group-fun">
                                <label class="form-label-fun">
                                    <span class="label-emoji">📌</span>
                                    <span>Subjek</span>
                                </label>
                                <input type="text"
                                       class="form-input-fun"
                                       id="contact-subject"
                                       name="subject"
                                       placeholder="Tentang apa pesanmu?"
                                       required/>
                            </div>

                            {{-- Message --}}
                            <div class="form-group-fun">
                                <label class="form-label-fun">
                                    <span class="label-emoji">💭</span>
                                    <span>Pesan</span>
                                </label>
                                <textarea class="form-textarea-fun"
                                          placeholder="Tulis pesanmu di sini..."
                                          name="message"
                                          id="contact-message"
                                          rows="4"
                                          required></textarea>
                            </div>

                            {{-- Submit Button --}}
                            <button class="btn-submit-fun" type="submit">
                                <span class="btn-emoji">🚀</span>
                                <span>Kirim Pesan</span>
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .contact-fun {
        background: transparent;
    }

    .contact-wrapper {
        background: white;
        border-radius: 32px;
        padding: 2.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
    }

    /* Section Badge */
    .section-badge-contact {
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
        margin-bottom: 0.75rem;
    }

    .title-wave {
        display: inline-block;
        animation: waveHand 1s ease-in-out infinite;
        transform-origin: 70% 70%;
    }

    @keyframes waveHand {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(20deg); }
        75% { transform: rotate(-10deg); }
    }

    .contact-description {
        color: var(--secondary);
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    /* Quote Card */
    .quote-card-fun {
        background: var(--primary-light);
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .quote-icon {
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }

    .quote-text {
        color: var(--dark);
        font-size: 0.9rem;
        font-style: italic;
        line-height: 1.7;
        margin-bottom: 1rem;
        text-align: justify;
    }

    .quote-source {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-gradient);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Contact Methods */
    .contact-methods {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .method-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: var(--primary-light);
        padding: 1rem;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .method-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.15);
    }

    .method-icon {
        font-size: 1.5rem;
    }

    .method-info {
        display: flex;
        flex-direction: column;
    }

    .method-label {
        font-size: 0.75rem;
        color: var(--secondary);
        font-weight: 500;
    }

    .method-value {
        font-weight: 600;
        color: var(--primary);
    }

    /* Form Card */
    .form-card-fun {
        background: var(--primary-light);
        border-radius: 24px;
        padding: 2rem;
        border: 1px solid rgba(0, 167, 157, 0.1);
    }

    .form-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .form-emoji {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 0.5rem;
    }

    .form-title {
        font-family: var(--font-primary);
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .form-subtitle {
        color: var(--secondary);
        font-size: 0.9rem;
        margin: 0;
    }

    /* Form Styles */
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-group-fun {
        margin-bottom: 1rem;
    }

    .form-label-fun {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.9rem;
    }

    .label-emoji {
        font-size: 1rem;
    }

    .form-input-fun,
    .form-textarea-fun {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid rgba(0, 167, 157, 0.2);
        border-radius: 16px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input-fun:focus,
    .form-textarea-fun:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(0, 167, 157, 0.1);
    }

    .form-input-fun::placeholder,
    .form-textarea-fun::placeholder {
        color: var(--secondary-light);
    }

    .form-textarea-fun {
        resize: none;
        min-height: 120px;
    }

    /* Submit Button */
    .btn-submit-fun {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        width: 100%;
        background: var(--primary-gradient);
        color: white;
        padding: 1rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
    }

    .btn-submit-fun:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 167, 157, 0.4);
    }

    .btn-submit-fun .btn-emoji {
        font-size: 1.25rem;
    }

    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .contact-wrapper {
            padding: 1.5rem;
        }

        .section-title-fun {
            font-size: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-card-fun {
            padding: 1.5rem;
        }

        .quote-card-fun {
            padding: 1rem;
        }

        .quote-text {
            font-size: 0.85rem;
        }
    }
</style>
