<script>
(function () {
    'use strict';

    var section = document.getElementById('cmt-section');
    if (!section) return;

    // Escape #photo stacking context (position:relative;z-index:1) so the backdrop
    // can cover the navbar. Moving to body puts it in the root stacking context.
    var gifModalEl = document.getElementById('cmt-gif-modal');
    if (gifModalEl && gifModalEl.parentNode !== document.body) {
        document.body.appendChild(gifModalEl);
    }

    // ── Config from data attributes ──────────────────────────────────
    var TYPE       = section.dataset.type;
    var ID         = section.dataset.id;
    var CSRF       = section.dataset.csrf;
    var IS_AUTH    = section.dataset.auth === '1';
    var STORE_URL  = section.dataset.storeUrl;
    var INDEX_URL  = section.dataset.indexUrl;
    var REACT_URL  = section.dataset.reactUrl;    // contains ':id' placeholder
    var UPLOAD_URL = section.dataset.uploadUrl;
    var GIF_URL    = section.dataset.gifUrl;
    var CAT_URL    = section.dataset.catUrl;
    var UPDATE_URL = section.dataset.updateUrl;
    var DELETE_URL = section.dataset.deleteUrl;

    // ── Reaction type definitions ────────────────────────────────────
    var REACTIONS = [
        { type: 'like',         emoji: '👍', label: 'Suka'        },
        { type: 'dislike',      emoji: '👎', label: 'Tidak Suka'  },
        { type: 'love',         emoji: '❤️',  label: 'Cinta'       },
        { type: 'heart_eyes',   emoji: '😍', label: 'Keren'       },
        { type: 'laughing',     emoji: '😂', label: 'Lucu'        },
        { type: 'rage',         emoji: '😡', label: 'Marah'       },
        { type: 'slight_smile', emoji: '🙂', label: 'Senyum'      },
    ];

    // ── Per-form media state { [target]: {url, type, gdriveId} } ────
    var mediaState = {};

    // ── HTML escape ──────────────────────────────────────────────────
    function esc(str) {
        var d = document.createElement('div');
        d.appendChild(document.createTextNode(String(str == null ? '' : str)));
        return d.innerHTML;
    }

    // ── Build avatar HTML ────────────────────────────────────────────
    function avatarHtml(user, small) {
        var dim = small ? ' style="width:32px;height:32px;font-size:.8rem"' : '';
        if (user.avatar) {
            return '<img src="' + esc(user.avatar) + '" alt="' + esc(user.name)
                 + '" class="cmt-avatar-img" loading="lazy"' + dim + '>';
        }
        return '<div class="cmt-avatar-placeholder"' + dim + '>'
             + esc(user.name.charAt(0).toUpperCase()) + '</div>';
    }

    // ── Build separate reaction pills + add button ───────────────────
    function buildReactionsHtml(commentId, counts, userTypes) {
        counts    = counts    || {};
        userTypes = userTypes || [];

        // One pill per active reaction type (count > 0 OR user has already reacted)
        var pillsHtml = '';
        for (var ri = 0; ri < REACTIONS.length; ri++) {
            var rx       = REACTIONS[ri];
            var cnt      = parseInt(counts[rx.type] || 0, 10);
            var isActive = userTypes.indexOf(rx.type) !== -1;

            if (cnt > 0 || isActive) {
                pillsHtml += '<button class="cmt-rx-pill' + (isActive ? ' active' : '') + '"'
                    + ' data-id="' + commentId + '" data-type="' + rx.type + '"'
                    + ' type="button" title="' + esc(rx.label) + '">'
                    + '<span class="cmt-rx-pill-emoji">' + rx.emoji + '</span>'
                    + (cnt > 0
                        ? '<span class="cmt-rx-pill-count">' + cnt + '</span>'
                        : '')
                    + '</button>';
            }
        }

        // Picker popup buttons (all 7, shown when "+" is clicked)
        var pickerBtns = '';
        for (var pi = 0; pi < REACTIONS.length; pi++) {
            var prx      = REACTIONS[pi];
            var pActive  = userTypes.indexOf(prx.type) !== -1;
            pickerBtns += '<button class="cmt-rx-pick-btn' + (pActive ? ' active' : '') + '"'
                + ' data-id="' + commentId + '" data-type="' + prx.type + '"'
                + ' type="button" title="' + esc(prx.label) + '">'
                + prx.emoji + '</button>';
        }

        // "+" add reaction button (logged-in users only)
        var addBtn = IS_AUTH
            ? '<div class="cmt-rx-wrap">'
              + '<button class="cmt-rx-add-btn" type="button" title="Tambah reaksi">'
              + '<i class="far fa-smile"></i>'
              + '</button>'
              + '<div class="cmt-rx-picker">' + pickerBtns + '</div>'
              + '</div>'
            : '';

        return '<div class="cmt-reactions-row" data-comment-id="' + commentId + '">'
             + pillsHtml
             + addBtn
             + '</div>';
    }

    // ── Build media inside comment HTML ──────────────────────────────
    function buildMediaHtml(c) {
        if (!c.mediaUrl) return '';
        return '<div class="cmt-item-media">'
             + '<img src="' + esc(c.mediaUrl) + '" alt="media" class="cmt-item-img"'
             + ' loading="lazy" onclick="this.requestFullscreen&&this.requestFullscreen()">'
             + '</div>';
    }

    // ── Build reply form HTML (for level 0 and 1 only) ───────────────
    function buildReplyFormHtml(commentId) {
        return '<div class="cmt-reply-form" id="cmt-reply-' + commentId + '" style="display:none">'
             + '<textarea class="cmt-textarea cmt-reply-textarea"'
             + ' placeholder="Tulis balasan…" rows="2" maxlength="2000"></textarea>'
             + '<div class="cmt-reply-mpw" id="cmt-rpw-' + commentId + '" style="display:none">'
             + '<button type="button" class="cmt-media-remove" data-target="' + commentId + '">'
             + '<i class="fas fa-times"></i></button>'
             + '<img class="cmt-reply-media-thumb" src="" alt=""></div>'
             + '<div class="cmt-reply-footer">'
             + '<div class="cmt-media-toolbar">'
             + '<button class="cmt-media-btn" data-action="img" data-target="' + commentId
             + '" type="button" title="Tambah gambar"><i class="fas fa-image"></i></button>'
             + '<button class="cmt-media-btn cmt-gif-open-btn" data-action="gif" data-target="' + commentId
             + '" type="button" title="Tambah GIF / Stiker">'
             + '<span class="cmt-gif-icon-wrap"><span class="cmt-gif-icon-text">GIF</span><span class="cmt-gif-sep">·</span><span class="cmt-gif-icon-text cmt-stk-text">Stiker</span></span>'
             + '</button>'
             + '</div>'
             + '<div class="cmt-form-controls">'
             + '<span class="cmt-char">0 / 2000</span>'
             + '<button class="cmt-btn-submit cmt-btn-reply" data-parent="' + commentId
             + '" type="button"><i class="fas fa-paper-plane"></i> Kirim</button>'
             + '</div></div>'
             + '</div>';
    }

    // ── Build edit form for a comment ────────────────────────────────
    function buildEditFormHtml(c) {
        var t      = 'edit-' + c.id;
        var hasM   = !!c.mediaUrl;
        return '<div class="cmt-edit-form" id="cmt-edit-' + c.id + '" style="display:none">'
             + '<textarea class="cmt-textarea cmt-edit-textarea" maxlength="2000">'
             + esc(c.commentText || '') + '</textarea>'
             + '<div class="cmt-edit-mpw" id="cmt-empw-' + c.id
             + '" style="display:' + (hasM ? 'inline-block' : 'none') + '">'
             + '<button type="button" class="cmt-media-remove" data-target="' + t + '">'
             + '<i class="fas fa-times"></i></button>'
             + '<img class="cmt-reply-media-thumb" src="' + esc(c.mediaUrl || '') + '" alt=""></div>'
             + '<div class="cmt-edit-footer">'
             + '<div class="cmt-media-toolbar">'
             + '<button class="cmt-media-btn" data-action="img" data-target="' + t
             + '" type="button" title="Tambah gambar"><i class="fas fa-image"></i></button>'
             + '<button class="cmt-media-btn cmt-gif-open-btn" data-action="gif" data-target="' + t
             + '" type="button" title="Tambah GIF / Stiker">'
             + '<span class="cmt-gif-icon-wrap"><span class="cmt-gif-icon-text">GIF</span><span class="cmt-gif-sep">·</span><span class="cmt-gif-icon-text cmt-stk-text">Stiker</span></span>'
             + '</button>'
             + '</div>'
             + '<div class="cmt-form-controls">'
             + '<button class="cmt-btn-cancel-edit" data-id="' + c.id + '" type="button">Batal</button>'
             + '<button class="cmt-btn-save-edit" data-id="' + c.id + '" type="button">'
             + '<i class="fas fa-check"></i> Simpan</button>'
             + '</div></div>'
             + '</div>';
    }

    // ── Build full comment item HTML ─────────────────────────────────
    // level: 0 = top-level, 1 = reply, 2 = reply-of-reply
    function buildHtml(c, level) {
        level = level || 0;

        var canReply = (level < 2) && IS_AUTH;
        var isOwner  = c.isOwner && IS_AUTH;

        var replyBtn = canReply
            ? '<button class="cmt-reply-toggle" data-id="' + c.id + '" type="button">'
            + '<i class="fas fa-reply"></i> Balas</button>'
            : '';

        var ownerBtns = isOwner
            ? '<div class="cmt-owner-actions">'
              + '<button class="cmt-edit-btn" data-id="' + c.id + '" type="button" title="Edit komentar">'
              + '<i class="fas fa-pencil-alt"></i></button>'
              + '<button class="cmt-delete-btn" data-id="' + c.id + '" type="button" title="Hapus komentar">'
              + '<i class="fas fa-trash-alt"></i></button>'
              + '</div>'
            : '';

        var replyForm = canReply ? buildReplyFormHtml(c.id) : '';
        var editForm  = isOwner  ? buildEditFormHtml(c) : '';

        // Collapsible replies section
        var repliesWrap = '';
        if (c.replies && c.replies.length) {
            var count       = c.replies.length;
            var repliesInner = '';
            for (var i = 0; i < count; i++) {
                repliesInner += buildHtml(c.replies[i], level + 1);
            }
            repliesWrap = '<div class="cmt-replies-wrap" data-wrap-id="' + c.id + '">'
                + '<button class="cmt-replies-toggle-btn" data-id="' + c.id + '" type="button">'
                + '<i class="fas fa-comments"></i>'
                + '<span class="cmt-replies-count-text">'
                + count + ' Balasan</span>'
                + '<i class="fas fa-chevron-down cmt-chevron"></i>'
                + '</button>'
                + '<div class="cmt-replies" id="cmt-replies-' + c.id + '" style="display:none">'
                + repliesInner
                + '</div></div>';
        }

        var rxInfo = c.reactions || {};
        return '<div class="cmt-item' + (level > 0 ? ' cmt-reply-item' : '')
             + '" data-id="' + c.id + '" data-level="' + level + '"'
             + ' data-text="' + esc(c.commentText || '') + '"'
             + ' data-media-url="' + esc(c.mediaUrl || '') + '"'
             + ' data-media-type="' + esc(c.mediaType || '') + '"'
             + ' data-media-gdrive-id="' + esc(c.mediaGdriveId || '') + '">'
             + '<div class="cmt-item-avatar">' + avatarHtml(c.user, level > 0) + '</div>'
             + '<div class="cmt-item-body">'
             + '<div class="cmt-item-header">'
             + '<span class="cmt-item-name">' + esc(c.user.name) + '</span>'
             + '<span class="cmt-item-time">' + esc(c.createdAt) + '</span>'
             + ownerBtns
             + '</div>'
             + (c.commentText ? '<p class="cmt-item-text">' + esc(c.commentText) + '</p>' : '')
             + buildMediaHtml(c)
             + '<div class="cmt-item-actions">'
             + replyBtn
             + buildReactionsHtml(c.id, rxInfo.counts, rxInfo.userTypes)
             + '</div>'
             + editForm
             + replyForm
             + repliesWrap
             + '</div></div>';
    }

    // ── Render full comment list ─────────────────────────────────────
    var list = document.getElementById('cmt-list');

    function renderList(comments) {
        if (!comments.length) {
            list.innerHTML = '<div class="cmt-empty">'
                + '<i class="fas fa-comment-slash"></i>'
                + '<p>Belum ada komentar. Jadilah yang pertama!</p></div>';
            return;
        }
        var html = '';
        for (var i = 0; i < comments.length; i++) {
            html += buildHtml(comments[i], 0);
        }
        list.innerHTML = html;
    }

    // ── Fetch comments from server ───────────────────────────────────
    function loadComments() {
        list.innerHTML = '<div class="cmt-loading">'
            + '<i class="fas fa-spinner fa-spin"></i> Memuat komentar…</div>';
        var url = INDEX_URL + '?type=' + encodeURIComponent(TYPE)
                            + '&id='   + encodeURIComponent(ID);
        fetch(url)
            .then(function (r) { if (!r.ok) throw new Error(); return r.json(); })
            .then(function (d) { renderList(d); })
            .catch(function () {
                list.innerHTML = '<div class="cmt-empty">'
                    + '<i class="fas fa-exclamation-circle"></i>'
                    + '<p>Gagal memuat komentar.</p></div>';
            });
    }

    // ── POST helper ──────────────────────────────────────────────────
    function doPost(url, payload, onOk, onErr) {
        fetch(url, {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            body: JSON.stringify(payload),
        })
        .then(function (r) {
            if (!r.ok) { var e = new Error(); e.status = r.status; throw e; }
            return r.json();
        })
        .then(onOk).catch(onErr);
    }

    // ── Prepend new comment at top ───────────────────────────────────
    function prependToList(comment) {
        var empty = list.querySelector('.cmt-empty');
        if (empty) empty.parentNode.removeChild(empty);
        var div = document.createElement('div');
        div.innerHTML = buildHtml(comment, 0);
        list.insertBefore(div.firstChild, list.firstChild);
    }

    // ── Add reply under parent, auto-show replies wrap ───────────────
    function appendReply(parentId, reply) {
        var parent = list.querySelector('.cmt-item[data-id="' + parentId + '"]');
        if (!parent) return;

        var lvl  = parseInt(parent.getAttribute('data-level') || '0', 10);
        var body = parent.querySelector('.cmt-item-body');
        if (!body) return;

        var wrap     = body.querySelector('.cmt-replies-wrap');
        var repliesDiv, countEl, toggleBtn;

        if (!wrap) {
            // First reply for this comment — create the collapsible wrap
            wrap = document.createElement('div');
            wrap.className = 'cmt-replies-wrap';
            wrap.setAttribute('data-wrap-id', parentId);
            wrap.innerHTML = '<button class="cmt-replies-toggle-btn open" data-id="' + parentId
                + '" type="button">'
                + '<i class="fas fa-comments"></i>'
                + '<span class="cmt-replies-count-text">0 Balasan</span>'
                + '<i class="fas fa-chevron-down cmt-chevron" style="transform:rotate(180deg)"></i>'
                + '</button>'
                + '<div class="cmt-replies" id="cmt-replies-' + parentId + '"></div>';
            body.appendChild(wrap);
        }

        repliesDiv = document.getElementById('cmt-replies-' + parentId);
        var div = document.createElement('div');
        div.innerHTML = buildHtml(reply, lvl + 1);
        repliesDiv.appendChild(div.firstChild);
        repliesDiv.style.display = 'block';

        // Update reply count
        countEl   = wrap.querySelector('.cmt-replies-count-text');
        toggleBtn = wrap.querySelector('.cmt-replies-toggle-btn');
        if (countEl) {
            var newCount = repliesDiv.children.length;
            countEl.textContent = newCount + ' Balasan';
        }
        if (toggleBtn) toggleBtn.classList.add('open');
    }

    // ── SweetAlert2 toast ────────────────────────────────────────────
    function showError(msg) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true, position: 'top-end', icon: 'error',
                title: msg, showConfirmButton: false, timer: 3500, timerProgressBar: true,
            });
        }
    }

    // ════════════════════════════════════════════════════════════════
    //  REACTIONS
    // ════════════════════════════════════════════════════════════════

    function handleReaction(commentId, type) {
        if (!IS_AUTH) {
            window.location.href = section.dataset.loginUrl
                + '?redirect=' + encodeURIComponent(window.location.href + '#cmt-section');
            return;
        }
        var url = REACT_URL.replace(':id', commentId);
        fetch(url, {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            body: JSON.stringify({ type: type }),
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            // Re-render reaction rows for this comment (there can be multiple — original + replies)
            var rows = document.querySelectorAll('.cmt-reactions-row[data-comment-id="' + commentId + '"]');
            var newHtml = buildReactionsHtml(commentId, data.counts, data.userTypes);
            var tmp = document.createElement('div');
            tmp.innerHTML = newHtml;
            var newEl = tmp.firstChild;
            for (var i = 0; i < rows.length; i++) {
                rows[i].parentNode.replaceChild(newEl.cloneNode(true), rows[i]);
            }
        })
        .catch(function () {});
    }

    // ════════════════════════════════════════════════════════════════
    //  MEDIA (image upload + GIF/Sticker picker)
    // ════════════════════════════════════════════════════════════════

    var activeMediaTarget = null;
    var sharedFileInput   = document.getElementById('cmt-shared-file');

    function getPreviewEl(target) {
        if (target === 'main') return document.getElementById('cmt-media-preview-main');
        if (target.indexOf('edit-') === 0) return document.getElementById('cmt-empw-' + target.slice(5));
        return document.getElementById('cmt-rpw-' + target);
    }

    function getPreviewImg(target, wrap) {
        if (target === 'main') return document.getElementById('cmt-media-img-main');
        return wrap ? wrap.querySelector('.cmt-reply-media-thumb') : null;
    }

    function setMedia(target, url, type, gdriveId) {
        mediaState[target] = { url: url, type: type, gdriveId: gdriveId || null };
        var pw  = getPreviewEl(target);
        var img = getPreviewImg(target, pw);
        if (pw && img) { img.src = url; pw.style.display = 'inline-block'; }
    }

    function clearMedia(target) {
        delete mediaState[target];
        var pw  = getPreviewEl(target);
        var img = getPreviewImg(target, pw);
        if (img) img.src = '';
        if (pw) pw.style.display = 'none';
    }

    function showUploadLoading(target) {
        var pw = getPreviewEl(target);
        if (pw) { pw.classList.add('cmt-media-loading'); pw.style.display = 'inline-block'; }
    }

    // Upload file to Google Drive via server endpoint
    function uploadFile(file, target) {
        var fd = new FormData();
        fd.append('file', file);
        fd.append('_token', CSRF);

        showUploadLoading(target);

        fetch(UPLOAD_URL, { method: 'POST', body: fd })
            .then(function (r) {
                if (!r.ok) throw new Error();
                return r.json();
            })
            .then(function (data) {
                var pw = getPreviewEl(target);
                if (pw) pw.classList.remove('cmt-media-loading');
                setMedia(target, data.url, data.type, data.gdriveId);
            })
            .catch(function () {
                var pw = getPreviewEl(target);
                if (pw) { pw.classList.remove('cmt-media-loading'); pw.style.display = 'none'; }
                showError('Gagal mengunggah gambar ke Google Drive. Pastikan ukuran file < 5 MB.');
            });
    }

    if (sharedFileInput) {
        sharedFileInput.addEventListener('change', function () {
            var file = this.files[0];
            if (!file || !activeMediaTarget) return;
            uploadFile(file, activeMediaTarget);
            this.value = '';
        });
    }

    // ════════════════════════════════════════════════════════════════
    //  GIF / STIKER PICKER
    // ════════════════════════════════════════════════════════════════

    var gifModal    = document.getElementById('cmt-gif-modal');
    var gifGrid     = document.getElementById('cmt-gif-grid');
    var gifInput    = document.getElementById('cmt-gif-q');
    var gifChips    = document.getElementById('cmt-gif-chips');
    var gifClearBtn = document.getElementById('cmt-gif-clear');
    var gifDebounce;
    var currentTab  = 'gifs';
    var currentChip = '';   // empty = trending

    // Load categories and inject extra chips
    function loadCategories() {
        fetch(CAT_URL)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!gifChips || !data.data || !data.data.length) return;
                for (var i = 0; i < data.data.length; i++) {
                    var cat = data.data[i];
                    var btn = document.createElement('button');
                    btn.className   = 'cmt-gif-chip';
                    btn.type        = 'button';
                    btn.dataset.q   = cat.slug;
                    btn.textContent = '#' + cat.name;
                    gifChips.appendChild(btn);
                }
            })
            .catch(function () {});
    }

    function openGifModal(target) {
        activeMediaTarget = target;
        if (!gifModal) return;

        gifModal.style.display = 'flex';
        gifModal.removeAttribute('aria-hidden');
        if (gifInput) { gifInput.value = ''; gifInput.focus(); }
        if (gifClearBtn) gifClearBtn.style.display = 'none';
        fetchGifs('', currentTab);
    }

    function closeGifModal() {
        if (gifModal) { gifModal.style.display = 'none'; gifModal.setAttribute('aria-hidden','true'); }
        activeMediaTarget = null;
    }

    function fetchGifs(q, tab) {
        if (!gifGrid) return;
        gifGrid.innerHTML = '<div class="cmt-gif-loading"><i class="fas fa-spinner fa-spin"></i></div>';

        var url = GIF_URL + '?tab=' + encodeURIComponent(tab);
        if (q) url += '&q=' + encodeURIComponent(q);

        fetch(url)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                var items = data.data || [];
                if (!items.length) {
                    gifGrid.innerHTML = '<div class="cmt-gif-hint">'
                        + '<i class="fas fa-image-slash"></i>'
                        + '<p>Tidak ada GIF ditemukan.</p></div>';
                    return;
                }
                var html = '';
                for (var i = 0; i < items.length; i++) {
                    var g = items[i];
                    html += '<div class="cmt-gif-item" data-url="' + esc(g.url)
                          + '" data-type="gif">'
                          + '<img src="' + esc(g.preview || g.url)
                          + '" alt="' + esc(g.title || '') + '" loading="lazy">'
                          + '</div>';
                }
                gifGrid.innerHTML = html;
            })
            .catch(function () {
                gifGrid.innerHTML = '<div class="cmt-gif-hint"><p>Gagal memuat GIF.</p></div>';
            });
    }

    // Load categories once
    loadCategories();

    // GIF search input debounce
    if (gifInput) {
        gifInput.addEventListener('input', function () {
            var q = this.value.trim();
            if (gifClearBtn) gifClearBtn.style.display = q ? 'block' : 'none';
            // Deselect all chips when typing
            if (gifChips) {
                var chips = gifChips.querySelectorAll('.cmt-gif-chip');
                for (var i = 0; i < chips.length; i++) chips[i].classList.remove('active');
            }
            clearTimeout(gifDebounce);
            gifDebounce = setTimeout(function () { fetchGifs(q, currentTab); }, 420);
        });
    }

    if (gifClearBtn) {
        gifClearBtn.addEventListener('click', function () {
            if (gifInput) gifInput.value = '';
            this.style.display = 'none';
            // Reactivate "Trending" chip
            setActiveChip('');
            fetchGifs('', currentTab);
        });
    }

    function setActiveChip(q) {
        currentChip = q;
        if (!gifChips) return;
        var chips = gifChips.querySelectorAll('.cmt-gif-chip');
        for (var i = 0; i < chips.length; i++) {
            var isActive = chips[i].dataset.q === q;
            chips[i].classList.toggle('active', isActive);
        }
    }

    // ════════════════════════════════════════════════════════════════
    //  EVENT DELEGATION
    // ════════════════════════════════════════════════════════════════

    function delegate(root, selector, handler) {
        if (!root) return;
        root.addEventListener('click', function (e) {
            var el = e.target.closest ? e.target.closest(selector) : null;
            if (el && root.contains(el)) handler(e, el);
        });
    }

    // Tabs: GIF / Sticker
    delegate(gifModal, '.cmt-gif-tab', function (e, btn) {
        var tabs = gifModal.querySelectorAll('.cmt-gif-tab');
        for (var i = 0; i < tabs.length; i++) tabs[i].classList.remove('active');
        btn.classList.add('active');
        currentTab = btn.dataset.tab;
        var q = gifInput ? gifInput.value.trim() : '';
        fetchGifs(q || currentChip, currentTab);
    });

    // Category chips
    delegate(gifModal, '.cmt-gif-chip', function (e, btn) {
        var q = btn.dataset.q;
        setActiveChip(q);
        if (gifInput) gifInput.value = '';
        if (gifClearBtn) gifClearBtn.style.display = 'none';
        fetchGifs(q, currentTab);
    });

    // GIF item selected — GIFs/Stickers are external URLs, just store URL (no GDrive needed)
    delegate(gifGrid, '.cmt-gif-item', function (e, item) {
        var url  = item.dataset.url;
        var type = item.dataset.type || 'gif';
        if (url && activeMediaTarget) {
            setMedia(activeMediaTarget, url, type, null);
        }
        closeGifModal();
    });

    // Close modal
    var backdrop = document.getElementById('cmt-gif-backdrop');
    var closeBtn = document.getElementById('cmt-gif-close');
    if (backdrop) backdrop.addEventListener('click', closeGifModal);
    if (closeBtn) closeBtn.addEventListener('click', closeGifModal);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeGifModal();
    });

    // Media toolbar buttons (image / GIF) in any form
    delegate(section, '[data-action="img"]', function (e, btn) {
        activeMediaTarget = btn.dataset.target;
        if (sharedFileInput) sharedFileInput.click();
    });
    delegate(section, '[data-action="gif"]', function (e, btn) {
        openGifModal(btn.dataset.target);
    });
    delegate(section, '.cmt-media-remove', function (e, btn) {
        clearMedia(btn.dataset.target);
    });

    // "+" button toggles the emoji picker popup
    delegate(section, '.cmt-rx-add-btn', function (e, btn) {
        var wrap = btn.parentElement;
        if (wrap) wrap.classList.toggle('open');
        // Close other open pickers
        var others = section.querySelectorAll('.cmt-rx-wrap.open');
        for (var i = 0; i < others.length; i++) {
            if (others[i] !== wrap) others[i].classList.remove('open');
        }
        e.stopPropagation();
    });
    // Close picker on outside click
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.cmt-rx-wrap')) {
            var opens = section.querySelectorAll('.cmt-rx-wrap.open');
            for (var i = 0; i < opens.length; i++) opens[i].classList.remove('open');
        }
    });

    // Click on an active pill → toggle off that reaction
    delegate(section, '.cmt-rx-pill', function (e, btn) {
        handleReaction(btn.dataset.id, btn.dataset.type);
    });

    // Click emoji from picker popup → toggle reaction + close picker
    delegate(section, '.cmt-rx-pick-btn', function (e, btn) {
        e.stopPropagation();
        handleReaction(btn.dataset.id, btn.dataset.type);
        var wrap = btn.closest('.cmt-rx-wrap');
        if (wrap) wrap.classList.remove('open');
    });

    // Toggle reply form
    delegate(section, '.cmt-reply-toggle', function (e, btn) {
        var form = document.getElementById('cmt-reply-' + btn.dataset.id);
        if (!form) return;
        var opening = form.style.display === 'none';
        form.style.display = opening ? 'block' : 'none';
        if (opening) form.querySelector('textarea').focus();
    });

    // Toggle collapsible replies
    delegate(section, '.cmt-replies-toggle-btn', function (e, btn) {
        var id      = btn.dataset.id;
        var replies = document.getElementById('cmt-replies-' + id);
        var chevron = btn.querySelector('.cmt-chevron');
        if (!replies) return;
        var isOpen  = replies.style.display !== 'none';
        replies.style.display = isOpen ? 'none' : 'block';
        btn.classList.toggle('open', !isOpen);
        if (chevron) chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
    });

    // Submit reply
    delegate(section, '.cmt-btn-reply', function (e, btn) {
        var parentId = btn.dataset.parent;
        var form     = document.getElementById('cmt-reply-' + parentId);
        var textarea = form.querySelector('textarea');
        var text     = textarea.value.trim();
        var media    = mediaState[parentId] || null;
        if (!text && !media) return;

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        var payload = { type: TYPE, id: ID, commentText: text, parentID: parentId };
        if (media) {
            payload.mediaUrl     = media.url;
            payload.mediaType    = media.type;
            payload.mediaGdriveId = media.gdriveId;
        }

        doPost(STORE_URL, payload,
            function (reply) {
                textarea.value = '';
                var charEl = form.querySelector('.cmt-char');
                if (charEl) charEl.textContent = '0 / 2000';
                clearMedia(parentId);
                form.style.display = 'none';
                appendReply(parentId, reply);
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim';
            },
            function () {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim';
            }
        );
    });

    // Character counter
    section.addEventListener('input', function (e) {
        var ta = e.target;
        if (ta.tagName !== 'TEXTAREA') return;
        var max     = parseInt(ta.getAttribute('maxlength') || '2000', 10);
        var counter = ta.parentElement.querySelector('.cmt-char, #cmt-char-count');
        if (counter) counter.textContent = ta.value.length + ' / ' + max;
    });

    // ════════════════════════════════════════════════════════════════
    //  EDIT COMMENT (own comments only)
    // ════════════════════════════════════════════════════════════════

    function openEditForm(commentId) {
        // Close all other open edit forms first
        var allForms = section.querySelectorAll('.cmt-edit-form');
        for (var fi = 0; fi < allForms.length; fi++) {
            var fid = allForms[fi].id.replace('cmt-edit-', '');
            if (fid !== String(commentId)) {
                allForms[fi].style.display = 'none';
                delete mediaState['edit-' + fid];
                // Restore media preview to saved data-attr value
                var prevElC = document.getElementById('cmt-empw-' + fid);
                var origItemC = section.querySelector('.cmt-item[data-id="' + fid + '"]');
                if (prevElC && origItemC) {
                    var prevImgC = prevElC.querySelector('.cmt-reply-media-thumb');
                    var origUrlC = origItemC.getAttribute('data-media-url') || '';
                    if (prevImgC) prevImgC.src = origUrlC;
                    prevElC.style.display = origUrlC ? 'inline-block' : 'none';
                }
            }
        }

        var editForm = document.getElementById('cmt-edit-' + commentId);
        if (!editForm) return;
        var item = section.querySelector('.cmt-item[data-id="' + commentId + '"]');
        if (!item) return;

        // Re-populate with current stored values
        var ta = editForm.querySelector('textarea');
        if (ta) ta.value = item.getAttribute('data-text') || '';

        var mUrl    = item.getAttribute('data-media-url') || '';
        var mType   = item.getAttribute('data-media-type') || '';
        var mGdrive = item.getAttribute('data-media-gdrive-id') || '';
        var prevEl  = document.getElementById('cmt-empw-' + commentId);
        if (prevEl) {
            var prevImg = prevEl.querySelector('.cmt-reply-media-thumb');
            if (prevImg) prevImg.src = mUrl;
            prevEl.style.display = mUrl ? 'inline-block' : 'none';
        }
        if (mUrl) {
            mediaState['edit-' + commentId] = { url: mUrl, type: mType, gdriveId: mGdrive || null };
        } else {
            delete mediaState['edit-' + commentId];
        }

        editForm.style.display = 'block';
        if (ta) ta.focus();
    }

    function submitEdit(commentId) {
        var editForm = document.getElementById('cmt-edit-' + commentId);
        if (!editForm) return;
        var ta   = editForm.querySelector('textarea');
        var text = ta ? ta.value.trim() : '';
        var media = mediaState['edit-' + commentId] || null;

        if (!text && !media) { showError('Komentar atau media wajib diisi.'); return; }

        var saveBtn = editForm.querySelector('.cmt-btn-save-edit');
        if (saveBtn) { saveBtn.disabled = true; saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>'; }

        var payload = {
            commentText:   text,
            mediaUrl:      media ? media.url      : null,
            mediaType:     media ? media.type     : null,
            mediaGdriveId: media ? media.gdriveId : null,
        };

        fetch(UPDATE_URL.replace(':id', commentId), {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify(payload),
        })
        .then(function (r) { if (!r.ok) throw new Error(); return r.json(); })
        .then(function (updated) {
            var item = section.querySelector('.cmt-item[data-id="' + commentId + '"]');
            if (item) {
                // Update data attributes
                item.setAttribute('data-text',            updated.commentText   || '');
                item.setAttribute('data-media-url',        updated.mediaUrl      || '');
                item.setAttribute('data-media-type',       updated.mediaType     || '');
                item.setAttribute('data-media-gdrive-id',  updated.mediaGdriveId || '');

                var body      = item.querySelector('.cmt-item-body');
                var actionsEl = item.querySelector('.cmt-item-actions');
                var textEl    = item.querySelector('.cmt-item-text');
                var mediaEl   = item.querySelector('.cmt-item-media');

                // Update text
                if (updated.commentText) {
                    if (textEl) {
                        textEl.textContent = updated.commentText;
                    } else {
                        var p = document.createElement('p');
                        p.className   = 'cmt-item-text';
                        p.textContent = updated.commentText;
                        body.insertBefore(p, actionsEl);
                    }
                } else if (textEl) {
                    textEl.parentNode.removeChild(textEl);
                }

                // Update media
                if (updated.mediaUrl) {
                    if (mediaEl) {
                        var mImg = mediaEl.querySelector('.cmt-item-img');
                        if (mImg) mImg.src = updated.mediaUrl;
                    } else {
                        var mDiv = document.createElement('div');
                        mDiv.className = 'cmt-item-media';
                        mDiv.innerHTML = '<img src="' + esc(updated.mediaUrl)
                            + '" alt="media" class="cmt-item-img" loading="lazy"'
                            + ' onclick="this.requestFullscreen&&this.requestFullscreen()">';
                        body.insertBefore(mDiv, actionsEl);
                    }
                } else if (mediaEl) {
                    mediaEl.parentNode.removeChild(mediaEl);
                }
            }

            editForm.style.display = 'none';
            delete mediaState['edit-' + commentId];
            if (saveBtn) { saveBtn.disabled = false; saveBtn.innerHTML = '<i class="fas fa-check"></i> Simpan'; }
        })
        .catch(function () {
            showError('Gagal menyimpan perubahan, silakan coba lagi.');
            if (saveBtn) { saveBtn.disabled = false; saveBtn.innerHTML = '<i class="fas fa-check"></i> Simpan'; }
        });
    }

    // ════════════════════════════════════════════════════════════════
    //  DELETE COMMENT (own comments only)
    // ════════════════════════════════════════════════════════════════

    function doDelete(commentId) {
        fetch(DELETE_URL.replace(':id', commentId), {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        })
        .then(function (r) { if (!r.ok) throw new Error(); return r.json(); })
        .then(function () {
            var item = section.querySelector('.cmt-item[data-id="' + commentId + '"]');
            if (!item) return;
            var level       = parseInt(item.getAttribute('data-level') || '0', 10);
            var repliesWrap = item.closest ? item.closest('.cmt-replies') : null;
            item.parentNode.removeChild(item);

            if (level > 0 && repliesWrap) {
                var wrap    = repliesWrap.closest ? repliesWrap.closest('.cmt-replies-wrap') : null;
                var countEl = wrap ? wrap.querySelector('.cmt-replies-count-text') : null;
                if (countEl) countEl.textContent = repliesWrap.children.length + ' Balasan';
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({ toast: true, position: 'top-end', icon: 'success',
                    title: 'Komentar dihapus.', showConfirmButton: false, timer: 2500, timerProgressBar: true });
            }
        })
        .catch(function () { showError('Gagal menghapus komentar, silakan coba lagi.'); });
    }

    function deleteComment(commentId) {
        if (typeof Swal === 'undefined') {
            if (confirm('Hapus komentar ini?')) doDelete(commentId);
            return;
        }
        Swal.fire({
            title: 'Hapus Komentar?',
            text: 'Komentar dan seluruh balasannya akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then(function (result) { if (result.isConfirmed) doDelete(commentId); });
    }

    // Owner action delegates
    delegate(section, '.cmt-edit-btn', function (e, btn) {
        openEditForm(btn.dataset.id);
    });
    delegate(section, '.cmt-delete-btn', function (e, btn) {
        deleteComment(btn.dataset.id);
    });
    delegate(section, '.cmt-btn-cancel-edit', function (e, btn) {
        var ef = document.getElementById('cmt-edit-' + btn.dataset.id);
        if (ef) ef.style.display = 'none';
        delete mediaState['edit-' + btn.dataset.id];
        // Restore media preview
        var prevEl   = document.getElementById('cmt-empw-' + btn.dataset.id);
        var origItem = section.querySelector('.cmt-item[data-id="' + btn.dataset.id + '"]');
        if (prevEl && origItem) {
            var origUrl = origItem.getAttribute('data-media-url') || '';
            var prevImg = prevEl.querySelector('.cmt-reply-media-thumb');
            if (prevImg) prevImg.src = origUrl;
            prevEl.style.display = origUrl ? 'inline-block' : 'none';
        }
    });
    delegate(section, '.cmt-btn-save-edit', function (e, btn) {
        submitEdit(btn.dataset.id);
    });

    // ── Main submit button ───────────────────────────────────────────
    var submitBtn = document.getElementById('cmt-submit-btn');
    var mainInput = document.getElementById('cmt-input');

    if (submitBtn && mainInput) {
        submitBtn.addEventListener('click', function () {
            var text  = mainInput.value.trim();
            var media = mediaState['main'] || null;
            if (!text && !media) return;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            var payload = { type: TYPE, id: ID, commentText: text };
            if (media) {
                payload.mediaUrl      = media.url;
                payload.mediaType     = media.type;
                payload.mediaGdriveId = media.gdriveId;
            }

            doPost(STORE_URL, payload,
                function (comment) {
                    mainInput.value = '';
                    var cc = document.getElementById('cmt-char-count');
                    if (cc) cc.textContent = '0 / 2000';
                    clearMedia('main');
                    prependToList(comment);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim';
                },
                function (err) {
                    var msg = (err && err.status === 422)
                        ? 'Komentar tidak valid. Teks atau media wajib diisi (maks. 2000 karakter).'
                        : 'Gagal mengirim komentar, silakan coba lagi.';
                    showError(msg);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim';
                }
            );
        });

        mainInput.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') submitBtn.click();
        });
    }

    // ── Initial load ─────────────────────────────────────────────────
    loadComments();

})();
</script>
