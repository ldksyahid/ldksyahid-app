@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add Schedule',
            'description' => 'Click the <strong>"Add Schedule"</strong> button to create a new schedule. Fill in the title, month, year, and upload the image.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the search filters to find schedules by title, month, or year.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete schedule details including the image.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Bulk Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit schedule details. Only Superadmins can perform <i class="fa fa-trash small text-danger"></i> bulk delete.'
        ],
    ];

    // Columns Config
    $columns = [
        [
            'key' => 'title',
            'label' => 'Title',
            'width' => '250px',
            'sortable' => true,
            'sortKey' => 'title',
            'filter' => 'text',
            'filterKey' => 'title',
        ],
        [
            'key' => 'month',
            'label' => 'Month',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'month',
            'filter' => 'select',
            'filterKey' => 'month',
            'placeholder' => 'All Months',
            'options' => $monthOptions,
        ],
        [
            'key' => 'year',
            'label' => 'Year',
            'width' => '100px',
            'sortable' => true,
            'sortKey' => 'year',
            'filter' => 'select',
            'filterKey' => 'year',
            'placeholder' => 'All Years',
            'options' => $yearOptions,
        ],
    ];

    // Column Widths for CSS
    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '250px',  // Title
        4 => '150px',  // Month
        5 => '100px',  // Year
        6 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Schedule Management"
    pageIcon="fa-calendar-alt"
    highlightedText="Schedule Management System"
    :guideCards="$guideCards"
    addButtonText="Add Schedule"
    addButtonRoute="admin.schedule.create"
    tableClass="table-schedules"
    tableId="dataScheduleTable"
    tableBodyId="scheduleTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.schedule.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/schedule') }}"
    bulkDeleteUrl="{{ route('admin.schedule.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="schedules"
    entityIcon="fa-calendar-alt"
    dateRangeField="created_at"
    select2Field="month"
    select2Placeholder="All Months"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
