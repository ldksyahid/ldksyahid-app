@verbatim
<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">

<style>
/* ================================================================
   HERO / JUMBOTRON COMPONENT STYLES
   Shared across pages that use <x-hero-jumbotron>.
   ================================================================ */

.hero-fun {
    position: relative;
    overflow: visible;
    background: transparent;
    padding-top: 80px !important;
    margin-bottom: 0;
}

.hero-carousel-wrapper {
    padding: 1rem;
    background: transparent;
    margin-bottom: 0;
}

.hero-carousel-card {
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,.1);
    position: relative;
    background: white;
}

@media (min-width: 992px) {
    .hero-carousel-wrapper { padding: 1.5rem 2.5rem; }
    .hero-carousel-card    { border-radius: 32px; }
}

.hero-slide { position: relative; width: 100%; overflow: hidden; }
.hero-image { width: 100%; height: auto; display: block; object-fit: cover; }

@media (min-width: 992px) {
    .hero-slide  { height: auto; }
    .hero-image  { height: auto; object-fit: unset; }
}

/* Desktop hadith content */
.hero-desktop-content {
    background: white;
    padding: 0 1.5rem 2.5rem;
    margin-top: -20px;
    position: relative;
    z-index: 5;
    border-radius: 0 0 32px 32px;
    overflow: visible;
}

.hero-divider-desktop {
    position: absolute;
    top: -40px; left: -10px;
    width: calc(100% + 20px);
    height: 60px;
    background: white;
    border-radius: 50% 50% 0 0;
    z-index: 30;
}

.hadith-background-animation {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    overflow: hidden;
    z-index: 1;
    pointer-events: none;
}

.floating-icon {
    position: absolute;
    font-size: 2.5rem;
    opacity: .25;
    animation: float 15s infinite ease-in-out;
    z-index: 1;
    pointer-events: none;
    filter: drop-shadow(0 2px 5px rgba(0,0,0,.1));
    display: block;
}

.floating-shape {
    position: absolute;
    width: 150px; height: 150px;
    background: radial-gradient(circle at 30% 30%, var(--primary-light), transparent 70%);
    border-radius: 50%;
    opacity: .2;
    animation: pulse 20s infinite ease-in-out;
    z-index: 1;
    pointer-events: none;
    filter: blur(8px);
    display: block;
    mix-blend-mode: multiply;
}

/* Desktop icon positions */
.hadith-background-animation:not(.mobile) .icon-1 { top:10%;   left:5%;   animation-delay:0s; }
.hadith-background-animation:not(.mobile) .icon-2 { bottom:15%;right:8%;  animation-delay:2s;  font-size:2.5rem; }
.hadith-background-animation:not(.mobile) .icon-3 { top:25%;  right:15%; animation-delay:4s;  font-size:1.8rem; }
.hadith-background-animation:not(.mobile) .icon-4 { bottom:20%;left:12%;  animation-delay:6s;  font-size:2.2rem; }
.hadith-background-animation:not(.mobile) .icon-5 { top:40%;  left:20%;  animation-delay:8s; }
.hadith-background-animation:not(.mobile) .icon-6 { top:65%;  right:15%; animation-delay:10s; font-size:2.3rem; }
.hadith-background-animation:not(.mobile) .icon-7 { bottom:8%;left:15%;  animation-delay:12s; }
.hadith-background-animation:not(.mobile) .icon-8 { top:20%;  right:25%; animation-delay:14s; font-size:2.4rem; }
.hadith-background-animation:not(.mobile) .shape-1 {
    top:20%; right:10%; width:150px; height:150px;
    animation:pulse 18s infinite;
    background: radial-gradient(circle at 20% 20%, var(--primary-light), transparent 80%);
}
.hadith-background-animation:not(.mobile) .shape-2 {
    bottom:10%; left:5%; width:120px; height:120px;
    animation: pulse 22s infinite reverse;
    background: radial-gradient(circle at 80% 80%, var(--primary-light), transparent 80%);
}

/* Mobile icon positions */
.hadith-background-animation.mobile .icon-1 { top:20%; left:5%;   font-size:2rem;   animation:float 12s infinite; }
.hadith-background-animation.mobile .icon-3 { top:15%; right:10%; font-size:1.8rem; animation:float 16s infinite 2s; }
.hadith-background-animation.mobile .icon-5 { top:25%; left:20%;  font-size:1.9rem; animation:float 15s infinite 4s; }
.hadith-background-animation.mobile .shape-1 {
    top:20%; right:5%; width:90px; height:90px;
    animation:pulse 15s infinite;
    background:radial-gradient(circle at 30% 30%, var(--primary-light), transparent 70%);
}
.hadith-background-animation.mobile .shape-2 {
    bottom:5%; left:10%; width:60px; height:60px;
    animation:pulse 18s infinite reverse;
    background:radial-gradient(circle at 70% 70%, var(--primary-light), transparent 70%);
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    25%       { transform: translateY(-20px) rotate(8deg); }
    50%       { transform: translateY(15px) rotate(-8deg); }
    75%       { transform: translateY(-8px) rotate(5deg); }
}
@keyframes pulse {
    0%, 100% { transform: scale(1);   opacity: .2; }
    50%       { transform: scale(1.4); opacity: .35; }
}

.desktop-countdown {
    position: absolute;
    bottom: 20px; right: 30px;
    background: rgba(0,0,0,.35);
    backdrop-filter: blur(6px);
    color: white;
    padding: .4rem 1rem;
    border-radius: 50px;
    font-size: .75rem;
    z-index: 40;
    border: 1px solid rgba(255,255,255,.08);
}
.desktop-countdown-number { font-weight: 700; color: #ffd700; margin: 0 2px; }

.hero-desktop-card { max-width: 900px; margin: 0 auto; text-align: center; position: relative; z-index: 35; padding-top: 30px; }

.hero-desktop-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--primary-light); color: var(--primary);
    border-radius: 50px; padding: .4rem 1rem;
    font-size: .8rem; font-weight: 600;
    margin-bottom: 1rem; position: relative; z-index: 35;
}

.hadith-desktop-wrapper {
    max-height: 150px; overflow: hidden; position: relative;
    transition: max-height .5s ease; margin-bottom: .75rem; z-index: 35;
}
.hadith-desktop-wrapper.expanded { max-height: 2000px; }
.hadith-desktop-wrapper:not(.expanded)::after {
    content: ''; position: absolute; bottom: 0; left: 0;
    width: 100%; height: 50px;
    background: linear-gradient(to bottom, transparent, white);
    pointer-events: none; z-index: 36;
}
.hadith-desktop-wrapper.hj-no-overflow:not(.expanded)::after { display: none; }

.hadith-fade-text { transition: opacity .5s ease-in-out; opacity: 1; }
.hadith-fade-text.fade-out { opacity: 0; }

.loading-text  { display: inline-block; }
.loading-dots  { display: inline-block; margin-left: 2px; }
.dot { display: inline-block; animation: bounce 1.4s infinite; font-size: 1.2rem; line-height: 1; }
.dot:nth-child(2) { animation-delay: .2s; }
.dot:nth-child(3) { animation-delay: .4s; }
@keyframes bounce {
    0%, 60%, 100% { transform: translateY(0); opacity: .3; }
    30%            { transform: translateY(-5px); opacity: 1; }
}

.hero-desktop-arab {
    font-family: 'Amiri','Traditional Arabic',serif;
    font-size: 1.4rem; line-height: 2; color: var(--dark);
    margin-bottom: .75rem; direction: rtl; padding: 0 .5rem;
    position: relative; z-index: 35;
}
.hero-desktop-text {
    font-size: .85rem; color: var(--gray); line-height: 1.6;
    margin-bottom: .35rem; font-style: italic; position: relative; z-index: 35;
}
.hero-desktop-number {
    display: block; font-size: .7rem; color: var(--primary);
    font-weight: 600; margin-bottom: .5rem; position: relative; z-index: 35;
}

.desktop-toggle-btn {
    background: none; border: 1px solid var(--primary-light); color: var(--primary);
    padding: .5rem 1.5rem; border-radius: 50px; font-size: .8rem; font-weight: 600;
    cursor: pointer; transition: all .3s ease;
    display: inline-flex; align-items: center; gap: .4rem;
    margin-top: .25rem; position: relative; z-index: 35;
}
.desktop-toggle-btn:hover,
.desktop-toggle-btn:focus,
.desktop-toggle-btn:active { background: transparent; border-color: var(--primary-light); color: var(--primary); transform: none; box-shadow: none; outline: none; }
.desktop-toggle-btn i { transition: transform .3s ease; font-size: .7rem; }
.desktop-toggle-btn.expanded i { transform: rotate(180deg); }

/* Mobile hadith content */
.hero-mobile-content {
    padding: 0 1.25rem 1rem; text-align: center;
    background: white; border-radius: 0 0 20px 20px;
    margin-top: -20px; position: relative; z-index: 4; overflow: visible;
}
.hero-divider-mobile {
    position: absolute; top: -20px; left: -5px;
    width: calc(100% + 10px); height: 45px;
    background: white; border-radius: 50% 50% 0 0;
    z-index: 30; box-shadow: 0 -3px 10px rgba(0,0,0,.02);
}
.hero-mobile-badge {
    display: inline-flex; align-items: center; gap: .4rem;
    background: var(--primary-light); color: var(--primary);
    border-radius: 50px; padding: .3rem .85rem;
    font-size: .75rem; font-weight: 600;
    margin-bottom: 1rem; position: relative; z-index: 35; margin-top: 20px;
}
.hero-mobile-arab {
    font-size: 1.1rem; color: var(--dark); line-height: 2;
    margin-bottom: .75rem; direction: rtl;
    font-family: 'Amiri','Traditional Arabic',serif;
    padding: 0 .5rem; position: relative; z-index: 35;
}
.hero-mobile-desc {
    font-size: .85rem; color: var(--gray); line-height: 1.5;
    margin-bottom: .75rem; font-style: italic; position: relative; z-index: 35;
}
.hadith-mobile-wrapper {
    max-height: 150px; overflow: hidden; position: relative;
    transition: max-height .4s ease; margin-bottom: 1rem; z-index: 35;
}
.hadith-mobile-wrapper.expanded { max-height: 2000px; }
.hadith-mobile-wrapper:not(.expanded)::after {
    content: ''; position: absolute; bottom: 0; left: 0;
    width: 100%; height: 40px;
    background: linear-gradient(to bottom, transparent, white);
    pointer-events: none; z-index: 36;
}
.hadith-mobile-wrapper.hj-no-overflow:not(.expanded)::after  { display: none; }
.hadith-number { display: block; font-size: .7rem; color: var(--primary); font-weight: 600; margin-top: .5rem; opacity: .7; position: relative; z-index: 35; }
.mobile-action-area { display: flex; justify-content: space-between; align-items: center; margin-top: .5rem; padding: 0 .25rem; position: relative; z-index: 35; }
.hadith-toggle {
    background: none; border: 1px solid var(--primary-light); color: var(--primary);
    font-size: .75rem; font-weight: 600; cursor: pointer;
    padding: .4rem 1.2rem; outline: none;
    display: inline-flex; align-items: center; gap: .3rem;
    border-radius: 50px; transition: all .3s ease; flex-shrink: 0;
}
.hadith-toggle:hover,.hadith-toggle:focus,.hadith-toggle:active { background: transparent; border-color: var(--primary-light); color: var(--primary); transform: none; box-shadow: none; outline: none; }
.hadith-toggle i { font-size: .6rem; transition: transform .3s ease; }
.hadith-toggle.expanded i { transform: rotate(180deg); }
.mobile-countdown {
    background: rgba(0,0,0,.35); backdrop-filter: blur(6px);
    color: rgba(255,255,255,.85); padding: .3rem .9rem;
    border-radius: 50px; font-size: .65rem;
    border: 1px solid rgba(255,255,255,.08); white-space: nowrap; flex-shrink: 0; z-index: 40;
}
.mobile-countdown-number { font-weight: 700; color: #ffd700; margin: 0 2px; }

/* ── Mobile responsive ── */
@media (max-width: 991.98px) {
    html, body { overflow-x: hidden; }

    .hero-fun { padding-top: 75px !important; }

    .hero-carousel-wrapper { padding: 1.25rem 0.75rem 1rem; }
    .hero-carousel-card    { border-radius: 20px; overflow: hidden; }

    .hero-fun .hero-slide  { height: auto !important; overflow: hidden; }
    .hero-fun .hero-image  {
        width: 100% !important; height: auto !important;
        max-height: none !important; display: block;
        object-fit: cover !important; object-position: center !important;
    }

    .hero-mobile-content {
        display: flex; flex-direction: column; align-items: center;
        gap: .75rem; text-align: center;
        padding: 1.5rem 1.25rem 1.5rem; margin-top: 0 !important;
    }
    .hero-mobile-content .hero-mobile-badge     { margin-bottom: 0; }
    .hero-mobile-content .hadith-mobile-wrapper { margin-bottom: 0; }
    .hero-mobile-content .hadith-mobile-wrapper,
    .hero-mobile-content .mobile-action-area    { width: 100%; }
}

@media (max-width: 480px) {
    .mobile-action-area { flex-direction: column; gap: .75rem; align-items: stretch; }
    .mobile-countdown   { align-self: flex-end; }
    .hadith-toggle      { align-self: flex-start; }
}
</style>
@endverbatim
