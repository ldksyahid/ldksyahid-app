@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.comment.components._index._index-styles')
@endsection

@php
    $guideCards = [
        [
            'icon'        => 'fa-comments',
            'title'       => 'Comment List',
            'description' => 'View all top-level comments posted across all content types (Article, News, Event, Book Catalog).',
        ],
        [
            'icon'        => 'fa-search',
            'title'       => 'Search & Filter',
            'description' => 'Filter comments by content type, media type, or date range. Use the search box to find by text or username.',
        ],
        [
            'icon'        => 'fa-eye',
            'title'       => 'View Detail',
            'description' => 'Click <i class="fa fa-eye small"></i> to view the full comment including replies and reactions.',
        ],
        [
            'icon'        => 'fa-trash',
            'title'       => 'Delete',
            'description' => 'Delete a comment with <i class="fa fa-trash small text-danger"></i>. This also removes all replies, reactions, and attached media from Google Drive.',
        ],
    ];

    $columns = [
        [
            'key'       => 'user.name',
            'label'     => 'User',
            'width'     => '160px',
            'sortable'  => false,
            'filter'    => 'text',
            'filterKey' => 'search',
        ],
        [
            'key'         => 'contentType',
            'label'       => 'Content Type',
            'width'       => '140px',
            'sortable'    => true,
            'sortKey'     => 'contentType',
            'filter'      => 'select',
            'filterKey'   => 'contentType',
            'placeholder' => 'All Types',
            'options'     => $contentTypeOptions ?? [],
        ],
        [
            'key'      => 'commentText',
            'label'    => 'Comment',
            'width'    => '280px',
            'sortable' => false,
        ],
        [
            'key'         => 'mediaType',
            'label'       => 'Media',
            'width'       => '110px',
            'sortable'    => false,
            'filter'      => 'select',
            'filterKey'   => 'mediaType',
            'placeholder' => 'All Media',
            'options'     => $mediaTypeOptions ?? [],
        ],
        [
            'key'       => 'createdDate',
            'label'     => 'Date',
            'width'     => '175px',
            'sortable'  => true,
            'sortKey'   => 'createdDate',
            'filter'    => 'daterange',
            'filterKey' => 'createdDate',
        ],
    ];

    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '160px',  // User
        4 => '140px',  // Content Type
        5 => '280px',  // Comment
        6 => '110px',  // Media
        7 => '175px',  // Date
        8 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Comment Control Center"
    pageIcon="fa-comments"
    highlightedText="Comment Control Center"
    :guideCards="$guideCards"
    :showAddButton="false"
    tableClass="table-comments"
    tableId="dataCommentTable"
    tableBodyId="commentTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.comments.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/comments') }}"
    bulkDeleteUrl="{{ route('admin.comments.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="createdDate"
    defaultSortOrder="desc"
    entityName="comments"
    entityIcon="fa-comments"
    dateRangeField="createdDate"
    :isSuperadmin="$isSuperadmin"
/>
@endsection

@section('scripts')
    @include('admin-page.comment.components._index._index-scripts')
@endsection
