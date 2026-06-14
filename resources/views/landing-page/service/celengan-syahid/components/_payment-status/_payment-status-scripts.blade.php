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
/* ── Download QR: generate a branded card image ──────────────────── */
(function () {
    var dlBtn = document.getElementById('ds-qris-dl');
    if (!dlBtn) return;

    dlBtn.addEventListener('click', function () {
        var qrBox  = document.getElementById('ds-qris');
        if (!qrBox) return;

        var rawQr    = qrBox.getAttribute('data-qr') || '';
        var amount   = dlBtn.getAttribute('data-amount')   || '';
        var campaign = dlBtn.getAttribute('data-campaign') || '';
        var expiry   = dlBtn.getAttribute('data-expiry')   || '';

        var origHTML    = dlBtn.innerHTML;
        dlBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        dlBtn.disabled  = true;

        buildQrisImage(rawQr, { amount: amount, campaign: campaign, expiry: expiry }, function (dataUrl) {
            var a = document.createElement('a');
            a.href     = dataUrl;
            a.download = 'qris-donasi-ldksyahid.png';
            a.style.display = 'none';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            dlBtn.innerHTML = origHTML;
            dlBtn.disabled  = false;
        });
    });

    /* ── Canvas builder ─────────────────────────────────────────── */
    function buildQrisImage(rawQr, opts, callback) {
        var W   = 500;
        var H   = 740;
        var DPR = 2;      /* retina – actual canvas pixels = W*2 × H*2 */

        var oc  = document.createElement('canvas');
        oc.width  = W * DPR;
        oc.height = H * DPR;
        var ctx = oc.getContext('2d');
        ctx.scale(DPR, DPR);

        /* Background */
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, W, H);

        /* Header gradient */
        var hH   = 108;
        var grad = ctx.createLinearGradient(0, 0, W, 0);
        grad.addColorStop(0, '#00a79d');
        grad.addColorStop(1, '#00c4b8');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, W, hH);

        /* Decorative circles in header */
        ctx.fillStyle = 'rgba(255,255,255,0.12)';
        ctx.beginPath(); ctx.arc(W + 10, -20, 110, 0, Math.PI * 2); ctx.fill();
        ctx.beginPath(); ctx.arc(W - 20, hH + 25, 75, 0, Math.PI * 2); ctx.fill();
        ctx.beginPath(); ctx.arc(10, hH - 5, 55, 0, Math.PI * 2); ctx.fill();

        /* Logo badge */
        ctx.fillStyle = 'rgba(255,255,255,0.25)';
        fillRR(ctx, 22, hH / 2 - 24, 48, 48, 12);
        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 15px Arial, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('LDK', 46, hH / 2 + 5);

        /* Header text */
        ctx.textAlign = 'left';
        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 20px Arial, sans-serif';
        ctx.fillText('LDK Syahid', 84, hH / 2 - 6);
        ctx.font = '13px Arial, sans-serif';
        ctx.fillStyle = 'rgba(255,255,255,0.88)';
        ctx.fillText('Celengan Syahid  •  UIN Jakarta', 84, hH / 2 + 14);

        /* Subtitle */
        ctx.fillStyle = '#6b7280';
        ctx.font = '14px Arial, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('Scan QRIS untuk Berdonasi', W / 2, hH + 40);

        /* QR card dimensions */
        var qrGenSize  = 320;   /* size fed to QRCode.js (re-generated bigger) */
        var qrDisplay  = 284;   /* drawn on canvas at this px */
        var cardPad    = 28;    /* white padding inside card (quiet zone) */
        var cardSize   = qrDisplay + cardPad * 2;
        var cardX      = (W - cardSize) / 2;
        var cardY      = hH + 60;

        /* White card with drop-shadow */
        ctx.save();
        ctx.shadowColor   = 'rgba(0,0,0,0.10)';
        ctx.shadowBlur    = 28;
        ctx.shadowOffsetY = 8;
        ctx.fillStyle     = '#ffffff';
        fillRR(ctx, cardX, cardY, cardSize, cardSize, 22);
        ctx.restore();

        /* Card border */
        ctx.strokeStyle = '#e5e7eb';
        ctx.lineWidth   = 1.5;
        strokeRR(ctx, cardX, cardY, cardSize, cardSize, 22);

        /* ── Render QR then finish canvas ── */
        function drawQrAndFinish(qrEl) {
            if (qrEl) {
                ctx.drawImage(qrEl, cardX + cardPad, cardY + cardPad, qrDisplay, qrDisplay);
            }
            var afterCard = cardY + cardSize;

            /* Amount */
            ctx.fillStyle = '#00a79d';
            ctx.font      = 'bold 28px Arial, sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText(opts.amount, W / 2, afterCard + 48);

            /* Dot divider */
            ctx.fillStyle = '#d1d5db';
            for (var i = -3; i <= 3; i++) {
                ctx.beginPath();
                ctx.arc(W / 2 + i * 12, afterCard + 66, 2.5, 0, Math.PI * 2);
                ctx.fill();
            }

            /* Campaign name */
            ctx.fillStyle = '#374151';
            ctx.font      = '13px Arial, sans-serif';
            wrapText(ctx, opts.campaign, W / 2, afterCard + 92, W - 80, 22);

            /* Expiry */
            if (opts.expiry) {
                ctx.fillStyle = '#9ca3af';
                ctx.font      = '12px Arial, sans-serif';
                ctx.fillText('⏰ Berlaku sampai  ' + opts.expiry, W / 2, H - 62);
            }

            /* Footer rule */
            ctx.strokeStyle = '#f3f4f6';
            ctx.lineWidth   = 1;
            ctx.beginPath();
            ctx.moveTo(40, H - 44);
            ctx.lineTo(W - 40, H - 44);
            ctx.stroke();

            ctx.fillStyle = '#9ca3af';
            ctx.font      = '11px Arial, sans-serif';
            ctx.fillText('ldksyah.id  •  Celengan Syahid', W / 2, H - 22);

            callback(oc.toDataURL('image/png'));
        }

        /* Decide QR source */
        if (/^https?:\/\//i.test(rawQr) || /^data:image\//i.test(rawQr)) {
            /* Gateway returned an image URL */
            var tmpImg = new Image();
            tmpImg.crossOrigin = 'anonymous';
            tmpImg.onload  = function () { drawQrAndFinish(tmpImg); };
            tmpImg.onerror = function () { drawQrAndFinish(null); };
            tmpImg.src     = rawQr;
        } else if (rawQr) {
            /* Re-generate at larger size + highest error-correction for crisp scan */
            var tmpDiv = document.createElement('div');
            tmpDiv.style.cssText = 'position:absolute;left:-9999px;visibility:hidden;';
            document.body.appendChild(tmpDiv);
            try {
                new QRCode(tmpDiv, {
                    text:         rawQr,
                    width:        qrGenSize,
                    height:       qrGenSize,
                    correctLevel: QRCode.CorrectLevel.H
                });
                var tmpCanvas = tmpDiv.querySelector('canvas') || tmpDiv.querySelector('img');
                drawQrAndFinish(tmpCanvas);
            } catch (e) {
                drawQrAndFinish(null);
            }
            document.body.removeChild(tmpDiv);
        } else {
            drawQrAndFinish(null);
        }
    }

    /* ── Helpers ─────────────────────────────────────────────────── */
    function fillRR(ctx, x, y, w, h, r) {
        ctx.beginPath();
        ctx.moveTo(x + r, y);
        ctx.lineTo(x + w - r, y);   ctx.quadraticCurveTo(x + w, y,     x + w, y + r);
        ctx.lineTo(x + w, y + h - r); ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
        ctx.lineTo(x + r, y + h);   ctx.quadraticCurveTo(x,     y + h, x,     y + h - r);
        ctx.lineTo(x, y + r);       ctx.quadraticCurveTo(x,     y,     x + r, y);
        ctx.closePath();
        ctx.fill();
    }

    function strokeRR(ctx, x, y, w, h, r) {
        ctx.beginPath();
        ctx.moveTo(x + r, y);
        ctx.lineTo(x + w - r, y);   ctx.quadraticCurveTo(x + w, y,     x + w, y + r);
        ctx.lineTo(x + w, y + h - r); ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
        ctx.lineTo(x + r, y + h);   ctx.quadraticCurveTo(x,     y + h, x,     y + h - r);
        ctx.lineTo(x, y + r);       ctx.quadraticCurveTo(x,     y,     x + r, y);
        ctx.closePath();
        ctx.stroke();
    }

    function wrapText(ctx, text, cx, y, maxW, lineH) {
        if (!text) return;
        var words = text.split(' ');
        var line  = '';
        for (var i = 0; i < words.length; i++) {
            var test = line ? line + ' ' + words[i] : words[i];
            if (ctx.measureText(test).width > maxW && line) {
                ctx.fillText(line, cx, y);
                line = words[i];
                y   += lineH;
            } else {
                line = test;
            }
        }
        if (line) ctx.fillText(line, cx, y);
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

            actions.className = 'ds-action-wrap two-col';
            actions.innerHTML =
                '<a href="' + SAVE_URL + '" class="ds-btn ds-btn-success">' +
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
