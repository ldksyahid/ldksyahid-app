<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        const searchInput = $('#search-input');
        const clearBtn = $('#clear-search');

        // Initialize select2 for filter dropdowns
        $('#category, #author, #publisher, #year').each(function () {
            $(this).select2({
                placeholder: "Semua",
                allowClear: true,
                width: '100%',
                dropdownPosition: 'below'
            });
        });

        // Auto-submit form when filters change
        $('#category, #author, #publisher, #year').on('change', function() {
            $('#search-form').submit();
        });

        searchInput.on('input', function () {
            clearBtn.toggle($(this).val().length > 0);
        });

        clearBtn.on('click', function () {
            searchInput.val('');
            $('#search-form').submit();
        });

        $(window).on('scroll', function () {
            $('#category, #author, #publisher, #year').select2('close');
        });
    });
</script>
