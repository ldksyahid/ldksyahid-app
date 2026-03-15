<script>
    document.addEventListener('DOMContentLoaded', function() {
        new WOW().init();

        // Parallax effect on mouse move
        const card = document.querySelector('.error-card-glow');
        document.addEventListener('mousemove', function(e) {
            const x = (e.clientX / window.innerWidth - 0.5) * 8;
            const y = (e.clientY / window.innerHeight - 0.5) * 8;
            card.style.transform = 'perspective(1000px) rotateY(' + x + 'deg) rotateX(' + (-y) + 'deg)';
        });

        document.addEventListener('mouseleave', function() {
            card.style.transform = 'perspective(1000px) rotateY(0deg) rotateX(0deg)';
        });
    });

    /* ── Dark Mode Toggle ── */
    (function () {
        var btn = document.getElementById('errDarkToggle');

        function updateIcon() {
            if (!btn) return;
            var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            btn.innerHTML = isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
            btn.title = isDark ? 'Mode Terang' : 'Mode Gelap';
        }

        if (btn) {
            btn.addEventListener('click', function () {
                var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                if (isDark) {
                    document.documentElement.removeAttribute('data-theme');
                    localStorage.setItem('darkMode', 'disabled');
                } else {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    localStorage.setItem('darkMode', 'enabled');
                }
                updateIcon();
            });
            updateIcon();
        }
    }());
</script>
