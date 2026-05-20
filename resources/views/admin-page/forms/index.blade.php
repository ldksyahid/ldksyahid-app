@extends('admin-page.template.body')

@php
    $guideCards = [
        [
            'icon'        => 'fa-plus-circle',
            'title'       => 'Create a New Form',
            'description' => 'Click the <strong>"Create Form"</strong> button to get started. After creation, use the Form Builder to add your questions.'
        ],
        [
            'icon'        => 'fa-hammer',
            'title'       => 'Form Builder',
            'description' => 'Use the <i class="fa fa-hammer small"></i> Builder button to add and arrange fields with drag-and-drop reordering.'
        ],
        [
            'icon'        => 'fa-share-alt',
            'title'       => 'Publish & Share',
            'description' => 'Click "Publish" on the form detail page to activate it. Copy the public URL and share it with respondents.'
        ],
        [
            'icon'        => 'fa-table',
            'title'       => 'View Responses in Google Sheets',
            'description' => 'All answers are automatically written to a Google Spreadsheet. Access it via the Spreadsheet link on the form detail page.'
        ],
    ];

    $columns = [
        [
            'key'       => 'title',
            'label'     => 'Form Title',
            'width'     => '220px',
            'sortable'  => true,
            'sortKey'   => 'title',
            'filter'    => 'text',
            'filterKey' => 'title',
        ],
        [
            'key'         => 'status',
            'label'       => 'Status',
            'width'       => '120px',
            'sortable'    => true,
            'sortKey'     => 'status',
            'filter'      => 'select',
            'filterKey'   => 'status',
            'placeholder' => 'All Statuses',
            'options'     => [
                'draft'     => 'Draft',
                'published' => 'Published',
                'closed'    => 'Closed',
                'archived'  => 'Archived',
            ],
        ],
        [
            'key'      => 'totalSubmission',
            'label'    => 'Submissions',
            'width'    => '100px',
            'sortable' => true,
            'sortKey'  => 'totalSubmission',
        ],
        [
            'key'   => 'createdBy',
            'label' => 'Created By',
            'width' => '150px',
        ],
        [
            'key'       => 'createdDate',
            'label'     => 'Created Date',
            'width'     => '130px',
            'sortable'  => true,
            'sortKey'   => 'createdDate',
            'filter'    => 'daterange',
            'filterKey' => 'created_at',
        ],
    ];

    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '220px',  // Form Title
        4 => '120px',  // Status
        5 => '100px',  // Submissions
        6 => '150px',  // Created By
        7 => '130px',  // Created Date
        8 => '205px',  // Action (5 buttons: View, Edit, Delete, Builder, Publish/Close)
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Dynamic Forms"
    pageIcon="fa-clipboard-list"
    highlightedText="Dynamic Form Management"
    :guideCards="$guideCards"
    addButtonText="Create Form"
    addButtonRoute="admin.forms.create"
    tableClass="table-forms"
    tableId="dataFormsTable"
    tableBodyId="formsTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.forms.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/forms') }}"
    bulkDeleteUrl="{{ url('admin/forms/bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="createdDate"
    defaultSortOrder="desc"
    entityName="forms"
    entityIcon="fa-clipboard-list"
    dateRangeField="created_at"
    select2Field="status"
    select2Placeholder="All Statuses"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
