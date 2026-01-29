@extends('admin-page.template.body')

@php
    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add KTA',
            'description' => 'Click the <strong>"Add KTA"</strong> button to create a new KTA LDK Syahid member card.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the dropdown filters to find KTA by generation, faculty, or date range.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete KTA details.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Bulk Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit user details. Only Superadmins can perform <i class="fa fa-trash small text-danger"></i> bulk delete.'
        ],
    ];

    // Columns Config
    $columns = [
        [
            'key' => 'fullName',
            'label' => 'Full Name',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'fullName',
            'filter' => 'text',
            'filterKey' => 'fullName',
        ],
        [
            'key' => 'generation',
            'label' => 'Generation',
            'width' => '150px',
            'sortable' => false,
            'filter' => 'select',
            'filterKey' => 'generationID',
            'options' => $generationOptions ?? [],
        ],
        [
            'key' => 'memberNumber',
            'label' => 'Member Number',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'memberNumber',
        ],
        [
            'key' => 'linkProfile',
            'label' => 'Link Profile',
            'width' => '250px',
            'sortable' => false,
            'filter' => 'text',
            'filterKey' => 'linkProfile',
        ],
    ];

    // Column Widths for CSS
    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '200px',  // Full Name
        4 => '150px',  // Generation
        5 => '150px',  // Member Number
        6 => '250px',  // Link Profile
        7 => '130px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="KTA LDK Syahid Management"
    pageIcon="fa-id-card"
    highlightedText="KTA LDK Syahid Management System"
    :guideCards="$guideCards"
    addButtonText="Add KTA"
    addButtonRoute="admin.ktaldksyahid.create"
    tableClass="table-kta"
    tableId="dataKtaTable"
    tableBodyId="ktaTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.ktaldksyahid.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/ktaldksyahid') }}"
    bulkDeleteUrl="{{ route('admin.ktaldksyahid.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="KTA"
    entityIcon="fa-id-card"
    dateRangeField="created_at"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
