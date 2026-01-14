@extends('admin-page.template.body')

@php
    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-magic',
            'title' => 'How to Create a Shortlink',
            'description' => 'Enter the complete URL you wish to shorten, click "<strong>Shorten</strong>", and afterward, feel free to edit the shortlink according to your needs.'
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

    // Columns Config
    $columns = [
        [
            'key' => 'urlKey',
            'label' => 'URL Key',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'url_key',
            'filter' => 'text',
            'filterKey' => 'url_key',
        ],
        [
            'key' => 'destinationUrl',
            'label' => 'URL Destination',
            'width' => '250px',
            'sortable' => true,
            'sortKey' => 'destination_url',
            'filter' => 'text',
            'filterKey' => 'destination_url',
        ],
        [
            'key' => 'shortUrl',
            'label' => 'Short URL',
            'width' => '250px',
            'sortable' => true,
            'sortKey' => 'default_short_url',
            'filter' => 'text',
            'filterKey' => 'default_short_url',
        ],
        [
            'key' => 'visits',
            'label' => 'Visitors',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'visits_count',
            'filter' => 'select',
            'filterKey' => 'visits_range',
            'placeholder' => 'All Visitors',
            'options' => [
                '0-10' => '0 - 10 visitors',
                '11-50' => '11 - 50 visitors',
                '51-100' => '51 - 100 visitors',
                '101-500' => '101 - 500 visitors',
                '501-1000' => '501 - 1000 visitors',
                '1001+' => '1000+ visitors',
            ],
        ],
        [
            'key' => 'createdAt',
            'label' => 'Created At',
            'width' => '180px',
            'sortable' => true,
            'sortKey' => 'created_at',
            'filter' => 'daterange',
            'filterKey' => 'created_at',
        ],
        [
            'key' => 'createdBy',
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
        2 => '50px',   // No
        3 => '200px',  // URL Key
        4 => '250px',  // URL Destination
        5 => '250px',  // Short URL
        6 => '150px',  // Visitors
        7 => '180px',  // Created At
        8 => '120px',  // Creator
        9 => '100px',  // Action
    ];

    // Extra Styles
    $extraStyles = '
        /* Modal Styles */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #00a79d 0%, #008b84 100%);
        }
    ';
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Shortlink"
    pageIcon="fa-link"
    highlightedText="Shortlink System"
    :guideCards="$guideCards"
    :showAddButton="false"
    tableClass="table-shortlinks"
    tableId="dataShortlinkTable"
    tableBodyId="shortlinkTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.service.shortlink.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/service/shortlink') }}"
    bulkDeleteUrl="{{ route('admin.service.shortlink.bulkDelete') }}"
    :includeSelect2="true"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="shortlinks"
    entityIcon="fa-link"
    dateRangeField="created_at"
    select2Field="visits_range"
    select2Placeholder="All Visitors"
    :isSuperadmin="$isSuperadmin"
    :extraStyles="$extraStyles"
>
    {{-- Shorten Form --}}
    <x-slot name="beforeTable">
        <div class="col-md-12">
            <form id="shortenForm">
                @csrf
                <div class="input-group">
                    <input type="text" name="url" class="form-control" placeholder="Enter URL to shorten">
                    <button class="btn btn-custom-primary" type="submit">Shorten</button>
                </div>
            </form>
        </div>
    </x-slot>

    {{-- Edit Modal --}}
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
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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

@push('scripts')
<script>
$(document).ready(function() {
    const baseUrl = '{{ url('/') }}';

    // Shorten form
    $('#shortenForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("admin.service.shortlink.shorten") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Toast.fire({ icon: 'success', title: response.message });
                $('#shortenForm')[0].reset();
                loadData();
            },
            error: function(xhr) {
                var msg = xhr.responseJSON?.errors?.url?.[0] || 'Error shortening URL';
                Toast.fire({ icon: 'error', title: msg });
            }
        });
    });

    // Edit button handler
    $(document).on('click', '.edit-btn', function() {
        $('#editId').val($(this).data('id'));
        $('#editUrl').val($(this).data('url'));
        $('#editDestination').val($(this).data('destination'));
        $('#editModal').modal('show');
    });

    // Edit form
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '/admin/service/shortlink/' + $('#editId').val(),
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                Toast.fire({ icon: 'success', title: response.message });
                $('#editModal').modal('hide');
                loadData();
            },
            error: function(xhr) {
                var errors = xhr.responseJSON?.errors;
                var msg = errors ? Object.values(errors).flat().join('<br>') : 'Error updating URL';
                Toast.fire({ icon: 'error', title: 'Validation Error', html: msg });
            }
        });
    });

    // Copy link function
    window.copyLink = function(urlKey, withBaseUrl) {
        if (withBaseUrl === undefined) withBaseUrl = true;
        var link = withBaseUrl ? baseUrl.replace(/^https?:\/\/(www\.)?/, '').replace(/\/$/, '') + '/' + urlKey : urlKey;
        navigator.clipboard.writeText(link).then(function() {
            Toast.fire({ icon: 'success', title: 'Copied to clipboard!' });
        });
    };
});
</script>
@endpush
