<div class="content page-break lampiran-page">
    <div class="lampiran-tag">Lampiran 1</div>
    <div class="lampiran-title">SUSUNAN ACARA</div>
    <div class="lampiran-subtitle">
        [{{ strtoupper($data['nama_acara'] ?? $data['nama_kegiatan'] ?? 'NAMA KEGIATAN') }}]<br>
        <span style="font-weight: normal; font-size: 10pt;">
            {{ $data['tempat_dipinjam'] ?? $data['tempat'] ?? 'Auditorium Harun Nasution' }}, {{ $hariTanggal }}
        </span>
    </div>

    <table class="rundown-table">
        <thead>
            <tr>
                <th class="col-time">Waktu</th>
                <th class="col-act">Kegiatan</th>
                <th class="col-person">Pengisi</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($data['susunan_acara']) && is_array($data['susunan_acara']))
                @foreach($data['susunan_acara'] as $item)
                    @if(!empty($item['is_header']))
                        <tr class="rundown-section-row">
                            <td colspan="3">{{ $item['kegiatan'] ?? '' }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="col-time">{{ $item['waktu'] ?? '-' }}</td>
                            <td class="col-act">{{ $item['kegiatan'] ?? '-' }}</td>
                            <td class="col-person">{{ $item['pengisi'] ?? '-' }}</td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td class="col-time">08.30 - 09.00</td>
                    <td class="col-act">Registrasi Peserta</td>
                    <td class="col-person">Panitia</td>
                </tr>
                <tr>
                    <td class="col-time">09.00 - 09.10</td>
                    <td class="col-act">Pembukaan</td>
                    <td class="col-person">MC</td>
                </tr>
                <tr>
                    <td class="col-time">09.10 - 09.15</td>
                    <td class="col-act">Tilawah Al-Qur'an</td>
                    <td class="col-person">Pengisi Acara</td>
                </tr>
                <tr>
                    <td class="col-time">09.15 - 09.25</td>
                    <td class="col-act">Menyanyikan Lagu Indonesia Raya, Hymne UIN, dan Mars LDK Syahid</td>
                    <td class="col-person">Panitia &amp; Seluruh Hadirin</td>
                </tr>
                <tr>
                    <td class="col-time">09.25 - 10.00</td>
                    <td class="col-act">
                        Sambutan-sambutan:<br>
                        1. Ketua Pelaksana ({{ $data['nama_ketua_pelaksana'] ?? 'Ketua Pelaksana' }})<br>
                        2. Ketua Umum LDK Syahid (Muhammad Syauqi Mubarak)<br>
                        3. Pembina LDK Syahid UIN Syarif Hidayatullah Jakarta
                    </td>
                    <td class="col-person">
                        Ketua Pelaksana<br>
                        Ketua Umum LDKS<br>
                        Pembina LDKS
                    </td>
                </tr>
                <tr>
                    <td class="col-time">10.00 - 11.45</td>
                    <td class="col-act">Agenda Utama / Acara Inti</td>
                    <td class="col-person">Narasumber / Panitia</td>
                </tr>
                <tr>
                    <td class="col-time">11.45 - 12.30</td>
                    <td class="col-act">Istirahat dan Shalat</td>
                    <td class="col-person">Seluruh Peserta</td>
                </tr>
                <tr>
                    <td class="col-time">12.30 - 14.30</td>
                    <td class="col-act">Sesi Lanjutan &amp; Diskusi Interaktif</td>
                    <td class="col-person">Pemateri &amp; Moderator</td>
                </tr>
                <tr>
                    <td class="col-time">14.30 - 15.00</td>
                    <td class="col-act">Doa, Dokumentasi, dan Penutupan</td>
                    <td class="col-person">Panitia</td>
                </tr>
                <tr>
                    <td class="col-time">15.00 - 16.00</td>
                    <td class="col-act">Operasi Semut &amp; Bersih-bersih Tempat</td>
                    <td class="col-person">Panitia Pelaksana</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
