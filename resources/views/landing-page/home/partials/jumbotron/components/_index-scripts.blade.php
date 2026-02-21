<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('header-carousel');
    if (!carousel) return;

    // Update indicators
    carousel.addEventListener('slid.bs.carousel', function(e) {
        const dots = document.querySelectorAll('.indicator-dot');
        dots.forEach(dot => dot.classList.remove('active'));
        if (dots[e.to]) {
            dots[e.to].classList.add('active');
        }
    });

    // Function to get fresh elements (to handle DOM changes)
    function getFreshElements() {
        return {
            desktop: {
                arab: document.getElementById('hadith-arab-desktop'),
                text: document.getElementById('hadith-text-desktop'),
                source: document.getElementById('hadith-source-desktop'),
                number: document.getElementById('hadith-number-desktop'),
                wrapper: document.getElementById('hadith-desktop-wrapper'),
                toggle: document.getElementById('hadith-toggle-desktop'),
                countdown: document.getElementById('countdown-number-desktop')
            },
            mobile: {
                arab: document.getElementById('hadith-arab-mobile'),
                text: document.getElementById('hadith-text-mobile'),
                source: document.getElementById('hadith-source-mobile'),
                number: document.getElementById('hadith-number-mobile'),
                wrapper: document.getElementById('hadith-mobile-wrapper'),
                toggle: document.getElementById('hadith-toggle-mobile'),
                countdown: document.getElementById('countdown-number-mobile')
            }
        };
    }

    // Function to refresh text elements array - HANYA TEKS YANG MEMILIKI CLASS hadith-fade-text
    function getTextElements() {
        const elements = getFreshElements();
        const textElements = [];

        // Tambahkan elemen desktop yang memiliki class hadith-fade-text
        if (elements.desktop.arab && elements.desktop.arab.classList.contains('hadith-fade-text'))
            textElements.push(elements.desktop.arab);
        if (elements.desktop.text && elements.desktop.text.classList.contains('hadith-fade-text'))
            textElements.push(elements.desktop.text);
        if (elements.desktop.number && elements.desktop.number.classList.contains('hadith-fade-text'))
            textElements.push(elements.desktop.number);
        if (elements.desktop.source && elements.desktop.source.classList.contains('hadith-fade-text'))
            textElements.push(elements.desktop.source);

        // Tambahkan elemen mobile yang memiliki class hadith-fade-text
        if (elements.mobile.arab && elements.mobile.arab.classList.contains('hadith-fade-text'))
            textElements.push(elements.mobile.arab);
        if (elements.mobile.text && elements.mobile.text.classList.contains('hadith-fade-text'))
            textElements.push(elements.mobile.text);
        if (elements.mobile.number && elements.mobile.number.classList.contains('hadith-fade-text'))
            textElements.push(elements.mobile.number);
        if (elements.mobile.source && elements.mobile.source.classList.contains('hadith-fade-text'))
            textElements.push(elements.mobile.source);

        return textElements;
    }

    const books = [
        { id: 'bukhari', name: 'HR. Bukhari', max: 6638 },
        { id: 'muslim', name: 'HR. Muslim', max: 4930 },
        { id: 'abu-daud', name: 'HR. Abu Daud', max: 4419 },
        { id: 'tirmidzi', name: 'HR. Tirmidzi', max: 3625 },
        { id: 'ibnu-majah', name: 'HR. Ibnu Majah', max: 4285 },
        { id: 'nasai', name: 'HR. Nasai', max: 5364 },
    ];

    let timeLeft = 60;
    let countdownInterval;
    let isFetching = false;
    let retryCount = 0;
    const MAX_RETRY = 5;
    let retryTimeout = null;

    // Toggle functionality with event delegation
    function setupToggleListeners() {
        document.addEventListener('click', function(e) {
            // Desktop toggle
            if (e.target.closest('#hadith-toggle-desktop')) {
                const toggle = document.getElementById('hadith-toggle-desktop');
                const wrapper = document.getElementById('hadith-desktop-wrapper');
                if (toggle && wrapper) {
                    e.preventDefault();
                    const isExpanded = wrapper.classList.toggle('expanded');
                    toggle.classList.toggle('expanded');
                    const textSpan = toggle.querySelector('.toggle-text');
                    if (textSpan) {
                        textSpan.textContent = isExpanded ? 'Sembunyikan' : 'Selengkapnya';
                    }
                }
            }

            // Mobile toggle
            if (e.target.closest('#hadith-toggle-mobile')) {
                const toggle = document.getElementById('hadith-toggle-mobile');
                const wrapper = document.getElementById('hadith-mobile-wrapper');
                if (toggle && wrapper) {
                    e.preventDefault();
                    const isExpanded = wrapper.classList.toggle('expanded');
                    toggle.classList.toggle('expanded');
                    const textSpan = toggle.querySelector('.hadith-toggle-text');
                    if (textSpan) {
                        textSpan.textContent = isExpanded ? 'Sembunyikan' : 'Selengkapnya';
                    }
                }
            }
        });
    }

    function checkOverflow() {
        const desktopWrapper = document.getElementById('hadith-desktop-wrapper');
        const desktopToggle = document.getElementById('hadith-toggle-desktop');
        const mobileWrapper = document.getElementById('hadith-mobile-wrapper');
        const mobileToggle = document.getElementById('hadith-toggle-mobile');

        if (desktopWrapper && desktopToggle) {
            if (desktopWrapper.scrollHeight > 150) {
                desktopToggle.style.display = 'inline-flex';
            } else {
                desktopToggle.style.display = 'none';
            }
        }

        if (mobileWrapper && mobileToggle) {
            if (mobileWrapper.scrollHeight > 150) {
                mobileToggle.style.display = 'inline-flex';
            } else {
                mobileToggle.style.display = 'none';
            }
        }
    }

    function updateCountdown() {
        const desktopCountdown = document.getElementById('countdown-number-desktop');
        const mobileCountdown = document.getElementById('countdown-number-mobile');

        if (desktopCountdown) {
            desktopCountdown.textContent = timeLeft;
        }
        if (mobileCountdown) {
            mobileCountdown.textContent = timeLeft;
        }
    }

    function resetCountdown() {
        timeLeft = 60;
        updateCountdown();
    }

    function startCountdown() {
        if (countdownInterval) clearInterval(countdownInterval);

        countdownInterval = setInterval(() => {
            timeLeft--;
            updateCountdown();

            if (timeLeft <= 0) {
                timeLeft = 60;
                fetchRandomHadith();
            }
        }, 1000);
    }

    function fadeOutElements(callback) {
        const textElements = getTextElements();
        let completed = 0;
        const total = textElements.length;

        if (total === 0) {
            callback();
            return;
        }

        // Tambahkan class fade-out ke semua elemen
        textElements.forEach(el => {
            el.classList.add('fade-out');
        });

        // Tunggu transisi selesai
        const checkComplete = function() {
            completed++;
            if (completed === total) {
                callback();
            }
        };

        textElements.forEach(el => {
            const handler = function() {
                el.removeEventListener('transitionend', handler);
                checkComplete();
            };
            el.addEventListener('transitionend', handler);

            // Fallback jika transisi tidak berjalan
            setTimeout(() => {
                if (el.classList.contains('fade-out')) {
                    el.removeEventListener('transitionend', handler);
                    checkComplete();
                }
            }, 600);
        });
    }

    function fadeInElements() {
        const textElements = getTextElements();
        textElements.forEach(el => {
            el.classList.remove('fade-out');
        });
    }

    // Fungsi untuk menampilkan pesan error dengan retry count
    function showErrorMessage(message, showRetry = true) {
        const desktopText = document.getElementById('hadith-text-desktop');
        const mobileText = document.getElementById('hadith-text-mobile');
        const desktopSource = document.getElementById('hadith-source-desktop');
        const mobileSource = document.getElementById('hadith-source-mobile');
        const desktopArab = document.getElementById('hadith-arab-desktop');
        const mobileArab = document.getElementById('hadith-arab-mobile');
        const desktopNumber = document.getElementById('hadith-number-desktop');
        const mobileNumber = document.getElementById('hadith-number-mobile');
        const desktopToggle = document.getElementById('hadith-toggle-desktop');
        const mobileToggle = document.getElementById('hadith-toggle-mobile');

        let errorText = message;
        if (showRetry && retryCount > 0) {
            errorText = `${message} (Percobaan ke-${retryCount}/${MAX_RETRY})`;
        }

        if (desktopText) desktopText.innerHTML = errorText;
        if (mobileText) mobileText.innerHTML = errorText;

        if (desktopSource) desktopSource.textContent = 'Hadits dalam 1 Menit';
        if (mobileSource) mobileSource.textContent = 'Hadits dalam 1 Menit';

        if (desktopArab) desktopArab.textContent = '';
        if (mobileArab) mobileArab.textContent = '';

        if (desktopNumber) desktopNumber.textContent = '';
        if (mobileNumber) mobileNumber.textContent = '';

        if (desktopToggle) desktopToggle.style.display = 'none';
        if (mobileToggle) mobileToggle.style.display = 'none';
    }

    // Fungsi untuk retry dengan delay
    function scheduleRetry(delay = 3000) {
        if (retryTimeout) clearTimeout(retryTimeout);

        if (retryCount < MAX_RETRY) {
            retryTimeout = setTimeout(() => {
                fetchRandomHadith();
            }, delay);
        } else {
            // Jika sudah mencapai maksimal percobaan, tampilkan pesan dan reset counter
            showErrorMessage('Gagal memuat hadits setelah beberapa kali percobaan. Silakan refresh halaman.', false);
            retryCount = 0;
        }
    }

    async function fetchRandomHadith() {
        if (isFetching) return;
        isFetching = true;

        try {
            // Fade out semua teks
            await new Promise(resolve => {
                fadeOutElements(resolve);
            });

            const book = books[Math.floor(Math.random() * books.length)];
            const number = Math.floor(Math.random() * book.max) + 1;

            // Tambahkan timeout untuk fetch
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000);

            const res = await fetch(`https://api.hadith.gading.dev/books/${book.id}/${number}`, {
                signal: controller.signal
            }).finally(() => clearTimeout(timeoutId));

            const json = await res.json();

            if (json.code === 200 && json.data && json.data.contents) {
                retryCount = 0;
                const contents = json.data.contents;

                const desktopWrapper = document.getElementById('hadith-desktop-wrapper');
                const mobileWrapper = document.getElementById('hadith-mobile-wrapper');
                const desktopToggle = document.getElementById('hadith-toggle-desktop');
                const mobileToggle = document.getElementById('hadith-toggle-mobile');

                if (desktopWrapper) desktopWrapper.classList.remove('expanded');
                if (mobileWrapper) mobileWrapper.classList.remove('expanded');

                if (desktopToggle) {
                    desktopToggle.classList.remove('expanded');
                    const textSpan = desktopToggle.querySelector('.toggle-text');
                    if (textSpan) textSpan.textContent = 'Selengkapnya';
                }

                if (mobileToggle) {
                    mobileToggle.classList.remove('expanded');
                    const textSpan = mobileToggle.querySelector('.hadith-toggle-text');
                    if (textSpan) textSpan.textContent = 'Selengkapnya';
                }

                const desktopArab = document.getElementById('hadith-arab-desktop');
                const desktopText = document.getElementById('hadith-text-desktop');
                const desktopSource = document.getElementById('hadith-source-desktop');
                const desktopNumber = document.getElementById('hadith-number-desktop');

                if (desktopArab) desktopArab.textContent = contents.arab;
                if (desktopText) desktopText.innerHTML = `"${contents.id}"`;
                if (desktopSource) desktopSource.textContent = book.name;
                if (desktopNumber) desktopNumber.textContent = `${book.name} No. ${contents.number}`;

                const mobileArab = document.getElementById('hadith-arab-mobile');
                const mobileText = document.getElementById('hadith-text-mobile');
                const mobileSource = document.getElementById('hadith-source-mobile');
                const mobileNumber = document.getElementById('hadith-number-mobile');

                if (mobileArab) mobileArab.textContent = contents.arab;
                if (mobileText) mobileText.innerHTML = `"${contents.id}"`;
                if (mobileSource) mobileSource.textContent = book.name;
                if (mobileNumber) mobileNumber.textContent = `${book.name} No. ${contents.number}`;

                fadeInElements();

                setTimeout(() => {
                    checkOverflow();
                }, 100);

                resetCountdown();
            } else {
                throw new Error('Invalid response');
            }
        } catch (e) {
            console.error('Error:', e);

            retryCount++;

            let errorMessage = '';
            if (e.name === 'AbortError') {
                errorMessage = 'Timeout memuat hadits.';
            } else if (e.message === 'Failed to fetch') {
                errorMessage = 'Koneksi terputus.';
            } else {
                errorMessage = 'Gagal memuat hadits.';
            }

            showErrorMessage(errorMessage);
            fadeInElements();
            scheduleRetry(3000);

        } finally {
            isFetching = false;
        }
    }

    // Initialize dengan teks loading
    const desktopArab = document.getElementById('hadith-arab-desktop');
    const mobileArab = document.getElementById('hadith-arab-mobile');
    const desktopSource = document.getElementById('hadith-source-desktop');
    const mobileSource = document.getElementById('hadith-source-mobile');
    const desktopNumber = document.getElementById('hadith-number-desktop');
    const mobileNumber = document.getElementById('hadith-number-mobile');

    if (desktopArab) desktopArab.textContent = '';
    if (mobileArab) mobileArab.textContent = '';

    if (desktopSource) desktopSource.textContent = 'Hadits dalam 1 Menit';
    if (mobileSource) mobileSource.textContent = 'Hadits dalam 1 Menit';

    if (desktopNumber) desktopNumber.textContent = '';
    if (mobileNumber) mobileNumber.textContent = '';

    setupToggleListeners();

    setTimeout(() => {
        checkOverflow();
    }, 100);

    window.addEventListener('resize', function() {
        checkOverflow();
    });

    startCountdown();
    setTimeout(() => {
        fetchRandomHadith();
    }, 3000);
});
</script>
