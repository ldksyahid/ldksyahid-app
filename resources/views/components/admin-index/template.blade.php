{{--
    Admin Index Template Component

    Usage in index.blade.php:

    <x-admin-index.template
        pageTitle="Finance Report"
        pageIcon="fa-file-invoice-dollar"
        highlightedText="Finance Report System"
        tableClass="table-reports"
        tableId="dataReportTable"
        tableBodyId="reportTableBody"
        :columns="$columns"
        :guideCards="$guideCards"
        addButtonText="Add Report"
        addButtonRoute="admin.finance-report.create"
        ajaxUrl="{{ route('admin.finance-report.index') }}"
        ...
    >
        <!-- Slot for additional content above table -->
        <x-slot name="beforeTable">
            <!-- custom content -->
        </x-slot>

        <!-- Slot for modals -->
        <x-slot name="modals">
            <!-- modal html -->
        </x-slot>
    </x-admin-index.template>
--}}

@props([
    // Page Config
    'pageTitle' => 'Data',
    'pageIcon' => 'fa-file',
    'highlightedText' => 'Management System',

    // Guide Cards - array of ['icon' => '', 'title' => '', 'description' => '']
    'guideCards' => [],

    // Add Button
    'addButtonText' => 'Add Item',
    'addButtonRoute' => '',
    'showAddButton' => true,

    // Table Config
    'tableClass' => 'table-data',
    'tableId' => 'dataTable',
    'tableBodyId' => 'tableBody',
    'columns' => [], // array of column configs

    // Ajax & Data Config
    'ajaxUrl' => '',
    'csrfToken' => '',
    'deleteUrl' => '',
    'bulkDeleteUrl' => '',

    // Scripts Config
    'includeSelect2' => false,
    'defaultSortBy' => 'createdDate',
    'defaultSortOrder' => 'desc',
    'entityName' => 'items',
    'entityIcon' => 'fa-file',
    'dateRangeField' => '',
    'select2Field' => '',
    'select2Placeholder' => 'All Items',
    'paginationContainerId' => 'paginationContainer',
    'showingInfoId' => 'showingInfo',

    // Styles Config
    'columnWidths' => [],
    'includeModal' => false,
    'extraStyles' => '',
    'extraScripts' => '',

    // Permission
    'isSuperadmin' => false,

    // Initial Data (optional)
    'initialData' => null,
    'initialPagination' => null,
])

@php
    // +3 = checkbox + No + Action columns
    $skeletonColumns = count($columns) > 0 ? count($columns) + 3 : 6;
@endphp

{{-- Styles Section --}}
@push('styles')
<x-admin-index.base-styles
    :tableClass="$tableClass"
    :includeSelect2="$includeSelect2"
    :includeModal="$includeModal"
    :columnWidths="$columnWidths"
    :extraStyles="$extraStyles"
/>
@endpush

{{-- Main Content --}}
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            {{-- Page Title --}}
            <h1 class="page-title">
                <i class="fa {{ $pageIcon }} me-2"></i>
                <span>LDK&nbsp;Syahid</span>
                <span class="highlighted-text ms-1">{{ $highlightedText }}</span>
            </h1>

            {{-- Guide Cards --}}
            @if(count($guideCards) > 0)
            <div class="col-md-12 mb-3">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
                    @foreach($guideCards as $card)
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold">
                                    <i class="fa {{ $card['icon'] ?? 'fa-info-circle' }} me-1"></i>
                                    {{ $card['title'] ?? '' }}
                                </h6>
                                <p class="card-text small text-muted">{!! $card['description'] ?? '' !!}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Slot: Before Table (for forms or custom content) --}}
            {{ $beforeTable ?? '' }}

            {{-- Action Buttons Row --}}
            <div class="col-md-12 my-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    @if($showAddButton && $addButtonRoute)
                    <a href="{{ route($addButtonRoute) }}" class="btn btn-custom-primary">
                        <i class="fa fa-plus me-1"></i> {{ $addButtonText }}
                    </a>
                    @endif
                    {{ $leftButtons ?? '' }}
                </div>
                <div>
                    <button type="button" id="refreshBtn" class="btn btn-custom-primary me-2">
                        <i class="fa fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" id="clearFiltersBtn" class="btn btn-custom-primary">
                        <i class="fa fa-times"></i> Clear Filters
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover table-borderless text-nowrap align-middle {{ $tableClass }}" id="{{ $tableId }}">
                    <thead>
                        <tr>
                            {{-- Checkbox Column --}}
                            <th width="50">
                                <input type="checkbox" id="selectAll" class="form-check-input m-0" {{ $isSuperadmin ? '' : 'disabled' }}>
                            </th>

                            {{-- No Column --}}
                            <th class="text-start" width="50">No</th>

                            {{-- Dynamic Columns --}}
                            @foreach($columns as $col)
                            <th class="text-center" width="{{ $col['width'] ?? 'auto' }}">
                                <div class="d-flex flex-column">
                                    @if(isset($col['sortable']) && $col['sortable'])
                                    <a href="#" class="sort-link" data-sort-by="{{ $col['sortKey'] ?? $col['key'] }}">
                                        <span>{{ $col['label'] }}</span>
                                        <span class="sort-arrow" id="sortArrow{{ ucfirst($col['sortKey'] ?? $col['key']) }}"></span>
                                    </a>
                                    @else
                                    <span>{{ $col['label'] }}</span>
                                    @endif

                                    @if(isset($col['filter']))
                                        @if($col['filter'] === 'text')
                                        <div class="position-relative">
                                            <input type="text" name="{{ $col['filterKey'] ?? $col['key'] }}"
                                                class="form-control form-control-sm mt-1 column-search"
                                                placeholder="Filter {{ $col['label'] }}"
                                                value="{{ request($col['filterKey'] ?? $col['key']) }}">
                                        </div>
                                        @elseif($col['filter'] === 'daterange')
                                        <div class="position-relative">
                                            <input type="text" name="{{ $col['filterKey'] ?? $col['key'] }}"
                                                class="form-control form-control-sm mt-1 daterangepicker-input"
                                                placeholder="Filter {{ $col['label'] }}"
                                                value="{{ request($col['filterKey'] ?? $col['key']) }}"
                                                autocomplete="off">
                                        </div>
                                        @elseif($col['filter'] === 'select' && isset($col['options']))
                                        <div class="position-relative">
                                            <select name="{{ $col['filterKey'] ?? $col['key'] }}"
                                                class="form-control form-control-sm mt-1 column-search select2-filter"
                                                data-placeholder="{{ $col['placeholder'] ?? 'All' }}"
                                                style="width: 100%">
                                                <option value="">{{ $col['placeholder'] ?? 'All' }}</option>
                                                @foreach($col['options'] as $optValue => $optLabel)
                                                <option value="{{ $optValue }}" {{ request($col['filterKey'] ?? $col['key']) == $optValue ? 'selected' : '' }}>
                                                    {{ $optLabel }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @elseif($col['filter'] === 'custom')
                                        {!! $col['filterHtml'] ?? '' !!}
                                        @endif
                                    @endif
                                </div>
                            </th>
                            @endforeach

                            {{-- Action Column --}}
                            <th class="text-center" width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody id="{{ $tableBodyId }}">
                        {{-- Data will be loaded via AJAX --}}
                    </tbody>
                </table>
            </div>

            {{-- Pagination & Info --}}
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div id="{{ $showingInfoId }}">
                    <p class="small text-muted mb-0">Loading...</p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap" id="{{ $paginationContainerId }}">
                </div>
            </div>

            {{-- Bulk Delete Button --}}
            <div class="d-flex justify-content-end align-items-center mb-3 flex-wrap gap-2">
                @if($bulkDeleteUrl)
                <form id="bulkDeleteForm" method="POST" class="mb-0">
                    @csrf
                    <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm"
                        {{ $isSuperadmin ? '' : 'disabled title=Only Superadmin can perform bulk delete' }}>
                        Bulk Delete
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Slot: Modals --}}
{{ $modals ?? '' }}

{{-- Scripts Section --}}
@push('scripts')
<x-admin-index.base-scripts
    :ajaxUrl="$ajaxUrl"
    :tableBodyId="$tableBodyId"
    :csrfToken="$csrfToken"
    :includeSelect2="$includeSelect2"
    :defaultSortBy="$defaultSortBy"
    :defaultSortOrder="$defaultSortOrder"
    :skeletonColumns="$skeletonColumns"
    :entityName="$entityName"
    :entityIcon="$entityIcon"
    :dateRangeField="$dateRangeField"
    :select2Field="$select2Field"
    :select2Placeholder="$select2Placeholder"
    :deleteUrl="$deleteUrl"
    :bulkDeleteUrl="$bulkDeleteUrl"
    :paginationContainerId="$paginationContainerId"
    :showingInfoId="$showingInfoId"
    :extraScripts="$extraScripts"
/>
@endpush
