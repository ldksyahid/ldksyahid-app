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
                          onsubmit="return handleContactSubmit(event);"
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

@include('landing-page.home.partials.contact-us.components._index-styles')
@include('landing-page.home.partials.contact-us.components._index-scripts')
