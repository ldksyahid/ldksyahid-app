@extends('admin-page.template.body')

@php
    $guideCards = [
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the dropdown filters to find donations by payment status, campaign, or date range.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'View donation details including donor name, amount, payment status, and payment link.'
        ],
        [
            'icon' => 'fa-trash',
            'title' => 'Delete',
            'description' => 'Use <i class="fa fa-trash small text-danger"></i> to delete a donation record.'
        ],
    ];

    $columns = [
        [
            'key' => 'nama_donatur',
            'label' => 'Donor Name',
            'width' => '180px',
            'sortable' => true,
            'sortKey' => 'nama_donatur',
        ],
        [
            'key' => 'jumlah_donasi',
            'label' => 'Amount',
            'width' => '150px',
            'sortable' => false,
        ],
        [
            'key' => 'created_at',
            'label' => 'Date',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'created_at',
            'filter' => 'daterange',
            'filterKey' => 'created_at',
        ],
        [
            'key' => 'campaign_name',
            'label' => 'Campaign',
            'width' => '200px',
            'sortable' => false,
            'filter' => 'select',
            'filterKey' => 'campaign_id',
            'options' => $campaignOptions ?? [],
        ],
        [
            'key' => 'payment_status',
            'label' => 'Payment Status',
            'width' => '130px',
            'sortable' => false,
            'filter' => 'select',
            'filterKey' => 'payment_status',
            'options' => $paymentStatusOptions ?? [],
        ],
        [
            'key' => 'payment_link',
            'label' => 'Payment Link',
            'width' => '200px',
            'sortable' => false,
        ],
    ];

    $columnWidths = [
        1 => '50px',
        2 => '50px',
        3 => '180px',
        4 => '150px',
        5 => '200px',
        6 => '200px',
        7 => '130px',
        8 => '200px',
        9 => '120px',
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="Donation Management"
    pageIcon="fa-donate"
    highlightedText="Donation Management System"
    :guideCards="$guideCards"
    :showAddButton="false"
    tableClass="table-donations"
    tableId="dataDonationTable"
    tableBodyId="donationTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.service.index.donation') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/service/celengansyahid/donation') }}"
    bulkDeleteUrl="{{ route('admin.service.donation.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="donations"
    entityIcon="fa-donate"
    dateRangeField="created_at"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
