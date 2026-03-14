<script>
document.addEventListener('DOMContentLoaded', function() {
    // Viewport animations with IntersectionObserver
    var animEls = document.querySelectorAll('.schedule-header-wrap, .schedule-card-animate');

    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15
        });

        animEls.forEach(function(el) {
            observer.observe(el);
        });
    } else {
        // Fallback for browsers without IntersectionObserver
        animEls.forEach(function(el) {
            el.classList.add('is-visible');
        });
    }
});
</script>
