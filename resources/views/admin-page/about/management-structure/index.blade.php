@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add Structure',
            'description' => 'Click the <strong>"Add Structure"</strong> button to create a new organizational structure. Fill in the batch, period, structure name, description, and upload both logo and structure image.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the search filters to find structures by batch, period, or structure name.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete structure details including logo and structure image.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Bulk Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit structure details. Only Superadmins can perform <i class="fa fa-trash small text-danger"></i> bulk delete.'
        ],
    ];

    // Columns Config
    $columns = [
        [
            'key' => 'batch',
            'label' => 'Batch',
            'width' => '120px',
            'sortable' => true,
            'sortKey' => 'batch',
            'filter' => 'text',
            'filterKey' => 'batch',
        ],
        [
            'key' => 'period',
            'label' => 'Period',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'period',
            'filter' => 'text',
            'filterKey' => 'period',
        ],
        [
            'key' => 'structureName',
            'label' => 'Structure Name',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'structureName',
            'filter' => 'text',
            'filterKey' => 'structureName',
        ],
        [
            'key' => 'created_at',
            'label' => 'Created At',
            'width' => '150px',
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
        3 => '120px',  // Batch
        4 => '150px',  // Period
        5 => '200px',  // Structure Name
        6 => '150px',  // Created At
        7 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Structure Management"
    pageIcon="fa-sitemap"
    highlightedText="Organizational Structure System"
    :guideCards="$guideCards"
    addButtonText="Add Structure"
    addButtonRoute="admin.about.structure.create"
    tableClass="table-structure"
    tableId="dataStructureTable"
    tableBodyId="structureTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.about.structure.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/about/structure') }}"
    bulkDeleteUrl="{{ route('admin.about.structure.bulk-delete') }}"
    :includeSelect2="false"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="structure"
    entityIcon="fa-sitemap"
    dateRangeField="created_at"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
