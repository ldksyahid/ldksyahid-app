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
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger: 'hover',
                placement: 'top',
                animation: true,
                customClass: 'custom-tooltip'
            });
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

        // Copy URL function with better feedback
        window.copyShareUrl = function() {
            var copyText = document.getElementById("shareReportUrl");
            var copyBtn = document.getElementById("copyLinkBtn");

            copyText.select();
            copyText.setSelectionRange(0, 99999);

            var originalText = copyBtn.innerHTML;
            var originalBg = copyBtn.style.backgroundColor;
            var originalColor = copyBtn.style.color;

            try {
                navigator.clipboard.writeText(copyText.value);

                // Visual feedback
                copyBtn.innerHTML = '<i class="fas fa-check me-1"></i> Disalin!';
                copyBtn.style.backgroundColor = '#2ecc71';
                copyBtn.style.color = 'white';
                copyBtn.style.borderColor = '#2ecc71';

                // Reset after 2 seconds
                setTimeout(function() {
                    copyBtn.innerHTML = '<i class="fas fa-copy"></i>';
                    copyBtn.style.backgroundColor = '';
                    copyBtn.style.color = '';
                    copyBtn.style.borderColor = '';
                }, 2000);

                showToast('Link berhasil disalin ke clipboard!', 'success');
            } catch (err) {
                // Fallback for older browsers
                document.execCommand("copy");

                // Visual feedback
                copyBtn.innerHTML = '<i class="fas fa-check me-1"></i> Disalin!';
                copyBtn.style.backgroundColor = '#2ecc71';
                copyBtn.style.color = 'white';
                copyBtn.style.borderColor = '#2ecc71';

                // Reset after 2 seconds
                setTimeout(function() {
                    copyBtn.innerHTML = '<i class="fas fa-copy"></i>';
                    copyBtn.style.backgroundColor = '';
                    copyBtn.style.color = '';
                    copyBtn.style.borderColor = '';
                }, 2000);

                showToast('Link berhasil disalin!', 'success');
            }
        };

        // Toast notification function with improved styling
        function showToast(message, type = 'success') {
            // Create toast element
            var toast = $('<div class="toast-alert"></div>');
            toast.html(`
                <div class="toast-content d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    ${message}
                </div>
            `);

            // Add styles
            toast.css({
                'position': 'fixed',
                'top': '20px',
                'right': '20px',
                'padding': '12px 16px',
                'background': type === 'success' ? '#2ecc71' : '#e74c3c',
                'color': 'white',
                'border-radius': '12px',
                'box-shadow': '0 5px 15px rgba(0,0,0,0.15)',
                'z-index': '1060',
                'animation': 'slideInRight 0.3s ease',
                'font-size': '0.9rem',
                'border': '1px solid rgba(255, 255, 255, 0.1)',
                'font-weight': '500'
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

        // Add CSS for animations and tooltip styling
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

                /* Custom tooltip styling */
                .custom-tooltip .tooltip-inner {
                    background-color: #00a79d;
                    color: white;
                    border-radius: 12px;
                    padding: 8px 12px;
                    font-size: 0.85rem;
                    font-weight: 500;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                    border: 1px solid rgba(255, 255, 255, 0.1);
                }

                .custom-tooltip.bs-tooltip-top .tooltip-arrow::before {
                    border-top-color: #00a79d;
                }

                .custom-tooltip.bs-tooltip-bottom .tooltip-arrow::before {
                    border-bottom-color: #00a79d;
                }

                /* Modal close button styling */
                .btn-close-white {
                    filter: brightness(0) invert(1);
                    opacity: 0.8;
                    transition: opacity 0.2s ease;
                }

                .btn-close-white:hover {
                    opacity: 1;
                }

                /* Modal input focus effect */
                #shareModal .form-control:focus {
                    border-color: #00a79d;
                    box-shadow: 0 0 0 0.25rem rgba(0, 167, 157, 0.25);
                }

                /* Share button hover effects */
                #shareModal .btn-success:hover {
                    background-color: #128C7E;
                    border-color: #128C7E;
                    transform: translateY(-2px);
                    transition: all 0.3s ease;
                }

                #shareModal .btn-primary:hover {
                    background-color: #0077b5;
                    border-color: #0077b5;
                    transform: translateY(-2px);
                    transition: all 0.3s ease;
                }

                #shareModal .btn-outline-primary:hover {
                    background-color: #00a79d;
                    border-color: #00a79d;
                    color: white;
                    transform: translateY(-2px);
                    transition: all 0.3s ease;
                }

                /* Smooth transition for all buttons */
                #shareModal .btn {
                    transition: all 0.3s ease;
                }
            `)
            .appendTo('head');

        // Accordion hover effects
        $('.accordion-item').hover(
            function() {
                $(this).css('box-shadow', '0 5px 20px rgba(0, 0, 0, 0.15)');
            },
            function() {
                $(this).css('box-shadow', '0 3px 10px rgba(0, 0, 0, 0.08)');
            }
        );

        // Report item hover effects
        $('.report-item').hover(
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

        // Button click tracking
        $('.btn-download').click(function(e) {
            var reportName = $(this).closest('.report-item').find('h6').text();
            console.log('Download started:', reportName);

            // Hide tooltip after click
            var tooltip = bootstrap.Tooltip.getInstance(this);
            if (tooltip) {
                tooltip.hide();
            }
        });

        $('.btn-view').click(function(e) {
            var reportName = $(this).closest('.report-item').find('h6').text();
            console.log('Viewing report:', reportName);

            // Hide tooltip after click
            var tooltip = bootstrap.Tooltip.getInstance(this);
            if (tooltip) {
                tooltip.hide();
            }
        });

        $('.btn-share').click(function(e) {
            var reportName = $(this).closest('.report-item').find('h6').text();
            console.log('Sharing report:', reportName);

            // Hide tooltip after click
            var tooltip = bootstrap.Tooltip.getInstance(this);
            if (tooltip) {
                tooltip.hide();
            }
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

        // Auto-focus input field when modal opens
        $('#shareModal').on('shown.bs.modal', function () {
            $('#shareReportUrl').focus();
        });
    });
</script>
