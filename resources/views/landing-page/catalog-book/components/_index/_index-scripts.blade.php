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

        // Initialize Select2 for filter modal
        $('#filterModal #category, #filterModal #author, #filterModal #publisher, #filterModal #year, #filterModal #language, #filterModal #author_type, #filterModal #availability').each(function () {
            $(this).select2({
                placeholder: $(this).attr('name') === 'category[]' ? "Pilih kategori buku" :
                            $(this).attr('name') === 'author[]' ? "Pilih penulis" :
                            $(this).attr('name') === 'publisher[]' ? "Pilih penerbit" :
                            $(this).attr('name') === 'year[]' ? "Pilih tahun" :
                            $(this).attr('name') === 'language[]' ? "Pilih bahasa" :
                            $(this).attr('name') === 'author_type[]' ? "Pilih kategori penulis" :
                            $(this).attr('name') === 'availability[]' ? "Pilih ketersediaan" : "Pilih opsi",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#filterModal'),
                dropdownPosition: 'below'
            });
        });

        // Set initial values for Select2 based on URL parameters when modal is shown
        $('#filterModal').on('show.bs.modal', function() {
            const currentCategories = @json(request('category', []));
            const currentAuthors = @json(request('author', []));
            const currentPublishers = @json(request('publisher', []));
            const currentYears = @json(request('year', []));
            const currentLanguages = @json(request('language', []));
            const currentAuthorTypes = @json(request('author_type', []));
            const currentAvailabilities = @json(request('availability', []));

            $('#filterModal #category').val(currentCategories).trigger('change');
            $('#filterModal #author').val(currentAuthors).trigger('change');
            $('#filterModal #publisher').val(currentPublishers).trigger('change');
            $('#filterModal #year').val(currentYears).trigger('change');
            $('#filterModal #language').val(currentLanguages).trigger('change');
            $('#filterModal #author_type').val(currentAuthorTypes).trigger('change');
            $('#filterModal #availability').val(currentAvailabilities).trigger('change');
        });

        // Submit filter form when apply button is clicked - FIXED VERSION
        $('#filter-form').on('submit', function(e) {
            e.preventDefault();
            $('#filterModal').modal('hide');

            // Build clean URL base
            const currentUrl = "{{ url('/perpustakaan') }}";

            // Get search and sort parameters if exist
            const currentSearchParams = new URLSearchParams(window.location.search);
            const currentSearch = currentSearchParams.get('search');
            const currentSort = currentSearchParams.get('sort');

            // Build new search params
            const newSearchParams = new URLSearchParams();

            // Add search parameter if exists
            if (currentSearch) {
                newSearchParams.append('search', currentSearch);
            }

            // Add sort parameter if exists
            if (currentSort) {
                newSearchParams.append('sort', currentSort);
            }

            // Get unique values dari semua filter
            const getUniqueValues = (selector) => {
                const values = $(selector).val();
                return values && Array.isArray(values)
                    ? [...new Set(values.filter(v => v && v !== ''))]
                    : [];
            };

            // Add filter parameters untuk semua filter
            const addFilterParams = (values, paramName) => {
                values.forEach(value => {
                    newSearchParams.append(`${paramName}[]`, value);
                });
            };

            addFilterParams(getUniqueValues('#filterModal #category'), 'category');
            addFilterParams(getUniqueValues('#filterModal #author'), 'author');
            addFilterParams(getUniqueValues('#filterModal #publisher'), 'publisher');
            addFilterParams(getUniqueValues('#filterModal #year'), 'year');
            addFilterParams(getUniqueValues('#filterModal #language'), 'language');
            addFilterParams(getUniqueValues('#filterModal #author_type'), 'author_type');
            addFilterParams(getUniqueValues('#filterModal #availability'), 'availability');

            // Build final URL
            let finalUrl = currentUrl;
            if (newSearchParams.toString()) {
                finalUrl += '?' + newSearchParams.toString();
            }

            window.location.href = finalUrl;
        });

        // Function to clear all filters - PERBAIKAN
        function clearAllFilters() {
            // Clear all Select2 filters in modal (SEMUA FILTER)
            $('#filterModal #category, #filterModal #author, #filterModal #publisher, #filterModal #year, #filterModal #language, #filterModal #author_type, #filterModal #availability').val(null).trigger('change');

            // Build clean URL - hanya pertahankan search dan sort
            const currentUrl = "{{ url('/perpustakaan') }}";
            const currentSearchParams = new URLSearchParams(window.location.search);
            const newSearchParams = new URLSearchParams();

            // Hanya pertahankan search dan sort parameters
            const search = currentSearchParams.get('search');
            const sort = currentSearchParams.get('sort');

            if (search) newSearchParams.append('search', search);
            if (sort) newSearchParams.append('sort', sort);

            // Build final URL
            let finalUrl = currentUrl;
            if (newSearchParams.toString()) {
                finalUrl += '?' + newSearchParams.toString();
            }

            window.location.href = finalUrl;
        }

        // Reset all filters when reset button is clicked - PERBAIKAN
        $('a[href="{{ url('/perpustakaan') }}"]').on('click', function(e) {
            e.preventDefault();
            $('#filterModal').modal('hide');
            clearAllFilters();
        });

        // Clear all filters in modal (without applying) - PERBAIKAN
        $('.clear-all-filters').on('click', function() {
            // Clear semua filter di modal
            $('#filterModal #category, #filterModal #author, #filterModal #publisher, #filterModal #year, #filterModal #language, #filterModal #author_type, #filterModal #availability').val(null).trigger('change');
        });

        // Reset all filters when reset button is clicked
        $('a[href="{{ url('/perpustakaan') }}"]').on('click', function(e) {
            e.preventDefault();
            $('#filterModal').modal('hide');
            clearAllFilters();
        });

        // Close modal when cancel button is clicked
        $('button[data-bs-dismiss="modal"]').on('click', function() {
            $('#filterModal').modal('hide');
        });

        // Clear all filters in modal (without applying)
        $('.clear-all-filters').on('click', function() {
            $('#filterModal #category, #filterModal #author, #filterModal #publisher, #filterModal #year').val(null).trigger('change');
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

        // Show active filter count on filter button (TANPA TOMBOL X)
        function updateFilterButton() {
            // Fix: Use proper JSON syntax for Blade
            const activeFilters = {
                category: @json(request('category', [])),
                author: @json(request('author', [])),
                publisher: @json(request('publisher', [])),
                year: @json(request('year', [])),
                language: @json(request('language', [])),
                author_type: @json(request('author_type', [])),
                availability: @json(request('availability', []))
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

                // Hanya badge tanpa tombol X
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

        $('#filterModal').on('hidden.bs.modal', function() {
            updateFilterButton();
        });

        // Reset state ketika halaman selesai load
        $(window).on('load', function() {
            isSearching = false;
            const submitButton = $('#search-form').find('button[type="submit"]');
            submitButton.prop('disabled', false).html('<i class="fas fa-search me-2"></i> Cari');

            // Update clear button
            updateClearButton();

            // Update filter button
            updateFilterButton();
        });

        // Inisialisasi clear button saat pertama kali load
        updateClearButton();

        // Fix untuk dropdown di mobile
        function fixMobileDropdowns() {
            if ($(window).width() <= 576) {
                // Reposition dropdown menus untuk mobile
                $('.dropdown-menu').each(function() {
                    const $dropdown = $(this);
                    const $toggle = $dropdown.prev('.dropdown-toggle');

                    if ($toggle.length) {
                        $toggle.off('click.mobile-fix').on('click.mobile-fix', function(e) {
                            e.preventDefault();
                            e.stopPropagation();

                            // Close other open dropdowns
                            $('.dropdown-menu').not($dropdown).removeClass('show');

                            // Toggle current dropdown
                            $dropdown.toggleClass('show');

                            // Position dropdown
                            if ($dropdown.hasClass('show')) {
                                const rect = $toggle[0].getBoundingClientRect();
                                $dropdown.css({
                                    'position': 'fixed',
                                    'top': '50%',
                                    'left': '50%',
                                    'transform': 'translate(-50%, -50%)',
                                    'width': '90%',
                                    'max-width': '300px',
                                    'z-index': '1060'
                                });
                            }
                        });
                    }
                });

                // Close dropdowns when clicking outside
                $(document).on('click touchstart', function(e) {
                    if (!$(e.target).closest('.dropdown').length) {
                        $('.dropdown-menu').removeClass('show');
                    }
                });
            }
        }

        // Panggil fungsi fix saat load dan resize
        fixMobileDropdowns();
        $(window).on('resize', fixMobileDropdowns);
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
                const fullLink = link;

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

        window.location.href = url;
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

    // Mobile Share Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Copy Link for Mobile
        document.querySelectorAll('.copy-link-mobile').forEach(button => {
            button.addEventListener('click', function() {
                const link = this.getAttribute('data-link');
                copyToClipboard(link);
                showCopySuccess();
            });
        });

        // WhatsApp Share for Mobile
        document.querySelectorAll('.share-wa-mobile').forEach(button => {
            button.addEventListener('click', function() {
                const link = this.getAttribute('data-link');
                const title = this.getAttribute('data-title');
                const text = `Lihat buku "${title}" di: ${link}`;
                const encodedText = encodeURIComponent(text);
                window.open(`https://wa.me/?text=${encodedText}`, '_blank');
            });
        });

        // Copy to Clipboard Function
        function copyToClipboard(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
        }

        // Show Copy Success Message
        function showCopySuccess() {
            const successMsg = document.createElement('div');
            successMsg.className = 'copy-success';
            successMsg.innerHTML = '<i class="fas fa-check-circle me-2"></i>Link berhasil disalin!';
            document.body.appendChild(successMsg);

            setTimeout(() => {
                successMsg.classList.add('fade-out');
                setTimeout(() => {
                    document.body.removeChild(successMsg);
                }, 300);
            }, 2000);
        }
    });
</script>
