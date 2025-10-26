<link href="{{ asset('assets/external/css/select2.min.css') }}" rel="stylesheet" />
<style>
.object-fit-cover {
    object-fit: cover;
    object-position: top;
}
.book-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.book-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}
.ratio.ratio-16x9 {
    height: 300px;
}
input.form-control:focus {
    box-shadow: none;
}
.search-btn {
    background-color: #00bfa6;
    color: white;
    transition: all 0.3s ease;
}
.search-btn:hover {
    background-color: #00d9bb !important;
    color: white;
    box-shadow: 0 4px 12px rgba(0, 217, 187, 0.4)
}
.custom-pagination {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    padding-left: 0;
    list-style: none;
    margin: 1rem 0;
}
.custom-pagination .page-link {
    color: #00a79d;
    background-color: #fff;
    border: 1px solid #00a79d;
    border-radius: 50px;
    transition: all 0.3s ease;
    padding: 6px 14px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    font-weight: 500;
}
.custom-pagination .page-item.active .page-link {
    background-color: #00a79d;
    border-color: #00a79d;
    color: #fff;
    font-weight: bold;
}
.custom-pagination .page-link:hover:not(.disabled):not(.active) {
    background-color: #00a79d;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
}
.custom-pagination .page-item.disabled .page-link {
    color: #ccc !important;
    background-color: #f9f9f9 !important;
    border-color: #eee !important;
    cursor: not-allowed;
    pointer-events: none;
}
.custom-pagination .page-item.disabled .page-link[aria-label="First"] {
    border-top-left-radius: 50px;
    border-bottom-left-radius: 50px;
    border-top-right-radius: 14px;
    border-bottom-right-radius: 14px;
}
.custom-pagination .page-item.disabled .page-link[aria-label="Last"] {
    border-top-right-radius: 50px;
    border-bottom-right-radius: 50px;
    border-top-left-radius: 14px;
    border-bottom-left-radius: 14px;
}
.custom-pagination .page-link[aria-label="First"] {
    border-top-left-radius: 50px;
    border-bottom-left-radius: 50px;
    border-top-right-radius: 14px;
    border-bottom-right-radius: 14px;
}
.custom-pagination .page-link[aria-label="Last"] {
    border-top-right-radius: 50px;
    border-bottom-right-radius: 50px;
    border-top-left-radius: 14px;
    border-bottom-left-radius: 14px;
}
.custom-pagination {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 0.4rem;
    padding-left: 0;
    list-style: none;
    margin: 1rem 0;
    row-gap: 0.5rem;
    flex-shrink: 1;
    flex-grow: 1;
}
.custom-pagination .page-link {
    color: #00a79d;
    background-color: #fff;
    border: 1px solid #00a79d;
    border-radius: 50px;
    transition: all 0.3s ease;
    padding: 6px 14px;
    font-size: 0.9rem;
    white-space: nowrap;
    min-width: 36px;
    text-align: center;
    font-weight: 500;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}
@media (max-width: 576px) {
    .custom-pagination {
        gap: 0.25rem;
    }
    .custom-pagination .page-link {
        font-size: 0.75rem;
        padding: 4px 10px;
        min-width: 28px;
    }
}
@media (max-width: 400px) {
    .custom-pagination {
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }
    .custom-pagination .page-link {
        font-size: 0.7rem;
        padding: 4px 8px;
    }
}
.card.p-3 {
    background: #fff;
    border: 1px solid #ddd;
}
.form-select.rounded-pill {
    padding-left: 1rem;
    padding-right: 1rem;
}
.btn.rounded-pill {
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn.btn-primary.rounded-pill:hover {
    background-color: #009b89;
}
.btn.btn-outline-secondary.rounded-pill:hover {
    background-color: #f2f2f2;
    color:  #6c757d;
}
.select2-container--default.select2-container--focus .select2-selection--multiple{
    border: 1px solid #00bfa6;
}
.select2-dropdown {
    border: 1px solid #00bfa6;
    border-radius: 12px;
    overflow: hidden;
    font-size: 0.95rem;
}
.select2-results__option {
    padding: 10px 14px;
    transition: all 0.2s ease;
    cursor: pointer;
    border-bottom: 1px solid #e0f2ef;
}
.select2-results__option:last-child {
    border-bottom: none;
}
.select2-results__option--highlighted {
    background-color: #00bfa6 !important;
    color: white !important;
}
.select2-results__option[aria-selected="true"] {
    background-color: #e6f9f6;
    color: #007f73;
}
.select2-results__options::-webkit-scrollbar {
    width: 6px;
}
.select2-results__options::-webkit-scrollbar-track {
    background: #f0f0f0;
    border-radius: 10px;
}
.select2-results__options::-webkit-scrollbar-thumb {
    background: #00bfa6;
    border-radius: 10px;
}
.select2-dropdown {
    animation: dropdownFadeIn 0.2s ease forwards;
    opacity: 1;
}
.select2-fade-out {
    animation: dropdownFadeOut 0.2s ease forwards;
}
.select2-selection .select2-selection--multiple{
    border-radius: 12px;
}
@keyframes dropdownFadeIn {
    from {
        opacity: 0;
        transform: translateY(-4px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
@keyframes dropdownFadeOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-4px);
    }
}
.select2-selection__clear {
    font-weight: bold;
    font-size: 1.1rem;
    color: #999;
    margin-right: 8px;
    transition: color 0.2s ease;
}
.select2-selection__clear:hover {
    color: #ccc;
}
.select2-search--dropdown .select2-search__field {
    border: none;
    box-shadow: none;
}
.select2-search__field {
    border: none;
    box-shadow: none;
    outline: none;
    background-color: transparent;
    color: #8d9297;
}
.select2-selection__choice{
    border: #00bfa6 !important;
    background-color: #00bfa6 !important;
    color: white;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: white;
    transition: all 0.2s ease;
    border-right: 1px solid white;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: white;
    background-color: #1ee8ce
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:focus {
    color: white;
    outline: none;
    background-color: #1ee8ce;
}
@media (min-width: 992px) {
    .sticky-filter {
        position: sticky;
        top: 90px;
        z-index: 900;
    }
}

/* Updated styles for 2 cards per row layout */
.item-new-book {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
    height: 100%;
}

.item-new-book:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.wrp-cover-book-new {
    padding: 1.25rem;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.title-book-mb {
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.centered-cover-frame {
    width: 100%;
    height: 220px;
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    background: #f8f9fa;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e9ecef;
}

.centered-cover-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top left;
    transition: transform 0.3s ease;
}

.centered-cover-frame:hover img {
    transform: scale(1.05);
}

.right-new-catalog {
    padding: 1.25rem;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.title-of-new h2 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1.3;
    margin-bottom: 0.5rem;
}

.book-title-truncate {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: 3.2rem;
}

.date-publish-book {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.icon-date-publish svg {
    width: 16px;
    height: 16px;
    color: #6c757d;
}

.text-publish-date p {
    margin: 0;
    color: #6c757d;
    font-size: 0.85rem;
}

/* Tabs Styling */
.nav-tabs {
    border-bottom: 2px solid #e9ecef;
    margin-bottom: 1rem;
}

.nav-tabs .nav-link {
    border: none;
    background: none;
    color: #6c757d;
    font-weight: 600;
    padding: 0.6rem 1rem;
    border-radius: 6px 6px 0 0;
    margin-bottom: -2px;
    transition: all 0.3s ease;
    font-size: 0.85rem;
}

.nav-tabs .nav-link:hover {
    color: #00bfa6;
    border: none;
}

.nav-tabs .nav-link.active {
    color: #00bfa6;
    background: none;
    border: none;
    border-bottom: 2px solid #00bfa6;
}

.tab-content-new {
    flex: 1;
    min-height: 180px;
}

.desc-of-new h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.75rem;
}

.desc-of-new ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.desc-of-new ul li {
    padding: 0.4rem 0;
    border-bottom: 1px solid #f8f9fa;
    font-size: 0.85rem;
}

.desc-of-new ul li:last-child {
    border-bottom: none;
}

.desc-of-new ul li p {
    margin: 0;
    color: #495057;
    line-height: 1.4;
    display: flex;
    justify-content: space-between;
}

.desc-of-new ul li p span.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 150px;
}

.desc-of-new p {
    color: #495057;
    font-size: 0.85rem;
    line-height: 1.5;
    margin-bottom: 0;
}

.synopsis-text {
    display: -webkit-box;
    -webkit-line-clamp: 10;
    -webkit-box-orient: vertical;
    overflow: hidden;
    max-height: 15rem;
}

/* Action Buttons */
.act-new-book {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.btn-detail-catalog {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    width: 100%;
    border: none;
    font-size: 0.85rem;
    background: linear-gradient(135deg, #00bfa6 0%, #009b89 100%);
    color: white;
}

.btn-detail-catalog:hover {
    background: linear-gradient(135deg, #009b89 0%, #007f73 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 191, 166, 0.3);
}

.text-button p {
    margin: 0;
    font-weight: 600;
    font-size: 0.85rem;
}
.icon-date-publish .fas.fa-heart {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.favorite-count {
    font-size: 0.875rem;
    color: #6c757d;
    margin-left: 4px;
}
.category-badge {
    margin-left: auto;
    padding-left: 1rem;
}

.category-badge .badge {
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.35rem 0.75rem;
    background: linear-gradient(135deg, #00bfa6 0%, #009b89 100%) !important;
    border: none;
    white-space: nowrap;
}
.crown-icon {
    font-size: 1.3rem;
    margin-left: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.crown-premium {
    color: #03a89e;
}

.crown-gold {
    color: #FFD700;
}

@keyframes crownGlow {
    0% {
        transform: scale(1);
        text-shadow: 0 0 5px currentColor;
    }
    100% {
        transform: scale(1.1);
        text-shadow: 0 0 12px currentColor;
    }
}
/* Responsive Design */
@media (max-width: 992px) {
    .item-new-book {
        margin-bottom: 1rem;
    }

    .centered-cover-frame {
        height: 180px;
    }

    .title-of-new h2 {
        font-size: 1.2rem;
    }

    .tab-content-new {
        min-height: 160px;
    }
}

@media (max-width: 768px) {
    .crown-icon {
        font-size: 1.1rem;
    }
    .category-badge {
        padding-left: 0.5rem;
    }

    .category-badge .badge {
        font-size: 0.65rem;
        padding: 0.3rem 0.6rem;
    }
    .wrp-cover-book-new {
        padding: 1rem;
    }

    .right-new-catalog {
        padding: 1rem;
    }

    .title-of-new h2 {
        font-size: 1.1rem;
    }

    .centered-cover-frame {
        height: 160px;
    }

    .nav-tabs .nav-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
    }

    .btn-detail-catalog {
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
    }

    .tab-content-new {
        min-height: 140px;
    }
    .item-new-book .row {
        flex-direction: column;
    }

    .wrp-cover-book-new {
        padding-bottom: 0.5rem;
    }

    .right-new-catalog {
        padding-top: 0.5rem;
    }
    .btn-share {
        padding: 0.5rem;
        font-size: 0.8rem;
    }

    .dropdown-item {
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
    }
}

@media (max-width: 576px) {
        .copy-success {
        bottom: 20px;
        left: 20px;
        right: 20px;
        transform: none;
        min-width: auto;
        text-align: center;
    }

    @keyframes slideUp {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes slideDown {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(100%);
            opacity: 0;
        }
    }
    .crown-icon {
        font-size: 1rem;
    }
    .category-badge .badge {
        font-size: 0.6rem;
        padding: 0.25rem 0.5rem;
    }

    .date-publish-book {
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .favorite-section {
        margin-left: 0 !important;
    }
    .item-new-book {
        margin-bottom: 1rem;
    }

    .title-of-new h2 {
        font-size: 1rem;
    }

    .centered-cover-frame {
        height: 140px;
    }

    .desc-of-new ul li {
        font-size: 0.8rem;
    }

    .desc-of-new ul li p span.text-truncate {
        max-width: 120px;
    }

    .tab-content-new {
        min-height: 120px;
    }
    .container-xxl.py-5 {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
    }

    .row.mb-5.justify-content-center {
        margin-bottom: 1.5rem !important;
    }

    .row.mb-4.wow.fadeInUp {
        margin-bottom: 1rem !important;
    }
}

/* Ensure equal height for cards in the same row */
.row.g-4 {
    align-items: stretch;
}
.btn-share {
    border: 1px solid #00bfa6;
    color: #00bfa6;
    border-radius: 6px;
    padding: 0.6rem;
    transition: all 0.3s ease;
    font-size: 0.85rem;
    outline: none;
}

.btn-share:hover {
    background-color: #00bfa6;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 191, 166, 0.3);
    outline: none;
}

.btn-share:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 191, 166, 0.25);
}

/* Dropdown Menu Styling */
.dropdown-menu {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 0.5rem;
}

.dropdown-item {
    border-radius: 6px;
    padding: 0.6rem 1rem;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: #00bfa6;
}

.dropdown-item.copy-link:hover {
    background-color: #e3f2fd;
}

.dropdown-item.share-wa:hover {
    background-color: #25d366;
    color: white;
}

/* Success message for copy */
.copy-success {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    background: #00bfa6;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    animation: slideUp 0.3s ease;
    font-size: 0.9rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 200px;
    text-align: center;
    justify-content: center;
}

@keyframes slideUp {
    from {
        transform: translateX(-50%) translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }
}

/* Optional: Tambahkan efek fade out */
.copy-success.fade-out {
    animation: slideDown 0.3s ease forwards;
}

@keyframes slideDown {
    from {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }
    to {
        transform: translateX(-50%) translateY(100%);
        opacity: 0;
    }
}
.small-tab-text {
    font-size: 0.8rem !important;
    font-weight: 600;
}
/* Dropdown item active state - FIXED */
.dropdown-menu .dropdown-item.active {
    background-color: #00bfa6 !important;
    color: white !important;
    border: none;
}

.dropdown-menu .dropdown-item.active i {
    color: white !important;
}

.dropdown-menu .dropdown-item.active:hover {
    background-color: #009b89 !important;
    color: white !important;
}

.dropdown-menu .dropdown-item.active:hover i {
    color: white !important;
}

/* Tambahkan jarak antara button dan dropdown */
.dropdown-menu {
    margin-top: 8px !important;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 0.5rem;
}

/* Pastikan dropdown item memiliki padding yang cukup */
.dropdown-menu .dropdown-item {
    padding: 0.6rem 1rem;
    font-size: 0.85rem;
    border-radius: 6px;
    margin: 2px 0;
    transition: all 0.2s ease;
}

/* Hover state untuk semua dropdown items */
.dropdown-menu .dropdown-item:not(.active):hover {
    background-color: #f8f9fa;
    color: #00bfa6;
}

/* Untuk button dropdown utama */
.btn-outline-primary.dropdown-toggle {
    border-color: #00bfa6;
    color: #00bfa6;
    font-weight: 500;
}

.btn-outline-primary.dropdown-toggle:hover,
.btn-outline-primary.dropdown-toggle:focus {
    background-color: #00bfa6;
    border-color: #00bfa6;
    color: white;
    box-shadow: 0 0 0 0.2rem rgba(0, 191, 166, 0.25);
}

/* Show dropdown animation */
.dropdown-menu.show {
    animation: dropdownFadeIn 0.2s ease;
}

@keyframes dropdownFadeIn {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>
