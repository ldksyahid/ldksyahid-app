<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        const languageElement = $('#languageID');
        if (languageElement.length && languageElement.is('select')) {
            languageElement.select2({
                placeholder: 'Select Language',
                width: '100%',
                dropdownPosition: 'below'
            });
        }

        const bookCategoryElement = $('#bookCategoryID');
        if (bookCategoryElement.length && bookCategoryElement.is('select')) {
            bookCategoryElement.select2({
                placeholder: 'Select Category',
                width: '100%',
                dropdownPosition: 'below'
            });
        }

        const authorTypeElement = $('#authorTypeID');
        if (authorTypeElement.length && authorTypeElement.is('select')) {
            authorTypeElement.select2({
                placeholder: 'Select Author Type',
                width: '100%',
                dropdownPosition: 'below'
            });
        }

        const availabilityTypeElement = $('#availabilityTypeID');
        if (availabilityTypeElement.length && availabilityTypeElement.is('select')) {
            availabilityTypeElement.select2({
                placeholder: 'Select Availability Type',
                width: '100%',
                dropdownPosition: 'below'
            });
        }

        function toggleLinkFields() {
            const availabilityTypeID = $('#availabilityTypeID').val();
            const purchaseLinkField = $('#purchaseLink').closest('.mb-3');
            const borrowLinkField = $('#borrowLink').closest('.mb-3');
            const purchaseLinkInput = $('#purchaseLink');
            const borrowLinkInput = $('#borrowLink');
            
            switch(availabilityTypeID) {
                case '1':
                    purchaseLinkField.hide();
                    borrowLinkField.hide();
                    purchaseLinkInput.val('');
                    borrowLinkInput.val('');
                    break;
                case '2':
                    purchaseLinkField.show();
                    borrowLinkField.hide();
                    borrowLinkInput.val('');
                    break;
                case '3':
                    purchaseLinkField.hide();
                    borrowLinkField.show();
                    purchaseLinkInput.val('');
                    break;
                default:
                    purchaseLinkField.hide();
                    borrowLinkField.hide();
                    purchaseLinkInput.val('');
                    borrowLinkInput.val('');
                    break;
            }

            if (purchaseLinkField.is(':hidden')) {
                purchaseLinkInput.removeClass('is-invalid');
                purchaseLinkInput.next('.invalid-feedback').hide();
            }
            if (borrowLinkField.is(':hidden')) {
                borrowLinkInput.removeClass('is-invalid');
                borrowLinkInput.next('.invalid-feedback').hide();
            }
        }

        toggleLinkFields();

        const availabilityTypeElementForEvent = $('#availabilityTypeID');
        if (availabilityTypeElementForEvent.is('select')) {
            availabilityTypeElementForEvent.on('change', function() {
                toggleLinkFields();
            });
        }

        document.getElementById('coverImage')?.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // You can add image preview functionality here if needed
                };
                reader.readAsDataURL(file);
            }
        });

        document.querySelector('form')?.addEventListener('submit', function(e) {
            const title = document.getElementById('titleBook').value;
            if (!title) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Title is required',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                return;
            }

            const requiredSelects = ['languageID', 'bookCategoryID', 'authorTypeID', 'availabilityTypeID'];
            for (const selectId of requiredSelects) {
                const select = document.getElementById(selectId);
                if (select && !select.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error!',
                        text: `${select.previousElementSibling?.textContent?.replace('*', '').trim()} is required`,
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    select.focus();
                    return;
                }
            }

            const availabilityTypeID = $('#availabilityTypeID').val();
            const purchaseLink = $('#purchaseLink').val();
            const borrowLink = $('#borrowLink').val();

            if (availabilityTypeID === '2' && !purchaseLink) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Purchase Link is required for this availability type',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                $('#purchaseLink').focus();
                return;
            }

            if (availabilityTypeID === '3' && !borrowLink) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Borrow Link is required for this availability type',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                $('#borrowLink').focus();
                return;
            }

            if ($('#purchaseLink').closest('.mb-3').is(':hidden')) {
                $('#purchaseLink').val('');
            }
            if ($('#borrowLink').closest('.mb-3').is(':hidden')) {
                $('#borrowLink').val('');
            }
        });

        $('.link-field').css({
            'transition': 'all 0.3s ease-in-out',
            'overflow': 'hidden'
        });
    });
</script>