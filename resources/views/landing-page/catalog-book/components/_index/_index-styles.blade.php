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
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.book-card .card-body {
    min-height: 280px;
}
.badge.rounded-pill {
    font-size: 0.7rem;
    padding: 0.35em 0.65em;
}
</style>
