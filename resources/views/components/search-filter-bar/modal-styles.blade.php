@verbatim
<style>
/* ================================================================
   SEARCH-FILTER-BAR  Filter Modal Styles   (prefix: sfb-fm-)
   Include with: @include('components.search-filter-bar.modal-styles')
   ================================================================ */

/* ── Custom blur backdrop ──────────────────────────────────────── */
.sfb-fm-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 1040;
    opacity: 0; visibility: hidden; pointer-events: none;
    transition: opacity .3s ease, visibility .3s ease;
}
.sfb-fm-backdrop.active {
    opacity: 1; visibility: visible; pointer-events: auto;
}

/* ── Modal shell ───────────────────────────────────────────────── */
.sfb-modal  { z-index: 1050; }
.sfb-fm-dialog { max-width: 580px; }
.sfb-fm-content {
    border-radius: 28px !important;
    border: 1px solid rgba(0,167,157,.1) !important;
    box-shadow: 0 24px 80px rgba(0,0,0,.18), 0 8px 30px rgba(0,167,157,.12) !important;
    overflow: hidden; position: relative;
}
.sfb-fm-content::before {
    content: '';
    position: absolute; top: 0; left: 10%; right: 10%;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(0,167,157,.45) 30%, rgba(0,167,157,.45) 70%, transparent);
    filter: blur(1px); z-index: 1; pointer-events: none;
}

/* ── Custom close button ───────────────────────────────────────── */
.sfb-fm-close {
    position: absolute; top: 1rem; right: 1rem;
    width: 34px; height: 34px;
    background: #f5f5f5; border: none; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: #6b7280; font-size: .85rem;
    transition: background .25s, color .25s, transform .25s; z-index: 10;
}
.sfb-fm-close:hover {
    background: #e0f7f5; color: #00a79d;
    transform: scale(1.1) rotate(90deg);
}

/* ── Header ────────────────────────────────────────────────────── */
.sfb-fm-header {
    padding: 2rem 2rem 1.35rem;
    text-align: center;
    background: linear-gradient(to bottom, #f0fefa, white);
    border-bottom: 1px solid rgba(0,167,157,.08);
}
.sfb-fm-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: #e0f7f5;
    border: 1px solid rgba(0,167,157,.2);
    border-radius: 50px; padding: .35rem 1rem;
    margin-bottom: 1.25rem;
    font-size: .82rem; font-weight: 500; color: #00a79d;
}
.sfb-fm-pulse {
    width: 7px; height: 7px; background: #00a79d;
    border-radius: 50%;
    animation: sfbFmPulse 2s ease infinite;
}
@keyframes sfbFmPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%      { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}
.sfb-fm-icon-wrap {
    position: relative; display: inline-block; margin-bottom: 1rem;
}
.sfb-fm-icon {
    width: 64px; height: 64px;
    background: linear-gradient(135deg, #00c4b8, #00a79d);
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 1.6rem;
    box-shadow: 0 8px 24px rgba(0,167,157,.35);
    position: relative; z-index: 2;
    animation: sfbFmIconBounce 3s ease-in-out infinite;
}
@keyframes sfbFmIconBounce {
    0%,100% { transform: translateY(0); }
    50%     { transform: translateY(-5px); }
}
.sfb-fm-ring {
    position: absolute; border-radius: 50%;
    border: 2px solid rgba(0,167,157,.12);
    top: 50%; left: 50%;
    transform: translate(-50%,-50%);
    animation: sfbFmRingExpand 3s ease-out infinite;
}
.sfb-fm-ring-1 { width: 90px;  height: 90px;  animation-delay: 0s;  }
.sfb-fm-ring-2 { width: 120px; height: 120px; animation-delay: .9s; }
@keyframes sfbFmRingExpand {
    0%   { opacity: .6; transform: translate(-50%,-50%) scale(.8);  }
    100% { opacity: 0;  transform: translate(-50%,-50%) scale(1.4); }
}
.sfb-fm-title    { font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin: 0 0 .3rem; }
.sfb-fm-subtitle { font-size: .85rem; color: #6b7280; margin: 0; }

/* ── Body ──────────────────────────────────────────────────────── */
.sfb-fm-body { padding: 1.5rem 1.75rem; }
.sfb-fm-field-wrap { display: flex; flex-direction: column; gap: .5rem; }
.sfb-fm-field-label {
    display: flex; align-items: center; gap: .55rem; margin-bottom: .55rem;
}
.sfb-fm-field-icon {
    width: 28px; height: 28px;
    background: #e0f7f5; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.sfb-fm-field-icon i { color: #00a79d; font-size: .72rem; }
.sfb-fm-label { font-size: .85rem; font-weight: 600; color: #2c3e50; margin: 0; }

/* ── Footer ────────────────────────────────────────────────────── */
.sfb-fm-footer {
    padding: 1.1rem 1.75rem 1.5rem;
    display: flex; align-items: center; gap: .65rem;
    border-top: 1px solid rgba(0,167,157,.08);
    background: linear-gradient(to top, #f0fefa, white);
}
.sfb-fm-btn-close {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .6rem 1.15rem; border-radius: 50px;
    border: 1.5px solid #e5e7eb; background: white;
    color: #6b7280; font-size: .83rem; font-weight: 600;
    cursor: pointer; transition: border-color .2s, color .2s, background .2s;
}
.sfb-fm-btn-close:hover {
    border-color: rgba(0,167,157,.3); color: #00a79d; background: #e0f7f5;
}
.sfb-fm-btn-reset {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .6rem 1.15rem; border-radius: 50px;
    border: 1.5px solid rgba(245,158,11,.4); background: white;
    color: #d97706; font-size: .83rem; font-weight: 600;
    cursor: pointer; transition: background .2s, border-color .2s;
}
.sfb-fm-btn-reset:hover { background: #fffbeb; border-color: #d97706; }
.sfb-fm-btn-apply {
    flex: 1;
    display: inline-flex; align-items: center; justify-content: center; gap: .55rem;
    padding: .7rem 1.5rem; border-radius: 50px;
    background: linear-gradient(135deg, #00c4b8, #00a79d);
    color: white; font-size: .88rem; font-weight: 700;
    border: none; cursor: pointer;
    box-shadow: 0 4px 16px rgba(0,167,157,.35);
    transition: filter .22s, box-shadow .22s, transform .18s;
    position: relative; overflow: hidden;
}
.sfb-fm-btn-apply:hover {
    filter: brightness(1.08);
    box-shadow: 0 6px 22px rgba(0,167,157,.52);
    transform: translateY(-1px);
}
.sfb-fm-btn-apply:active { transform: translateY(0); }
.sfb-fm-btn-icon {
    width: 24px; height: 24px;
    background: rgba(255,255,255,.2); border-radius: 50%;
    display: flex; align-items: center; justify-content: center; font-size: .72rem;
}
.sfb-fm-btn-shine {
    position: absolute; top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.22), transparent);
    transition: left .6s ease;
}
.sfb-fm-btn-apply:hover .sfb-fm-btn-shine { left: 100%; }


/* ================================================================
   SELECT2 — Custom Overrides for multi-select inside modal
   ================================================================ */

.select2-container--default .select2-selection--multiple {
    border: 1.5px solid #d1ece9 !important;
    border-radius: 12px !important;
    padding: 6px 10px !important;
    min-height: 48px !important;
    background: #fafffe !important;
    transition: border-color .2s, box-shadow .2s;
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: center !important;
    gap: 4px !important;
    position: relative;
    overflow: visible !important;
}
.select2-container--default .select2-selection--multiple.select2-selection--clearable {
    padding-right: 28px !important;
}
.select2-container--default.select2-container--focus .select2-selection--multiple,
.select2-container--default.select2-container--open .select2-selection--multiple {
    border-color: #00a79d !important;
    box-shadow: 0 0 0 3px rgba(0,167,157,.1) !important;
    outline: none !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__clear {
    position: absolute !important; right: 8px; top: 8px;
    transform: none !important; float: none !important;
    margin: 0 !important; padding: 0 3px !important;
    font-size: 1rem; line-height: 1;
    color: #6b7280 !important; background: transparent !important; border: none !important;
    cursor: pointer;
}
.select2-container--default .select2-selection--multiple .select2-selection__clear:hover {
    color: #ef4444 !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__rendered {
    display: contents !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    display: inline-flex !important; align-items: center !important;
    flex-direction: row !important; gap: 4px !important;
    background: linear-gradient(135deg, #00a79d, #00bfb3) !important;
    color: white !important; border: none !important;
    border-radius: 50px !important;
    padding: 3px 5px !important;
    font-size: .78rem !important; font-weight: 600 !important;
    margin: 0 !important; max-width: 180px !important;
    min-width: 0 !important; flex-shrink: 1 !important;
    overflow: hidden !important; float: none !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__display {
    white-space: nowrap !important; overflow: hidden !important;
    text-overflow: ellipsis !important; line-height: 1.4 !important;
    min-width: 0 !important; flex: 1 !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    position: static !important;
    display: inline-flex !important; align-items: center !important;
    justify-content: center !important; flex-shrink: 0 !important;
    width: 14px !important; height: 14px !important;
    border-radius: 50% !important; border: none !important;
    background: rgba(255,255,255,.92) !important;
    color: #00a79d !important; padding: 0 !important; margin: 0 !important;
    font-size: .65rem !important; font-weight: 700 !important;
    line-height: 1 !important; cursor: pointer !important;
    transition: background .15s, color .15s;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    background: white !important; color: #ef4444 !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove span {
    display: block; line-height: 1;
}
.select2-container--default .select2-selection--multiple .select2-search--inline {
    display: flex !important; align-items: center !important;
    flex: 1 !important; min-width: 60px !important;
}
.select2-container--default .select2-selection--multiple .select2-search__field {
    width: 100% !important; border: none !important; outline: none !important;
    background: transparent !important; font-size: .875rem !important;
    color: #2c3e50 !important; resize: none !important;
    padding: 0 !important; margin: 0 !important;
    line-height: 1.5 !important; height: 1.5em !important; min-height: unset !important;
}
.select2-container--default .select2-selection--multiple .select2-search__field::placeholder {
    color: #a8c5c3 !important;
}
.select2-container--default .select2-dropdown {
    border: 1.5px solid rgba(0,167,157,.2) !important;
    border-radius: 14px !important; overflow: hidden !important;
    font-size: .875rem !important;
    box-shadow: 0 12px 36px rgba(0,167,157,.14), 0 2px 10px rgba(0,0,0,.07) !important;
    background: #fff !important; margin-top: 6px !important;
    animation: sfbDropIn .16s ease forwards;
}
@keyframes sfbDropIn {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}
.select2-container--default .select2-search--dropdown {
    padding: 10px 10px 8px !important;
    border-bottom: 1px solid #edf7f6 !important;
}
.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1.5px solid #e0f2ef !important; border-radius: 8px !important;
    padding: 7px 10px !important; font-size: .85rem !important;
    outline: none !important; transition: border-color .2s, box-shadow .2s; width: 100% !important;
}
.select2-container--default .select2-search--dropdown .select2-search__field:focus {
    border-color: #00a79d !important;
    box-shadow: 0 0 0 3px rgba(0,167,157,.1) !important;
}
.select2-container--default .select2-results > .select2-results__options {
    max-height: 230px !important; overflow-y: auto !important; overflow-x: hidden !important;
    padding: 6px !important; scrollbar-width: thin;
    scrollbar-color: rgba(0,167,157,.3) transparent;
}
.select2-container--default .select2-results > .select2-results__options::-webkit-scrollbar { width: 4px; }
.select2-container--default .select2-results > .select2-results__options::-webkit-scrollbar-thumb {
    background: rgba(0,167,157,.35); border-radius: 4px;
}
.select2-container--default .select2-results__option {
    padding: 9px 32px 9px 12px !important; cursor: pointer !important;
    border-radius: 8px !important; border-bottom: none !important;
    transition: background .15s, color .15s !important;
    font-size: .875rem !important; line-height: 1.4 !important;
    color: #333 !important; position: relative;
}
.select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
    background: rgba(0,167,157,.09) !important; color: #005f58 !important;
}
.select2-container--default .select2-results__option[aria-selected="true"] {
    background: rgba(0,167,157,.08) !important;
    color: #00a79d !important; font-weight: 600 !important;
}
.select2-container--default .select2-results__option[aria-selected="true"]::before,
.select2-container--default .select2-results__option[aria-selected="true"]::after {
    content: '' !important; display: none !important;
}
.select2-container--default .select2-results__option--highlighted.select2-results__option--selectable[aria-selected="true"] {
    background: rgba(0,167,157,.16) !important; color: #005f58 !important;
}


/* ── Responsive ────────────────────────────────────────────────── */
@media (max-width: 575.98px) {
    .sfb-fm-header  { padding: 1.75rem 1.5rem 1.1rem; }
    .sfb-fm-body    { padding: 1rem 1.25rem; }
    .sfb-fm-footer  { padding: .75rem 1.25rem 1.1rem; gap: .45rem; }
    .sfb-fm-btn-close,
    .sfb-fm-btn-reset  { padding: .5rem .85rem; font-size: .78rem; }
    .sfb-fm-btn-apply  { padding: .5rem 1rem; font-size: .82rem; }
    .sfb-fm-btn-icon   { width: 20px; height: 20px; font-size: .65rem; }
    .sfb-fm-title      { font-size: 1.15rem; }
    .sfb-fm-icon       { width: 54px; height: 54px; font-size: 1.35rem; }
    .sfb-fm-ring-1     { width: 76px; height: 76px; }
    .sfb-fm-ring-2     { width: 104px; height: 104px; }
}
</style>
@endverbatim
