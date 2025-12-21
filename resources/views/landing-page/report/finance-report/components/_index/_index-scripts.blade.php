<!-- Animation Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
    // Initialize WOW.js
    new WOW().init();

    // Set background color
    document.body.style.backgroundColor = "#f5f6fa";
</script>

<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Share Modal Functionality
        $('#shareModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var reportName = button.data('report-name');
            var reportUrl = button.data('report-url');
            var reportViewUrl = button.data('report-view-url');

            var modal = $(this);
            modal.find('#shareReportName').val(reportName);
            modal.find('#shareReportUrl').val(reportUrl);

            // Set WhatsApp share link
            var whatsappText = encodeURIComponent(`Laporan Keuangan: ${reportName}\n\nLihat laporan: ${reportViewUrl}\n\nDownload: ${reportUrl}`);
            modal.find('.btn-share-whatsapp').attr('href', `https://wa.me/?text=${whatsappText}`);

            // Set Telegram share link
            var telegramText = encodeURIComponent(`Laporan Keuangan: ${reportName}\n\nLihat laporan: ${reportViewUrl}\n\nDownload: ${reportUrl}`);
            modal.find('.btn-share-telegram').attr('href', `https://t.me/share/url?url=${encodeURIComponent(reportViewUrl)}&text=${telegramText}`);
        });

        // Copy URL function
        window.copyShareUrl = function() {
            var copyText = document.getElementById("shareReportUrl");
            copyText.select();
            copyText.setSelectionRange(0, 99999);

            try {
                navigator.clipboard.writeText(copyText.value);
                showToast('Link berhasil disalin ke clipboard!', 'success');
            } catch (err) {
                // Fallback for older browsers
                document.execCommand("copy");
                showToast('Link berhasil disalin!', 'success');
            }
        };

        // Toast notification function
        function showToast(message, type = 'success') {
            // Create toast element
            var toast = $('<div class="toast-alert"></div>');
            toast.html(`
                <div class="toast-content">
                    <i class="fas fa-check-circle me-2"></i>
                    ${message}
                </div>
            `);

            // Add styles
            toast.css({
                'position': 'fixed',
                'top': '20px',
                'right': '20px',
                'padding': '15px 20px',
                'background': type === 'success' ? '#2ecc71' : '#e74c3c',
                'color': 'white',
                'border-radius': '8px',
                'box-shadow': '0 5px 15px rgba(0,0,0,0.2)',
                'z-index': '9999',
                'animation': 'slideInRight 0.3s ease'
            });

            // Add to body
            $('body').append(toast);

            // Remove after 3 seconds
            setTimeout(function() {
                toast.animate({right: '-100%'}, 300, function() {
                    toast.remove();
                });
            }, 3000);
        }

        // Add CSS for toast animation
        $('<style>')
            .text(`
                @keyframes slideInRight {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }

                .toast-content {
                    display: flex;
                    align-items: center;
                }
            `)
            .appendTo('head');

        // Row hover effect
        $('.report-row').hover(
            function() {
                $(this).css({
                    'background-color': 'rgba(0, 167, 157, 0.05)',
                    'border-left': '3px solid #00a79d'
                });
            },
            function() {
                $(this).css({
                    'background-color': '',
                    'border-left': ''
                });
            }
        );

        // Table responsive labels
        if ($(window).width() <= 768) {
            $('.finance-report-container table tbody td').each(function() {
                var $this = $(this);
                var index = $this.index();
                var label = '';

                switch(index) {
                    case 0:
                        label = 'Nama Laporan';
                        break;
                    case 1:
                        label = 'Tanggal Unggah';
                        break;
                    case 2:
                        label = 'Aksi';
                        break;
                }

                $this.attr('data-label', label);
            });
        }

        // Update on window resize
        $(window).resize(function() {
            if ($(window).width() <= 768) {
                $('.finance-report-container table tbody td').each(function() {
                    var $this = $(this);
                    var index = $this.index();
                    var label = '';

                    switch(index) {
                        case 0:
                            label = 'Nama Laporan';
                            break;
                        case 1:
                            label = 'Tanggal Unggah';
                            break;
                        case 2:
                            label = 'Aksi';
                            break;
                    }

                    $this.attr('data-label', label);
                });
            } else {
                $('.finance-report-container table tbody td').removeAttr('data-label');
            }
        });

        // Download button click tracking
        $('.btn-download').click(function(e) {
            var reportName = $(this).closest('tr').find('h6').text();
            console.log('Download started:', reportName);
            // You can add analytics tracking here
        });

        // View button click tracking
        $('.btn-view').click(function(e) {
            var reportName = $(this).closest('tr').find('h6').text();
            console.log('Viewing report:', reportName);
            // You can add analytics tracking here
        });

        // Share button click tracking
        $('.btn-share').click(function(e) {
            var reportName = $(this).closest('tr').find('h6').text();
            console.log('Sharing report:', reportName);
            // You can add analytics tracking here
        });

        // Smooth scroll for page sections
        $('a[href^="#"]').on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();
                var hash = this.hash;
                $('html, body').animate({
                    scrollTop: $(hash).offset().top - 80
                }, 800);
            }
        });

        // Add loading animation to empty state
        if ($('.finance-report-container').children().length === 0) {
            $('.finance-report-container').html(`
                <div class="skeleton-loading-card">
                    <div class="skeleton-loading" style="height: 150px; border-radius: 10px; margin-bottom: 20px;"></div>
                    <div class="skeleton-loading" style="height: 150px; border-radius: 10px;"></div>
                </div>
            `);
        }
    });
</script>
