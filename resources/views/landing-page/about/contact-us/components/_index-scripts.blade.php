{{-- ── Hero Jumbotron hadith system ── --}}
@include('components.hero-jumbotron.scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /* SweetAlert toast preset — available globally */
    window.CuContactToast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: { container: 'toast-below-navbar' }
    });

    document.addEventListener('DOMContentLoaded', function () {

        /* ================================================
           1. OWL CAROUSEL — mobile info cards
           ================================================ */
        if (window.jQuery && typeof jQuery.fn.owlCarousel === 'function') {
            var $owl = jQuery('#cu-info-owl');
            if ($owl.length) {
                $owl.owlCarousel({
                    loop: false,
                    margin: 16,
                    nav: false,
                    dots: false,
                    autoplay: false,
                    smartSpeed: 450,
                    responsive: {
                        0:   { items: 1 },
                        480: { items: 2 },
                    },
                    onInitialized: function () { cuBuildDots($owl); },
                    onTranslated:  function () { cuUpdateDots($owl); },
                });
            }
        }

        function cuBuildDots($owl) {
            var container = document.getElementById('cu-owl-dots');
            if (!container) return;
            container.innerHTML = '';
            var count = $owl.find('.cu-mobile-card').length;
            for (var i = 0; i < count; i++) {
                var btn = document.createElement('button');
                btn.className = 'cu-owl-dot' + (i === 0 ? ' cu-dot-active' : '');
                btn.setAttribute('aria-label', 'Slide ' + (i + 1));
                btn.dataset.index = i;
                btn.addEventListener('click', (function (idx) {
                    return function () { $owl.trigger('to.owl.carousel', [idx, 350]); };
                })(i));
                container.appendChild(btn);
            }
        }

        function cuUpdateDots($owl) {
            var container = document.getElementById('cu-owl-dots');
            if (!container) return;
            var current = $owl.find('.owl-item.active').first()
                .find('.cu-mobile-card').data('card-index') || 0;
            container.querySelectorAll('.cu-owl-dot').forEach(function (dot) {
                dot.classList.toggle('cu-dot-active', parseInt(dot.dataset.index) === current);
            });
        }


        /* ================================================
           3. MOBILE BOTTOM SHEET
           ================================================ */
        var backdrop = document.getElementById('cu-bs-backdrop');
        var sheet    = document.getElementById('cu-bottom-sheet');
        var bsClose  = document.getElementById('cu-bs-close');
        var bsContent= document.getElementById('cu-bs-content');
        var btt      = document.querySelector('.back-to-top');

        var _cuWheelLock = null, _cuKeyLock = null, _cuTouchLock = null;

        function cuLockScroll() {
            document.body.style.overflow = 'hidden';
        }

        function cuUnlockScroll() {
            document.body.style.overflow = '';
        }

        var colorBg = {
            primary: 'rgba(0,167,157,0.12)',
            green:   'rgba(0,184,148,0.12)',
            teal:    'rgba(32,201,151,0.12)',
            info:    'rgba(13,202,240,0.12)',
        };

        function cuOpenSheet(card) {
            var title   = card.dataset.cardTitle;
            var icon    = card.dataset.cardIcon;
            var color   = card.dataset.cardColor;
            var socials = card.querySelectorAll('.cu-social-link');
            var valueEl = card.querySelector('.cu-card-value');
            var subEl   = card.querySelector('.cu-card-sub');

            var html = '<div class="cu-bs-header">';
            html += '<div class="cu-bs-icon" style="background:' + (colorBg[color] || 'rgba(0,167,157,0.1)') + '">' + icon + '</div>';
            html += '<h5 class="cu-bs-title">' + title + '</h5>';
            html += '</div><div class="cu-bs-body">';

            if (socials.length) {
                html += '<div class="cu-bs-social-list">';
                socials.forEach(function (a) {
                    var iEl = a.querySelector('i');
                    var sEl = a.querySelector('span');
                    html += '<a href="' + a.href + '" target="_blank" class="cu-bs-social-item">';
                    if (iEl) html += '<i class="' + iEl.className + '"></i>';
                    if (sEl) html += '<span>' + sEl.textContent + '</span>';
                    html += '</a>';
                });
                html += '</div>';
            } else {
                if (valueEl) {
                    var linkEl = card.querySelector('a.cu-card-value');
                    if (linkEl) {
                        html += '<p style="margin-bottom:1rem;">' + valueEl.textContent + '</p>';
                        html += '<a href="' + linkEl.href + '" target="_blank" class="cu-bs-link-btn">'
                              + '<i class="fas fa-external-link-alt"></i><span>Buka</span></a>';
                    } else {
                        html += '<p>' + valueEl.textContent + '</p>';
                    }
                }
                if (subEl) html += '<p style="margin-top:0.5rem;font-size:0.82rem;color:var(--gray);">' + subEl.textContent + '</p>';
            }

            html += '</div>';
            if (bsContent) bsContent.innerHTML = html;

            if (backdrop) backdrop.classList.add('cu-bs-open');
            if (sheet) sheet.classList.add('cu-bs-open');
            cuLockScroll();
            if (btt) btt.classList.add('cu-hide-btt');
            if (sheet) sheet.focus();
        }

        function cuCloseSheet() {
            if (backdrop) backdrop.classList.remove('cu-bs-open');
            if (sheet) sheet.classList.remove('cu-bs-open');
            cuUnlockScroll();
            if (btt) btt.classList.remove('cu-hide-btt');
        }

        document.addEventListener('click', function (e) {
            var card = e.target.closest('.cu-mobile-card');
            if (card && window.innerWidth < 768) {
                if (!e.target.closest('a')) {
                    e.preventDefault();
                    cuOpenSheet(card);
                }
            }
        });

        if (bsClose)  bsClose.addEventListener('click', cuCloseSheet);
        if (backdrop) backdrop.addEventListener('click', cuCloseSheet);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && sheet && sheet.classList.contains('cu-bs-open')) {
                cuCloseSheet();
            }
        });

        /* Swipe down to close */
        var touchStartY = 0;
        if (sheet) {
            sheet.addEventListener('touchstart', function (e) {
                touchStartY = e.touches[0].clientY;
            }, { passive: true });

            sheet.addEventListener('touchend', function (e) {
                if (e.changedTouches[0].clientY - touchStartY > 80) cuCloseSheet();
            }, { passive: true });
        }


        /* ================================================
           4. AJAX CONTACT FORM
           ================================================ */
        var form = document.getElementById('cu-contact-form');
        if (form) {
            var inputs = form.querySelectorAll('.cu-form-input, .cu-form-textarea');

            inputs.forEach(function (inp) {
                inp.addEventListener('blur',  function () { cuValidateField(inp); });
                inp.addEventListener('input', function () {
                    if (inp.classList.contains('cu-invalid')) cuValidateField(inp);
                });
            });

            function cuValidateField(field) {
                var grp = field.closest('.cu-form-group');
                var ok  = field.validity.valid && field.value.trim() !== '';
                field.classList.toggle('cu-invalid', !ok);
                field.classList.toggle('cu-valid',   ok);
                if (grp) grp.classList.toggle('cu-has-error', !ok);
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                var valid = true;
                inputs.forEach(function (inp) {
                    cuValidateField(inp);
                    if (inp.classList.contains('cu-invalid')) valid = false;
                });

                if (!valid) {
                    var first = form.querySelector('.cu-invalid');
                    if (first) { first.focus(); first.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
                    window.CuContactToast.fire({ icon: 'error', title: 'Harap lengkapi semua field yang wajib diisi!' });
                    return;
                }

                /* Loading state */
                var btn      = form.querySelector('.cu-form-submit');
                var emoji    = btn.querySelector('.cu-btn-emoji');
                var txt      = btn.querySelector('.cu-btn-txt');
                var ico      = btn.querySelector('.cu-btn-ico');
                var origTxt  = txt.textContent;

                btn.disabled    = true;
                emoji.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                txt.textContent = 'Mengirim...';
                if (ico) ico.style.display = 'none';

                fetch('/about/contact/message/store', {
                    method: 'POST',
                    body:   new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.success) {
                        window.CuContactToast.fire({ icon: 'success', title: data.message || 'Pesan berhasil dikirim! Terima kasih 🎉' });
                        form.reset();
                        inputs.forEach(function (inp) {
                            inp.classList.remove('cu-valid', 'cu-invalid');
                            var grp = inp.closest('.cu-form-group');
                            if (grp) grp.classList.remove('cu-has-error');
                        });
                    } else {
                        window.CuContactToast.fire({ icon: 'error', title: data.message || 'Terjadi kesalahan saat mengirim pesan!' });
                    }
                })
                .catch(function () {
                    window.CuContactToast.fire({ icon: 'error', title: 'Terjadi kesalahan jaringan. Silakan coba lagi!' });
                })
                .finally(function () {
                    btn.disabled    = false;
                    emoji.innerHTML = '🚀';
                    txt.textContent = origTxt;
                    if (ico) ico.style.display = '';
                });
            });
        }


        /* ================================================
           5. NEWSLETTER SUBSCRIBE
           ================================================ */
        var cuNlForm = document.getElementById('cuNewsletterForm');
        if (cuNlForm) {
            cuNlForm.addEventListener('submit', function (e) {
                e.preventDefault();

                var emailInput = document.getElementById('cuNewsletterEmail');
                var btn        = document.getElementById('cuSubscribeBtn');
                var btnTxt     = btn.querySelector('.cu-subscribe-btn-txt');
                var btnIco     = btn.querySelector('.cu-subscribe-btn-ico');
                var email      = emailInput.value.trim();

                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email || !emailRegex.test(email)) {
                    window.CuContactToast.fire({ icon: 'error', title: 'Masukkan alamat email yang valid!' });
                    emailInput.focus();
                    return;
                }

                btn.disabled = true;
                btnTxt.textContent = 'Mengirim...';
                if (btnIco) btnIco.className = 'fas fa-spinner fa-spin cu-subscribe-btn-ico';

                fetch('{{ route("newsletter.store") }}', {
                    method: 'POST',
                    body: new FormData(cuNlForm),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.success) {
                        window.CuContactToast.fire({ icon: 'success', title: data.message || 'Berhasil berlangganan! Terima kasih 🎉' });
                        cuNlForm.reset();
                    } else {
                        var errorMsg = (data.errors && data.errors.email && data.errors.email[0]) || data.message || 'Terjadi kesalahan!';
                        window.CuContactToast.fire({ icon: 'error', title: errorMsg });
                    }
                })
                .catch(function () {
                    window.CuContactToast.fire({ icon: 'error', title: 'Terjadi kesalahan jaringan!' });
                })
                .finally(function () {
                    btn.disabled = false;
                    btnTxt.textContent = 'Berlangganan';
                    if (btnIco) btnIco.className = 'fas fa-paper-plane cu-subscribe-btn-ico';
                });
            });
        }


        /* ================================================
           5. INTERSECTION OBSERVER — entrance animations
           ================================================ */
        var cuObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('cu-visible');
                    cuObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('.cu-form-card, .cu-info-section, .cu-map-form').forEach(function (el) {
            cuObserver.observe(el);
        });

    });
</script>
