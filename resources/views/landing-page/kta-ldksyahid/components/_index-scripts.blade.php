<script>
$(document).ready(function() {
    $('.card').hover(
        function() {
            $(this).find('.card-header').css('background', 'linear-gradient(135deg, #006D6D 0%, #008F8F 100%)');
        },
        function() {
            $(this).find('.card-header').css('background', 'linear-gradient(135deg, #008F8F 0%, #006D6D 100%)');
        }
    );
});
</script>
