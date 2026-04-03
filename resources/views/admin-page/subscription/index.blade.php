@extends('admin-page.template.body')

@php
    $guideCards = [
        [
            'icon'        => 'fa-plus-circle',
            'title'       => 'Add Subscribers',
            'description' => 'Click <strong>"Add Subscriber"</strong> to add one or more emails at once. Separate each email with a new line.',
        ],
        [
            'icon'        => 'fa-search',
            'title'       => 'Filter & Search',
            'description' => 'Use column filters to search by email or active/inactive status.',
        ],
        [
            'icon'        => 'fa-eye',
            'title'       => 'View & Edit',
            'description' => 'Click <i class="fa fa-eye small"></i> to view details and edit the subscriber\'s email and status.',
        ],
        [
            'icon'        => 'fa-trash',
            'title'       => 'Delete',
            'description' => 'Delete subscribers one by one or select multiple and delete in bulk (Superadmin only).',
        ],
    ];

    $columns = [
        [
            'key'       => 'email',
            'label'     => 'Email',
            'width'     => '300px',
            'sortable'  => true,
            'sortKey'   => 'email',
            'filter'    => 'text',
            'filterKey' => 'email',
        ],
        [
            'key'         => 'flagActive',
            'label'       => 'Status',
            'width'       => '120px',
            'sortable'    => true,
            'sortKey'     => 'flagActive',
            'filter'      => 'select',
            'filterKey'   => 'flagActive',
            'placeholder' => 'All Status',
            'options'     => ['1' => 'Active', '0' => 'Inactive'],
        ],
        [
            'key'       => 'subscribedDate',
            'label'     => 'Subscribed Date',
            'width'     => '160px',
            'sortable'  => true,
            'sortKey'   => 'subscribedDate',
            'filter'    => 'daterange',
            'filterKey' => 'subscribedDate',
        ],
    ];

    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '300px',  // Email
        4 => '120px',  // Status
        5 => '160px',  // Subscribed Date
        6 => '100px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Subscription Management"
    pageIcon="fa-envelope"
    highlightedText="Subscriber Management"
    :guideCards="$guideCards"
    addButtonText="Add Subscriber"
    addButtonRoute="admin.subscription.create"
    tableClass="table-subscription"
    tableId="dataSubscriptionTable"
    tableBodyId="subscriptionTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.subscription.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/subscription') }}"
    bulkDeleteUrl="{{ route('admin.subscription.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="createdDate"
    defaultSortOrder="desc"
    entityName="subscriber"
    entityIcon="fa-envelope"
    dateRangeField="subscribedDate"
    select2Field="flagActive"
    select2Placeholder="All Status"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
