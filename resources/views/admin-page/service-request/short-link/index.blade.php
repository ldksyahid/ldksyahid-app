@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-link',
            'title' => 'Request Shortlinks',
            'description' => 'View all shortlink requests submitted by users. Edit to add the final custom link.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the dropdown filters to find requests by name, status, or date range.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view full request details and send WhatsApp notification.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to add or edit the fix custom link. Use <i class="fa fa-trash small text-danger"></i> to delete.'
        ],
    ];

    // Columns Config
    $columns = [
        [
            'key' => 'name',
            'label' => 'Full Name',
            'width' => '180px',
            'sortable' => true,
            'sortKey' => 'name',
            'filter' => 'select',
            'filterKey' => 'name',
            'options' => $nameOptions ?? [],
        ],
        [
            'key' => 'whatsapp',
            'label' => 'Whatsapp',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'whatsapp',
        ],
        [
            'key' => 'customLink',
            'label' => 'Custom Link',
            'width' => '180px',
            'sortable' => true,
            'sortKey' => 'customLink',
        ],
        [
            'key' => 'fixCustomLink',
            'label' => 'Fix Custom Link',
            'width' => '180px',
            'sortable' => false,
            'filter' => 'select',
            'filterKey' => 'status',
            'placeholder' => 'All Status',
            'options' => $statusOptions ?? [],
        ],
        [
            'key' => 'created_at',
            'label' => 'Date',
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
        3 => '180px',  // Full Name
        4 => '150px',  // Whatsapp
        5 => '180px',  // Custom Link
        6 => '180px',  // Fix Custom Link
        7 => '180px',  // Date
        8 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Request Shortlink Management"
    pageIcon="fa-link"
    highlightedText="Request Shortlink Management System"
    :guideCards="$guideCards"
    :showAddButton="false"
    tableClass="table-reqshortlinks"
    tableId="dataReqShortlinkTable"
    tableBodyId="reqshortlinkTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.reqservice.shortlink.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/reqservice/shortlink') }}"
    bulkDeleteUrl="{{ route('admin.reqservice.shortlink.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="request shortlinks"
    entityIcon="fa-link"
    dateRangeField="created_at"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
