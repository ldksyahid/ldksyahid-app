<script>
let isFullscreen = false;
let readerFrame  = null;
let readerStatus = null;

document.addEventListener('DOMContentLoaded', function () {
    readerFrame  = document.getElementById('reader-frame');
    readerStatus = document.getElementById('pr-status');

    if (!readerFrame) return;

    readerFrame.addEventListener('load', function () {
        setStatus('success', 'Buku siap dibaca');
        showToast('success', 'Buku berhasil dimuat!');
    });

    readerFrame.addEventListener('error', function () {
        setStatus('error', 'Gagal memuat buku');
        showToast('error', 'Gagal memuat buku. Silakan coba lagi.');
    });

    setStatus('loading', 'Memuat buku…');
    setupEventListeners();
});

/* ── Status ── */
function setStatus(type, message) {
    if (!readerStatus) return;
    readerStatus.className = 'pr-status status-' + type;
    readerStatus.textContent = message;
}

/* ── Toast (SweetAlert) ── */
function showToast(icon, title) {
    if (typeof Swal === 'undefined') return;
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        customClass: { popup: 'swal-bd-toast' },
    });
}

function showSuccessMessage(msg) { showToast('success', msg); }
function showErrorMessage(msg)   { showToast('error',   msg); }

/* ── Reload ── */
function reloadReader() {
    if (!readerFrame) return;
    setStatus('loading', 'Memuat ulang…');
    const src = readerFrame.src.split('?')[0];
    readerFrame.src = src + '?t=' + Date.now();

    const btn = event?.target?.closest('.pr-ctrl-btn');
    if (btn) {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        setTimeout(() => { btn.innerHTML = '<i class="fas fa-redo"></i>'; }, 1200);
    }
}

/* ── Open in new tab ── */
function openInNewTab() {
    const url = '{{ $book->getReaderLink() }}';
    if (url) {
        window.open(url, '_blank', 'noopener,noreferrer');
        showToast('info', 'Membuka di tab baru…');
    } else {
        showToast('error', 'URL buku tidak tersedia');
    }
}

/* ── Fullscreen ── */
function toggleFullscreen() {
    const wrap = document.querySelector('.pr-frame-wrap');
    const btnMain = document.getElementById('fullscreen-btn');
    const btnCtrl = document.getElementById('fullscreen-control');

    if (!isFullscreen) {
        if (wrap.requestFullscreen)            wrap.requestFullscreen();
        else if (wrap.webkitRequestFullscreen) wrap.webkitRequestFullscreen();
        else if (wrap.mozRequestFullScreen)    wrap.mozRequestFullScreen();

        wrap.classList.add('fullscreen');
        document.body.classList.add('fullscreen-mode');
        if (btnMain) btnMain.innerHTML = '<i class="fas fa-compress"></i>Keluar Layar Penuh';
        if (btnCtrl) btnCtrl.innerHTML = '<i class="fas fa-compress"></i>';
        isFullscreen = true;
        setStatus('success', 'Mode layar penuh');
    } else {
        if (document.exitFullscreen)            document.exitFullscreen();
        else if (document.webkitExitFullscreen) document.webkitExitFullscreen();
        else if (document.mozCancelFullScreen)  document.mozCancelFullScreen();

        wrap.classList.remove('fullscreen');
        document.body.classList.remove('fullscreen-mode');
        if (btnMain) btnMain.innerHTML = '<i class="fas fa-expand"></i>Layar Penuh';
        if (btnCtrl) btnCtrl.innerHTML = '<i class="fas fa-expand"></i>';
        isFullscreen = false;
        setStatus('success', 'Buku siap dibaca');
    }
}

function handleFullscreenChange() {
    if (!document.fullscreenElement &&
        !document.webkitFullscreenElement &&
        !document.mozFullScreenElement) {

        const wrap = document.querySelector('.pr-frame-wrap');
        const btnMain = document.getElementById('fullscreen-btn');
        const btnCtrl = document.getElementById('fullscreen-control');

        wrap?.classList.remove('fullscreen');
        document.body.classList.remove('fullscreen-mode');
        if (btnMain) btnMain.innerHTML = '<i class="fas fa-expand"></i>Layar Penuh';
        if (btnCtrl) btnCtrl.innerHTML = '<i class="fas fa-expand"></i>';
        isFullscreen = false;
        setStatus('success', 'Buku siap dibaca');
    }
}

/* ── Event listeners ── */
function setupEventListeners() {
    document.getElementById('fullscreen-btn')?.addEventListener('click', toggleFullscreen);
    document.getElementById('fullscreen-control')?.addEventListener('click', toggleFullscreen);

    ['fullscreenchange','webkitfullscreenchange','mozfullscreenchange','MSFullscreenChange']
        .forEach(ev => document.addEventListener(ev, handleFullscreenChange));

    document.addEventListener('keydown', function (e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.key === 'F11') { e.preventDefault(); toggleFullscreen(); }
        if (e.key === 'Escape' && isFullscreen) { e.preventDefault(); toggleFullscreen(); }
        if (e.key === 'F5') { e.preventDefault(); reloadReader(); }
        if ((e.ctrlKey || e.metaKey) && (e.key === 'r' || e.key === 'R')) {
            e.preventDefault(); reloadReader();
        }
    });

    /* Ripple on control buttons */
    document.querySelectorAll('.pr-ctrl-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            const ripple = document.createElement('span');
            const rect = btn.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.cssText = `position:absolute;border-radius:50%;width:${size}px;height:${size}px;`
                + `left:${e.clientX - rect.left - size/2}px;top:${e.clientY - rect.top - size/2}px;`
                + `background:rgba(255,255,255,0.5);transform:scale(0);animation:prRipple 0.5s linear;pointer-events:none;`;
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 500);
        });
    });
}

/* ── Ripple keyframe ── */
const _s = document.createElement('style');
_s.textContent = `@keyframes prRipple { to { transform:scale(4); opacity:0; } }`;
document.head.appendChild(_s);

/* ── Global exports ── */
window.reloadReader    = reloadReader;
window.openInNewTab    = openInNewTab;
window.toggleFullscreen = toggleFullscreen;
</script>
