{{-- FILE: resources/views/landing-page/service/zakat-calculator/components/_index-scripts.blade.php --}}
<script>
$(document).ready(function () {

    /* -------------------------------------------------------
       KONFIGURASI
    ------------------------------------------------------- */
    const goldPrice     = 2600000;  // Estimasi harga emas Rp/gram
    const nisabGram     = 85;
    const fitrahPerJiwa = 50000;
    let   currentType   = 'penghasilan';

    /* Sinkronkan badge harga emas dengan variabel JS */
    $('#goldPriceDisplay').text('Rp ' + goldPrice.toLocaleString('id-ID') + '/gr');

    /* Jalankan updateUI saat pertama load */
    updateUI();

    /* -------------------------------------------------------
       EVENT: Klik Pill
       Selector .sl-pill — sesuai class di index.blade.php
    ------------------------------------------------------- */
    $('.sl-pill').on('click', function () {
        $('.sl-pill').removeClass('active');
        $(this).addClass('active');
        currentType = $(this).data('type');

        if (currentType === 'fitrah') {
            $('#wealthInputSection').hide();
            $('#fitrahInputSection').show();
        } else {
            $('#wealthInputSection').show();
            $('#fitrahInputSection').hide();
        }

        resetResult();
        updateUI();
    });

    /* -------------------------------------------------------
       UPDATE UI NISAB
    ------------------------------------------------------- */
    function updateUI() {
        const nisabTahun = goldPrice * nisabGram;
        let hint = '';

        if (currentType === 'penghasilan') {
            const nisabBulan = Math.round(nisabTahun / 12);
            hint = 'Nisab per bulan: Rp ' + nisabBulan.toLocaleString('id-ID') + ' (Setara 85gr emas / 12)';
            $('#labelWealth').text('Penghasilan Bersih Per Bulan');
            showPrefix();

        } else if (currentType === 'maal') {
            hint = 'Nisab Maal: Rp ' + nisabTahun.toLocaleString('id-ID') + ' (Sudah tersimpan 1 tahun / haul)';
            $('#labelWealth').text('Total Harta Simpanan (Tabungan/Saham/Uang Tunai)');
            showPrefix();

        } else if (currentType === 'emas') {
            hint = 'Nisab Emas: 85 gram. Input total gram emas yang dimiliki.';
            $('#labelWealth').text('Total Berat Emas (Dalam Gram)');
            hidePrefix();
        }

        $('#nisabDesc').text(hint);
    }

    /* -------------------------------------------------------
       HELPER: Prefix Rp
    ------------------------------------------------------- */
    function showPrefix() {
        $('#currencyPrefix').removeClass('hidden');
        $('#total_wealth')
            .removeClass('no-prefix')
            .addClass('sl-input-with-prefix')
            .attr('placeholder', 'Contoh: 10000000');
    }
    function hidePrefix() {
        $('#currencyPrefix').addClass('hidden');
        $('#total_wealth')
            .removeClass('sl-input-with-prefix')
            .addClass('no-prefix')
            .attr('placeholder', 'Contoh: 100 (dalam gram)');
    }

    /* -------------------------------------------------------
       RESET HASIL
    ------------------------------------------------------- */
    function resetResult() {
        $('#resultBox').hide();
        $('#payButtonContainer').hide();
        $('#total_wealth').val('');
    }

    /* -------------------------------------------------------
       KALKULASI
    ------------------------------------------------------- */
    function calculate() {
        let wealth = parseFloat($('#total_wealth').val()) || 0;
        if (wealth < 0) { wealth = 0; $('#total_wealth').val(0); }

        let jiwa = parseInt($('#total_jiwa').val());
        if (isNaN(jiwa) || jiwa < 1) { jiwa = 1; $('#total_jiwa').val(1); }

        const nisabVal = goldPrice * nisabGram;
        let total = 0, wajib = false;

        if (currentType === 'penghasilan') {
            if (wealth >= nisabVal / 12) { total = wealth * 0.025; wajib = true; }

        } else if (currentType === 'maal') {
            if (wealth >= nisabVal)       { total = wealth * 0.025; wajib = true; }

        } else if (currentType === 'emas') {
            if (wealth >= 85)             { total = (wealth * goldPrice) * 0.025; wajib = true; }

        } else if (currentType === 'fitrah') {
            total = jiwa * fitrahPerJiwa;
            wajib = true;
        }

        const hasInput = wealth > 0 || currentType === 'fitrah';

        if (hasInput) {
            $('#resultBox').fadeIn();
            $('#totalZakat').text('Rp ' + Math.round(total).toLocaleString('id-ID'));

            if (wajib) {
                $('#statusZakat')
                    .text('✅ Wajib Zakat')
                    .attr('class', 'fw-bold mb-2 text-uppercase text-success');
                $('#payButtonContainer').slideDown();
            } else {
                $('#statusZakat')
                    .text('❌ Belum Wajib Zakat')
                    .attr('class', 'fw-bold mb-2 text-uppercase text-muted');
                $('#payButtonContainer').hide();
            }
        } else {
            $('#resultBox').hide();
            $('#payButtonContainer').hide();
        }
    }

    /* -------------------------------------------------------
       EVENT: Input berubah
    ------------------------------------------------------- */
    $('#total_wealth, #total_jiwa').on('input', calculate);

});
</script>