<script>
$(document).ready(function () {
    $(document).on('click', '.btn-save-setting', function () {
        var $row   = $(this).closest('.setting-row');
        var key1   = $row.data('key1');
        var key2   = $row.data('key2');
        var $btn   = $(this);
        var $badge = $row.find('.setting-saved-badge');
        var value1 = $row.find('.inp-value1').val();
        var value2 = $row.find('.inp-value2').val();

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Saving...');
        $badge.hide();

        $.ajax({
            url: '/admin/setting/update',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                key1:   key1,
                key2:   key2,
                value1: value1,
                value2: value2,
            },
            success: function () {
                $badge.css('display', 'inline-flex').hide().fadeIn(200);
                setTimeout(function () { $badge.fadeOut(400); }, 2500);
            },
            error: function () {
                if (typeof Swal !== 'undefined') {
                    var Toast = Swal.mixin({
                        toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
                        timerProgressBar: true,
                    });
                    Toast.fire({ icon: 'error', title: 'Failed to save setting.' });
                } else {
                    alert('Failed to save setting.');
                }
            },
            complete: function () {
                $btn.prop('disabled', false).html('<i class="fas fa-save"></i> Save');
            }
        });
    });
});
</script>

