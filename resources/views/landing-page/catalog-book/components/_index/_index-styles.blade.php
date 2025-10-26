<link href="{{ asset('assets/external/css/select2.min.css') }}" rel="stylesheet" />
<style>
/* Global Styles */
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

/* Search Button */
.search-btn {
    background-color: #00bfa6;
    color: white;
    transition: all 0.3s ease;
}

.search-btn:hover {
    background-color: #00d9bb !important;
    color: white;
    box-shadow: 0 4px 12px rgba(0, 217, 187, 0.4);
}

/* Pagination */
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
/* Book Card Layout */
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

/* Title Section */
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

/* Description Content */
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

/* Favorite & Category */
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

/* Crown Icon */
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

/* Share Button */
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

/* Copy Success Message */
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

/* Small Tab Text */
.small-tab-text {
    font-size: 0.8rem !important;
    font-weight: 600;
}

/* Filter Modal Styles */
#filterModal .modal-content {
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    border: none;
}

#filterModal .modal-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #e9ecef;
    border-radius: 20px 20px 0 0 !important;
    padding: 1.5rem;
}

#filterModal .modal-title {
    font-weight: 600;
    color: #2c3e50;
    font-size: 1.25rem;
}

#filterModal .modal-body {
    padding: 1.5rem;
    font-weight: 400;
}

#filterModal .modal-footer {
    border-top: 1px solid #e9ecef;
    border-radius: 0 0 20px 20px !important;
    padding: 1.5rem;
}

#filterModal .form-label {
    font-size: 0.95rem;
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

#filterModal .form-select {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    padding: 0.75rem 1rem;
    font-weight: 400;
}

#filterModal .form-select:focus {
    border-color: #00bfa6;
    box-shadow: 0 0 0 0.2rem rgba(0, 191, 166, 0.25);
}

/* Filter Button */
.btn-outline-primary.rounded-pill {
    border: 2px solid #00bfa6;
    color: #00bfa6;
    font-weight: 500;
    transition: all 0.3s ease;
    padding: 0.6rem 1.2rem;
}

.btn-outline-primary.rounded-pill:hover {
    background-color: #00bfa6;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 191, 166, 0.3);
}

/* Select2 in Modal - SPECIFIC TO PERPUSTAKAAN ONLY */
#filterModal .select2-container--default .select2-selection--multiple {
    border: 2px solid #e9ecef !important;
    border-radius: 50px !important;
    padding: 0.25rem 0.5rem !important;
    min-height: 48px !important;
    transition: all 0.3s ease !important;
    font-weight: 400 !important;
}

#filterModal .select2-container--default .select2-selection__choice {
    font-weight: 400 !important;
}

#filterModal .select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #00bfa6 !important;
}

#filterModal .select2-dropdown {
    border-radius: 12px !important;
    border: 2px solid #00bfa6 !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    margin-top: 8px !important;
    padding: 8px 0 !important;
}

#filterModal .select2-results__option {
    font-weight: 400 !important;
    padding: 0.75rem 1rem !important;
    margin: 2px 8px !important;
    border-radius: 6px !important;
    transition: all 0.2s ease !important;
}

#filterModal .select2-results__option:not(:last-child) {
    margin-bottom: 4px !important;
}

#filterModal .select2-results__option--highlighted {
    background-color: #00bfa6 !important;
    color: white !important;
    margin: 2px 8px !important;
    border-radius: 6px !important;
}

/* Filter Badge */
/* Circle Badge Styles */
.filter-badge {
    width: 20px !important;
    height: 20px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 0.7rem !important;
    font-weight: 700 !important;
    padding: 0 !important;
    line-height: 1 !important;
    background: white !important;
    color: #00bfa6 !important;
    border: 1px solid #00bfa6 !important;
    margin-left: 0.5rem !important;
}

/* Untuk button primary state */
.btn-primary .filter-badge {
    background: white !important;
    color: #00bfa6 !important;
    border: 1px solid white !important;
}

/* Untuk button outline state */
.btn-outline-primary .filter-badge {
    background: #00bfa6 !important;
    color: white !important;
    border: 1px solid #00bfa6 !important;
}

/* Hover effects */
.btn-outline-primary:hover .filter-badge {
    background: white !important;
    color: #00bfa6 !important;
    border: 1px solid white !important;
}

/* Active Filter Badges */
.badge.rounded-pill {
    font-size: 0.8rem;
    padding: 0.5rem 0.8rem;
    font-weight: 500;
}

/* Modal Animation */
.modal.fade .modal-dialog {
    transform: translateY(-50px);
    transition: transform 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: translateY(0);
}

.modal-backdrop.show {
    opacity: 0.7;
}

/* Loading Animation */
.fa-spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Ensure equal height for cards */
.row.g-4 {
    align-items: stretch;
}

/* Utility Classes */
.text-button p {
    margin: 0;
}

.small-tab-text {
    font-size: 0.8rem !important;
}

/* PERPUSTAKAAN SPECIFIC DROPDOWN STYLES - ONLY FOR THIS PAGE */
.container-xxl.py-5 .dropdown-menu {
    border: 1px solid #e9ecef !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    padding: 0.5rem !important;
    margin-top: 8px !important;
}

.container-xxl.py-5 .dropdown-item {
    border-radius: 6px !important;
    padding: 0.6rem 1rem !important;
    font-size: 0.85rem !important;
    transition: all 0.2s ease !important;
    display: flex !important;
    align-items: center !important;
}

.container-xxl.py-5 .dropdown-item:hover {
    background-color: #f8f9fa !important;
    color: #00bfa6 !important;
}

.container-xxl.py-5 .dropdown-item.copy-link:hover {
    background-color: #e3f2fd !important;
}

.container-xxl.py-5 .dropdown-item.share-wa:hover {
    background-color: #25d366 !important;
    color: white !important;
}

.container-xxl.py-5 .dropdown-menu .dropdown-item.active {
    background-color: #00bfa6 !important;
    color: white !important;
    border: none !important;
}

.container-xxl.py-5 .dropdown-menu .dropdown-item.active i {
    color: white !important;
}

/* Fix untuk glitch dropdown Bootstrap */
.dropdown-toggle::after {
    display: inline-block !important;
    margin-left: 0.255em !important;
    vertical-align: 0.255em !important;
    content: "" !important;
    border-top: 0.3em solid !important;
    border-right: 0.3em solid transparent !important;
    border-bottom: 0 !important;
    border-left: 0.3em solid transparent !important;
}

/* Pastikan tidak ada konflik dengan Select2 */
.select2-container {
    z-index: 1055 !important;
}

.select2-dropdown {
    z-index: 1060 !important;
}
/* Loading state untuk search input */
#search-input:disabled {
    background-color: #f8f9fa;
    cursor: not-allowed;
    opacity: 0.7;
}

/* Style untuk tombol search saat loading */
.search-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Animasi untuk clear button saat hidden */
#clear-search {
    transition: opacity 0.3s ease;
}

#clear-search.hidden {
    opacity: 0;
    pointer-events: none;
}
.btn-outline-primary.btn-sm.dropdown-toggle.rounded-pill:focus,
.btn-outline-primary.btn-sm.dropdown-toggle.rounded-pill:active,
.btn-outline-primary.btn-sm.dropdown-toggle.rounded-pill.show {
    background-color: white !important;
    color: #00bfa6 !important;
    border-color: #00bfa6 !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 191, 166, 0.25) !important;
}

.btn-outline-primary.btn-sm.dropdown-toggle.rounded-pill:hover {
    background-color: #00bfa6 !important;
    color: white !important;
    border-color: #00bfa6 !important;
}

.btn-outline-primary.btn-sm.dropdown-toggle.rounded-pill.show:hover {
    background-color: white !important;
    color: #00bfa6 !important;
    border-color: #00bfa6 !important;
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
</style>
