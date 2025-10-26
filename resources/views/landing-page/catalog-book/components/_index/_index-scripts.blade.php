<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Filter and Search Functionality
    $(document).ready(function() {
        const searchInput = $('#search-input');
        const clearBtn = $('#clear-search');
        let isSearching = false;

        // Function untuk update clear button
        function updateClearButton() {
            if (!isSearching && searchInput.val().length > 0) {
                clearBtn.show();
            } else {
                clearBtn.hide();
            }
        }

        // Function untuk reset search state
        function resetSearchState(submitButton, originalText) {
            isSearching = false;
            submitButton.prop('disabled', false).html(originalText);
            updateClearButton();
        }

        $('#filterModal #category, #filterModal #author, #filterModal #publisher, #filterModal #year').each(function () {
            $(this).select2({
                placeholder: $(this).attr('name') === 'category[]' ? "Pilih kategori" :
                            $(this).attr('name') === 'author[]' ? "Pilih penulis" :
                            $(this).attr('name') === 'publisher[]' ? "Pilih penerbit" :
                            $(this).attr('name') === 'year[]' ? "Pilih tahun" : "Pilih opsi",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#filterModal'),
                dropdownPosition: 'below'
            });
        });

        // Submit filter form when apply button is clicked
        $('#filter-form').on('submit', function(e) {
            e.preventDefault();
            $('#filterModal').modal('hide');

            // Get all selected values
            const formData = $(this).serialize();
            const currentUrl = "{{ url('/perpustakaan') }}";
            const searchParams = new URLSearchParams(window.location.search);

            // Remove existing filter parameters
            ['category', 'author', 'publisher', 'year', 'page'].forEach(param => {
                searchParams.delete(param);
            });

            // Add new filter parameters
            const newParams = new URLSearchParams(formData);
            newParams.forEach((value, key) => {
                if (value) {
                    searchParams.append(key, value);
                }
            });

            // Build final URL
            let finalUrl = currentUrl + '?' + searchParams.toString();
            window.location.href = finalUrl;
        });

        // Reset form when reset button is clicked
        $('a[href="{{ url('/perpustakaan') }}"]').on('click', function(e) {
            e.preventDefault();
            $('#filterModal').modal('hide');
            window.location.href = "{{ url('/perpustakaan') }}";
        });

        // Close modal when cancel button is clicked
        $('button[data-bs-dismiss="modal"]').on('click', function() {
            $('#filterModal').modal('hide');
        });

        // Search functionality dengan loading state
        searchInput.on('input', function () {
            if (!isSearching) {
                updateClearButton();
            }
        });

        clearBtn.on('click', function () {
            if (!isSearching) {
                searchInput.val('');
                $('#search-form').submit();
            }
        });

        // Auto-submit search form on enter
        searchInput.on('keypress', function(e) {
            if (e.which === 13 && !isSearching) {
                $('#search-form').submit();
            }
        });

        // Loading state untuk search form
        $('#search-form').on('submit', function(e) {
            if (isSearching) {
                e.preventDefault();
                return;
            }

            const submitButton = $(this).find('button[type="submit"]');
            const originalText = submitButton.html();

            // Set state searching
            isSearching = true;

            // Sembunyikan tombol clear
            clearBtn.hide();

            // Hanya disable tombol submit, biarkan input tetap aktif
            submitButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Mencari...');

            // Jika form di-submit secara manual (bukan oleh script lain)
            if (e.originalEvent) {
                // Biarkan form submit normal
                // Reset state akan dilakukan setelah halaman reload
            } else {
                // Reset state setelah halaman selesai load
                $(window).on('load', function() {
                    resetSearchState(submitButton, originalText);
                });
            }
        });

        // Close select2 dropdowns on window scroll
        $(window).on('scroll', function () {
            $('.select2-container--open').select2('close');
        });

        // Initialize select2 for existing dropdowns (if any)
        $('#category, #author, #publisher, #year').not('#filterModal #category, #filterModal #author, #filterModal #publisher, #filterModal #year').each(function () {
            $(this).select2({
                placeholder: "Semua",
                allowClear: true,
                width: '100%',
                dropdownPosition: 'below'
            });
        });

        // Show active filter count on filter button
        function updateFilterButton() {
            // Fix: Use proper JSON syntax for Blade
            const activeFilters = {
                category: @json(request('category', [])),
                author: @json(request('author', [])),
                publisher: @json(request('publisher', [])),
                year: @json(request('year', []))
            };

            let activeCount = 0;

            Object.values(activeFilters).forEach(filter => {
                if (filter && filter.length > 0) {
                    if (Array.isArray(filter)) {
                        activeCount += filter.length;
                    } else {
                        activeCount += 1;
                    }
                }
            });

            const filterButton = $('button[data-bs-target="#filterModal"]');
            const filterIcon = filterButton.find('i');
            const filterText = filterButton.find('span');

            if (activeCount > 0) {
                filterButton.addClass('btn-primary').removeClass('btn-outline-primary');
                filterButton.css({
                    'background-color': '#00bfa6',
                    'border-color': '#00bfa6',
                    'color': 'white'
                });

                if (!filterButton.find('.filter-badge').length) {
                    filterText.after('<span class="filter-badge badge rounded-circle bg-white text-primary ms-1">' + activeCount + '</span>');
                } else {
                    filterButton.find('.filter-badge').text(activeCount);
                }
            } else {
                filterButton.removeClass('btn-primary').addClass('btn-outline-primary');
                filterButton.css({
                    'background-color': 'transparent',
                    'border-color': '#00bfa6',
                    'color': '#00bfa6'
                });
                filterButton.find('.filter-badge').remove();
            }
        }

        // Call update function on page load
        updateFilterButton();

        // Update filter button when modal is shown/hidden
        $('#filterModal').on('shown.bs.modal', function() {
            updateFilterButton();
        });

        // Clear all filters function
        $('.clear-all-filters').on('click', function() {
            $('#filterModal #category, #filterModal #author, #filterModal #publisher, #filterModal #year').val(null).trigger('change');
        });

        // Reset state ketika halaman selesai load
        $(window).on('load', function() {
            isSearching = false;
            const submitButton = $('#search-form').find('button[type="submit"]');
            submitButton.prop('disabled', false).html('<i class="fas fa-search me-2"></i> Cari');

            // Update clear button
            updateClearButton();
        });

        // Inisialisasi clear button saat pertama kali load
        updateClearButton();
    });

    // Share Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Function to show success message
        function showCopySuccess(message) {
            // Remove existing success message
            const existingMessage = document.querySelector('.copy-success');
            if (existingMessage) {
                existingMessage.remove();
            }

            // Create new success message
            const successMessage = document.createElement('div');
            successMessage.className = 'copy-success';
            successMessage.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <span>${message}</span>
            `;
            document.body.appendChild(successMessage);

            // Remove message after 3 seconds with fade out effect
            setTimeout(() => {
                successMessage.classList.add('fade-out');
                setTimeout(() => {
                    if (successMessage.parentNode) {
                        successMessage.remove();
                    }
                }, 300);
            }, 2700);
        }

        // Copy link functionality
        document.querySelectorAll('.copy-link').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const link = this.getAttribute('data-link');
                const fullLink = link;

                navigator.clipboard.writeText(fullLink).then(() => {
                    showCopySuccess('Link berhasil disalin!');
                }).catch(() => {
                    const textArea = document.createElement('textarea');
                    textArea.value = fullLink;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    showCopySuccess('Link berhasil disalin!');
                });

                // Close dropdown
                $(this).closest('.dropdown').find('.dropdown-toggle').dropdown('hide');
            });
        });

        // WhatsApp share functionality
        document.querySelectorAll('.share-wa').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const link = this.getAttribute('data-link');
                const title = this.getAttribute('data-title');
                const fullLink = window.location.origin + link;

                const message = `📚 *${title}* \n\nBaca buku ini di: ${fullLink}`;
                const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;

                window.open(whatsappUrl, '_blank');
                $(this).closest('.dropdown').find('.dropdown-toggle').dropdown('hide');
            });
        });
    });

    // Smooth scrolling for pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');

        $('html, body').animate({
            scrollTop: $('.container-xxl.py-5').offset().top - 100
        }, 500, function() {
            window.location.href = url;
        });
    });

    // Loading state untuk filter form
    $('#filter-form').on('submit', function() {
        const submitButton = $(this).find('button[type="submit"]');
        const originalText = submitButton.html();

        submitButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Memproses...');

        setTimeout(() => {
            submitButton.prop('disabled', false).html(originalText);
        }, 2000);
    });
</script>
