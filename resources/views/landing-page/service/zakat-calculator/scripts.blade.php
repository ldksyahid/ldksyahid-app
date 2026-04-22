<script>
$(document).ready(function() {
    let currentType = 'penghasilan';
    let goldPrice = 2600000; // Harga estimasi 2.6jt/gr
    const nisabGram = 85;

    // Fungsi Update UI Nisab
    function updateUI() {
        let nisabTahun = goldPrice * nisabGram;
        let text = "";

        if(currentType === 'penghasilan') {
            let nisabBulan = Math.round(nisabTahun / 12);
            text = "Nisab per bulan: Rp " + nisabBulan.toLocaleString('id-ID') + " (Setara 85gr emas / 12)";
            $('#labelWealth').text('Penghasilan Bersih Per Bulan');
        } else if(currentType === 'maal') {
            text = "Nisab Maal: Rp " + nisabTahun.toLocaleString('id-ID') + " (Sudah tersimpan 1 tahun)";
            $('#labelWealth').text('Total Harta Simpanan (Tabungan/Saham/Uang Tunai)');
        } else if(currentType === 'emas') {
            text = "Nisab Emas: 85 gram. (Input total gram emas yang dimiliki)";
            $('#labelWealth').text('Total Berat Emas (Dalam Gram)');
        }

        $('#nisabDesc').text(text);
        calculate();
    }

    // Klik Pill Type
    $('.type-pill').on('click', function() {
        $('.type-pill').removeClass('active');
        $(this).addClass('active');
        currentType = $(this).data('type');

        if(currentType === 'fitrah') {
            $('#wealthInputSection').hide();
            $('#fitrahInputSection').show();
        } else {
            $('#wealthInputSection').show();
            $('#fitrahInputSection').hide();
        }
        updateUI();
    });

    // Logic Kalkulasi
    function calculate() {
        let wealth = parseFloat($('#total_wealth').val()) || 0;
        let jiwa = parseInt($('#total_jiwa').val()) || 1;
        let total = 0;
        let wajib = false;
        let nisabVal = goldPrice * nisabGram;

        if(currentType === 'penghasilan') {
            if(wealth >= (nisabVal / 12)) {
                total = wealth * 0.025;
                wajib = true;
            }
        } else if(currentType === 'maal') {
            if(wealth >= nisabVal) {
                total = wealth * 0.025;
                wajib = true;
            }
        } else if(currentType === 'emas') {
            if(wealth >= 85) { // Wealth di sini satuannya gram
                total = (wealth * goldPrice) * 0.025;
                wajib = true;
            }
        } else if(currentType === 'fitrah') {
            total = jiwa * 50000;
            wajib = true;
        }

        if(wealth > 0 || currentType === 'fitrah') {
            $('#resultBox').fadeIn();
            $('#totalZakat').text('Rp ' + Math.round(total).toLocaleString('id-ID'));
            
            if(wajib) {
                $('#statusZakat').text('✅ Wajib Zakat').attr('class', 'fw-bold mb-2 text-success');
                $('#payButtonContainer').slideDown();
            } else {
                $('#statusZakat').text('❌ Belum Wajib').attr('class', 'fw-bold mb-2 text-muted');
                $('#payButtonContainer').hide();
            }
        } else {
            $('#resultBox').hide();
        }
    }

    $('#total_wealth, #total_jiwa').on('input', calculate);
});
</script>