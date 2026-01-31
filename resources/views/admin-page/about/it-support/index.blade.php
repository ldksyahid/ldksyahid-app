@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add IT Support',
            'description' => 'Click the <strong>"Add IT Support"</strong> button to create a new IT Support member. Fill in name, forkat, position, photo, and social links.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the dropdown filters to find IT Support members by forkat or position.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete IT Support details including photo and social links.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Bulk Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit details. Only Superadmins can perform <i class="fa fa-trash small text-danger"></i> bulk delete.'
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
            'filter' => 'text',
            'filterKey' => 'name',
        ],
        [
            'key' => 'forkat',
            'label' => 'Forkat',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'forkat',
            'filter' => 'select',
            'filterKey' => 'forkat',
            'options' => $forkatOptions ?? [],
        ],
        [
            'key' => 'position',
            'label' => 'Position',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'position',
            'filter' => 'select',
            'filterKey' => 'position',
            'options' => $positionOptions ?? [],
        ],
        [
            'key' => 'linkInstagram',
            'label' => 'Instagram',
            'width' => '180px',
            'sortable' => false,
            'filter' => 'text',
            'filterKey' => 'linkInstagram',
        ],
        [
            'key' => 'linkLinkedin',
            'label' => 'Linkedin',
            'width' => '180px',
            'sortable' => false,
            'filter' => 'text',
            'filterKey' => 'linkLinkedin',
        ],
    ];

    // Column Widths for CSS
    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '180px',  // Name
        4 => '150px',  // Forkat
        5 => '150px',  // Position
        6 => '180px',  // Instagram
        7 => '180px',  // Linkedin
        8 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="IT Support Management"
    pageIcon="fa-headset"
    highlightedText="IT Support Management System"
    :guideCards="$guideCards"
    addButtonText="Add IT Support"
    addButtonRoute="admin.about.itsupport.create"
    tableClass="table-itsupport"
    tableId="dataITSupportTable"
    tableBodyId="itsupportTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.about.itsupport.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/about/itsupport') }}"
    bulkDeleteUrl="{{ route('admin.about.itsupport.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="itsupports"
    entityIcon="fa-headset"
    dateRangeField="created_at"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
