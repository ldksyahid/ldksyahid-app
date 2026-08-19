{{-- Path: resources/views/landing-page/service/persuratan/components/_modal-choose-letter.blade.php --}}
<div class="modal fade prs-modal" id="modalChooseLetter" tabindex="-1" aria-labelledby="modalChooseLetterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content prs-modal-content">

            {{-- Modal Header --}}
            <div class="modal-header prs-modal-header">
                <div>
                    <span class="prs-modal-eyebrow"><i class="fas fa-file-signature me-1"></i> Layanan Mandiri</span>
                    <h5 class="modal-title prs-modal-title" id="modalChooseLetterLabel">Pilih Jenis Surat Resmi</h5>
                </div>
                <button type="button" class="btn-close prs-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Modal Search & Category Filter --}}
            <div class="prs-modal-filter-wrap">
                <div class="prs-search-input-wrap">
                    <i class="fas fa-search prs-search-icon"></i>
                    <input type="text" id="prsSearchInput" class="prs-search-input" placeholder="Ketik kata kunci surat... misal: izin, pinjam, pemateri, rekomendasi" autocomplete="off">
                    <button type="button" id="prsClearSearch" class="prs-search-clear" style="display:none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Category Filter Pills --}}
                <div class="prs-cat-pills-wrap">
                    <button type="button" class="prs-cat-pill active" data-category="all">
                        <i class="fas fa-th-large me-1"></i> Semua (18)
                    </button>
                    @foreach (\App\Support\LetterRegistry::categories() as $catKey => $catData)
                        <button type="button" class="prs-cat-pill" data-category="{{ $catKey }}">
                            <i class="fas {{ $catData['icon'] }} me-1"></i> {{ $catData['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Modal Body: Cards Grid --}}
            <div class="modal-body prs-modal-body">
                <div class="prs-letters-grid" id="prsLettersGrid">
                    @foreach ($suratTypes as $key => $surat)
                        <div class="prs-letter-card {{ old('jenis_surat', $reapplyLog?->jenis_surat) === $key ? 'selected' : '' }}"
                             data-key="{{ $key }}"
                             data-category="{{ $surat['category'] ?? 'izin_peminjaman' }}"
                             data-label="{{ $surat['label'] }}"
                             data-badge="{{ $surat['badge'] ?? 'Ph-e' }}"
                             data-icon="{{ $surat['icon'] ?? 'fa-file-alt' }}"
                             data-desc="{{ $surat['description'] ?? 'Surat resmi untuk keperluan kegiatan dan organisasi' }}">
                            <div class="prs-letter-card-icon">
                                <i class="fas {{ $surat['icon'] ?? 'fa-file-alt' }}"></i>
                            </div>
                            <div class="prs-letter-card-content">
                                <div class="prs-letter-card-head">
                                    <h6 class="prs-letter-card-title">{{ $surat['label'] }}</h6>
                                    <span class="prs-letter-card-badge">{{ $surat['badge'] ?? 'Ph-e' }}</span>
                                </div>
                                <p class="prs-letter-card-desc">{{ $surat['description'] ?? 'Surat resmi untuk keperluan kegiatan dan organisasi' }}</p>
                            </div>
                            <div class="prs-letter-card-check">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Empty Search Result --}}
                <div class="prs-empty-search text-center py-5" id="prsEmptySearch" style="display:none;">
                    <i class="fas fa-search mb-3" style="font-size: 2.5rem; color: #94a3b8;"></i>
                    <h6 class="fw-bold mb-1">Surat Tidak Ditemukan</h6>
                    <p class="text-muted small">Coba gunakan kata kunci lain seperti <em>izin</em>, <em>pinjam</em>, <em>rekomendasi</em>, atau <em>undangan</em>.</p>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer prs-modal-footer">
                <span class="text-muted small me-auto d-none d-sm-inline">
                    <i class="fas fa-info-circle text-primary me-1"></i> Klik pada salah satu jenis surat untuk memilih template formulir
                </span>
                <button type="button" class="prs-btn-close-modal" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>