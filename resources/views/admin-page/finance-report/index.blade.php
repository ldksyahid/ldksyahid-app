@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add a Report',
            'description' => 'Click the <strong>"Add Report"</strong> button to add a new finance report. Fill in all required fields including file name and select LDK.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the search filters in each column to find reports more precisely.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete report details including file information and LDK details.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Bulk Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit report details. Only Superadmins can perform <i class="fa fa-trash small text-danger"></i> bulk delete.'
        ],
    ];

    // Columns Config
    $columns = [
        [
            'key' => 'createdDate',
            'label' => 'Created Date',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'createdDate',
            'filter' => 'daterange',
            'filterKey' => 'created_date',
        ],
        [
            'key' => 'fileName',
            'label' => 'File Name',
            'width' => '250px',
            'sortable' => true,
            'sortKey' => 'fileName',
            'filter' => 'text',
            'filterKey' => 'file_name',
        ],
        [
            'key' => 'ldkTag',
            'label' => 'Tag',
            'width' => '150px',
            'sortable' => false,
            'filter' => 'select',
            'filterKey' => 'ldk_tag',
            'placeholder' => 'All Tags',
            'options' => $ldkTags->mapWithKeys(fn($tag) => [$tag => $tag])->toArray(),
        ],
    ];

    // Column Widths for CSS
    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '150px',  // Created Date
        4 => '250px',  // File Name
        5 => '150px',  // Tag
        6 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Finance Report"
    pageIcon="fa-file-invoice-dollar"
    highlightedText="Finance Report System"
    :guideCards="$guideCards"
    addButtonText="Add Report"
    addButtonRoute="admin.finance-report.create"
    tableClass="table-reports"
    tableId="dataReportTable"
    tableBodyId="reportTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.finance-report.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/finance-report') }}"
    bulkDeleteUrl="{{ route('admin.finance-report.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="createdDate"
    defaultSortOrder="desc"
    entityName="reports"
    entityIcon="fa-file-invoice-dollar"
    dateRangeField="created_date"
    select2Field="ldk_tag"
    select2Placeholder="All Tags"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
