<script>
document.addEventListener('DOMContentLoaded', function () {
    var tabBtns     = document.querySelectorAll('.kta-tab-btn');
    var tabContents = document.querySelectorAll('.kta-tab-content');
    var slider      = document.querySelector('.kta-tabs-slider');

    function updateSlider(btn) {
        if (!slider || window.innerWidth < 992) return;
        slider.style.left  = btn.offsetLeft + 'px';
        slider.style.width = btn.offsetWidth + 'px';
    }

    // Init slider position
    var activeBtn = document.querySelector('.kta-tab-btn.active');
    if (activeBtn) setTimeout(function () { updateSlider(activeBtn); }, 100);

    tabBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = btn.dataset.tab;

            tabBtns.forEach(function (b) { b.classList.remove('active'); });
            tabContents.forEach(function (c) { c.classList.remove('active'); });

            btn.classList.add('active');
            var content = document.getElementById('ktaTab-' + target);
            if (content) content.classList.add('active');

            updateSlider(btn);
        });
    });

    window.addEventListener('resize', function () {
        var active = document.querySelector('.kta-tab-btn.active');
        if (active) updateSlider(active);
    });
});
</script>
