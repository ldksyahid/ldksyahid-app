@extends('admin-page.template.body')

@php
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add Campaign',
            'description' => 'Click the <strong>"Add Campaign"</strong> button to create a new campaign. Fill in the title, category, target cost, and other details.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the dropdown filters to find campaigns by category or deadline date range.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete campaign details including story and donations.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Bulk Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit campaign details. Only Superadmins can perform <i class="fa fa-trash small text-danger"></i> bulk delete.'
        ],
    ];

    $columns = [
        [
            'key' => 'judul',
            'label' => 'Title',
            'width' => '250px',
            'sortable' => true,
            'sortKey' => 'judul',
            'filter' => 'text',
            'filterKey' => 'judul',
        ],
        [
            'key' => 'kategori',
            'label' => 'Category',
            'width' => '150px',
            'sortable' => true,
            'sortKey' => 'kategori',
            'filter' => 'select',
            'filterKey' => 'kategori',
            'placeholder' => 'All Categories',
            'options' => $categoryOptions ?? [],
        ],
        [
            'key' => 'target_biaya',
            'label' => 'Cost Target',
            'width' => '150px',
            'sortable' => false,
            'filter' => 'text',
            'filterKey' => 'target_biaya',
        ],
        [
            'key' => 'deadline',
            'label' => 'Deadline',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'deadline',
            'filter' => 'daterange',
            'filterKey' => 'deadline',
        ],
    ];

    $columnWidths = [
        1 => '50px',
        2 => '50px',
        3 => '250px',
        4 => '150px',
        5 => '150px',
        6 => '200px',
        7 => '120px',
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Campaign Management"
    pageIcon="fa-hand-holding-heart"
    highlightedText="Campaign Management System"
    :guideCards="$guideCards"
    addButtonText="Add Campaign"
    addButtonRoute="admin.service.create.campaign"
    tableClass="table-campaigns"
    tableId="dataCampaignTable"
    tableBodyId="campaignTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.service.index.celsyahid.dashboard') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/service/celengansyahid/campaign') }}"
    bulkDeleteUrl="{{ route('admin.service.campaign.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="campaigns"
    entityIcon="fa-hand-holding-heart"
    dateRangeField="deadline"
    select2Field="kategori"
    select2Placeholder="All Categories"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
