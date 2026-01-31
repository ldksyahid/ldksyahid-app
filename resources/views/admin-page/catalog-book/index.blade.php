@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add a Book',
            'description' => 'Click the <strong>"Add Book"</strong> button to add a new book to the catalog. Fill in all required fields including title, author, and ISBN.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the search filters in each column to find books more precisely.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete book details including description, cover image, and additional metadata.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit book details (available for all roles). Only Superadmins are allowed to perform <i class="fa fa-trash small text-danger"></i> bulk delete.'
        ],
    ];

    // Columns Config
    $columns = [
        [
            'key' => 'createdDate',
            'label' => 'Added Date',
            'width' => '120px',
            'sortable' => true,
            'sortKey' => 'createdDate',
            'filter' => 'daterange',
            'filterKey' => 'added_date',
        ],
        [
            'key' => 'isbn',
            'label' => 'ISBN',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'isbn',
            'filter' => 'text',
            'filterKey' => 'isbn',
        ],
        [
            'key' => 'titleBook',
            'label' => 'Title',
            'width' => '250px',
            'sortable' => true,
            'sortKey' => 'titleBook',
            'filter' => 'text',
            'filterKey' => 'title',
        ],
        [
            'key' => 'authorName',
            'label' => 'Author',
            'width' => '180px',
            'sortable' => true,
            'sortKey' => 'authorName',
            'filter' => 'text',
            'filterKey' => 'author',
        ],
        [
            'key' => 'publisherName',
            'label' => 'Publisher',
            'width' => '180px',
            'sortable' => true,
            'sortKey' => 'publisherName',
            'filter' => 'text',
            'filterKey' => 'publisher',
        ],
        [
            'key' => 'category',
            'label' => 'Category',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'bookCategoryID',
            'filter' => 'select',
            'filterKey' => 'category',
            'placeholder' => 'All Categories',
            'options' => $bookCategories->pluck('bookCategoryName', 'bookCategoryName')->toArray(),
        ],
        [
            'key' => 'year',
            'label' => 'Year',
            'width' => '80px',
            'sortable' => true,
            'sortKey' => 'year',
            'filter' => 'text',
            'filterKey' => 'year',
        ],
        [
            'key' => 'favoriteCount',
            'label' => 'Fav Count',
            'width' => '100px',
            'sortable' => true,
            'sortKey' => 'favoriteCount',
            'filter' => 'text',
            'filterKey' => 'favorite_count',
        ],
    ];

    // Column Widths for CSS
    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '60px',   // No
        3 => '120px',  // Added Date
        4 => '150px',  // ISBN
        5 => '250px',  // Title
        6 => '180px',  // Author
        7 => '180px',  // Publisher
        8 => '150px',  // Category
        9 => '80px',   // Year
        10 => '100px', // Fav Count
        11 => '120px', // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Book Catalog"
    pageIcon="fa-book"
    highlightedText="Book Catalog System"
    :guideCards="$guideCards"
    addButtonText="Add Book"
    addButtonRoute="admin.catalog.books.create"
    tableClass="table-books"
    tableId="dataBookTable"
    tableBodyId="bookTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.catalog.books.indexAdmin') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/catalog/books') }}"
    bulkDeleteUrl="{{ route('admin.catalog.books.bulkDelete') }}"
    :includeSelect2="true"
    defaultSortBy="createdDate"
    defaultSortOrder="desc"
    entityName="books"
    entityIcon="fa-book"
    dateRangeField="added_date"
    select2Field="category"
    select2Placeholder="All Categories"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
