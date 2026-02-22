<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">

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
           1. HADITH — adapted from home jumbotron script
              Uses cu- IDs, jumbotron CSS classes
           ================================================ */

        function getFreshElements() {
            return {
                desktop: {
                    arab:      document.getElementById('cu-arab-desktop'),
                    text:      document.getElementById('cu-text-desktop'),
                    source:    document.getElementById('cu-source-desktop'),
                    number:    document.getElementById('cu-num-desktop'),
                    wrapper:   document.getElementById('cu-wrapper-desktop'),
                    toggle:    document.getElementById('cu-toggle-desktop'),
                    countdown: document.getElementById('cu-countdown-desktop'),
                },
                mobile: {
                    arab:      document.getElementById('cu-arab-mobile'),
                    text:      document.getElementById('cu-text-mobile'),
                    source:    document.getElementById('cu-source-mobile'),
                    number:    document.getElementById('cu-num-mobile'),
                    wrapper:   document.getElementById('cu-wrapper-mobile'),
                    toggle:    document.getElementById('cu-toggle-mobile'),
                    countdown: document.getElementById('cu-countdown-mobile'),
                }
            };
        }

        /* Only return elements that carry hadith-fade-text class */
        function getTextElements() {
            var el = getFreshElements();
            return [
                el.desktop.arab, el.desktop.text, el.desktop.number, el.desktop.source,
                el.mobile.arab,  el.mobile.text,  el.mobile.number,  el.mobile.source,
            ].filter(function (e) {
                return e && e.classList.contains('hadith-fade-text');
            });
        }

        var books = [
            { id: 'bukhari',    name: 'HR. Bukhari',    max: 6638 },
            { id: 'muslim',     name: 'HR. Muslim',     max: 4930 },
            { id: 'abu-daud',   name: 'HR. Abu Daud',   max: 4419 },
            { id: 'tirmidzi',   name: 'HR. Tirmidzi',   max: 3625 },
            { id: 'ibnu-majah', name: 'HR. Ibnu Majah', max: 4285 },
            { id: 'nasai',      name: 'HR. Nasai',      max: 5364 },
        ];

        var timeLeft    = 60;
        var countdownInterval;
        var isFetching  = false;
        var retryCount  = 0;
        var MAX_RETRY   = 5;
        var retryTimeout = null;

        /* Toggle expand/collapse */
        function setupToggleListeners() {
            document.addEventListener('click', function (e) {
                /* Desktop toggle */
                if (e.target.closest('#cu-toggle-desktop')) {
                    var toggle  = document.getElementById('cu-toggle-desktop');
                    var wrapper = document.getElementById('cu-wrapper-desktop');
                    if (toggle && wrapper) {
                        e.preventDefault();
                        var expanded = wrapper.classList.toggle('expanded');
                        toggle.classList.toggle('expanded');
                        var span = toggle.querySelector('.toggle-text');
                        if (span) span.textContent = expanded ? 'Sembunyikan' : 'Selengkapnya';
                    }
                }
                /* Mobile toggle */
                if (e.target.closest('#cu-toggle-mobile')) {
                    var toggleM  = document.getElementById('cu-toggle-mobile');
                    var wrapperM = document.getElementById('cu-wrapper-mobile');
                    if (toggleM && wrapperM) {
                        e.preventDefault();
                        var expandedM = wrapperM.classList.toggle('expanded');
                        toggleM.classList.toggle('expanded');
                        var spanM = toggleM.querySelector('.hadith-toggle-text');
                        if (spanM) spanM.textContent = expandedM ? 'Sembunyikan' : 'Selengkapnya';
                    }
                }
            });
        }

        function checkOverflow() {
            var dw = document.getElementById('cu-wrapper-desktop');
            var dt = document.getElementById('cu-toggle-desktop');
            var mw = document.getElementById('cu-wrapper-mobile');
            var mt = document.getElementById('cu-toggle-mobile');

            if (dw && dt) dt.style.display = dw.scrollHeight > 150 ? 'inline-flex' : 'none';
            if (mw && mt) mt.style.display = mw.scrollHeight > 150 ? 'inline-flex' : 'none';
        }

        function updateCountdown() {
            var d = document.getElementById('cu-countdown-desktop');
            var m = document.getElementById('cu-countdown-mobile');
            if (d) d.textContent = timeLeft;
            if (m) m.textContent = timeLeft;
        }

        function resetCountdown() {
            timeLeft = 60;
            updateCountdown();
        }

        function startCountdown() {
            if (countdownInterval) clearInterval(countdownInterval);
            countdownInterval = setInterval(function () {
                timeLeft--;
                updateCountdown();
                if (timeLeft <= 0) {
                    timeLeft = 60;
                    fetchRandomHadith();
                }
            }, 1000);
        }

        function fadeOutElements(callback) {
            var textElements = getTextElements();
            var completed = 0;
            var total = textElements.length;

            if (total === 0) { callback(); return; }

            textElements.forEach(function (el) {
                el.classList.add('fade-out');
            });

            textElements.forEach(function (el) {
                var handler = function () {
                    el.removeEventListener('transitionend', handler);
                    if (++completed === total) callback();
                };
                el.addEventListener('transitionend', handler);
                setTimeout(function () {
                    if (el.classList.contains('fade-out') && completed < total) {
                        el.removeEventListener('transitionend', handler);
                        if (++completed === total) callback();
                    }
                }, 600);
            });
        }

        function fadeInElements() {
            getTextElements().forEach(function (el) { el.classList.remove('fade-out'); });
        }

        function showErrorMessage(message, showRetry) {
            if (showRetry === undefined) showRetry = true;
            var el = getFreshElements();
            var txt = (showRetry && retryCount > 0)
                ? message + ' (Percobaan ke-' + retryCount + '/' + MAX_RETRY + ')'
                : message;

            if (el.desktop.text)   el.desktop.text.innerHTML   = txt;
            if (el.mobile.text)    el.mobile.text.innerHTML    = txt;
            if (el.desktop.source) el.desktop.source.textContent = 'Hadits dalam 1 Menit';
            if (el.mobile.source)  el.mobile.source.textContent  = 'Hadits dalam 1 Menit';
            if (el.desktop.arab)   el.desktop.arab.textContent   = '';
            if (el.mobile.arab)    el.mobile.arab.textContent    = '';
            if (el.desktop.number) el.desktop.number.textContent = '';
            if (el.mobile.number)  el.mobile.number.textContent  = '';
            if (el.desktop.toggle) el.desktop.toggle.style.display = 'none';
            if (el.mobile.toggle)  el.mobile.toggle.style.display  = 'none';
        }

        function scheduleRetry(delay) {
            if (retryTimeout) clearTimeout(retryTimeout);
            if (retryCount < MAX_RETRY) {
                retryTimeout = setTimeout(function () { fetchRandomHadith(); }, delay || 3000);
            } else {
                showErrorMessage('Gagal memuat hadits setelah beberapa kali percobaan. Silakan refresh halaman.', false);
                retryCount = 0;
            }
        }

        function fetchRandomHadith() {
            if (isFetching) return;
            isFetching = true;

            fadeOutElements(function () {
                var book   = books[Math.floor(Math.random() * books.length)];
                var number = Math.floor(Math.random() * book.max) + 1;
                var ctrl   = new AbortController();
                var tId    = setTimeout(function () { ctrl.abort(); }, 10000);

                fetch('https://api.hadith.gading.dev/books/' + book.id + '/' + number, {
                    signal: ctrl.signal
                })
                .then(function (r) { clearTimeout(tId); return r.json(); })
                .then(function (json) {
                    if (json.code === 200 && json.data && json.data.contents) {
                        retryCount = 0;
                        var c  = json.data.contents;
                        var el = getFreshElements();

                        /* Reset expanded state */
                        if (el.desktop.wrapper) el.desktop.wrapper.classList.remove('expanded');
                        if (el.mobile.wrapper)  el.mobile.wrapper.classList.remove('expanded');

                        if (el.desktop.toggle) {
                            el.desktop.toggle.classList.remove('expanded');
                            var spanD = el.desktop.toggle.querySelector('.toggle-text');
                            if (spanD) spanD.textContent = 'Selengkapnya';
                        }
                        if (el.mobile.toggle) {
                            el.mobile.toggle.classList.remove('expanded');
                            var spanM = el.mobile.toggle.querySelector('.hadith-toggle-text');
                            if (spanM) spanM.textContent = 'Selengkapnya';
                        }

                        /* Update text content */
                        if (el.desktop.arab)   el.desktop.arab.textContent   = c.arab;
                        if (el.desktop.text)   el.desktop.text.innerHTML     = '\u201c' + c.id + '\u201d';
                        if (el.desktop.source) el.desktop.source.textContent = book.name;
                        if (el.desktop.number) el.desktop.number.textContent = book.name + ' No. ' + c.number;

                        if (el.mobile.arab)    el.mobile.arab.textContent    = c.arab;
                        if (el.mobile.text)    el.mobile.text.innerHTML      = '\u201c' + c.id + '\u201d';
                        if (el.mobile.source)  el.mobile.source.textContent  = book.name;
                        if (el.mobile.number)  el.mobile.number.textContent  = book.name + ' No. ' + c.number;

                        fadeInElements();
                        setTimeout(checkOverflow, 100);
                        resetCountdown();
                    } else {
                        throw new Error('Invalid response');
                    }
                })
                .catch(function (e) {
                    console.error('Hadith fetch error:', e);
                    retryCount++;
                    var msg = e.name === 'AbortError'
                        ? 'Timeout memuat hadits.'
                        : (e.message === 'Failed to fetch' ? 'Koneksi terputus.' : 'Gagal memuat hadits.');
                    showErrorMessage(msg);
                    fadeInElements();
                    scheduleRetry(3000);
                })
                .finally(function () { isFetching = false; });
            });
        }

        /* Initialize hadith elements */
        (function () {
            var el = getFreshElements();
            if (el.desktop.arab)   el.desktop.arab.textContent   = '';
            if (el.mobile.arab)    el.mobile.arab.textContent    = '';
            if (el.desktop.source) el.desktop.source.textContent = 'Hadits dalam 1 Menit';
            if (el.mobile.source)  el.mobile.source.textContent  = 'Hadits dalam 1 Menit';
            if (el.desktop.number) el.desktop.number.textContent = '';
            if (el.mobile.number)  el.mobile.number.textContent  = '';
        })();

        setupToggleListeners();
        setTimeout(checkOverflow, 100);
        window.addEventListener('resize', checkOverflow);
        startCountdown();
        setTimeout(fetchRandomHadith, 3000);


        /* ================================================
           2. OWL CAROUSEL — mobile info cards
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
            document.body.classList.add('cu-no-scroll');
            if (btt) btt.classList.add('cu-hide-btt');
            if (sheet) sheet.focus();
        }

        function cuCloseSheet() {
            if (backdrop) backdrop.classList.remove('cu-bs-open');
            if (sheet) sheet.classList.remove('cu-bs-open');
            document.body.classList.remove('cu-no-scroll');
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
