{{--
    Reusable Admin Index Scripts Component
    Use directly in index.blade.php:

    @section('scripts')
    <x-admin-index.base-scripts
        ajaxUrl="{{ route('xxx.index') }}"
        tableBodyId="xxxTableBody"
        ...
    />
    @endsection
--}}

@props([
    'ajaxUrl' => '',
    'tableBodyId' => 'tableBody',
    'csrfToken' => '',
    'includeSelect2' => false,
    'defaultSortBy' => 'createdDate',
    'defaultSortOrder' => 'desc',
    'skeletonColumns' => 6,
    'entityName' => 'items',
    'entityIcon' => 'fa-file',
    'dateRangeField' => '',
    'select2Field' => '',
    'select2Placeholder' => 'All Items',
    'deleteUrl' => '',
    'bulkDeleteUrl' => '',
    'paginationContainerId' => 'paginationContainer',
    'showingInfoId' => 'showingInfo',
    'extraScripts' => ''
])

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if($includeSelect2)
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endif
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
(function() {
    // Configuration
    const AdminIndexConfig = {
        ajaxUrl: '{{ $ajaxUrl }}',
        tableBodyId: '{{ $tableBodyId }}',
        csrfToken: '{{ $csrfToken }}',
        skeletonColumns: {{ $skeletonColumns }},
        entityName: '{{ $entityName }}',
        entityIcon: '{{ $entityIcon }}',
        dateRangeField: '{{ $dateRangeField }}',
        select2Field: '{{ $select2Field }}',
        select2Placeholder: '{{ $select2Placeholder }}',
        deleteUrl: '{{ $deleteUrl }}',
        bulkDeleteUrl: '{{ $bulkDeleteUrl }}',
        paginationContainerId: '{{ $paginationContainerId }}',
        showingInfoId: '{{ $showingInfoId }}',
        defaultSortBy: '{{ $defaultSortBy }}',
        defaultSortOrder: '{{ $defaultSortOrder }}'
    };

    // Toast Configuration
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        width: '350px',
    });
    window.Toast = Toast;

    // Copy link function (used by copy-button, destination-link, shortlink, url-key column types)
    const baseUrl = '{{ url('/') }}';
    window.copyLink = function(urlKey, withBaseUrl) {
        if (withBaseUrl === undefined) withBaseUrl = true;
        var link = withBaseUrl ? baseUrl.replace(/^https?:\/\/(www\.)?/, '').replace(/\/$/, '') + '/' + urlKey : urlKey;
        navigator.clipboard.writeText(link).then(function() {
            Toast.fire({ icon: 'success', title: 'Copied to clipboard!' });
        });
    };

    // State Variables
    let sortBy = '{{ request("sort_by", $defaultSortBy) }}';
    let sortOrder = '{{ request("sort_order", $defaultSortOrder) }}';
    let currentParams = {};
    window.currentParams = currentParams;

    // ============ FUNCTION DEFINITIONS FIRST ============

    function showLoading() {
        let skeletonRows = '';
        for (let i = 0; i < 10; i++) {
            skeletonRows += '<tr class="skeleton-row">';
            for (let j = 0; j < AdminIndexConfig.skeletonColumns; j++) {
                skeletonRows += '<td><div class="skeleton"></div></td>';
            }
            skeletonRows += '</tr>';
        }
        $(`#${AdminIndexConfig.tableBodyId}`).html(skeletonRows);
    }

    function showNoDataMessage() {
        $(`#${AdminIndexConfig.tableBodyId}`).html(`
            <tr>
                <td colspan="${AdminIndexConfig.skeletonColumns}" class="text-center py-4">
                    <div class="d-flex flex-column align-items-center">
                        <i class="fa ${AdminIndexConfig.entityIcon} fa-2x mb-2 text-muted"></i>
                        <span class="text-muted">No ${AdminIndexConfig.entityName} found</span>
                    </div>
                </td>
            </tr>
        `);
        $(`#${AdminIndexConfig.showingInfoId}`).html('<p class="small text-muted mb-0">No data available</p>');
        $(`#${AdminIndexConfig.paginationContainerId}`).html('');
    }

    function updateSortArrows() {
        $('.sort-arrow').html('');
        if (sortBy) {
            const camelCaseId = `sortArrow${sortBy.charAt(0).toUpperCase() + sortBy.slice(1)}`;
            const snakeCaseId = `${sortBy}_arrow`;

            let arrowElement = $(`#${camelCaseId}`);
            if (!arrowElement.length) {
                arrowElement = $(`#${snakeCaseId}`);
            }

            if (arrowElement.length) {
                arrowElement.html(sortOrder === 'asc' ? '↑' : '↓');
            }
        }
    }
    window.updateSortArrows = updateSortArrows;

    function loadData(params = {}) {
        showLoading();

        const queryParams = {...currentParams, ...params};

        $.ajax({
            url: AdminIndexConfig.ajaxUrl,
            type: 'GET',
            data: queryParams,
            success: function(response) {
                if (response && typeof response === 'object') {
                    $(`#${AdminIndexConfig.tableBodyId}`).html(response.tableBody || response.html);
                    $(`#${AdminIndexConfig.paginationContainerId}`).html(response.pagination);

                    if (response.total === 0) {
                        $(`#${AdminIndexConfig.showingInfoId}`).html(`<p class="small text-muted mb-0">No ${AdminIndexConfig.entityName} found</p>`);
                    } else {
                        const from = response.from || response.showing?.first || 1;
                        const to = response.to || response.showing?.last || response.total;
                        $(`#${AdminIndexConfig.showingInfoId}`).html(`<p class="small text-muted mb-0">Showing ${from}-${to} of ${response.total} ${AdminIndexConfig.entityName}</p>`);
                    }
                } else if (response) {
                    $(`#${AdminIndexConfig.tableBodyId}`).html(response);
                } else {
                    showNoDataMessage();
                }

                // Reinitialize tooltips
                $(`#${AdminIndexConfig.tableBodyId} [data-bs-toggle="tooltip"]`).tooltip('dispose');
                $(`#${AdminIndexConfig.tableBodyId} td`).each(function() {
                    if (this.offsetWidth < this.scrollWidth) {
                        $(this).attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', $(this).text().trim());
                    }
                });
                $('[data-bs-toggle="tooltip"]').tooltip();

                $(`#${AdminIndexConfig.tableBodyId} .btn`).each(function() {
                    const title = $(this).attr('title') || $(this).data('original-title');
                    if (title) {
                        $(this).tooltip({ placement: 'top', trigger: 'hover' });
                    }
                });
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                Toast.fire({ icon: 'error', title: 'Error loading data' });
                showNoDataMessage();
            }
        });
    }
    window.loadData = loadData;

    @if($includeSelect2)
    function initSelect2() {
        // Initialize Select2 on all select elements with .select2-filter class
        $('.select2-filter').each(function() {
            // Skip if already initialized
            if ($(this).hasClass('select2-hidden-accessible')) return;

            const placeholder = $(this).data('placeholder') || 'All';
            $(this).select2({
                placeholder: placeholder,
                allowClear: true,
                width: '100%',
                dropdownParent: $('body'),
                dropdownPosition: 'below',
                closeOnSelect: true,
            });
        });
    }
    @endif

    @if($dateRangeField)
    function initDateRangePicker() {
        $('input[name="{{ $dateRangeField }}"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'DD-MM-YYYY',
                separator: ' - ',
                applyLabel: 'Apply',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            },
            opens: 'right',
            drops: 'down'
        });

        $('input[name="{{ $dateRangeField }}"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            currentParams['{{ $dateRangeField }}'] = picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY');
            loadData();
        });

        $('input[name="{{ $dateRangeField }}"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            delete currentParams['{{ $dateRangeField }}'];
            loadData();
        });
    }
    @endif

    function initColumnSearch() {
        document.querySelectorAll('.column-search').forEach(input => {
            if (input.type === 'select-one') return;

            if (input.nextElementSibling && input.nextElementSibling.classList.contains('column-search-clear')) {
                return;
            }

            const clearBtn = document.createElement('button');
            clearBtn.innerHTML = '<i class="fa fa-times"></i>';
            clearBtn.className = 'column-search-clear';
            clearBtn.style.display = input.value ? 'block' : 'none';
            clearBtn.type = 'button';

            input.insertAdjacentElement('afterend', clearBtn);

            clearBtn.addEventListener('click', function() {
                input.value = '';
                this.style.display = 'none';
                const paramName = input.name || input.dataset.column;
                delete currentParams[paramName];
                loadData();
            });

            input.addEventListener('input', function() {
                clearBtn.style.display = this.value ? 'block' : 'none';
            });
        });
    }

    function updateBulkDeleteButton() {
        const anyChecked = $('input[name="ids[]"]:checked').length > 0;
        $('#bulkDeleteBtn').prop('disabled', !anyChecked);
    }

    @if($bulkDeleteUrl)
    function handleBulkDelete() {
        const checkboxes = $('input[name="ids[]"]:checked');
        const ids = checkboxes.map(function() { return $(this).val(); }).get();

        if (ids.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: `No ${AdminIndexConfig.entityName} selected`,
                text: `Please select at least one item to delete.`,
                confirmButtonText: 'OK'
            });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete ${ids.length} item(s). This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: '{{ $bulkDeleteUrl }}',
                    data: { _token: AdminIndexConfig.csrfToken, ids: ids },
                    success: function(response) {
                        Toast.fire({ icon: 'success', title: response.message || 'Selected items have been deleted!' });
                        loadData();
                        $('#selectAll').prop('checked', false);
                    },
                    error: function(xhr) {
                        Swal.fire({ title: 'Error!', text: xhr.responseJSON?.message || 'Something went wrong.', icon: 'error' });
                    }
                });
            }
        });
    }
    @endif

    // ============ DOCUMENT READY ============
    $(document).ready(function() {
        currentParams = Object.fromEntries(new URLSearchParams(window.location.search));
        window.currentParams = currentParams;

        @if($includeSelect2)
        initSelect2();
        @endif

        @if($dateRangeField)
        initDateRangePicker();
        @endif

        initColumnSearch();
        updateSortArrows();

        // Load data after all initializations
        loadData();

        $(document).ajaxComplete(function() {
            initColumnSearch();
            @if($includeSelect2)
            initSelect2();
            @endif
        });

        // Sort Link Handler
        $(document).on('click', '.sort-link', function(e) {
            e.preventDefault();
            const newSortBy = $(this).data('sort-by') || $(this).data('sort');

            if (sortBy === newSortBy) {
                sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
            } else {
                sortBy = newSortBy;
                sortOrder = 'desc';
            }

            currentParams.sort_by = sortBy;
            currentParams.sort_order = sortOrder;

            updateSortArrows();
            loadData();
        });

        @if($includeSelect2)
        // Select2 Change Handler (all Select2 dropdowns)
        $(document).on('change', '.select2-filter', function() {
            const value = $(this).val();
            const name = $(this).attr('name');
            if (value) { currentParams[name] = value; } else { delete currentParams[name]; }
            loadData();
        });
        @endif

        // Column Search Handler (text inputs)
        $(document).on('keyup blur', '.column-search', function(e) {
            if (this.type === 'select-one') return;
            if (e.type === 'keyup' && e.key !== 'Enter') return;

            const value = $(this).val();
            const name = $(this).attr('name') || $(this).data('column');
            if (value) { currentParams[name] = value; } else { delete currentParams[name]; }
            loadData();
        });

        // Native Select Handler (non-Select2 dropdowns)
        $(document).on('change', 'select.column-search', function() {
            // Skip if this select is initialized with Select2
            if ($(this).hasClass('select2-hidden-accessible')) return;

            const value = $(this).val();
            const name = $(this).attr('name') || $(this).data('column');
            if (value) { currentParams[name] = value; } else { delete currentParams[name]; }
            loadData();
        });

        // Pagination Handler
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = new URL($(this).attr('href'), window.location.origin);
            currentParams.page = url.searchParams.get('page');
            loadData();
        });

        // Checkbox Handlers
        $('#selectAll').on('change', function() {
            $('input[name="ids[]"]').prop('checked', this.checked);
            updateBulkDeleteButton();
        });

        $(document).on('change', 'input[name="ids[]"]', function() {
            updateBulkDeleteButton();
            const allChecked = $('input[name="ids[]"]:checked').length === $('input[name="ids[]"]').length;
            $('#selectAll').prop('checked', allChecked);
        });

        @if($deleteUrl)
        $(document).on('click', '.delete-action-btn', function() {
            const itemId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: `{{ $deleteUrl }}/${itemId}`,
                        data: { _token: AdminIndexConfig.csrfToken },
                        success: function(data) {
                            Toast.fire({ icon: 'success', title: data.message || 'Item has been deleted!' });
                            loadData();
                            $('#selectAll').prop('checked', false);
                        },
                        error: function(xhr) {
                            Swal.fire({ title: 'Error!', text: xhr.responseJSON?.message || 'Something went wrong.', icon: 'error' });
                        }
                    });
                }
            });
        });
        @endif

        @if($bulkDeleteUrl)
        $('#bulkDeleteBtn').on('click', handleBulkDelete);
        @endif

        // Session Flash Messages
        @if(session('success'))
        Toast.fire({ icon: 'success', title: '{{ session('success') }}', showCloseButton: true, width: '400px' });
        @endif

        @if(session('failed') && $errors->any())
        Toast.fire({
            icon: 'error',
            title: 'There were some problems with your input',
            html: `<ul class="text-start small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`,
            showCloseButton: true,
            width: '500px'
        });
        @endif

        // Show clear buttons for fields with values
        $('.column-search').each(function() {
            if ($(this).val() && this.type !== 'select-one') {
                $(this).next('.column-search-clear').show();
            }
        });

        // Refresh Button
        $('#refreshBtn').on('click', function() { loadData(); });

        // Clear Filters Button
        $('#clearFiltersBtn').on('click', function() {
            sortBy = AdminIndexConfig.defaultSortBy;
            sortOrder = AdminIndexConfig.defaultSortOrder;

            currentParams = { sort_by: sortBy, sort_order: sortOrder, page: 1 };
            window.currentParams = currentParams;

            $('.column-search').val('');
            @if($includeSelect2)
            // Reset all Select2 dropdowns
            $('.select2-filter').val('').trigger('change');
            @endif
            @if($dateRangeField)
            $('input[name="{{ $dateRangeField }}"]').val('');
            @endif
            $('.column-search-clear').hide();
            updateSortArrows();
            loadData();
        });

        // Extra Custom Scripts
        {!! $extraScripts !!}
    });
})();
</script>
