@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add Testimony',
            'description' => 'Click the <strong>"Add Testimony"</strong> button to create a new testimony. Fill in the name, profession, and testimony content.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the search filters to find testimonies by name or profession.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete testimony details including the profile picture.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Bulk Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit testimony details. Only Superadmins can perform <i class="fa fa-trash small text-danger"></i> bulk delete.'
        ],
    ];

    // Columns Config
    $columns = [
        [
            'key' => 'name',
            'label' => 'Name',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'name',
            'filter' => 'text',
            'filterKey' => 'name',
        ],
        [
            'key' => 'profession',
            'label' => 'Profession',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'profession',
            'filter' => 'text',
            'filterKey' => 'profession',
        ],
        [
            'key' => 'created_at',
            'label' => 'Created At',
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
        3 => '200px',  // Name
        4 => '200px',  // Profession
        5 => '180px',  // Created At
        6 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Testimony Management"
    pageIcon="fa-comments"
    highlightedText="Testimony Management System"
    :guideCards="$guideCards"
    addButtonText="Add Testimony"
    addButtonRoute="admin.testimony.create"
    tableClass="table-testimonies"
    tableId="dataTestimonyTable"
    tableBodyId="testimonyTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.testimony.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/testimony') }}"
    bulkDeleteUrl="{{ route('admin.testimony.bulk-delete') }}"
    :includeSelect2="false"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="testimonies"
    entityIcon="fa-comments"
    dateRangeField="created_at"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
