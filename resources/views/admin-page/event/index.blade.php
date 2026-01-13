@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add an Event',
            'description' => 'Click the <strong>"Add Event"</strong> button to create a new event. Fill in all required fields including title, division, and poster.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the search filters in each column to find events more precisely.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete event details including poster and registration info.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Bulk Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit event details. Only Superadmins can perform <i class="fa fa-trash small text-danger"></i> bulk delete.'
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
            'key' => 'division',
            'label' => 'Organizer',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'division',
            'filter' => 'select',
            'filterKey' => 'division',
            'placeholder' => 'All Organizers',
            'options' => $divisions->mapWithKeys(fn($div) => [$div => $div])->toArray(),
        ],
        [
            'key' => 'start',
            'label' => 'Event Date',
            'width' => '180px',
            'sortable' => true,
            'sortKey' => 'start',
            'filter' => 'daterange',
            'filterKey' => 'start_date',
        ],
        [
            'key' => 'linkRegist',
            'label' => 'Link Registration',
            'width' => '200px',
            'sortable' => false,
            'filter' => 'none',
        ],
    ];

    // Column Widths for CSS
    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '200px',  // Title
        4 => '150px',  // Organizer
        5 => '180px',  // Event Date
        6 => '200px',  // Link Registration
        7 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Event Management"
    pageIcon="fa-calendar-alt"
    highlightedText="Event Management System"
    :guideCards="$guideCards"
    addButtonText="Add Event"
    addButtonRoute="admin.event.create"
    tableClass="table-events"
    tableId="dataEventTable"
    tableBodyId="eventTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.event.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/event') }}"
    bulkDeleteUrl="{{ route('admin.event.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="events"
    entityIcon="fa-calendar-alt"
    dateRangeField="start_date"
    select2Field="division"
    select2Placeholder="All Organizers"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
