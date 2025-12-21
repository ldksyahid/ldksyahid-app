<!-- Animation Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
    document.body.style.backgroundColor = "#f5f6fa";
</script>
<script>
    new WOW().init();
</script>

<script>
    $(document).ready(function() {
        // Card hover effect
        $('.report-card').hover(function() {
            $(this).css({
                'transform': 'translateY(-10px)',
                'box-shadow': '0 15px 30px rgba(0,0,0,0.15)',
                'border-color': '#667eea'
            });
        }, function() {
            $(this).css({
                'transform': 'translateY(0)',
                'box-shadow': '0 .125rem .25rem rgba(0,0,0,.075)',
                'border-color': 'rgba(0,0,0,0.1)'
            });
        });
    });
</script>
