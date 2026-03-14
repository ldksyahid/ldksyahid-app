{{-- ══════════════════════════════════════════ --}}
{{-- STYLES                                    --}}
{{-- ══════════════════════════════════════════ --}}
<style>
/* ════ BACK-TO-TOP smooth toggle ════ */
.back-to-top {
    transition: opacity 0.35s ease, transform 0.35s ease !important;
}
body.kmb2-popup-open .back-to-top {
    opacity: 0 !important;
    transform: scale(0.8) translateY(12px) !important;
    pointer-events: none !important;
}

/* ════ BASE ════ */
.kmb2-section {
    background: transparent;
    overflow: hidden;
}

/* ════ BG DECOR ════ */
.kmb2-bg-decor {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
    z-index: 0;
}
.kmb2-blob {
    position: absolute;
    border-radius: 50%;
    background: var(--primary);
    opacity: 0.04;
}
.kmb2-blob.b1 { width: 360px; height: 360px; top: -110px; right: -90px; }
.kmb2-blob.b2 { width: 240px; height: 240px; bottom: 30px; left: -90px; }
.kmb2-blob.b3 { width: 140px; height: 140px; top: 42%;    right: 3%;   }

.kmb2-flt {
    position: absolute;
    font-size: 1.5rem;
    opacity: 0.07;
    animation: kmb2Float 13s ease-in-out infinite;
    pointer-events: none;
}
.kmb2-flt.e1 { top:6%;  left:2%;  animation-delay:0s;  }
.kmb2-flt.e2 { top:19%; right:5%; animation-delay:2s;  font-size:1.3rem; }
.kmb2-flt.e3 { bottom:9%;  right:2%; animation-delay:4s;  }
.kmb2-flt.e4 { bottom:20%; left:4%;  animation-delay:6s;  font-size:1.2rem; }
.kmb2-flt.e5 { top:50%;  left:1%;  animation-delay:8s;  }
.kmb2-flt.e6 { top:34%;  right:3%; animation-delay:10s; font-size:1.4rem; }

@keyframes kmb2Float {
    0%,100%{ transform:translateY(0) rotate(0deg); }
    33%     { transform:translateY(-18px) rotate(9deg); }
    66%     { transform:translateY(11px) rotate(-6deg); }
}

/* ════ HEADER ════ */
.kmb2-badge {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: var(--primary-light);
    border: 1px solid rgba(0,167,157,.25);
    border-radius: 50px;
    padding: .5rem 1.25rem;
    margin-bottom: 1rem;
    font-size: .9rem;
    font-weight: 600;
    color: var(--primary);
}
.kmb2-badge-dot {
    width: 8px; height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: kmb2Pulse 2s ease-in-out infinite;
}
@keyframes kmb2Pulse {
    0%,100%{ opacity:1; transform:scale(1); }
    50%    { opacity:.3; transform:scale(1.8); }
}
.kmb2-title {
    font-family: var(--font-primary);
    font-size: 2.4rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.2;
    margin-bottom: .7rem;
}
.kmb2-title-hl {
    display: block;
    color: var(--primary);
    position: relative;
    z-index: 1;
}
.kmb2-title-hl::after {
    content:'';
    position:absolute;
    bottom:3px; left:0;
    width:100%; height:10px;
    background:rgba(0,167,157,.12);
    border-radius:4px;
    z-index:-1;
}
.kmb2-subtitle {
    color: var(--secondary);
    font-size: 1rem;
    max-width: 620px;
    margin: 0 auto;
    line-height: 1.75;
}

/* ════ GRID (6-col → 3-2 centred) ════ */
.kmb2-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 1.5rem;
    margin-bottom: 2.5rem;
}
.kmb2-grid .kmb2-card:nth-child(1) { grid-column: 1/3; }
.kmb2-grid .kmb2-card:nth-child(2) { grid-column: 3/5; }
.kmb2-grid .kmb2-card:nth-child(3) { grid-column: 5/7; }
.kmb2-grid .kmb2-card:nth-child(4) { grid-column: 1/3; }
.kmb2-grid .kmb2-card:nth-child(5) { grid-column: 3/5; }
.kmb2-grid .kmb2-card:nth-child(6) { grid-column: 5/7; }

/* ════ CARD ════ */
.kmb2-card {
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.6);
    border-radius: 24px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    position: relative;
    cursor: pointer;
    box-shadow: 0 4px 24px rgba(0,0,0,.06), 0 1px 4px rgba(0,0,0,.04);
    transition: transform .4s cubic-bezier(.4,0,.2,1),
                box-shadow .4s cubic-bezier(.4,0,.2,1);
    outline: none;
}
@media(hover:hover) {
    .kmb2-card:hover {
        transform: translateY(-10px) scale(1.01);
        box-shadow: 0 28px 60px rgba(0,0,0,.11), 0 0 0 2px var(--kc);
    }
}
.kmb2-card:focus-visible {
    box-shadow: 0 0 0 3px var(--kc);
}

/* ── Banner ── */
.kmb2-card-banner {
    height: 110px;
    background: var(--kc);
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
}
.kmb2-banner-dots {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,.18) 1px, transparent 1px);
    background-size: 20px 20px;
}
.kmb2-banner-tag {
    position: absolute;
    top: 14px; left: 14px;
    background: rgba(255,255,255,.22);
    backdrop-filter: blur(6px);
    color: white;
    font-size: .7rem;
    font-weight: 700;
    padding: .28rem .85rem;
    border-radius: 50px;
    letter-spacing: .6px;
    text-transform: uppercase;
    border: 1px solid rgba(255,255,255,.3);
}
.kmb2-banner-emoji {
    position: absolute;
    bottom: 12px; right: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    filter: drop-shadow(0 2px 8px rgba(0,0,0,.2));
    animation: kmb2BounceIcon 3.5s ease-in-out infinite;
}
.kmb2-banner-emoji svg {
    width: 2.2rem;
    height: 2.2rem;
    display: block;
}
@keyframes kmb2BounceIcon {
    0%,100%{ transform:translateY(0) rotate(0); }
    40%    { transform:translateY(-7px) rotate(-9deg); }
    70%    { transform:translateY(3px) rotate(5deg); }
}

/* ── Overlapping Photo ── */
.kmb2-card-photo-area {
    display: flex;
    justify-content: center;
    padding: 0 1rem .5rem;
    position: relative;
    margin-top: -50px;
    z-index: 2;
}
.kmb2-photo-ring {
    width: 100px; height: 100px;
    border-radius: 50%;
    padding: 4px;
    background: linear-gradient(135deg, var(--kc), var(--kl));
    box-shadow: 0 8px 28px rgba(0,0,0,.12);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
}
@media(hover:hover) {
    .kmb2-card:hover .kmb2-photo-ring { transform: scale(1.08) rotate(4deg); }
}
.kmb2-photo-icon {
    width: 100%; height: 100%;
    border-radius: 50%;
    border: 3px solid white;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}
.kmb2-photo-icon svg {
    width: 2.4rem;
    height: 2.4rem;
    display: block;
}
.kmb2-photo-chip {
    position: absolute;
    bottom: 2px;
    right: calc(50% - 64px);
    width: 30px; height: 30px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--kc);
    box-shadow: 0 3px 10px rgba(0,0,0,.12);
    border: 2px solid var(--kl);
    transition: transform .3s ease;
}
.kmb2-photo-chip svg {
    width: 14px;
    height: 14px;
    display: block;
}
@media(hover:hover) {
    .kmb2-card:hover .kmb2-photo-chip { transform: scale(1.18) rotate(-12deg); }
}

/* ── Card Body ── */
.kmb2-card-body {
    padding: .75rem 1.35rem 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: .5rem;
    text-align: center;
}
.kmb2-card-name {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1.05rem;
    color: var(--dark);
    margin: 0;
    padding-bottom: .6rem;
    position: relative;
}
.kmb2-card-name::after {
    content:'';
    position:absolute;
    bottom:0; left:50%;
    transform:translateX(-50%);
    width:36px; height:3px;
    background: var(--kc);
    border-radius:2px;
    transition: width .35s ease;
}
@media(hover:hover) {
    .kmb2-card:hover .kmb2-card-name::after { width:70px; }
}
.kmb2-card-preview {
    color: var(--secondary);
    font-size: .85rem;
    line-height: 1.6;
    margin: 0;
    flex: 1;
}
.kmb2-card-cta {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    background: var(--kc);
    color: white;
    font-size: .8rem;
    font-weight: 600;
    padding: .55rem 1.25rem;
    border-radius: 50px;
    margin-top: .25rem;
    box-shadow: 0 4px 14px rgba(0,0,0,.15);
    transition: transform .25s ease, box-shadow .25s ease;
    cursor: pointer;
}
@media(hover:hover) {
    .kmb2-card:hover .kmb2-card-cta {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,.2);
    }
}

/* ── Shine on hover ── */
.kmb2-card-shine {
    position: absolute;
    top: 0; left: -100%;
    width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.12), transparent);
    transform: skewX(-20deg);
    pointer-events: none;
    transition: left .6s ease;
}
@media(hover:hover) {
    .kmb2-card:hover .kmb2-card-shine { left: 160%; }
}

/* ════ CTA BANNER ════ */
.kmb2-cta {
    background: var(--primary-gradient);
    border-radius: 24px;
    padding: 1.75rem 2rem;
    box-shadow: 0 10px 36px rgba(0,167,157,.28);
    position: relative;
    overflow: hidden;
}
.kmb2-cta-orb {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,.08);
    pointer-events: none;
}
.kmb2-cta-orb.oa { width:180px; height:180px; top:-60px;    right:-40px; }
.kmb2-cta-orb.ob { width:110px; height:110px; bottom:-35px; left:60px;  }
.kmb2-cta-inner {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    flex-wrap: wrap;
}
.kmb2-cta-left  { display:flex; align-items:center; gap:1rem; }
.kmb2-cta-rocket { font-size:2.6rem; flex-shrink:0; animation:kmb2Float 4s ease-in-out infinite; }
.kmb2-cta-h { color:white; font-family:var(--font-primary); font-weight:700; font-size:1.1rem; }
.kmb2-cta-s { color:rgba(255,255,255,.85); font-size:.85rem; margin-top:.2rem; line-height:1.5; }
.kmb2-cta-chips { display:flex; gap:.6rem; flex-wrap:wrap; }
.kmb2-cta-chips span {
    display:inline-flex; align-items:center; justify-content:center;
    width:50px; height:50px;
    color: white;
    background:rgba(255,255,255,.16);
    border-radius:14px;
    border:1px solid rgba(255,255,255,.22);
    cursor:default;
    transition:transform .3s ease;
}
.kmb2-cta-chips span svg {
    width: 1.4rem;
    height: 1.4rem;
    display: block;
}
@media(hover:hover) {
    .kmb2-cta-chips span:hover { transform:translateY(-5px) scale(1.1); }
}

/* ════════════════════════════════════════════
   MODAL (Desktop)
   ════════════════════════════════════════════ */
.kmb2-modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 9100;
    opacity: 0;
    transition: opacity .3s ease;
}
.kmb2-modal-backdrop.active { display:block; opacity:1; }

.kmb2-modal {
    display: none;
    position: fixed;
    top: 50%; left: 50%;
    transform: translate(-50%,-50%) scale(.9);
    width: min(520px, 94vw);
    max-height: 90vh;
    overflow-y: auto;
    background: white;
    border-radius: 28px;
    z-index: 9101;
    opacity: 0;
    transition: opacity .35s ease, transform .35s cubic-bezier(.34,1.56,.64,1);
    scrollbar-width: none;
}
.kmb2-modal::-webkit-scrollbar { display:none; }
.kmb2-modal.active {
    display: block;
    opacity: 1;
    transform: translate(-50%,-50%) scale(1);
}

/* Modal close */
.kmb2-modal-x {
    position: absolute;
    top: 14px; right: 14px;
    width: 46px; height: 46px;
    background: rgba(0,0,0,.28) !important;
    backdrop-filter: blur(8px);
    border: 1.5px solid rgba(0,0,0,.18) !important;
    border-radius: 50% !important;
    color: white !important;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    outline: none !important;
    box-shadow: none !important;
    transition: transform .25s ease !important;
    appearance: none;
}
/* hover saja yang membesar, focus tidak (supaya tidak membesar saat popup pertama dibuka) */
.kmb2-modal-x:hover {
    transform: scale(1.2) !important;
    background: rgba(0,0,0,.28) !important;
    border-color: rgba(0,0,0,.18) !important;
    color: white !important;
    box-shadow: none !important;
    outline: none !important;
}
.kmb2-modal-x:focus,
.kmb2-modal-x:active {
    transform: none !important;
    background: rgba(0,0,0,.28) !important;
    border-color: rgba(0,0,0,.18) !important;
    color: white !important;
    box-shadow: none !important;
    outline: none !important;
}

/* Modal banner */
.kmb2-modal-banner {
    height: 160px;
    position: relative;
    overflow: hidden;
    border-radius: 28px 28px 0 0;
    transition: background .4s ease;
}
.kmb2-modal-banner-dots {
    position:absolute; inset:0;
    background-image: radial-gradient(circle,rgba(255,255,255,.2) 1px,transparent 1px);
    background-size: 22px 22px;
}
.kmb2-modal-banner-emoji {
    position: absolute;
    bottom: 18px; right: 26px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    filter: drop-shadow(0 4px 12px rgba(0,0,0,.2));
    animation: kmb2BounceIcon 3.5s ease-in-out infinite;
}
.kmb2-modal-banner-emoji svg {
    width: 3rem;
    height: 5rem;
    display: block;
}
.kmb2-modal-banner-tag {
    position: absolute;
    top: 18px; left: 18px;
    background: rgba(255,255,255,.22);
    backdrop-filter: blur(6px);
    color: white;
    font-size: .78rem;
    font-weight: 700;
    padding: .35rem 1rem;
    border-radius: 50px;
    text-transform: uppercase;
    letter-spacing: .6px;
    border: 1px solid rgba(255,255,255,.3);
}

/* Modal nav arrows — di batas banner/konten (center = 160px) */
.kmb2-modal-nav {
    position: absolute;
    top: 137px; /* 160px banner - 23px (½ btn) = center di garis batas */
    width: 46px; height: 46px;
    background: rgba(0,0,0,.28) !important;
    backdrop-filter: blur(8px);
    border: 1.5px solid rgba(0,0,0,.18) !important;
    border-radius: 50% !important;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 6;
    color: white !important;
    outline: none !important;
    box-shadow: none !important;
    transition: transform .25s cubic-bezier(.4,0,.2,1);
    appearance: none;
}
.kmb2-modal-nav:hover,
.kmb2-modal-nav:focus,
.kmb2-modal-nav:active {
    transform: scale(1.2) !important;
    background: rgba(0,0,0,.28) !important;
    border-color: rgba(0,0,0,.18) !important;
    color: white !important;
    box-shadow: none !important;
    outline: none !important;
}
/* Prev di kiri, Next di kanan — keduanya center vertikal pada banner */
.kmb2-modal-nav.mnav-prev { left: 14px; }
.kmb2-modal-nav.mnav-next { right: 14px; }

/* Modal photo (overlapping) */
.kmb2-modal-photo-area {
    display: flex;
    justify-content: center;
    margin-top: -58px;
    position: relative;
    z-index: 2;
}
.kmb2-modal-photo-ring {
    width: 116px; height: 116px;
    border-radius: 50%;
    padding: 5px;
    box-shadow: 0 10px 32px rgba(0,0,0,.14);
    transition: background .4s ease;
}
.kmb2-modal-photo-icon {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 4px solid white;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}
.kmb2-modal-photo-icon svg {
    width: 3.2rem;
    height: 3.2rem;
    display: block;
}
.kmb2-modal-photo-chip {
    position: absolute;
    bottom: 0; right: calc(50% - 74px);
    width: 36px; height: 36px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,.12);
    border: 2px solid #f3f3f3;
}
.kmb2-modal-photo-chip svg {
    width: 16px;
    height: 16px;
    display: block;
}

/* Modal body */
.kmb2-modal-body {
    padding: .75rem 2rem 2rem;
    text-align: center;
}
.kmb2-modal-title {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1.3rem;
    color: var(--dark);
    margin-bottom: .5rem;
}
.kmb2-modal-desc {
    color: var(--secondary);
    font-size: .925rem;
    line-height: 1.8;
    text-align: justify;
    margin: 0 0 1rem;
}

/* Modal dots — hover = scale only */
.kmb2-modal-dots {
    display: flex;
    justify-content: center;
    gap: 6px;
    padding-bottom: 1.25rem;
}
.kmb2-modal-dots .mdot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #ddd;
    cursor: pointer;
    transition: all .3s ease;
}
.kmb2-modal-dots .mdot:hover { transform: scale(1.35); }
.kmb2-modal-dots .mdot.active {
    width: 24px;
    border-radius: 50px;
    background: var(--primary);
}

/* ════════════════════════════════════════════
   BOTTOM SHEET (Mobile)
   ════════════════════════════════════════════ */
.kmb2-sheet-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    z-index: 9100;
    opacity: 0;
    transition: opacity .3s ease;
}
.kmb2-sheet-backdrop.active { display:block; opacity:1; }

.kmb2-sheet {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 9101;
    transform: translateY(100%);
    transition: transform .38s cubic-bezier(.4,0,.2,1);
    max-height: 92dvh;
    overflow-y: auto;
    scrollbar-width: none;
}
.kmb2-sheet::-webkit-scrollbar { display:none; }
.kmb2-sheet.active { transform: translateY(0); }

/* Handle sits inside the colored banner — no white gap */
.kmb2-sheet-handle {
    width: 42px; height: 4px;
    background: rgba(255,255,255,0.55);
    border-radius: 4px;
    position: absolute;
    top: 11px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3;
}

/* Sheet banner */
.kmb2-sheet-banner {
    height: 136px;
    position: relative;
    overflow: hidden;
    border-radius: 24px 24px 0 0;
    transition: background .4s ease;
}
.kmb2-sheet-banner-dots {
    position:absolute; inset:0;
    background-image: radial-gradient(circle,rgba(255,255,255,.2) 1px,transparent 1px);
    background-size:20px 20px;
}
.kmb2-sheet-banner-emoji {
    position:absolute;
    bottom:14px; right:18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    filter:drop-shadow(0 3px 8px rgba(0,0,0,.2));
    animation:kmb2BounceIcon 3.5s ease-in-out infinite;
}
.kmb2-sheet-banner-emoji svg {
    width: 2.5rem;
    height: 2.5rem;
    display: block;
}
.kmb2-sheet-banner-tag {
    position:absolute;
    top:14px; left:14px;
    background:rgba(255,255,255,.22);
    backdrop-filter:blur(6px);
    color:white;
    font-size:.7rem;
    font-weight:700;
    padding:.28rem .85rem;
    border-radius:50px;
    text-transform:uppercase;
    letter-spacing:.6px;
    border:1px solid rgba(255,255,255,.3);
}

/* Sheet photo */
.kmb2-sheet-photo-area {
    display:flex;
    justify-content:center;
    margin-top:-48px;
    position:relative;
    z-index:2;
}
.kmb2-sheet-photo-ring {
    width:96px; height:96px;
    border-radius:50%;
    padding:4px;
    box-shadow:0 8px 24px rgba(0,0,0,.13);
    transition:background .4s ease;
}
.kmb2-sheet-photo-icon {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 3px solid white;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}
.kmb2-sheet-photo-icon svg {
    width: 2.6rem;
    height: 2.6rem;
    display: block;
}
.kmb2-sheet-photo-chip {
    position:absolute;
    bottom:0; right:calc(50% - 60px);
    width:30px; height:30px;
    background:white;
    border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 3px 10px rgba(0,0,0,.12);
    border:2px solid #f3f3f3;
}
.kmb2-sheet-photo-chip svg {
    width: 13px;
    height: 13px;
    display: block;
}

/* Sheet body */
.kmb2-sheet-body {
    padding:.6rem 1.5rem 1rem;
    text-align:center;
}
.kmb2-sheet-title {
    font-family:var(--font-primary);
    font-weight:700;
    font-size:1.1rem;
    color:var(--dark);
    margin-bottom:.4rem;
}
.kmb2-sheet-desc {
    color:var(--secondary);
    font-size:.875rem;
    line-height:1.75;
    text-align:justify;
    margin:0;
}

/* Sheet footer */
.kmb2-sheet-footer {
    padding:.75rem 1.5rem 1.5rem;
    display:flex;
    flex-direction:column;
    gap:.75rem;
}
.kmb2-sheet-nav-row {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:.5rem;
}
/* Nav buttons: hover = scale only, no color change */
.kmb2-sheet-nav-btn {
    display:inline-flex;
    align-items:center;
    gap:.35rem;
    background:var(--primary-light);
    color:var(--primary);
    border:1px solid rgba(0,167,157,.2);
    border-radius:50px;
    padding:.5rem 1rem;
    font-size:.8rem;
    font-weight:600;
    cursor:pointer;
    transition: transform .22s ease;
}
.kmb2-sheet-nav-btn:hover { transform: scale(1.07); }
.kmb2-sheet-nav-btn:active,
.kmb2-sheet-nav-btn:focus {
    transform: scale(1.07) !important;
    background: var(--primary-light) !important;
    color: var(--primary) !important;
    border-color: rgba(0,167,157,.2) !important;
    box-shadow: none !important;
    outline: none !important;
}
.kmb2-sheet-dots {
    display:flex;
    gap:5px;
    align-items:center;
}
.kmb2-sheet-dots .sdot {
    width:7px; height:7px;
    border-radius:50%;
    background:#ddd;
    transition:all .3s ease;
    cursor:pointer;
}
.kmb2-sheet-dots .sdot:hover { transform: scale(1.35); }
.kmb2-sheet-dots .sdot.active {
    width:20px;
    border-radius:50px;
    background:var(--primary);
}
.kmb2-sheet-close {
    display:block;
    width:100%;
    background:var(--primary-gradient);
    color:white;
    border:none;
    border-radius:50px;
    padding:.75rem;
    font-size:.9rem;
    font-weight:600;
    cursor:pointer;
    box-shadow:0 4px 14px rgba(0,167,157,.3);
    transition: transform .22s ease;
}
.kmb2-sheet-close:hover { transform: scale(1.02); }

/* ════ RESPONSIVE ════ */
@media(max-width:991.98px) {
    .kmb2-title { font-size:1.9rem; }
    .kmb2-grid {
        grid-template-columns:repeat(4,1fr);
        gap:1.1rem;
    }
    .kmb2-grid .kmb2-card:nth-child(1){grid-column:1/3;}
    .kmb2-grid .kmb2-card:nth-child(2){grid-column:3/5;}
    .kmb2-grid .kmb2-card:nth-child(3){grid-column:1/3;}
    .kmb2-grid .kmb2-card:nth-child(4){grid-column:3/5;}
    .kmb2-grid .kmb2-card:nth-child(5){grid-column:1/3;}
    .kmb2-grid .kmb2-card:nth-child(6){grid-column:3/5;}
    .kmb2-cta { padding:1.5rem; }
}
@media(max-width:767.98px) {
    .kmb2-title { font-size:1.65rem; }
    .kmb2-grid {
        grid-template-columns:1fr;
        gap:.9rem;
    }
    .kmb2-grid .kmb2-card:nth-child(n) { grid-column:auto; }
    .kmb2-cta-inner { flex-direction:column; text-align:center; }
    .kmb2-cta-left  { flex-direction:column; align-items:center; }
    .kmb2-cta-chips { justify-content:center; }
}
@media(max-width:575.98px) {
    .kmb2-title  { font-size:1.4rem; }
    .kmb2-badge  { font-size:.8rem; padding:.4rem 1rem; }
    .kmb2-cta    { padding:1.25rem; }
    .kmb2-cta-chips span { width:42px; height:42px; border-radius:12px; }
}
</style>
