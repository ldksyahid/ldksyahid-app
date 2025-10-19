<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.table-books thead th {
    background-color: #00a79d !important;
    color: #fff !important;
    border-color: #00a79d !important;
    position: sticky;
    top: 0;
    z-index: 2;
}
.table-books tbody tr:hover {
    background-color: #e0f7f5 !important;
}
.table-books td,
.table-books th {
    vertical-align: middle !important;
}
.table-books a {
    color: #00a79d;
    text-decoration: none;
}
.table-books a:hover {
    text-decoration: underline;
    color: #008b84;
}
.pagination .page-link {
    color: #00a79d;
}
.pagination .page-link:hover {
    background-color: #e0f7f5;
    color: #008b84;
}
.pagination .page-item.active .page-link {
    background-color: #00a79d;
    color: #fff;
}
.pagination .page-link:focus {
    box-shadow: none;
}
.btn-custom-primary {
    color: #fff;
    background-color: #00a79d;
    border: 1px solid #00a79d;
    transition: all 0.3s ease;
}
.btn-custom-primary:hover {
    background-color: #008b84;
    border-color: #008b84;
    color: #fff;
}
.btn-custom-primary:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
}
.text-secondary {
    color: #191C24 !important;
}
.input-group input:focus {
    box-shadow: none !important;
    border-color: #00a79d !important;
    outline: none;
}
.table-books thead th a span {
    color: #fff !important;
    font-size: 0.875rem !important;
    font-weight: 600 !important;
}
.table-books thead th a {
    text-decoration: none !important;
    display: inline-block;
    width: 100%;
}
.table-books {
    border-collapse: separate !important;
    border-spacing: 0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: inset 0 0 12px rgba(0, 0, 0, 0.15);
}
.table-books thead th:first-child {
    border-top-left-radius: 10px;
}
.table-books thead th:last-child {
    border-top-right-radius: 10px;
}
.table-books tbody tr:last-child td:first-child {
    border-bottom-left-radius: 10px;
}
.table-books tbody tr:last-child td:last-child {
    border-bottom-right-radius: 10px;
}
.sort-arrow {
    color: #fff !important;
    font-weight: bold;
}
.pagination {
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.0rem;
}
.page-title {
    font-size: 1.65rem;
    font-weight: 600;
    text-align: center;
    color: #00a79d;
    margin: .75rem 0 1.5rem;
    position: relative;
    display: inline-block;
}
.page-title .highlighted-text {
    color: #008b84;
    font-weight: 700;
}
.page-title::after {
    content: '';
    display: block;
    height: 4px;
    width: 120px;
    margin: .35rem auto 0;
    border-radius: 3px;
    background: linear-gradient(90deg,#00a79d 0%,#008b84 100%);
}
.text-custom {
    color: #00a79d;
}
.card .card-title {
    font-size: 0.95rem;
}
.card .card-text {
    font-size: 0.8rem;
}
.card-guide {
    border-radius: 12px;
    transition: all 0.3s ease;
}
.card-guide:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
    cursor: pointer;
}
.pagination .page-item {
    flex: 0 0 auto;
}
.form-control-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}
.table-books input[type="text"]:focus,
.table-books input[type="number"]:focus {
    border-color: #00a79d !important;
    box-shadow: 0 0 0 0.15rem rgba(0, 167, 157, 0.25) !important;
    outline: none !important;
}
.table-books input[type="text"]:hover,
.table-books input[type="number"]:hover {
    border-color: #00a79d;
}

#bulkDeleteBtn {
    min-width: 100px;
}

.position-relative {
    position: relative;
}

.column-search-clear {
    position: absolute;
    right: 5px;
    top: 60%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    color: #6c757d;
    cursor: pointer;
    display: none;
}

.column-search-clear:hover {
    color: #495057;
}

.daterangepicker {
    font-family: inherit;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    border: 1px solid #e0e0e0;
}

.daterangepicker td.active,
.daterangepicker td.active:hover {
    background-color: #00a79d;
}

.daterangepicker .drp-buttons .btn {
    padding: 5px 15px;
    border-radius: 4px;
    font-size: 0.875rem;
}

.daterangepicker .drp-buttons .btn.applyBtn {
    background-color: #00a79d;
    border-color: #00a79d;
}

.daterangepicker .drp-buttons .btn.applyBtn:hover {
    background-color: #008b84;
    border-color: #008b84;
}

.daterangepicker .drp-buttons .btn.cancelBtn {
    color: #495057;
}

.daterangepicker .drp-buttons .btn.cancelBtn:hover {
    background-color: #f8f9fa;
}

#refreshBtn {
    min-width: 42px;
    align-items: center;
    justify-content: center;
}

#clearFiltersBtn {
    white-space: nowrap;
}

.skeleton-row {
    animation: pulse 1.5s infinite ease-in-out;
}

.skeleton {
    height: 20px;
    background: #e0f7f5;
    border-radius: 4px;
    margin: 5px 0;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}
.table-books {
    table-layout: fixed;
}
.table-books th:nth-child(1),
.table-books td:nth-child(1) { width: 50px; max-width: 50px; } /* Checkbox column */
.table-books th:nth-child(2),
.table-books td:nth-child(2) { width: 60px; max-width: 60px; } /* No column */
.table-books th:nth-child(3),
.table-books td:nth-child(3) { width: 120px; max-width: 120px; } /* Added Date */
.table-books th:nth-child(4),
.table-books td:nth-child(4) { width: 150px; max-width: 150px; } /* ISBN */
.table-books th:nth-child(5),
.table-books td:nth-child(5) { width: 250px; max-width: 250px; } /* Title */
.table-books th:nth-child(6),
.table-books td:nth-child(6) { width: 180px; max-width: 180px; } /* Author */
.table-books th:nth-child(7),
.table-books td:nth-child(7) { width: 180px; max-width: 180px; } /* Publisher */
.table-books th:nth-child(8),
.table-books td:nth-child(8) { width: 150px; max-width: 150px; } /* Category */
.table-books th:nth-child(9),
.table-books td:nth-child(9) { width: 80px; max-width: 80px; } /* Year */
.table-books th:nth-child(10),
.table-books td:nth-child(10) { width: 120px; max-width: 120px; } /* Action */

.table-books td {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.tooltip-inner {
    max-width: 500px;
    text-align: left;
}
.select2-container .select2-selection--single {
    height: 31px !important;
    border: 1px solid rgba(255, 255, 255, 0.5) !important;
    border-radius: 0.375rem !important;
    background-color: rgba(255, 255, 255, 0.9) !important;
    transition: all 0.3s ease !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 29px !important;
    font-size: 0.75rem !important;
    padding-left: 8px !important;
    color: #495057 !important;
    font-weight: 500 !important;
}

.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #6c757d !important;
    font-size: 0.75rem !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 29px !important;
    right: 6px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: #495057 transparent transparent transparent !important;
    border-width: 5px 4px 0 4px !important;
}

.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
    border-color: transparent transparent #495057 transparent !important;
    border-width: 0 4px 5px 4px !important;
}

.select2-dropdown {
    border: 1px solid #ced4da !important;
    border-radius: 0.375rem !important;
    box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1) !important;
    font-size: 0.875rem !important;
}

.select2-container--default .select2-results__option {
    padding: 6px 12px !important;
    font-size: 0.875rem !important;
    color: #495057 !important;
    transition: all 0.2s ease !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #00a79d !important;
    color: white !important;
}

.select2-container--default .select2-results__option[aria-selected="true"] {
    background-color: #e0f7f5 !important;
    color: #008b84 !important;
    font-weight: 500 !important;
}

.select2-search--dropdown {
    padding: 8px !important;
}

.select2-search--dropdown .select2-search__field {
    border: 1px solid #ced4da !important;
    border-radius: 0.375rem !important;
    padding: 4px 8px !important;
    font-size: 0.875rem !important;
    outline: none !important;
}

.select2-search--dropdown .select2-search__field:focus {
    border-color: #00a79d !important;
    box-shadow: 0 0 0 0.15rem rgba(0, 167, 157, 0.25) !important;
}

.table-books thead th .select2-container--default .select2-selection--single:focus {
    border-color: rgba(255, 255, 255, 0.8) !important;
    box-shadow: 0 0 0 0.15rem rgba(255, 255, 255, 0.3) !important;
    outline: none !important;
    background-color: rgba(255, 255, 255, 0.95) !important;
}

.table-books thead th .select2-container--default .select2-selection--single:hover {
    border-color: rgba(255, 255, 255, 0.7) !important;
    background-color: rgba(255, 255, 255, 0.95) !important;
}

.select2-container--default .select2-selection--single .select2-selection__clear {
    color: #6c757d !important;
    font-size: 1.2rem !important;
    margin-right: 20px !important;
}

.select2-container--default .select2-selection--single .select2-selection__clear:hover {
    color: #495057 !important;
}

.table-books thead th .select2-container {
    width: 100% !important;
}

.select2-container--default .select2-selection--single:focus {
    outline: none !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered .select2-selection__placeholder {
    color: #6c757d !important;
}

@media (max-width: 768px) {
    .select2-container .select2-selection--single {
        height: 35px !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px !important;
        font-size: 0.8rem !important;
    }
}

.table-books thead th:nth-child(8) .select2-container .select2-selection--single {
    background-color: rgba(255, 255, 255, 0.9) !important;
    border: 1px solid rgba(255, 255, 255, 0.4) !important;
}

.table-books thead th:nth-child(8) .select2-container .select2-selection--single:hover {
    background-color: rgba(255, 255, 255, 0.95) !important;
    border-color: rgba(255, 255, 255, 0.6) !important;
}

.table-books thead th:nth-child(8) .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #495057 !important;
    font-weight: 500 !important;
}

.select2-container--open .select2-dropdown {
    z-index: 9999 !important;
}

.select2-dropdown {
    animation: dropdownFadeIn 0.2s ease forwards !important;
}

@keyframes dropdownFadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.table-books thead th:nth-child(8) .column-search-clear {
    display: none !important;
}

.table-books thead th .select2-container {
    min-width: 100% !important;
}

.select2-container--default .select2-results__option:hover {
    background-color: #f8f9fa !important;
    color: #495057 !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected]:hover {
    background-color: #008b84 !important;
    color: white !important;
}

.table-books thead th .select2-selection__rendered {
    color: #495057 !important;
}

.table-books thead th .select2-container .select2-selection--single {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
}

.table-books thead th .select2-container--open .select2-selection--single {
    background-color: rgba(255, 255, 255, 1) !important;
    border-color: rgba(255, 255, 255, 0.8) !important;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15) !important;
}

.table-books thead th .select2-selection__placeholder {
    color: #6c757d !important;
}
</style>
