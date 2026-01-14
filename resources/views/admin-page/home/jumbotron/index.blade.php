@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add Jumbotron',
            'description' => 'Click the <strong>"Add Jumbotron"</strong> button to create a new jumbotron slide. Upload an image and optionally add a button.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the search filters to find jumbotrons by title or button name.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete jumbotron details including the image preview.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit jumbotron details. Use <i class="fa fa-trash small text-danger"></i> to delete.'
        ],
    ];

    // Columns Config
    $columns = [
        [
            'key' => 'title',
            'label' => 'Title',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'title',
            'filter' => 'text',
            'filterKey' => 'title',
        ],
        [
            'key' => 'btnname',
            'label' => 'Button Name',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'btnname',
            'filter' => 'text',
            'filterKey' => 'btnname',
        ],
        [
            'key' => 'btnlink',
            'label' => 'Button Link',
            'width' => '200px',
            'sortable' => false,
            'filter' => 'none',
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
        3 => '200px',  // Title
        4 => '150px',  // Button Name
        5 => '200px',  // Button Link
        6 => '180px',  // Created At
        7 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Jumbotron Management"
    pageIcon="fa-images"
    highlightedText="Jumbotron Management System"
    :guideCards="$guideCards"
    addButtonText="Add Jumbotron"
    addButtonRoute="admin.jumbotron.create"
    tableClass="table-jumbotrons"
    tableId="dataJumbotronTable"
    tableBodyId="jumbotronTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.jumbotron.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/jumbotron') }}"
    bulkDeleteUrl="{{ route('admin.jumbotron.bulk-delete') }}"
    :includeSelect2="false"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="jumbotrons"
    entityIcon="fa-images"
    dateRangeField="created_at"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
