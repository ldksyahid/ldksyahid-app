@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-magic',
            'title' => 'How to Create a Shortlink',
            'description' => 'Enter the complete URL you wish to shorten, click <strong>"Shorten"</strong>, and afterward, feel free to edit the shortlink according to your needs.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'You can now search in each column by typing in the search field below each column header.'
        ],
        [
            'icon' => 'fa-copy',
            'title' => 'Copy Values',
            'description' => 'Click the <i class="fa fa-copy small"></i> icon next to the URL Key, Destination URL, or Short URL to copy the value to your clipboard.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit a shortlink (available for all roles), or <i class="fa fa-trash small text-danger"></i> to delete it (only Superadmins are allowed to delete).'
        ],
    ];

    // Visits dropdown HTML
    $visitsFilterHtml = '
    <div class="dropdown">
        <button class="btn btn-sm dropdown-toggle visits-dropdown" type="button" id="visitsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <span id="visitsDropdownLabel">All Visitors</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end visits-dropdown-menu" aria-labelledby="visitsDropdown">
            <li><h6 class="dropdown-header">Visitor Range</h6></li>
            <li><a class="dropdown-item visits-option" href="#" data-range="">All Visitors</a></li>
            <li><hr class="dropdown-divider m-0"></li>
            <li><a class="dropdown-item visits-option" href="#" data-range="0-10">0 - 10 visitors</a></li>
            <li><a class="dropdown-item visits-option" href="#" data-range="11-50">11 - 50 visitors</a></li>
            <li><a class="dropdown-item visits-option" href="#" data-range="51-100">51 - 100 visitors</a></li>
            <li><a class="dropdown-item visits-option" href="#" data-range="101-500">101 - 500 visitors</a></li>
            <li><a class="dropdown-item visits-option" href="#" data-range="501-1000">501 - 1000 visitors</a></li>
            <li><a class="dropdown-item visits-option" href="#" data-range="1001+">1000+ visitors</a></li>
        </ul>
    </div>';

    // Columns Config
    $columns = [
        [
            'key' => 'url_key',
            'label' => 'URL Key',
            'width' => '300px',
            'sortable' => true,
            'sortKey' => 'url_key',
            'filter' => 'text',
            'filterKey' => 'url_key',
        ],
        [
            'key' => 'destination_url',
            'label' => 'URL Destination',
            'width' => '350px',
            'sortable' => true,
            'sortKey' => 'destination_url',
            'filter' => 'text',
            'filterKey' => 'destination_url',
        ],
        [
            'key' => 'default_short_url',
            'label' => 'Short URL',
            'width' => '400px',
            'sortable' => true,
            'sortKey' => 'default_short_url',
            'filter' => 'text',
            'filterKey' => 'default_short_url',
        ],
        [
            'key' => 'visits_count',
            'label' => 'Visitors',
            'width' => '180px',
            'sortable' => true,
            'sortKey' => 'visits_count',
            'filter' => 'custom',
            'filterHtml' => $visitsFilterHtml,
        ],
        [
            'key' => 'created_at',
            'label' => 'Created At',
            'width' => '225px',
            'sortable' => true,
            'sortKey' => 'created_at',
            'filter' => 'daterange',
            'filterKey' => 'created_at',
        ],
        [
            'key' => 'created_by',
            'label' => 'Creator',
            'width' => '120px',
            'sortable' => true,
            'sortKey' => 'created_by',
            'filter' => 'text',
            'filterKey' => 'created_by',
        ],
    ];

    // Column Widths for CSS
    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '60px',   // No
        3 => '300px',  // URL Key
        4 => '350px',  // URL Destination
        5 => '400px',  // Short URL
        6 => '180px',  // Visitors
        7 => '225px',  // Created At
        8 => '120px',  // Creator
        9 => '100px',  // Action
    ];

    // Extra Styles for visits dropdown
    $extraStyles = '
    .visits-dropdown {
        background-color: white;
        border: 1px solid #dee2e6;
        color: #495057;
        width: 100%;
        text-align: left;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 0.25rem;
        transition: all 0.2s ease;
        position: relative;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .visits-dropdown::after { position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); }
    .visits-dropdown:hover { background-color: #f8f9fa; }
    .visits-dropdown:focus { box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25); border-color: #00a79d; }
    .visits-dropdown-menu { min-width: 160px; max-width: 200px; border: 1px solid rgba(0, 0, 0, 0.1); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 0; }
    .visits-dropdown-menu .dropdown-header { font-size: 0.7rem; font-weight: 600; color: #00a79d; padding: 0.25rem 0.75rem; }
    .visits-dropdown-menu .dropdown-item { font-size: 0.75rem; padding: 0.35rem 0.75rem; color: #212529; transition: all 0.2s ease; white-space: normal; word-wrap: break-word; }
    .visits-dropdown-menu .dropdown-item:hover, .visits-dropdown-menu .dropdown-item:focus { background-color: #e0f7f5; color: #008b84; }
    .visits-dropdown-menu .dropdown-item.active { background-color: #00a79d; color: white; }
    .visits-dropdown-menu .dropdown-divider { margin: 0; border-color: #e9ecef; }
    ';

    // Extra Scripts for shortlink-specific functionality
    $extraScripts = "
    const baseUrl = window.location.origin;
    const shortenUrl = '" . route('admin.service.shortlink.shorten') . "';

    // Shorten Form Handler
    \$('#shortenForm').on('submit', function(e) {
        e.preventDefault();
        \$.ajax({
            url: shortenUrl,
            type: 'POST',
            data: \$(this).serialize(),
            success: function(response) {
                Toast.fire({ icon: 'success', title: response.message, showCloseButton: true, timer: 1500, width: '400px' });
                \$('#shortenForm')[0].reset();
                loadData();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (const field in errors) { errorMessages += errors[field].join('<br>') + '<br>'; }
                    Toast.fire({ icon: 'error', title: 'Validation Error', html: errorMessages, showCloseButton: true, timer: 4500, timerProgressBar: true, width: '500px' });
                } else {
                    Toast.fire({ icon: 'error', title: 'Error shortening URL', showCloseButton: true, timer: 4500, timerProgressBar: true, width: '500px' });
                }
            }
        });
    });

    // Edit Button Handler
    \$(document).on('click', '.edit-btn', function() {
        \$('#editId').val(\$(this).data('id'));
        \$('#editUrl').val(\$(this).data('url'));
        \$('#editDestination').val(\$(this).data('destination'));
        \$('#editModal').modal('show');
    });

    // Edit Form Handler
    \$('#editForm').on('submit', function(e) {
        e.preventDefault();
        const id = \$('#editId').val();
        \$.ajax({
            url: '/admin/service/shortlink/' + id,
            type: 'PUT',
            data: \$(this).serialize(),
            success: function(response) {
                Toast.fire({ icon: 'success', title: response.message, showCloseButton: true, timer: 1500, width: '400px' });
                loadData();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (const field in errors) { errorMessages += errors[field].join('<br>') + '<br>'; }
                    Toast.fire({ icon: 'error', title: 'Validation Error', html: errorMessages, showCloseButton: true, timer: 4500, timerProgressBar: true, width: '500px' });
                } else {
                    Toast.fire({ icon: 'error', title: 'Error updating URL', showCloseButton: true, timer: 4500, timerProgressBar: true, width: '500px' });
                }
            },
            complete: function() { \$('#editModal').modal('hide'); }
        });
    });

    // Copy Link Function
    window.copyLink = function(urlKey, withBaseUrl) {
        if (withBaseUrl === undefined) withBaseUrl = true;
        let fullLink;
        if (withBaseUrl) {
            const cleanBaseUrl = baseUrl.replace(/^(https?:\\/\\/)?(www\\.)?/i, '').replace(/\\/+\$/, '');
            fullLink = cleanBaseUrl + '/' + urlKey.replace(/^\\//, '');
        } else {
            fullLink = urlKey;
        }
        navigator.clipboard.writeText(fullLink).then(function() {
            Toast.fire({ icon: 'success', title: 'Copied to clipboard!', showCloseButton: true, timer: 1500, width: '400px' });
        }).catch(function(err) {
            Toast.fire({ icon: 'error', title: 'Failed to copy text', showCloseButton: true, timer: 3000 });
        });
    };

    // Visits Dropdown Handler
    \$(document).on('click', '.visits-option', function(e) {
        e.preventDefault();
        const range = \$(this).data('range');
        const label = \$(this).text().trim();
        \$('#visitsDropdownLabel').text(label.split(' ')[0] === 'All' ? 'All Visitors' : label);
        if (range) { currentParams.visits_range = range; } else { delete currentParams.visits_range; }
        loadData();
    });

    \$(document).on('shown.bs.dropdown', '#visitsDropdown', function() {
        const currentRange = currentParams.visits_range || '';
        \$('.visits-option').removeClass('active');
        \$('.visits-option[data-range=\"' + currentRange + '\"]').addClass('active');
    });

    // Date range filter for created_at
    \$('.daterangepicker-input').daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'DD-MM-YYYY',
            cancelLabel: 'Clear',
            applyLabel: 'Apply',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        },
        opens: 'right',
        drops: 'down'
    });

    \$('.daterangepicker-input').on('apply.daterangepicker', function(ev, picker) {
        \$(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        currentParams.created_at_start = picker.startDate.format('DD-MM-YYYY');
        currentParams.created_at_end = picker.endDate.format('DD-MM-YYYY');
        loadData();
    });

    \$('.daterangepicker-input').on('cancel.daterangepicker', function(ev, picker) {
        \$(this).val('');
        delete currentParams.created_at_start;
        delete currentParams.created_at_end;
        loadData();
    });

    // Override clear filters
    \$('#clearFiltersBtn').off('click').on('click', function() {
        currentParams = { sort_by: 'created_at', sort_order: 'desc', page: 1 };
        window.currentParams = currentParams;
        \$('.column-search').val('');
        \$('.daterangepicker-input').val('');
        \$('.column-search-clear').hide();
        \$('#visitsDropdownLabel').text('All Visitors');
        updateSortArrows();
        loadData();
    });
    ";
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Shortlink"
    pageIcon="fa-link"
    highlightedText="Shortlink System"
    :guideCards="$guideCards"
    :showAddButton="false"
    tableClass="table-shortlink"
    tableId="dataShortlinkTable"
    tableBodyId="shortlinkTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.service.shortlink.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/service/shortlink') }}"
    bulkDeleteUrl="{{ route('admin.service.shortlink.bulkDelete') }}"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="shortlinks"
    entityIcon="fa-link"
    paginationContainerId="paginationLinks"
    :includeModal="true"
    :extraStyles="$extraStyles"
    :extraScripts="$extraScripts"
    :isSuperadmin="$isSuperadmin"
>
    {{-- Slot: Before Table - Shorten Form --}}
    <x-slot name="beforeTable">
        <div class="col-md-12 mb-3">
            <form id="shortenForm">
                @csrf
                <div class="input-group">
                    <input type="text" name="url" class="form-control" placeholder="Enter URL to shorten">
                    <button class="btn btn-custom-primary" type="submit">Shorten</button>
                </div>
            </form>
        </div>
    </x-slot>

    {{-- Slot: Modals --}}
    <x-slot name="modals">
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header bg-gradient-primary text-white">
                        <h5 class="modal-title fw-semibold text-white">
                            <i class="fas fa-pencil-alt me-2"></i>Edit Shortlink
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="editForm">
                            @csrf
                            <input type="hidden" name="id" id="editId">
                            <div class="mb-4">
                                <label for="editUrl" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-key me-2 text-primary"></i>URL Key
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-link text-primary"></i></span>
                                    <input type="text" name="url" class="form-control border-start-0" id="editUrl" placeholder="e.g. yusuf">
                                </div>
                                <small class="text-muted mt-1 d-block">Customize your short URL identifier</small>
                            </div>
                            <div class="mb-4">
                                <label for="editDestination" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-external-link-alt me-2 text-primary"></i>Destination URL
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-globe text-primary"></i></span>
                                    <input type="text" name="destination" class="form-control border-start-0" id="editDestination" placeholder="e.g. https://example.com">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-index.template>
@endsection
