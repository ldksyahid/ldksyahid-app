@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add Call Kestari',
            'description' => 'Click the <strong>"Add Call Kestari"</strong> button to create a new call kestari entry. Fill in all required fields including button name and link.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the search filters in each column to find call kestari more precisely.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete call kestari details including link and appear status.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Bulk Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit call kestari details. Only Superadmins can perform <i class="fa fa-trash small text-danger"></i> bulk delete.'
        ],
    ];

    // Columns Config
    $columns = [
        [
            'key' => 'buttonName',
            'label' => 'Button Name',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'buttonName',
            'filter' => 'text',
            'filterKey' => 'buttonName',
        ],
        [
            'key' => 'link',
            'label' => 'Link',
            'width' => '300px',
            'sortable' => true,
            'sortKey' => 'link',
            'filter' => 'text',
            'filterKey' => 'link',
        ],
        [
            'key' => 'created_at',
            'label' => 'Created Date',
            'width' => '180px',
            'sortable' => true,
            'sortKey' => 'created_at',
            'filter' => 'daterange',
            'filterKey' => 'created_at',
        ],
    ];

    // Column Widths for CSS
    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '150px',  // Button Name
        4 => '300px',  // Link
        5 => '180px',  // Created Date
        6 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Call Kestari"
    pageIcon="fa-phone"
    highlightedText="Call Kestari Management"
    :guideCards="$guideCards"
    addButtonText="Add Call Kestari"
    addButtonRoute="admin.service.callkestari.create"
    tableClass="table-callkestari"
    tableId="dataCallKestariTable"
    tableBodyId="callKestariTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.service.callkestari.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/service/callkestari') }}"
    bulkDeleteUrl="{{ route('admin.service.callkestari.bulk-delete') }}"
    :includeSelect2="false"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="call kestari"
    entityIcon="fa-phone"
    dateRangeField="created_at"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
