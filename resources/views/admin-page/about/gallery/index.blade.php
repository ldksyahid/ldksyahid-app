@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add Gallery',
            'description' => 'Click the <strong>"Add Gallery"</strong> button to create a new gallery. Fill in the event name, theme, description, and upload photos.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the dropdown filters to find galleries by event name or theme.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete gallery details including all photos.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Bulk Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit gallery details. Only Superadmins can perform <i class="fa fa-trash small text-danger"></i> bulk delete.'
        ],
    ];

    // Columns Config
    $columns = [
        [
            'key' => 'eventName',
            'label' => 'Event Name',
            'width' => '250px',
            'sortable' => true,
            'sortKey' => 'eventName',
            'filter' => 'select',
            'filterKey' => 'eventName',
            'options' => $eventNameOptions ?? [],
        ],
        [
            'key' => 'eventTheme',
            'label' => 'Event Theme',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'eventTheme',
            'filter' => 'select',
            'filterKey' => 'eventTheme',
            'options' => $eventThemeOptions ?? [],
        ],
        [
            'key' => 'linkEmbedYoutube',
            'label' => 'Youtube Link',
            'width' => '200px',
            'sortable' => false,
            'filter' => 'text',
            'filterKey' => 'linkEmbedYoutube',
        ],
    ];

    // Column Widths for CSS
    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '250px',  // Event Name
        4 => '200px',  // Event Theme
        5 => '200px',  // Youtube Link
        6 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Gallery Management"
    pageIcon="fa-images"
    highlightedText="Gallery Management System"
    :guideCards="$guideCards"
    addButtonText="Add Gallery"
    addButtonRoute="admin.about.gallery.create"
    tableClass="table-galleries"
    tableId="dataGalleryTable"
    tableBodyId="galleryTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.about.gallery.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/about/gallery') }}"
    bulkDeleteUrl="{{ route('admin.about.gallery.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="galleries"
    entityIcon="fa-images"
    dateRangeField="created_at"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
