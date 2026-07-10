<script>
/* ── Welcome Gemilang — Popup Logic + AJAX Messages ─────────────── */
(function () {
    /* ── localStorage keys ── */
    var LS_KEYS_OLD = [
        'ldksyahid_welcome_popup',
        'ldksyahid_welcome_popup_eid_fitri',
        'ldksyahid_welcome_popup_arafah_fasting',
        'ldksyahid_welcome_popup_syawal_fasting',
        'ldksyahid_welcome_popup_self_reward',
        'ldksyahid_welcome_popup_qurban',
        'ldksyahid_welcome_popup_milad_30',
        'ldksyahid_welcome_popup_muharram_1448',
    ];
    var LS_KEY   = 'ldksyahid_welcome_popup_gemilang_2026';
    var backdrop = document.getElementById('wrp-backdrop');

    LS_KEYS_OLD.forEach(function (k) { localStorage.removeItem(k); });
    if (localStorage.getItem(LS_KEY)) return;

    /* ── Scroll lock ── */
    function lockScroll()   { document.body.style.overflow = 'hidden'; }
    function unlockScroll() { document.body.style.overflow = ''; }

    /* ── Open / close / dismiss ── */
    function closePopup() {
        if (!backdrop) return;
        backdrop.classList.remove('active');
        unlockScroll();
    }
    function dismissPopup() {
        if (!backdrop) return;
        backdrop.classList.remove('active');
        unlockScroll();
        localStorage.setItem(LS_KEY, '1');
    }

    var btnExplore = document.getElementById('wrp-btn-explore');
    var btnDismiss = document.getElementById('wrp-btn-dismiss');
    var btnX       = document.getElementById('wrp-x');
    var fallback   = document.getElementById('wrp-share-fallback');

    if (btnX)       btnX.addEventListener('click', closePopup);
    if (btnDismiss) btnDismiss.addEventListener('click', dismissPopup);

    /* ── Share — Web Share API + fallback ── */
    if (btnExplore) {
        var shareData = {
            title : 'Warisan Akal Budi Gemilang — LDK Syahid',
            text  : 'Tentang masa depan, tentang masa terang. Pelan pasti, jalanmu bakal gemilang gaes! 🌟 — LDK Syahid UIN Jakarta',
            url   : 'https://ldksyah.id/',
        };
        btnExplore.addEventListener('click', function () {
            if (navigator.share) {
                navigator.share(shareData).catch(function () {});
            } else {
                if (fallback) fallback.style.display = 'block';
                btnExplore.style.display = 'none';
            }
        });
    }

    /* ── Close on backdrop click & Escape ── */
    if (backdrop) {
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) closePopup();
        });
    }
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePopup();
    });

    /* ════════════════════════════════════════════════
       AJAX MESSAGES
    ════════════════════════════════════════════════ */
    var msgList      = document.getElementById('wrp-msg-list');
    var msgEmpty     = document.getElementById('wrp-msg-empty');
    var msgLoadMore  = document.getElementById('wrp-msg-load-more');
    var msgForm      = document.getElementById('wrp-msg-form');
    var msgName      = document.getElementById('wrp-msg-name');
    var msgText      = document.getElementById('wrp-msg-text');
    var msgChar      = document.getElementById('wrp-msg-char');
    var msgSubmit    = document.getElementById('wrp-msg-submit');
    var msgFeedback  = document.getElementById('wrp-msg-feedback');

    var currentOffset = 0;
    var isLoading     = false;

    /* ── CSRF token ── */
    function getCsrf() {
        var el = document.querySelector('meta[name="csrf-token"]');
        return el ? el.getAttribute('content') : '';
    }

    /* ── Format date ── */
    function formatDate(str) {
        var d = new Date(str);
        var pad = function (n) { return n < 10 ? '0' + n : n; };
        return pad(d.getDate()) + '/' + pad(d.getMonth() + 1) + '/' + d.getFullYear()
             + ' ' + pad(d.getHours()) + ':' + pad(d.getMinutes());
    }

    /* ── Sanitize output ── */
    function esc(str) {
        var d = document.createElement('div');
        d.appendChild(document.createTextNode(str));
        return d.innerHTML;
    }

    /* ── Render satu item pesan ── */
    function renderItem(msg, prepend) {
        if (msgEmpty) msgEmpty.style.display = 'none';
        var item = document.createElement('div');
        item.className = 'wrp-msg-item';
        item.innerHTML =
            '<div class="wrp-msg-item-header">' +
                '<span class="wrp-msg-item-name">' + esc(msg.senderName) + '</span>' +
                '<span class="wrp-msg-item-date">' + formatDate(msg.createdDate) + '</span>' +
            '</div>' +
            '<div class="wrp-msg-item-text">' + esc(msg.messageText) + '</div>';
        if (prepend && msgList.firstChild) {
            msgList.insertBefore(item, msgList.firstChild);
        } else {
            msgList.appendChild(item);
        }
    }

    /* ── Fetch messages (offset-based) ── */
    function fetchMessages(offset, prepend) {
        if (isLoading) return;
        isLoading = true;
        if (msgLoadMore) msgLoadMore.textContent = 'Memuat...';

        fetch('/api/gemilang-messages?offset=' + offset)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                data.messages.forEach(function (m) { renderItem(m, prepend); });
                currentOffset = offset + data.messages.length;

                if (msgLoadMore) {
                    if (data.hasMore) {
                        msgLoadMore.style.display = 'block';
                        msgLoadMore.innerHTML = 'Tampilkan lebih banyak <i class="fas fa-chevron-down"></i>';
                    } else {
                        msgLoadMore.style.display = 'none';
                    }
                }
                if (msgEmpty && data.messages.length === 0 && currentOffset === 0) {
                    msgEmpty.style.display = 'block';
                }
            })
            .catch(function () {
                if (msgLoadMore) {
                    msgLoadMore.innerHTML = 'Tampilkan lebih banyak <i class="fas fa-chevron-down"></i>';
                }
            })
            .finally(function () { isLoading = false; });
    }

    /* ── Load more ── */
    if (msgLoadMore) {
        msgLoadMore.addEventListener('click', function () {
            fetchMessages(currentOffset, false);
        });
    }

    /* ── Char counter ── */
    if (msgText && msgChar) {
        msgText.addEventListener('input', function () {
            msgChar.textContent = msgText.value.length + '/300';
        });
    }

    /* ── Submit pesan ── */
    if (msgForm) {
        msgForm.addEventListener('submit', function (e) {
            e.preventDefault();

            var name = msgName ? msgName.value.trim() : '';
            var text = msgText ? msgText.value.trim() : '';

            if (!name || !text) {
                setFeedback('Eh, nama sama pesannya jangan kosong dong! 😄', 'error');
                return;
            }

            if (msgSubmit) msgSubmit.disabled = true;
            setFeedback('', '');

            fetch('/api/gemilang-messages', {
                method  : 'POST',
                headers : {
                    'Content-Type'     : 'application/json',
                    'X-CSRF-TOKEN'     : getCsrf(),
                    'X-Requested-With' : 'XMLHttpRequest',
                },
                body: JSON.stringify({ senderName: name, messageText: text }),
            })
            .then(function (r) {
                if (!r.ok) return r.json().then(function (d) { throw d; });
                return r.json();
            })
            .then(function (data) {
                renderItem(data.message, true);
                if (msgName)  msgName.value  = '';
                if (msgText)  msgText.value  = '';
                if (msgChar)  msgChar.textContent = '0/300';
                setFeedback('Semangat kamu udah dititip! Makasih ya gaes 🌟', 'success');
                currentOffset += 1;
            })
            .catch(function (err) {
                var msg = 'Waduh, gagal nih. Coba lagi bentar ya! 😅';
                if (err && err.errors) {
                    var errs = Object.values(err.errors);
                    if (errs.length) msg = errs[0][0];
                }
                setFeedback(msg, 'error');
            })
            .finally(function () {
                if (msgSubmit) msgSubmit.disabled = false;
            });
        });
    }

    function setFeedback(text, type) {
        if (!msgFeedback) return;
        msgFeedback.textContent  = text;
        msgFeedback.className    = type;
    }

    /* ── Show popup & initial fetch ── */
    function showPopup() {
        setTimeout(function () {
            if (backdrop) { backdrop.classList.add('active'); lockScroll(); }
            fetchMessages(0, false);
        }, 800);
    }
    if (document.readyState === 'complete') { showPopup(); }
    else { window.addEventListener('load', showPopup); }
}());
</script>
