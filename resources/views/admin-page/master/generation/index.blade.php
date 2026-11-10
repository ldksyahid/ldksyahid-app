@extends('admin-page.template.body')

@php
    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add Generation',
            'description' => 'Click the <strong>"Add Generation"</strong> button to register a new batch year and name.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search & Filter',
            'description' => 'Quickly find generations by typing into the column search inputs below the table headers.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit Generation',
            'description' => 'Click <i class="fa fa-edit small text-primary"></i> on any row to modify its year or generation name in a popup modal.'
        ],
        [
            'icon' => 'fa-trash',
            'title' => 'Delete Generation',
            'description' => 'Delete an unused generation safely. Generations linked to KTA members are protected from deletion.'
        ],
    ];

    // Columns Config
    $columns = [
        [
            'key' => 'year',
            'label' => 'Year',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'year',
            'filter' => 'text',
            'filterKey' => 'year',
        ],
        [
            'key' => 'generationName',
            'label' => 'Generation Name',
            'width' => 'auto',
            'sortable' => true,
            'sortKey' => 'generationName',
            'filter' => 'text',
            'filterKey' => 'generationName',
        ],
    ];

    // Column Widths for CSS
    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '200px',  // Year
        4 => 'auto',   // Generation Name
        5 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Master Generation"
    pageIcon="fa-database"
    highlightedText="Master Generation"
    :guideCards="$guideCards"
    :showAddButton="false"
    tableClass="table-generation"
    tableId="dataGenerationTable"
    tableBodyId="generationTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.master.generation.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/master/generation') }}"
    bulkDeleteUrl="{{ route('admin.master.generation.bulk-delete') }}"
    :includeSelect2="false"
    defaultSortBy="year"
    defaultSortOrder="desc"
    entityName="generations"
    entityIcon="fa-graduation-cap"
    :isSuperadmin="$isSuperadmin"
>
    {{-- Left Action Buttons --}}
    <x-slot name="leftButtons">
        <button type="button" class="btn btn-custom-primary" data-bs-toggle="modal" data-bs-target="#createGenerationModal">
            <i class="fa fa-plus me-1"></i> Add Generation
        </button>
    </x-slot>

    {{-- Modals --}}
    <x-slot name="modals">
        {{-- Create Generation Modal --}}
        <div class="modal fade" id="createGenerationModal" tabindex="-1" aria-labelledby="createGenerationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-custom-primary text-white">
                        <h5 class="modal-title" id="createGenerationModalLabel">
                            <i class="fa fa-plus-circle me-2"></i>Add New Generation
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="createGenerationForm">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label for="createYear" class="form-label fw-bold">
                                    Year <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="year" id="createYear" class="form-control" placeholder="e.g. 2026" required min="1990" max="2100">
                                <small class="text-muted">Enter the 4-digit intake/cohort year.</small>
                            </div>
                            <div class="mb-3">
                                <label for="createGenerationName" class="form-label fw-bold">
                                    Generation Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="generationName" id="createGenerationName" class="form-control" placeholder="e.g. Ar-Rahman, Al-Hadid" required maxlength="100">
                                <small class="text-muted">Name of the generation (e.g. surah name or cohort theme).</small>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fa fa-times me-1"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-custom-primary">
                                <i class="fa fa-save me-1"></i> Save Generation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit Generation Modal --}}
        <div class="modal fade" id="editGenerationModal" tabindex="-1" aria-labelledby="editGenerationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-custom-primary text-white">
                        <h5 class="modal-title" id="editGenerationModalLabel">
                            <i class="fa fa-edit me-2"></i>Edit Generation
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editGenerationForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editGenerationId" name="id">
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label for="editYear" class="form-label fw-bold">
                                    Year <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="year" id="editYear" class="form-control" required min="1990" max="2100">
                                <small class="text-muted">Enter the 4-digit intake/cohort year.</small>
                            </div>
                            <div class="mb-3">
                                <label for="editGenerationName" class="form-label fw-bold">
                                    Generation Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="generationName" id="editGenerationName" class="form-control" required maxlength="100">
                                <small class="text-muted">Name of the generation (e.g. surah name or cohort theme).</small>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fa fa-times me-1"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-custom-primary">
                                <i class="fa fa-save me-1"></i> Update Generation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-index.template>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Open Edit Modal with row data
    $(document).on('click', '.edit-btn', function() {
        const id   = $(this).data('id');
        const year = $(this).data('year');
        const name = $(this).data('name');

        $('#editGenerationId').val(id);
        $('#editYear').val(year);
        $('#editGenerationName').val(name);

        $('#editGenerationModal').modal('show');
    });

    // Handle Create Generation Form Submit (AJAX)
    $('#createGenerationForm').on('submit', function(e) {
        e.preventDefault();
        const $btn = $(this).find('button[type="submit"]');
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Saving...');

        $.ajax({
            url: "{{ route('admin.master.generation.store') }}",
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#createGenerationModal').modal('hide');
                $('#createGenerationForm')[0].reset();
                if (window.Toast) {
                    Toast.fire({ icon: 'success', title: response.message || 'Generation created successfully.' });
                }
                if (typeof window.loadData === 'function') {
                    window.loadData();
                }
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || xhr.responseJSON?.errors?.year?.[0] || xhr.responseJSON?.errors?.generationName?.[0] || 'Failed to create generation.';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg
                });
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    });

    // Handle Edit Generation Form Submit (AJAX)
    $('#editGenerationForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editGenerationId').val();
        const $btn = $(this).find('button[type="submit"]');
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Updating...');

        $.ajax({
            url: "{{ url('admin/master/generation') }}/" + id + "/update",
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#editGenerationModal').modal('hide');
                if (window.Toast) {
                    Toast.fire({ icon: 'success', title: response.message || 'Generation updated successfully.' });
                }
                if (typeof window.loadData === 'function') {
                    window.loadData();
                }
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || xhr.responseJSON?.errors?.year?.[0] || xhr.responseJSON?.errors?.generationName?.[0] || 'Failed to update generation.';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg
                });
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    });
});
</script>
@endpush
