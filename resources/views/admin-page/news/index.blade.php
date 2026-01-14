@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add News',
            'description' => 'Click the <strong>"Add News"</strong> button to create a new news article. Fill in the title, date, publisher, reporter, editor, and upload the featured image.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the search filters to find news by title, publisher, reporter, or editor.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete news details including the full article content.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit news details. Use <i class="fa fa-trash small text-danger"></i> to delete.'
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
            'key' => 'datepublish',
            'label' => 'Date Publish',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'datepublish',
            'filter' => 'date',
            'filterKey' => 'datepublish',
        ],
        [
            'key' => 'publisher',
            'label' => 'Publisher',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'publisher',
            'filter' => 'text',
            'filterKey' => 'publisher',
        ],
        [
            'key' => 'reporter',
            'label' => 'Reporter',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'reporter',
            'filter' => 'text',
            'filterKey' => 'reporter',
        ],
        [
            'key' => 'editor',
            'label' => 'Editor',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'editor',
            'filter' => 'text',
            'filterKey' => 'editor',
        ],
    ];

    // Column Widths for CSS
    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '250px',  // Title
        4 => '150px',  // Date Publish
        5 => '150px',  // Publisher
        6 => '150px',  // Reporter
        7 => '150px',  // Editor
        8 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="News Management"
    pageIcon="fa-newspaper"
    highlightedText="News Management System"
    :guideCards="$guideCards"
    addButtonText="Add News"
    addButtonRoute="admin.news.create"
    tableClass="table-news"
    tableId="dataNewsTable"
    tableBodyId="newsTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.news.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/news') }}"
    bulkDeleteUrl="{{ route('admin.news.bulk-delete') }}"
    :includeSelect2="false"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="news"
    entityIcon="fa-newspaper"
    dateRangeField="created_at"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
