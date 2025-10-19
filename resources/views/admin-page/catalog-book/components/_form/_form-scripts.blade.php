<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#languageID, #bookCategoryID, #authorTypeID, #availabilityTypeID').select2({
            placeholder: function() {
                const id = $(this).attr('id');
                const placeholders = {
                    'languageID': 'Select Language',
                    'bookCategoryID': 'Select Category',
                    'authorTypeID': 'Select Author Type',
                    'availabilityTypeID': 'Select Availability Type'
                };
                return placeholders[id] || 'Select Option';
            },
            width: '100%',
            dropdownPosition: 'below'
        });

        function toggleLinkFields() {
            const availabilityTypeID = $('#availabilityTypeID').val();
            const purchaseLinkField = $('#purchaseLink').closest('.mb-3');
            const borrowLinkField = $('#borrowLink').closest('.mb-3');

            purchaseLinkField.hide();
            borrowLinkField.hide();

            switch(availabilityTypeID) {
                case '1':
                    purchaseLinkField.hide();
                    borrowLinkField.hide();
                    break;
                case '2':
                    purchaseLinkField.show();
                    borrowLinkField.hide();
                    break;
                case '3':
                    purchaseLinkField.hide();
                    borrowLinkField.show();
                    break;
                default:
                    purchaseLinkField.hide();
                    borrowLinkField.hide();
                    break;
            }
        }

        toggleLinkFields();

        $('#availabilityTypeID').on('change', function() {
            toggleLinkFields();
        });

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
        });
    });
</script>