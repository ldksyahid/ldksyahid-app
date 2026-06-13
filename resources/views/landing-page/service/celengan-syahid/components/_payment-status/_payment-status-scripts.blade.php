@if($isPending)
{{-- Render the QRIS code: image when the gateway returns a URL/data-uri,
     otherwise generate it locally from the raw QRIS payload string. --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
(function () {
    var box = document.getElementById('ds-qris');
    if (!box) return;
    var raw = box.getAttribute('data-qr') || '';
    if (!raw) return;

    if (/^https?:\/\//i.test(raw) || /^data:image\//i.test(raw)) {
        var img = document.createElement('img');
        img.src = raw;
        img.alt = 'QRIS';
        img.crossOrigin = 'anonymous';
        box.appendChild(img);
    } else {
        try {
            new QRCode(box, { text: raw, width: 240, height: 240, correctLevel: QRCode.CorrectLevel.M });
        } catch (e) {
            box.innerHTML = '<div style="font-size:.75rem;color:#6c757d;word-break:break-all;">' + raw + '</div>';
        }
    }
})();
</script>

<script>
(function () {
    var dlBtn = document.getElementById('ds-qris-dl');
    if (!dlBtn) return;

    dlBtn.addEventListener('click', function () {
        var box    = document.getElementById('ds-qris');
        var canvas = box ? box.querySelector('canvas') : null;
        var img    = box ? box.querySelector('img')    : null;
        var fname  = 'qris-donasi.png';

        if (canvas) {
            triggerDownload(canvas.toDataURL('image/png'), fname);
        } else if (img) {
            if (/^data:image\//i.test(img.src)) {
                triggerDownload(img.src, fname);
            } else {
                fetch(img.src)
                    .then(function (r) { return r.blob(); })
                    .then(function (blob) {
                        var url = URL.createObjectURL(blob);
                        triggerDownload(url, fname);
                        setTimeout(function () { URL.revokeObjectURL(url); }, 5000);
                    })
                    .catch(function () {
                        window.open(img.src, '_blank');
                    });
            }
        }
    });

    function triggerDownload(href, filename) {
        var a = document.createElement('a');
        a.href     = href;
        a.download = filename;
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
})();
</script>

<script>
(function () {
    var CHECK_URL  = @json(route('service.celengansyahid.api.checkPayment', $data->id));
    var SAVE_URL   = @json(route('service.celengansyahid.savePayment', ['link' => $campaign->link, 'id' => $data->id]));
    var PAY_URL    = @json(route('service.celengansyahid.detail.donatenow', $campaign->link));
    var HOME_URL   = @json(route('service.celengansyahid'));
    var POLL_MS    = 5000;
    var active     = true;
    var timer      = null;

    function applyTransition(fn) {
        var banner  = document.getElementById('ds-banner');
        var actions = document.getElementById('ds-actions');

        banner.style.transition  = 'opacity .35s ease, transform .35s ease';
        actions.style.transition = 'opacity .35s ease';
        banner.style.opacity     = '0';
        banner.style.transform   = 'translateY(-6px) scale(0.98)';
        actions.style.opacity    = '0';

        setTimeout(function () {
            fn(banner, actions);

            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    banner.style.opacity   = '1';
                    banner.style.transform = 'translateY(0) scale(1)';
                    actions.style.opacity  = '1';
                });
            });
        }, 350);
    }

    function transitionToPaid() {
        applyTransition(function (banner, actions) {
            banner.className = 'ds-status-banner paid';
            banner.querySelector('.ds-status-icon').innerHTML = '<i class="fas fa-check-circle"></i>';
            banner.querySelector('.ds-status-title').textContent = 'Pembayaran Berhasil';
            banner.querySelector('.ds-status-sub').textContent   = 'Jazakallah khayran, donasi kamu sudah kami terima!';
            var indicator = document.getElementById('ds-polling');
            if (indicator) indicator.remove();
            var qrCardPaid = document.getElementById('ds-qris-card');
            if (qrCardPaid) qrCardPaid.style.display = 'none';

            actions.className   = 'ds-action-wrap two-col';
            actions.innerHTML   =
                '<a href="' + SAVE_URL + '" target="_blank" class="ds-btn ds-btn-success">' +
                    '<i class="fas fa-download"></i> Simpan Bukti' +
                '</a>' +
                '<a href="' + HOME_URL + '" class="ds-btn ds-btn-outline">' +
                    '<i class="fas fa-home"></i> Kembali' +
                '</a>';
        });
    }

    function transitionToFailed() {
        applyTransition(function (banner, actions) {
            banner.className = 'ds-status-banner failed';
            banner.querySelector('.ds-status-icon').innerHTML = '<i class="fas fa-times-circle"></i>';
            banner.querySelector('.ds-status-title').textContent = 'Pembayaran Gagal';
            banner.querySelector('.ds-status-sub').textContent   = 'Terjadi masalah, silakan coba lagi';
            var indicator = document.getElementById('ds-polling');
            if (indicator) indicator.remove();
            var qrCardFailed = document.getElementById('ds-qris-card');
            if (qrCardFailed) qrCardFailed.style.display = 'none';

            actions.className = 'ds-action-wrap';
            actions.innerHTML =
                '<a href="' + PAY_URL + '" class="ds-btn ds-btn-primary">' +
                    '<i class="fas fa-redo"></i> Donasi Lagi' +
                '</a>' +
                '<button type="button" class="ds-btn ds-btn-gray" onclick="location.reload()">' +
                    '<i class="fas fa-sync-alt"></i> Muat Ulang Halaman' +
                '</button>' +
                '<a href="' + HOME_URL + '" class="ds-btn ds-btn-outline">' +
                    '<i class="fas fa-arrow-left"></i> Kembali ke Celengan Syahid' +
                '</a>';
        });
    }

    function poll() {
        if (!active) return;
        fetch(CHECK_URL)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!active) return;
                if (data.status === 'PAID' || data.status === 'SETTLED') {
                    active = false;
                    transitionToPaid();
                } else if (data.status === 'FAILED' || data.status === 'EXPIRED') {
                    active = false;
                    transitionToFailed();
                } else {
                    timer = setTimeout(poll, POLL_MS);
                }
            })
            .catch(function () {
                if (active) timer = setTimeout(poll, POLL_MS);
            });
    }

    timer = setTimeout(poll, POLL_MS);
})();
</script>
@endif
