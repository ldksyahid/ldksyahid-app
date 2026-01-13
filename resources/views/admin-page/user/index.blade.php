@extends('admin-page.template.body')

@php
    // $isSuperadmin is automatically available via View Composer

    // Guide Cards Config
    $guideCards = [
        [
            'icon' => 'fa-plus-circle',
            'title' => 'How to Add a User',
            'description' => 'Click the <strong>"Add User"</strong> button to create a new user. Fill in all required fields including name, email, password, and role.'
        ],
        [
            'icon' => 'fa-search',
            'title' => 'Search Feature',
            'description' => 'Use the search filters in each column to find users more precisely by name, email, or role.'
        ],
        [
            'icon' => 'fa-eye',
            'title' => 'View Details',
            'description' => 'Click <i class="fa fa-eye small"></i> to view complete user details including profile and role information.'
        ],
        [
            'icon' => 'fa-edit',
            'title' => 'Edit & Bulk Delete',
            'description' => 'Click <i class="fa fa-edit small"></i> to edit user details. Only Superadmins can perform <i class="fa fa-trash small text-danger"></i> bulk delete.'
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
            'key' => 'email',
            'label' => 'Email',
            'width' => '200px',
            'sortable' => true,
            'sortKey' => 'email',
            'filter' => 'text',
            'filterKey' => 'email',
        ],
        [
            'key' => 'email_verified_at',
            'label' => 'Verification',
            'width' => '120px',
            'sortable' => true,
            'sortKey' => 'email_verified_at',
            'filter' => 'select',
            'filterKey' => 'verification',
            'placeholder' => 'All Status',
            'options' => [
                'verified' => 'Verified',
                'not_verified' => 'Not Verified',
            ],
        ],
        [
            'key' => 'role_name',
            'label' => 'Role',
            'width' => '150px',
            'sortable' => false,
            'filter' => 'select',
            'filterKey' => 'role',
            'placeholder' => 'All Roles',
            'options' => $roles->mapWithKeys(fn($role) => [$role => $role])->toArray(),
        ],
        [
            'key' => 'created_at',
            'label' => 'Created At',
            'width' => '180px',
            'sortable' => true,
            'sortKey' => 'created_at',
            'filter' => 'daterange',
            'filterKey' => 'created_at',
        ],
    ];

    // Column Widths for CSS
    $columnWidths = [
        1 => '50px',   // Checkbox
        2 => '50px',   // No
        3 => '180px',  // Name
        4 => '200px',  // Email
        5 => '120px',  // Verification
        6 => '150px',  // Role
        7 => '180px',  // Created At
        8 => '120px',  // Action
    ];
@endphp

@section('content')
<x-admin-index.template
    pageTitle="User Management"
    pageIcon="fa-users"
    highlightedText="User Management System"
    :guideCards="$guideCards"
    addButtonText="Add User"
    addButtonRoute="admin.user.create"
    tableClass="table-users"
    tableId="dataUserTable"
    tableBodyId="userTableBody"
    :columns="$columns"
    :columnWidths="$columnWidths"
    ajaxUrl="{{ route('admin.user.index') }}"
    csrfToken="{{ csrf_token() }}"
    deleteUrl="{{ url('admin/user') }}"
    bulkDeleteUrl="{{ route('admin.user.bulk-delete') }}"
    :includeSelect2="true"
    defaultSortBy="created_at"
    defaultSortOrder="desc"
    entityName="users"
    entityIcon="fa-users"
    dateRangeField="created_at"
    select2Field="role"
    select2Placeholder="All Roles"
    :isSuperadmin="$isSuperadmin"
/>
@endsection
