{{-- FILE: resources/views/landing-page/service/zakat-calculator/components/_index-styles.blade.php --}}
<style>
/* ==========================================================
   1. MAIN LAYOUT
   ========================================================== */
#zakat-calculator {
    padding-top: 0;
    padding-bottom: 5rem;
    min-height: 100vh;
    position: relative;
    z-index: 1;
}

/* ==========================================================
   2. HEADER SECTION
   ========================================================== */
#zakat-header {
    background: var(--primary-color);
    padding: 120px 0 80px 0;
}
.zk-header-icon {
    width: 100px;
    height: 100px;
    border-radius: 15px;
    object-fit: cover;
}

/* ==========================================================
   3. GOLD SETTINGS PANEL
   ========================================================== */
.sl-gold-settings {
    background: #fffbeb;
    border: 1.5px solid #fde68a;
    border-radius: 16px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
}
.sl-gold-settings-title {
    font-size: .8rem;
    font-weight: 700;
    color: #92400e;
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-bottom: .75rem;
    display: flex;
    align-items: center;
    gap: .4rem;
}
.sl-gold-input-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.sl-gold-input {
    width: 160px;
    height: 40px;
    padding: .5rem .75rem;
    border: 1.5px solid #fbbf24;
    border-radius: 10px;
    font-weight: 700;
    font-size: .9rem;
    color: #92400e;
    background: #fff;
    outline: none;
}
.sl-gold-input:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(251,191,36,.2);
}
.sl-gold-ref { font-size: .72rem; color: #b45309; }
.sl-gold-ref a { color: #b45309; text-decoration: underline; }

/* ==========================================================
   4. BADGE HARGA EMAS
   ========================================================== */
.sl-gold-badge {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: rgba(0,167,157,.08);
    border: 1px solid rgba(0,167,157,.22);
    border-radius: 99px;
    padding: .35rem 1rem .35rem .7rem;
    font-size: .78rem;
    font-weight: 600;
    color: #007a73;
    letter-spacing: .04em;
    text-transform: uppercase;
    margin-bottom: 1.5rem;
}
.sl-gold-badge-pulse {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #00a79d;
    animation: slBadgePulse 2s infinite;
}
@keyframes slBadgePulse {
    0%,100% { transform: scale(1);   opacity: 1; }
    50%      { transform: scale(1.5); opacity: .5; }
}

/* ==========================================================
   5. KARTU
   ========================================================== */
.sl-zakat-card {
    background: linear-gradient(135deg, rgba(0,167,157,.05) 0%, rgba(255,255,255,.8) 100%);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(0,167,157,.15);
    border-radius: 28px;
    padding: 2.5rem;
    box-shadow: 0 20px 60px rgba(0,167,157,.08);
    transition: border-color .3s, box-shadow .3s;
}
.sl-zakat-card:hover {
    border-color: rgba(0,167,157,.25);
    box-shadow: 0 25px 70px rgba(0,167,157,.12);
}
.sl-zakat-card.sl-warning {
    background: #fffbeb;
    border: 1px solid #fde68a;
    box-shadow: none;
}
.sl-zakat-card.sl-warning:hover { border-color: #fbbf24; box-shadow: none; }

/* ==========================================================
   6. TYPE PILLS
   ========================================================== */
.sl-pill-wrap {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    padding-bottom: 4px;
    margin-bottom: 25px;
}
.sl-pill {
    padding: 9px 16px;
    background: rgba(0,167,157,.06);
    border: 1px solid rgba(0,167,157,.14);
    border-radius: 12px;
    cursor: pointer;
    white-space: nowrap;
    font-weight: 600;
    color: #475569;
    font-size: .85rem;
    transition: all .3s;
    user-select: none;
}
.sl-pill.active { background: #00a79d; border-color: #00a79d; color: #fff; }

/* ==========================================================
   7. DESKRIPSI JENIS ZAKAT
   ========================================================== */
.sl-zakat-desc-box {
    background: rgba(0,167,157,.06);
    border-left: 3px solid #00a79d;
    border-radius: 0 10px 10px 0;
    padding: .6rem 1rem;
    margin-bottom: 1.25rem;
    font-size: .82rem;
    color: #334155;
    line-height: 1.6;
}

/* ==========================================================
   8. FORM LABEL & INPUT
   ========================================================== */
.sl-zakat-label {
    display: flex;
    align-items: center;
    gap: .4rem;
    margin-bottom: .5rem;
    font-weight: 600;
    color: #2c3e50;
    font-size: .9rem;
}
.sl-zakat-input {
    width: 100%;
    height: 50px;
    padding: .875rem 1.125rem;
    border: 2px solid rgba(0,167,157,.2);
    border-radius: 14px;
    background: rgba(255,255,255,.9);
    color: #2c3e50;
    font-family: inherit;
    font-size: .9rem;
    font-weight: 600;
    transition: border-color .3s, box-shadow .3s, transform .3s;
    outline: none;
    box-sizing: border-box;
    display: block;
}
.sl-zakat-input:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 4px rgba(0,167,157,.1);
    background: #fff;
    transform: translateY(-2px);
}
.sl-zakat-input::placeholder { color: rgba(0,0,0,.35); }

.sl-input-prefix {
    height: 50px;
    padding: .875rem 1.125rem;
    border: 2px solid rgba(0,167,157,.2);
    border-right: none;
    border-radius: 14px 0 0 14px;
    background: rgba(0,167,157,.05);
    color: #007a73;
    font-weight: 700;
    display: flex;
    align-items: center;
    font-size: .9rem;
    flex-shrink: 0;
}
.sl-input-with-prefix  { border-radius: 0 14px 14px 0 !important; }
.sl-input-prefix.hidden { display: none; }
.sl-zakat-input.no-prefix { border-radius: 14px !important; }

/* ==========================================================
   9. PERDAGANGAN: SUMMARY BOX
   ========================================================== */
.sl-dagang-summary {
    background: rgba(0,167,157,.05);
    border: 1.5px dashed rgba(0,167,157,.3);
    border-radius: 14px;
    padding: .9rem 1.1rem;
    margin-bottom: 1rem;
    font-size: .85rem;
}
.sl-dagang-summary-label { color: #64748b; font-size: .78rem; }
.sl-dagang-summary-val   { font-weight: 700; font-size: 1.05rem; color: #00a79d; }

/* ==========================================================
   10. PERTANIAN: TARIF TOGGLE
   ========================================================== */
.sl-tarif-wrap {
    display: flex;
    gap: 10px;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}
.sl-tarif-label {
    flex: 1;
    min-width: 140px;
    border: 2px solid rgba(0,167,157,.2);
    border-radius: 12px;
    padding: .6rem 1rem;
    cursor: pointer;
    text-align: center;
    font-size: .83rem;
    font-weight: 600;
    color: #475569;
    transition: all .25s;
    user-select: none;
}
.sl-tarif-label input { display: none; }
.sl-tarif-label:has(input:checked) {
    background: #00a79d;
    border-color: #00a79d;
    color: #fff;
}

/* ==========================================================
   11. PETERNAKAN: JENIS SELECT
   ========================================================== */
.sl-zakat-select {
    width: 100%;
    height: 50px;
    padding: .875rem 1.125rem;
    border: 2px solid rgba(0,167,157,.2);
    border-radius: 14px;
    background: rgba(255,255,255,.9);
    color: #2c3e50;
    font-family: inherit;
    font-size: .9rem;
    font-weight: 600;
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2300a79d' stroke-width='2' fill='none'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    transition: border-color .3s;
}
.sl-zakat-select:focus { border-color: #00a79d; box-shadow: 0 0 0 4px rgba(0,167,157,.1); }

/* ==========================================================
   12. HINT TEXT
   ========================================================== */
.sl-zakat-hint {
    font-size: .72rem;
    color: #94a3b8;
    margin-top: .3rem;
    line-height: 1.4;
}

/* ==========================================================
   13. RESULT BOX
   ========================================================== */
.sl-res-box {
    margin-top: 30px;
    padding: 25px;
    border-radius: 20px;
    text-align: center;
    background: rgba(0,167,157,.05);
    border: 2px dashed #00a79d;
    display: none;
}
.sl-res-amount {
    font-size: 2.5rem;
    font-weight: 800;
    color: #00a79d;
}

/* ==========================================================
   14. ACCORDION — multi-expand
   ========================================================== */
.sl-accordion .accordion-item {
    border: 1px solid rgba(0,167,157,.14);
    border-radius: 16px !important;
    margin-bottom: 10px;
    overflow: hidden;
    background: transparent;
}
.sl-accordion .accordion-button {
    font-weight: 600;
    box-shadow: none !important;
    background: transparent;
    color: #2c3e50;
    padding: 1rem 1.25rem;
}
.sl-accordion .accordion-button:not(.collapsed) {
    color: #00a79d;
    background: rgba(0,167,157,.05);
}
.sl-accordion .accordion-body { font-size: .82rem; color: #475569; line-height: 1.6; }

/* ==========================================================
   15. AYAT / HADIS CARD
   ========================================================== */
.sl-quran-card {
    background: linear-gradient(135deg, #00a79d 0%, #007a73 100%);
    border-radius: 20px;
    padding: 1.5rem;
    color: #fff;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}
.sl-quran-card::before {
    content: '\f61b';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    right: 16px; top: 12px;
    font-size: 4rem;
    opacity: .08;
}
.sl-quran-arabic {
    font-size: 1.15rem;
    line-height: 2;
    text-align: right;
    direction: rtl;
    margin-bottom: .75rem;
    font-weight: 600;
}
.sl-quran-trans {
    font-size: .82rem;
    opacity: .88;
    line-height: 1.6;
    font-style: italic;
    border-top: 1px solid rgba(255,255,255,.2);
    padding-top: .75rem;
}
.sl-quran-src { font-size: .75rem; opacity: .7; margin-top: .5rem; font-weight: 600; }

/* ==========================================================
   16. TABEL NISAB PETERNAKAN
   ========================================================== */
.sl-nisab-table {
    width: 100%;
    font-size: .78rem;
    border-collapse: collapse;
}
.sl-nisab-table th {
    background: rgba(0,167,157,.1);
    color: #007a73;
    padding: .4rem .6rem;
    font-weight: 700;
    text-align: left;
}
.sl-nisab-table td { padding: .35rem .6rem; border-bottom: 1px solid rgba(0,167,157,.08); }
.sl-nisab-table tr:last-child td { border-bottom: none; }

/* ==========================================================
   17. MOBILE RESPONSIVE
   ========================================================== */
@media (max-width: 768px) {
    .sl-zakat-card   { padding: 1.5rem 1.1rem; border-radius: 18px; }
    .sl-res-amount   { font-size: 1.8rem; }
    .sl-pill         { font-size: .8rem; padding: 8px 12px; }
    #zakat-header    { padding: 80px 0 50px; }
    .sl-tarif-label  { min-width: 100%; }
}

/* ==========================================================
   18. DARK MODE
   ========================================================== */
[data-theme="dark"] #zakat-calculator { background-color: transparent; }
[data-theme="dark"] .sl-gold-badge    { background: rgba(0,167,157,.1); border-color: rgba(0,167,157,.25); color: #4ade80; }
[data-theme="dark"] .sl-zakat-title   { color: #e2e8f0; }
[data-theme="dark"] .sl-zakat-sub     { color: #9ca3af; }
[data-theme="dark"] .sl-zakat-card {
    background: linear-gradient(135deg, rgba(0,167,157,.08) 0%, rgba(26,29,36,.9) 100%);
    border-color: rgba(0,167,157,.2);
    box-shadow: 0 10px 40px rgba(0,0,0,.4);
    color: #e4e6eb;
}
[data-theme="dark"] .sl-zakat-card.sl-warning { background: rgba(245,158,11,.05); border-color: rgba(245,158,11,.2); }
[data-theme="dark"] .sl-gold-settings         { background: rgba(245,158,11,.05); border-color: rgba(245,158,11,.2); }
[data-theme="dark"] .sl-pill                  { background: rgba(0,167,157,.06); border-color: rgba(0,167,157,.18); color: #9ca3af; }
[data-theme="dark"] .sl-pill.active           { background: #00a79d; color: #fff; }
[data-theme="dark"] .sl-zakat-label           { color: #cbd5e0; }
[data-theme="dark"] .sl-zakat-input {
    background: #1e2535;
    border-color: rgba(0,167,157,.25);
    color: #e2e8f0;
}
[data-theme="dark"] .sl-zakat-input:focus     { background: #252b3b; border-color: #00a79d; }
[data-theme="dark"] .sl-zakat-input::placeholder { color: rgba(226,232,240,.35); }
[data-theme="dark"] .sl-input-prefix          { background: rgba(0,167,157,.1); border-color: rgba(0,167,157,.25); color: #4ade80; }
[data-theme="dark"] .sl-gold-input            { background: #1e2535; color: #fbbf24; border-color: rgba(251,191,36,.3); }
[data-theme="dark"] .sl-zakat-hint            { color: #9ca3af; }
[data-theme="dark"] .sl-res-box               { background: rgba(0,167,157,.1); }
[data-theme="dark"] .sl-zakat-desc-box        { background: rgba(0,167,157,.08); color: #94a3b8; }
[data-theme="dark"] .sl-dagang-summary        { background: rgba(0,167,157,.08); }
[data-theme="dark"] .sl-zakat-select          { background-color: #1e2535; border-color: rgba(0,167,157,.25); color: #e2e8f0; }
[data-theme="dark"] .sl-tarif-label           { border-color: rgba(0,167,157,.25); color: #9ca3af; }
[data-theme="dark"] .sl-nisab-table th        { background: rgba(0,167,157,.15); }
[data-theme="dark"] .sl-nisab-table td        { border-color: rgba(0,167,157,.12); color: #9ca3af; }
[data-theme="dark"] .sl-accordion .accordion-item  { border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .sl-accordion .accordion-button { background-color: #1a1d24; color: #e4e6eb; }
[data-theme="dark"] .sl-accordion .accordion-button:not(.collapsed) { background-color: rgba(0,167,157,.1); color: #4ade80; }
[data-theme="dark"] .sl-accordion .accordion-body { color: #9ca3af; }
</style>