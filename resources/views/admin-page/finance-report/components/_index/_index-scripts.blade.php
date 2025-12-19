<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    width: '350px',
});

let sortBy = '{{ request("sort_by", "createdDate") }}';
let sortOrder = '{{ request("sort_order", "desc") }}';
let currentParams = {};

$(document).ready(function() {
    currentParams = Object.fromEntries(new URLSearchParams(window.location.search));

    initSelect2();
    loadReports();
    updateSortArrows();
    initColumnSearch();
    initDateRangePicker();

    $(document).ajaxComplete(function() {
        initColumnSearch();
        initSelect2();
    });

    function initSelect2() {
        $('select[name="ldk_tag"]').select2({
            placeholder: "All Tags",
            allowClear: true,
            width: '100%',
            dropdownParent: $('body'),
            dropdownPosition: 'below',
            closeOnSelect: true,
        });
    }

    function loadReports(params = {}) {
        showLoading();

        const queryParams = {...currentParams, ...params};
        const queryString = new URLSearchParams(queryParams).toString();

        $.ajax({
            url: "{{ route('admin.finance-report.index') }}",
            type: 'GET',
            data: queryParams,
            success: function(response) {
                if (response && typeof response === 'object') {
                    $('#reportTableBody').html(response.tableBody);
                    $('#paginationContainer').html(response.pagination);

                    if (response.total === 0) {
                        $('#showingInfo').html('<p class="small text-muted mb-0">No reports found</p>');
                    } else {
                        $('#showingInfo').html(`<p class="small text-muted mb-0">Showing ${response.from}-${response.to} of ${response.total} reports</p>`);
                    }
                } else if (response) {
                    $('#reportTableBody').html(response);
                } else {
                    showNoDataMessage();
                }

                // Reinitialize tooltips
                $('#reportTableBody [data-bs-toggle="tooltip"]').tooltip('dispose');
                $('#reportTableBody td').each(function() {
                    if (this.offsetWidth < this.scrollWidth) {
                        $(this).attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', $(this).text().trim());
                    }
                });
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                Toast.fire({
                    icon: 'error',
                    title: 'Error loading data'
                });
                showNoDataMessage();
            }
        });
    }

    function showNoDataMessage() {
        $('#reportTableBody').html(`
            <tr>
                <td colspan="6" class="text-center py-4">
                    <div class="d-flex flex-column align-items-center">
                        <i class="fa fa-file-invoice-dollar fa-2x mb-2 text-muted"></i>
                        <span class="text-muted">No finance reports found</span>
                    </div>
                </td>
            </tr>
        `);
        $('#showingInfo').html('<p class="small text-muted mb-0">No data available</p>');
        $('#paginationContainer').html('');
    }

    function showLoading() {
        let skeletonRows = '';
        for (let i = 0; i < 10; i++) {
            skeletonRows += `
            <tr class="skeleton-row">
                <td><div class="skeleton"></div></td>
                <td><div class="skeleton"></div></td>
                <td><div class="skeleton"></div></td>
                <td><div class="skeleton"></div></td>
                <td><div class="skeleton"></div></td>
                <td><div class="skeleton"></div></td>
            </tr>`;
        }
        $('#reportTableBody').html(skeletonRows);
    }

    function updateSortArrows() {
        $('.sort-arrow').html('');
        if (sortBy) {
            const arrowElement = $(`#sortArrow${sortBy.charAt(0).toUpperCase() + sortBy.slice(1)}`);
            if (arrowElement.length) {
                arrowElement.html(sortOrder === 'asc' ? '↑' : '↓');
            }
        }
    }

    function initDateRangePicker() {
        $('input[name="created_date"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'DD-MM-YYYY',
                separator: ' - ',
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
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

        $('input[name="created_date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            currentParams.created_date = picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY');
            loadReports();
        });

        $('input[name="created_date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            delete currentParams.created_date;
            loadReports();
        });
    }

    $(document).on('click', '.sort-link', function(e) {
        e.preventDefault();
        const newSortBy = $(this).data('sort-by');

        if (sortBy === newSortBy) {
            sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            sortBy = newSortBy;
            sortOrder = 'desc';
        }

        currentParams.sort_by = sortBy;
        currentParams.sort_order = sortOrder;

        updateSortArrows();
        loadReports();
    });

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
                delete currentParams[input.name];
                loadReports();
            });

            input.addEventListener('input', function() {
                clearBtn.style.display = this.value ? 'block' : 'none';
            });
        });
    }

    $(document).on('change', 'select[name="ldk_tag"]', function() {
        const value = $(this).val();
        const name = $(this).attr('name');

        if (value) {
            currentParams[name] = value;
        } else {
            delete currentParams[name];
        }

        loadReports();
    });

    $(document).on('keyup blur', '.column-search', function(e) {
        if (this.type === 'select-one') return;

        if (e.type === 'keyup' && e.key !== 'Enter') {
            return;
        }

        const value = $(this).val();
        const name = $(this).attr('name');

        if (value) {
            currentParams[name] = value;
        } else {
            delete currentParams[name];
        }

        loadReports();
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = new URL($(this).attr('href'));
        const page = url.searchParams.get('page');
        currentParams.page = page;
        loadReports();
    });

    // Checkbox functions for bulk delete
    $('#selectAll').on('change', function() {
        $('input[name="ids[]"]').prop('checked', this.checked);
        updateBulkDeleteButton();
    });

    $(document).on('change', 'input[name="ids[]"]', function() {
        updateBulkDeleteButton();

        const allChecked = $('input[name="ids[]"]:checked').length === $('input[name="ids[]"]').length;
        $('#selectAll').prop('checked', allChecked);
    });

    function updateBulkDeleteButton() {
        const anyChecked = $('input[name="ids[]"]:checked').length > 0;
        $('#bulkDeleteBtn').prop('disabled', !anyChecked);
    }

    $(document).on('click', '.delete-report-btn', function() {
        const reportId = $(this).data('id');

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
                    url: `{{ url('admin/finance-report/') }}/${reportId}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Report has been deleted!'
                        });
                        loadReports();
                        $('#selectAll').prop('checked', false);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });

    // Bulk delete function
    function handleBulkDelete() {
        const checkboxes = $('input[name="ids[]"]:checked');
        const ids = checkboxes.map(function() {
            return $(this).val();
        }).get();

        if (ids.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No reports selected',
                text: 'Please select at least one report to delete.',
                confirmButtonText: 'OK'
            });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete ${ids.length} report(s). This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.finance-report.bulk-delete') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: ids
                    },
                    success: function(response) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Selected reports have been deleted!'
                        });
                        loadReports();
                        $('#selectAll').prop('checked', false);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }

    $('#bulkDeleteBtn').on('click', handleBulkDelete);

    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            showCloseButton: true,
            width: '400px'
        });
    @endif

    @if(session('failed'))
        @if($errors->any())
            Toast.fire({
                icon: 'error',
                title: 'There were some problems with your input',
                html: `
                    <ul class="text-start small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                showCloseButton: true,
                width: '500px'
            });
        @endif
    @endif

    $('.column-search').each(function() {
        if ($(this).val() && this.type !== 'select-one') {
            $(this).next('.column-search-clear').show();
        }
    });

    $('#refreshBtn').on('click', function() {
        loadReports();
    });

    $('#clearFiltersBtn').on('click', function() {
        sortBy = 'createdDate';
        sortOrder = 'desc';

        currentParams = {
            sort_by: sortBy,
            sort_order: sortOrder,
            page: 1
        };

        $('.column-search').val('');
        $('select[name="ldk_tag"]').val('').trigger('change');
        $('input[name="created_date"]').val('');
        $('.column-search-clear').hide();
        updateSortArrows();

        loadReports();
    });
});
</script>
