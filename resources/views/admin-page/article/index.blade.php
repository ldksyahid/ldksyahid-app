@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add Article',
            'description' => 'Click the <strong>"Add Article"</strong> button to create a new article. Fill in the title, theme, writer, editor, and upload the poster.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the search filters to find articles by title, theme, writer, or editor.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete article details including the anyflip embed link.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit article details. Use <i class="fa fa-trash small text-danger"></i> to delete.'
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
            'key' => 'theme',
            'label' => 'Theme',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'theme',
            'filter' => 'text',
            'filterKey' => 'theme',
        ],
        [
            'key' => 'dateevent',
            'label' => 'Publish Date',
            'width' => '180px',
            'sortable' => true,
            'sortKey' => 'dateevent',
            'filter' => 'daterange',
            'filterKey' => 'dateevent',
        ],
        [
            'key' => 'writer',
            'label' => 'Writer',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'writer',
            'filter' => 'text',
            'filterKey' => 'writer',
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
        3 => '200px',  // Title
        4 => '150px',  // Theme
        5 => '180px',  // Publish Date
        6 => '150px',  // Writer
        7 => '150px',  // Editor
        8 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Article Management"
    pageIcon="fa-newspaper"
    highlightedText="Article Management System"
    :guideCards="$guideCards"
    addButtonText="Add Article"
    addButtonRoute="admin.article.create"
    tableClass="table-articles"
    tableId="dataArticleTable"
    tableBodyId="articleTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.article.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/article') }}"
    bulkDeleteUrl="{{ route('admin.article.bulk-delete') }}"
    :includeSelect2="false"
    defaultSortBy="dateevent"
    defaultSortOrder="desc"
    entityName="articles"
    entityIcon="fa-newspaper"
    dateRangeField="dateevent"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
