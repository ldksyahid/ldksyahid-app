{{-- FILE: resources/views/landing-page/service/zakat-calculator/components/_index-scripts.blade.php --}}
<script>
$(document).ready(function () {

    /* -------------------------------------------------------
       KONFIGURASI AWAL
    ------------------------------------------------------- */
    let   goldPrice     = 2600000;   // Rp/gram — bisa diubah user
    const nisabGram     = 85;        // gram emas
    const fitrahPerJiwa = 50000;     // Rp/jiwa (BAZNAS Pusat)
    const nisabPertanian = 653;      // kg gabah setara
    let   currentType   = 'penghasilan';

    /* Tabel Nisab Peternakan
       Sumber: Fiqh Zakat Yusuf Qardhawi & Keputusan Menteri Agama RI */
    const peternakanNisab = {
        kambing: [
            { min: 1,   max: 39,  zakat: 0,  keterangan: 'Belum wajib' },
            { min: 40,  max: 120, zakat: 1,  keterangan: '1 ekor kambing/domba (umur ≥ 1 th)' },
            { min: 121, max: 200, zakat: 2,  keterangan: '2 ekor kambing/domba' },
            { min: 201, max: 399, zakat: 3,  keterangan: '3 ekor kambing/domba' },
            { min: 400, max: 499, zakat: 4,  keterangan: '4 ekor kambing/domba' },
        ],
        sapi: [
            { min: 1,   max: 29,  zakat: 0,  keterangan: 'Belum wajib' },
            { min: 30,  max: 39,  zakat: 1,  keterangan: '1 ekor sapi/kerbau umur ≥ 1 th (tabi\')' },
            { min: 40,  max: 59,  zakat: 1,  keterangan: '1 ekor sapi/kerbau umur ≥ 2 th (musinnah)' },
            { min: 60,  max: 69,  zakat: 2,  keterangan: '2 ekor sapi/kerbau umur ≥ 1 th' },
            { min: 70,  max: 79,  zakat: 3,  keterangan: '2 ekor umur ≥ 1 th + 1 ekor umur ≥ 2 th' },
            { min: 80,  max: 89,  zakat: 2,  keterangan: '2 ekor sapi/kerbau umur ≥ 2 th' },
            { min: 90,  max: 99,  zakat: 3,  keterangan: '3 ekor sapi/kerbau umur ≥ 1 th' },
            { min: 100, max: 999, zakat: null, keterangan: 'Setiap 30 ekor: 1 ekor umur ≥ 1 th; setiap 40 ekor: 1 ekor umur ≥ 2 th' },
        ],
        unta: [
            { min: 1,   max: 4,   zakat: 0,  keterangan: 'Belum wajib' },
            { min: 5,   max: 9,   zakat: 1,  keterangan: '1 ekor kambing' },
            { min: 10,  max: 14,  zakat: 2,  keterangan: '2 ekor kambing' },
            { min: 15,  max: 19,  zakat: 3,  keterangan: '3 ekor kambing' },
            { min: 20,  max: 24,  zakat: 4,  keterangan: '4 ekor kambing' },
            { min: 25,  max: 35,  zakat: 1,  keterangan: '1 ekor unta bintu makhad (umur ≥ 1 th)' },
            { min: 36,  max: 45,  zakat: 1,  keterangan: '1 ekor unta bintu labun (umur ≥ 2 th)' },
            { min: 46,  max: 60,  zakat: 1,  keterangan: '1 ekor unta hiqqah (umur ≥ 3 th)' },
            { min: 61,  max: 75,  zakat: 1,  keterangan: '1 ekor unta jadza\'ah (umur ≥ 4 th)' },
            { min: 76,  max: 90,  zakat: 2,  keterangan: '2 ekor unta bintu labun' },
            { min: 91,  max: 120, zakat: 2,  keterangan: '2 ekor unta hiqqah' },
            { min: 121, max: 999, zakat: null, keterangan: 'Setiap 40 ekor: 1 bintu labun; setiap 50 ekor: 1 hiqqah' },
        ],
        kerbau: [] // Kerbau = sama dengan sapi (qiyas), dihandle di JS
    };

    /* -------------------------------------------------------
       INISIALISASI
    ------------------------------------------------------- */
    $('#goldPriceInput').val(formatRibuan(goldPrice));
    updateGoldBadge();
    updateUI();

    /* -------------------------------------------------------
       FORMAT RIBUAN
    ------------------------------------------------------- */
    function formatRibuan(n) {
        return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    function parseRibuan(s) {
        return parseFloat((s || '').replace(/\./g, '')) || 0;
    }

    /* -------------------------------------------------------
       EVENT: Input harga emas
    ------------------------------------------------------- */
    $('#goldPriceInput').on('input', function () {
        let raw = $(this).val().replace(/\./g, '').replace(/\D/g, '');
        let num = parseInt(raw) || 0;
        $(this).val(num > 0 ? formatRibuan(num) : '');
        goldPrice = num > 0 ? num : 2600000;
        updateGoldBadge();
        updateUI();
        calculate();
    });

    function updateGoldBadge() {
        $('#goldPriceDisplay').text('Rp ' + formatRibuan(goldPrice) + '/gr');
    }

    /* -------------------------------------------------------
       EVENT: Klik Pill
    ------------------------------------------------------- */
    $('.sl-pill').on('click', function () {
        $('.sl-pill').removeClass('active');
        $(this).addClass('active');
        currentType = $(this).data('type');
        showInputSection(currentType);
        resetResult();
        updateUI();
    });

    function showInputSection(type) {
        $('#wealthInputSection').hide();
        $('#fitrahInputSection').hide();
        $('#perdaganganInputSection').hide();
        $('#pertanianInputSection').hide();
        $('#peternakanInputSection').hide();

        if (type === 'fitrah')        $('#fitrahInputSection').show();
        else if (type === 'perdagangan') $('#perdaganganInputSection').show();
        else if (type === 'pertanian')   $('#pertanianInputSection').show();
        else if (type === 'peternakan')  $('#peternakanInputSection').show();
        else                             $('#wealthInputSection').show();
    }

    /* -------------------------------------------------------
       FORMAT RIBUAN real-time pada input uang
    ------------------------------------------------------- */
    function attachRibuanFormat(selector) {
        $(selector).on('input', function () {
            let raw   = $(this).val().replace(/\./g, '').replace(/\D/g, '');
            let num   = parseInt(raw) || 0;
            let caret = this.selectionStart;
            let prev  = $(this).val().length;
            $(this).val(num > 0 ? formatRibuan(num) : '');
            let diff = $(this).val().length - prev;
            try { this.setSelectionRange(caret + diff, caret + diff); } catch(e) {}
            calculate();
        });
    }

    attachRibuanFormat('#total_wealth');
    attachRibuanFormat('#stok_barang');
    attachRibuanFormat('#piutang_dagang');
    attachRibuanFormat('#kas_bank');
    attachRibuanFormat('#utang_dagang');

    /* -------------------------------------------------------
       UPDATE UI — label, hint, deskripsi per jenis
    ------------------------------------------------------- */
    function updateUI() {
        const nisabTahun = goldPrice * nisabGram;
        let hint = '', desc = '';

        switch (currentType) {
            case 'penghasilan':
                const nb = Math.round(nisabTahun / 12);
                hint = 'Nisab/bulan: Rp ' + formatRibuan(nb) + ' (85gr ÷ 12) | Ref: Fatwa MUI No.3/2003';
                desc = 'Zakat atas penghasilan/profesi bulanan. Tarif <strong>2,5%</strong> dari penghasilan bruto jika mencapai nisab. Metode bruto dipilih atas prinsip <em>ihtiyath</em>.';
                $('#labelWealth').text('Penghasilan Bersih Per Bulan');
                showPrefix(); break;

            case 'maal':
                hint = 'Nisab Maal: Rp ' + formatRibuan(nisabTahun) + ' (disimpan ≥ 1 haul) | Ref: Fatwa MUI No.3/2003';
                desc = 'Zakat atas harta simpanan (tabungan, saham, uang tunai) yang telah tersimpan <strong>1 tahun penuh (haul)</strong>. Tarif <strong>2,5%</strong>.';
                $('#labelWealth').text('Total Harta Simpanan');
                showPrefix(); break;

            case 'emas':
                hint = 'Nisab: 85 gram emas (≥ 1 haul). Input dalam gram.';
                desc = 'Zakat atas kepemilikan emas/perak ≥ nisab setelah <strong>1 haul</strong>. Tarif <strong>2,5%</strong> dari nilai jual emas saat ini.';
                $('#labelWealth').text('Total Berat Emas (Gram)');
                hidePrefix(); break;

            case 'perdagangan':
                hint = 'Nisab: Rp ' + formatRibuan(nisabTahun) + ' (setara 85gr emas, ≥ 1 haul) | Ref: Fatwa MUI No.4/2014';
                desc = 'Zakat atas usaha perdagangan. Dihitung dari <strong>(Stok + Piutang Lancar + Kas/Bank) − Utang Jatuh Tempo</strong>. Tarif <strong>2,5%</strong> jika mencapai nisab.';
                break;

            case 'pertanian':
                hint = 'Nisab: 653 kg gabah / 524 kg beras per panen. Tidak perlu haul. | Ref: Fatwa MUI No.3/2003';
                desc = 'Zakat hasil pertanian per panen. Tarif: <strong>5%</strong> jika menggunakan irigasi/biaya pengairan, <strong>10%</strong> jika tadah hujan/tanpa biaya. Tidak disyaratkan haul.';
                break;

            case 'peternakan':
                hint = 'Nisab berbeda tiap jenis hewan. Disyaratkan ≥ 1 haul. | Ref: Kitab Fiqh Zakat Yusuf Qardhawi';
                desc = 'Zakat atas hewan ternak yang digembalakan (sa\'imah) dan telah dimiliki selama <strong>1 haul</strong>. Nisab dan kadar zakat berbeda untuk tiap jenis hewan.';
                break;

            case 'fitrah':
                hint = '';
                desc = 'Wajib bagi setiap Muslim yang mampu menjelang Idul Fitri. Standar: <strong>Rp 50.000/jiwa</strong> (BAZNAS Pusat).';
                break;
        }

        $('#nisabDesc').html(hint);
        $('#zakatTypeDesc').html(desc);
    }

    /* -------------------------------------------------------
       HELPER: Prefix Rp
    ------------------------------------------------------- */
    function showPrefix() {
        $('#currencyPrefix').removeClass('hidden');
        $('#total_wealth').removeClass('no-prefix').addClass('sl-input-with-prefix').attr('placeholder', 'Contoh: 5.000.000');
    }
    function hidePrefix() {
        $('#currencyPrefix').addClass('hidden');
        $('#total_wealth').removeClass('sl-input-with-prefix').addClass('no-prefix').attr('placeholder', 'Contoh: 100 (gram)');
    }

    /* -------------------------------------------------------
       RESET HASIL
    ------------------------------------------------------- */
    function resetResult() {
        $('#resultBox').hide();
        $('#payButtonContainer').hide();
        $('#total_wealth, #stok_barang, #piutang_dagang, #kas_bank, #utang_dagang').val('');
        $('#total_jiwa').val(1);
        $('#jumlah_hewan').val('');
        $('#hasil_panen_kg').val('');
        $('#total_perdagangan_display').text('Rp 0').removeClass('text-danger text-success');
    }

    /* -------------------------------------------------------
       KALKULASI UTAMA
    ------------------------------------------------------- */
    function calculate() {
        const nisabVal = goldPrice * nisabGram;
        let total = 0, wajib = false, extraInfo = '';

        /* ---- Penghasilan ---- */
        if (currentType === 'penghasilan') {
            let w = parseRibuan($('#total_wealth').val());
            if (w >= nisabVal / 12) { total = w * 0.025; wajib = true; }

        /* ---- Maal ---- */
        } else if (currentType === 'maal') {
            let w = parseRibuan($('#total_wealth').val());
            if (w >= nisabVal) { total = w * 0.025; wajib = true; }

        /* ---- Emas ---- */
        } else if (currentType === 'emas') {
            let gram = parseFloat($('#total_wealth').val()) || 0;
            if (gram >= 85) { total = gram * goldPrice * 0.025; wajib = true; }

        /* ---- Perdagangan ---- */
        } else if (currentType === 'perdagangan') {
            let stok     = parseRibuan($('#stok_barang').val());
            let piutang  = parseRibuan($('#piutang_dagang').val());
            let kas      = parseRibuan($('#kas_bank').val());
            let utang    = parseRibuan($('#utang_dagang').val());
            let asetBersih = stok + piutang + kas - utang;

            // Tampilkan aset bersih live
            $('#total_perdagangan_display')
                .text('Rp ' + formatRibuan(asetBersih))
                .removeClass('text-danger text-success')
                .addClass(asetBersih < 0 ? 'text-danger' : 'text-success');

            if (asetBersih > 0 && (stok + piutang + kas) > 0) {
                if (asetBersih >= nisabVal) {
                    total = asetBersih * 0.025;
                    wajib = true;
                }
                extraInfo = 'Aset bersih dagang: Rp ' + formatRibuan(asetBersih);
            }

        /* ---- Pertanian ---- */
        } else if (currentType === 'pertanian') {
            let kg     = parseFloat($('#hasil_panen_kg').val()) || 0;
            let tarif  = $('input[name="tarif_pertanian"]:checked').val() === 'irigasi' ? 0.05 : 0.10;
            let tarifLabel = tarif === 0.05 ? '5% (Irigasi)' : '10% (Tadah Hujan)';
            if (kg >= nisabPertanian) {
                total = kg * goldPrice * 0.025 * (tarif / 0.025); // konversi: zakat = kg * tarif, dalam Rp = kg * harga_beras_equiv
                // ---- koreksi: zakat pertanian dalam KG, lalu dikonversi Rp ----
                // Nilai hasil panen = kg × harga gabah estimasi
                // Tapi karena tidak ada input harga gabah, kita pakai nilai uang alternatif
                // → tampilkan dalam KG dan Rp estimasi
                let zakatKg = kg * tarif;
                let hargaGabahEstimasi = 6000; // Rp/kg, estimasi harga gabah 2024
                total = zakatKg * hargaGabahEstimasi;
                wajib = true;
                extraInfo = 'Zakat: ' + zakatKg.toFixed(2) + ' kg gabah ≈ Rp ' + formatRibuan(total) + ' (est. Rp 6.000/kg) | Tarif: ' + tarifLabel;
            }

        /* ---- Peternakan ---- */
        } else if (currentType === 'peternakan') {
            let jenis  = $('#jenis_hewan').val();
            let jumlah = parseInt($('#jumlah_hewan').val()) || 0;
            // kerbau = mengikuti nisab sapi
            let tabel  = jenis === 'kerbau' ? peternakanNisab.sapi : peternakanNisab[jenis];
            if (tabel && jumlah > 0) {
                let row = tabel.find(r => jumlah >= r.min && jumlah <= r.max);
                if (!row) row = tabel[tabel.length - 1]; // ambil baris terakhir jika > max
                if (row && row.zakat !== 0) {
                    wajib = row.zakat > 0 || row.zakat === null;
                    // Tidak ada nilai Rp untuk peternakan — tampilkan keterangan
                    total = 0;
                    extraInfo = row.keterangan;
                    showPeternakanResult(wajib, row);
                    return;
                }
            }

        /* ---- Fitrah ---- */
        } else if (currentType === 'fitrah') {
            let jiwa = parseInt($('#total_jiwa').val()) || 1;
            total = jiwa * fitrahPerJiwa;
            wajib = true;
        }

        showMoneyResult(wajib, total, extraInfo);
    }

    /* -------------------------------------------------------
       TAMPIL HASIL — uang
    ------------------------------------------------------- */
    function showMoneyResult(wajib, total, extraInfo) {
        const hasInput = hasAnyInput();
        if (!hasInput) { $('#resultBox').hide(); $('#payButtonContainer').hide(); return; }

        $('#resultBox').fadeIn();
        $('#totalZakat').html('Rp ' + formatRibuan(Math.round(total)));
        $('#extraInfo').html(extraInfo ? '<small class="text-muted d-block mt-1">' + extraInfo + '</small>' : '');

        if (wajib) {
            $('#statusZakat').text('✅ Wajib Zakat').attr('class', 'fw-bold mb-2 text-uppercase text-success');
            $('#payButtonContainer').slideDown();
        } else {
            $('#statusZakat').text('❌ Belum Wajib Zakat').attr('class', 'fw-bold mb-2 text-uppercase text-muted');
            $('#payButtonContainer').hide();
        }
    }

    /* -------------------------------------------------------
       TAMPIL HASIL — peternakan (non-uang)
    ------------------------------------------------------- */
    function showPeternakanResult(wajib, row) {
        $('#resultBox').fadeIn();
        if (wajib) {
            $('#statusZakat').text('✅ Wajib Zakat').attr('class', 'fw-bold mb-2 text-uppercase text-success');
            $('#totalZakat').html('<span style="font-size:1.1rem">' + row.keterangan + '</span>');
            $('#extraInfo').html('<small class="text-muted">Zakat peternakan dibayarkan dalam bentuk hewan, bukan uang tunai.</small>');
            $('#payButtonContainer').slideDown();
        } else {
            $('#statusZakat').text('❌ Belum Wajib Zakat').attr('class', 'fw-bold mb-2 text-uppercase text-muted');
            $('#totalZakat').html('<span style="font-size:1rem; color:#94a3b8">' + row.keterangan + '</span>');
            $('#extraInfo').html('');
            $('#payButtonContainer').hide();
        }
    }

    /* -------------------------------------------------------
       HELPER: cek apakah ada input
    ------------------------------------------------------- */
    function hasAnyInput() {
        if (currentType === 'fitrah') return true;
        if (currentType === 'perdagangan') {
            return parseRibuan($('#stok_barang').val()) > 0
                || parseRibuan($('#piutang_dagang').val()) > 0
                || parseRibuan($('#kas_bank').val()) > 0;
        }
        if (currentType === 'pertanian') return (parseFloat($('#hasil_panen_kg').val()) || 0) > 0;
        if (currentType === 'peternakan') return (parseInt($('#jumlah_hewan').val()) || 0) > 0;
        return parseRibuan($('#total_wealth').val()) > 0 || (parseFloat($('#total_wealth').val()) || 0) > 0;
    }

    /* -------------------------------------------------------
       EVENT LISTENERS
    ------------------------------------------------------- */
    $('#total_jiwa').on('input', calculate);
    $('#hasil_panen_kg, #jumlah_hewan').on('input', calculate);
    $('#jenis_hewan').on('change', function () { $('#jumlah_hewan').val(''); resetResult(); calculate(); });
    $('input[name="tarif_pertanian"]').on('change', calculate);

});
</script>