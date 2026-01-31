@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-envelope',
            'title' => 'Contact Messages',
            'description' => 'View all contact messages submitted by visitors through the contact form.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the dropdown filters to find messages by sender name or subject.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view the complete message details.'
        ],
        [
            'icon' => 'fa-trash',
            'title' => 'Delete Messages',
            'description' => 'Use <i class="fa fa-trash small text-danger"></i> to delete messages. Superadmins can perform bulk delete.'
        ],
    ];

    // Columns Config
    $columns = [
        [
            'key' => 'name',
            'label' => 'Name',
            'width' => '180px',
            'sortable' => true,
            'sortKey' => 'name',
            'filter' => 'select',
            'filterKey' => 'name',
            'options' => $nameOptions ?? [],
        ],
        [
            'key' => 'email',
            'label' => 'Email',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'email',
            'filter' => 'text',
            'filterKey' => 'email',
        ],
        [
            'key' => 'subject',
            'label' => 'Subject',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'subject',
            'filter' => 'select',
            'filterKey' => 'subject',
            'options' => $subjectOptions ?? [],
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
        3 => '180px',  // Name
        4 => '200px',  // Email
        5 => '200px',  // Subject
        6 => '180px',  // Date
        7 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Contact Message Management"
    pageIcon="fa-envelope"
    highlightedText="Contact Message Management System"
    :guideCards="$guideCards"
    :showAddButton="false"
    tableClass="table-messages"
    tableId="dataMessageTable"
    tableBodyId="messageTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.about.contact.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/about/contact/message') }}"
    bulkDeleteUrl="{{ route('admin.about.contact.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="messages"
    entityIcon="fa-envelope"
    dateRangeField="created_at"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
