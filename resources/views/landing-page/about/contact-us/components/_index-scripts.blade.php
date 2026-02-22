<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ================================================
       1. HADITH API — fetch & display rotating hadith
       ================================================ */
    const cuBooks = [
        { id: 'bukhari',   name: 'HR. Bukhari',   max: 6638 },
        { id: 'muslim',    name: 'HR. Muslim',    max: 4930 },
        { id: 'abu-daud',  name: 'HR. Abu Daud',  max: 4419 },
        { id: 'tirmidzi',  name: 'HR. Tirmidzi',  max: 3625 },
        { id: 'ibnu-majah',name: 'HR. Ibnu Majah',max: 4285 },
        { id: 'nasai',     name: 'HR. Nasai',     max: 5364 },
    ];

    let cuTimeLeft    = 60;
    let cuInterval    = null;
    let cuFetching    = false;
    let cuRetry       = 0;
    let cuRetryTimer  = null;
    const CU_MAX_RETRY = 5;

    /* --- element getters --- */
    function cuEl(id) { return document.getElementById(id); }

    function cuGetFadeEls() {
        return [
            cuEl('cu-src-desktop'), cuEl('cu-arab-desktop'),
            cuEl('cu-text-desktop'), cuEl('cu-num-desktop'),
            cuEl('cu-src-mobile'),  cuEl('cu-arab-mobile'),
            cuEl('cu-text-mobile'), cuEl('cu-num-mobile'),
        ].filter(Boolean).filter(el => el.classList.contains('cu-fade-text'));
    }

    /* --- countdown --- */
    function cuUpdateCountdown() {
        const d = cuEl('cu-cdown-desktop');
        const m = cuEl('cu-cdown-mobile');
        if (d) d.textContent = cuTimeLeft;
        if (m) m.textContent = cuTimeLeft;
    }

    function cuStartCountdown() {
        if (cuInterval) clearInterval(cuInterval);
        cuInterval = setInterval(function () {
            cuTimeLeft--;
            cuUpdateCountdown();
            if (cuTimeLeft <= 0) {
                cuTimeLeft = 60;
                cuFetchHadith();
            }
        }, 1000);
    }

    /* --- fade helpers --- */
    function cuFadeOut(cb) {
        const els = cuGetFadeEls();
        if (!els.length) { cb(); return; }
        let done = 0;
        els.forEach(function (el) {
            el.classList.add('cu-fading');
            var handler = function () {
                el.removeEventListener('transitionend', handler);
                if (++done === els.length) cb();
            };
            el.addEventListener('transitionend', handler);
            setTimeout(function () {
                if (el.classList.contains('cu-fading') && done < els.length) {
                    el.removeEventListener('transitionend', handler);
                    if (++done === els.length) cb();
                }
            }, 600);
        });
    }

    function cuFadeIn() {
        cuGetFadeEls().forEach(function (el) { el.classList.remove('cu-fading'); });
    }

    /* --- overflow check (toggle button visibility) --- */
    function cuCheckOverflow() {
        var pairs = [
            { body: cuEl('cu-body-desktop'), btn: cuEl('cu-toggle-desktop'), max: 145 },
            { body: cuEl('cu-body-mobile'),  btn: cuEl('cu-toggle-mobile'),  max: 130 },
        ];
        pairs.forEach(function (p) {
            if (p.body && p.btn) {
                p.btn.style.display = p.body.scrollHeight > p.max ? 'inline-flex' : 'none';
            }
        });
    }

    /* --- show error --- */
    function cuShowError(msg) {
        var txt = cuRetry > 0 ? msg + ' (Percobaan ' + cuRetry + '/' + CU_MAX_RETRY + ')' : msg;
        ['cu-text-desktop','cu-text-mobile'].forEach(function (id) {
            var el = cuEl(id); if (el) el.innerHTML = txt;
        });
        ['cu-src-desktop','cu-src-mobile'].forEach(function (id) {
            var el = cuEl(id); if (el) el.textContent = 'Hadits dalam 1 Menit';
        });
        ['cu-arab-desktop','cu-arab-mobile','cu-num-desktop','cu-num-mobile'].forEach(function (id) {
            var el = cuEl(id); if (el) el.textContent = '';
        });
        ['cu-toggle-desktop','cu-toggle-mobile'].forEach(function (id) {
            var el = cuEl(id); if (el) el.style.display = 'none';
        });
    }

    /* --- main fetch --- */
    function cuFetchHadith() {
        if (cuFetching) return;
        cuFetching = true;

        cuFadeOut(function () {
            var book   = cuBooks[Math.floor(Math.random() * cuBooks.length)];
            var number = Math.floor(Math.random() * book.max) + 1;
            var ctrl   = new AbortController();
            var tId    = setTimeout(function () { ctrl.abort(); }, 10000);

            fetch('https://api.hadith.gading.dev/books/' + book.id + '/' + number, {
                signal: ctrl.signal
            })
            .then(function (r) { clearTimeout(tId); return r.json(); })
            .then(function (json) {
                if (json.code === 200 && json.data && json.data.contents) {
                    cuRetry = 0;
                    var c = json.data.contents;

                    // Reset expanded state
                    ['cu-body-desktop','cu-body-mobile'].forEach(function (id) {
                        var el = cuEl(id); if (el) el.classList.remove('cu-expanded');
                    });
                    ['cu-toggle-desktop','cu-toggle-mobile'].forEach(function (id) {
                        var el = cuEl(id);
                        if (!el) return;
                        el.classList.remove('cu-expanded');
                        var span = el.querySelector('[class*="cu-toggle-txt"]');
                        if (span) span.textContent = 'Selengkapnya';
                    });

                    // Update content
                    var sets = [
                        { arab: 'cu-arab-desktop', text: 'cu-text-desktop',
                          src:  'cu-src-desktop',  num:  'cu-num-desktop' },
                        { arab: 'cu-arab-mobile',  text: 'cu-text-mobile',
                          src:  'cu-src-mobile',   num:  'cu-num-mobile' },
                    ];
                    sets.forEach(function (s) {
                        var ea = cuEl(s.arab), et = cuEl(s.text),
                            es = cuEl(s.src),  en = cuEl(s.num);
                        if (ea) ea.textContent = c.arab;
                        if (et) et.innerHTML   = '\u201c' + c.id + '\u201d';
                        if (es) es.textContent = book.name;
                        if (en) en.textContent = book.name + ' No. ' + c.number;
                    });

                    cuFadeIn();
                    setTimeout(cuCheckOverflow, 120);

                    cuTimeLeft = 60;
                    cuUpdateCountdown();
                } else {
                    throw new Error('Invalid response');
                }
            })
            .catch(function (e) {
                cuRetry++;
                var msg = e.name === 'AbortError'
                    ? 'Timeout memuat hadits.'
                    : (e.message === 'Failed to fetch' ? 'Koneksi terputus.' : 'Gagal memuat hadits.');
                cuShowError(msg);
                cuFadeIn();
                if (cuRetry < CU_MAX_RETRY) {
                    if (cuRetryTimer) clearTimeout(cuRetryTimer);
                    cuRetryTimer = setTimeout(cuFetchHadith, 3500);
                } else {
                    cuShowError('Gagal memuat hadits setelah beberapa percobaan. Refresh halaman.', false);
                    cuRetry = 0;
                }
            })
            .finally(function () { cuFetching = false; });
        });
    }

    /* --- toggle expand --- */
    document.addEventListener('click', function (e) {
        var dt = e.target.closest('#cu-toggle-desktop');
        if (dt) {
            e.preventDefault();
            var body = cuEl('cu-body-desktop');
            if (body) {
                var expanded = body.classList.toggle('cu-expanded');
                dt.classList.toggle('cu-expanded', expanded);
                var sp = dt.querySelector('.cu-toggle-txt');
                if (sp) sp.textContent = expanded ? 'Sembunyikan' : 'Selengkapnya';
            }
        }
        var mb = e.target.closest('#cu-toggle-mobile');
        if (mb) {
            e.preventDefault();
            var bodyM = cuEl('cu-body-mobile');
            if (bodyM) {
                var expandedM = bodyM.classList.toggle('cu-expanded');
                mb.classList.toggle('cu-expanded', expandedM);
                var spM = mb.querySelector('.cu-toggle-txt-m');
                if (spM) spM.textContent = expandedM ? 'Sembunyikan' : 'Selengkapnya';
            }
        }
    });

    /* --- init hadith --- */
    // Clear initial text elements
    ['cu-arab-desktop','cu-arab-mobile','cu-num-desktop','cu-num-mobile'].forEach(function (id) {
        var el = cuEl(id); if (el) el.textContent = '';
    });

    cuCheckOverflow();
    window.addEventListener('resize', cuCheckOverflow);
    cuStartCountdown();
    setTimeout(cuFetchHadith, 2500);


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
        var container = cuEl('cu-owl-dots');
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
        var container = cuEl('cu-owl-dots');
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
    var backdrop = cuEl('cu-bs-backdrop');
    var sheet    = cuEl('cu-bottom-sheet');
    var bsClose  = cuEl('cu-bs-close');
    var bsContent= cuEl('cu-bs-content');
    var btt      = document.querySelector('.back-to-top');

    // Card color icon bg map
    var colorBg = {
        primary: 'rgba(0,167,157,0.12)',
        green:   'rgba(0,184,148,0.12)',
        teal:    'rgba(32,201,151,0.12)',
        info:    'rgba(13,202,240,0.12)',
    };

    function cuOpenSheet(card) {
        var title  = card.dataset.cardTitle;
        var icon   = card.dataset.cardIcon;
        var color  = card.dataset.cardColor;
        var socials = card.querySelectorAll('.cu-social-link');
        var valueEl = card.querySelector('.cu-card-value');
        var subEl   = card.querySelector('.cu-card-sub');

        // Build content
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
                          + '<i class="fas fa-external-link-alt"></i>'
                          + '<span>Buka</span></a>';
                } else {
                    html += '<p>' + valueEl.textContent + '</p>';
                }
            }
            if (subEl) html += '<p style="margin-top:0.5rem;font-size:0.82rem;color:var(--gray);">' + subEl.textContent + '</p>';
        }

        html += '</div>';
        bsContent.innerHTML = html;

        // Open
        backdrop.classList.add('cu-bs-open');
        sheet.classList.add('cu-bs-open');
        document.body.classList.add('cu-no-scroll');
        if (btt) btt.classList.add('cu-hide-btt');
        sheet.focus();
    }

    function cuCloseSheet() {
        backdrop.classList.remove('cu-bs-open');
        sheet.classList.remove('cu-bs-open');
        document.body.classList.remove('cu-no-scroll');
        if (btt) btt.classList.remove('cu-hide-btt');
    }

    // Click on mobile card
    document.addEventListener('click', function (e) {
        var card = e.target.closest('.cu-mobile-card');
        if (card && window.innerWidth < 768) {
            // Don't open if clicking a link inside
            if (!e.target.closest('a')) {
                e.preventDefault();
                cuOpenSheet(card);
            }
        }
    });

    if (bsClose)  bsClose.addEventListener('click', cuCloseSheet);
    if (backdrop) backdrop.addEventListener('click', cuCloseSheet);

    // Keyboard close
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sheet && sheet.classList.contains('cu-bs-open')) {
            cuCloseSheet();
        }
    });

    // Swipe down to close
    var touchStartY = 0;
    if (sheet) {
        sheet.addEventListener('touchstart', function (e) {
            touchStartY = e.touches[0].clientY;
        }, { passive: true });

        sheet.addEventListener('touchend', function (e) {
            var dy = e.changedTouches[0].clientY - touchStartY;
            if (dy > 80) cuCloseSheet();
        }, { passive: true });
    }


    /* ================================================
       4. AJAX CONTACT FORM
       ================================================ */
    var form = cuEl('cu-contact-form');
    if (form) {
        var inputs = form.querySelectorAll('.cu-form-input, .cu-form-textarea');

        // Real-time validation on blur / input
        inputs.forEach(function (inp) {
            inp.addEventListener('blur', function () { cuValidateField(inp); });
            inp.addEventListener('input', function () {
                if (inp.classList.contains('cu-invalid')) cuValidateField(inp);
            });
        });

        function cuValidateField(field) {
            var grp = field.closest('.cu-form-group');
            var ok  = field.validity.valid && field.value.trim() !== '';
            field.classList.toggle('cu-invalid', !ok);
            field.classList.toggle('cu-valid', ok);
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
                cuShowToast('error', 'Harap lengkapi semua field yang wajib diisi!');
                return;
            }

            // Loading state
            var btn     = form.querySelector('.cu-form-submit');
            var emoji   = btn.querySelector('.cu-btn-emoji');
            var txt     = btn.querySelector('.cu-btn-txt');
            var ico     = btn.querySelector('.cu-btn-ico');
            var origTxt = txt.textContent;

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
                    cuShowToast('success', data.message || 'Pesan berhasil dikirim! Terima kasih 🎉');
                    form.reset();
                    inputs.forEach(function (inp) {
                        inp.classList.remove('cu-valid', 'cu-invalid');
                        var grp = inp.closest('.cu-form-group');
                        if (grp) grp.classList.remove('cu-has-error');
                    });
                } else {
                    cuShowToast('error', data.message || 'Terjadi kesalahan saat mengirim pesan!');
                }
            })
            .catch(function () {
                cuShowToast('error', 'Terjadi kesalahan jaringan. Silakan coba lagi!');
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
       5. CUSTOM TOAST
       ================================================ */
    function cuShowToast(type, message) {
        var container = cuEl('cu-toast-container');
        if (!container) return;

        var icons = { success: '✅', error: '❌', warning: '⚠️' };

        var el = document.createElement('div');
        el.className = 'cu-toast cu-toast--' + type;
        el.innerHTML =
            '<span class="cu-toast__ico">' + (icons[type] || 'ℹ️') + '</span>' +
            '<span class="cu-toast__msg">' + message + '</span>' +
            '<div class="cu-toast__bar"></div>';

        container.appendChild(el);

        // Trigger transition
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                el.classList.add('cu-toast-show');
            });
        });

        // Auto-remove after 3.8s
        setTimeout(function () {
            el.classList.remove('cu-toast-show');
            el.addEventListener('transitionend', function () {
                if (el.parentNode) el.parentNode.removeChild(el);
            });
        }, 3800);
    }


    /* ================================================
       6. INTERSECTION OBSERVER — entrance animations
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
