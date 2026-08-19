{{-- Path: resources/views/landing-page/service/persuratan/components/_modal-choose-dept.blade.php --}}
<div class="modal fade prs-modal" id="modalChooseDepartment" tabindex="-1" aria-labelledby="modalChooseDepartmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content prs-modal-content">

            {{-- Modal Header --}}
            <div class="modal-header prs-modal-header">
                <div>
                    <span class="prs-modal-eyebrow"><i class="fas fa-sitemap me-1"></i> Struktur Organisasi</span>
                    <h5 class="modal-title prs-modal-title" id="modalChooseDepartmentLabel">Pilih Asal Bidang / LDKSF Pengaju</h5>
                </div>
                <button type="button" class="btn-close prs-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Modal Search & Category Filter --}}
            <div class="prs-modal-filter-wrap">
                <div class="prs-search-input-wrap">
                    <i class="fas fa-search prs-search-icon"></i>
                    <input type="text" id="prsSearchDeptInput" class="prs-search-input" placeholder="Cari bidang atau fakultas... misal: kaderisasi, humas, sains, fst, tarbiyah..." autocomplete="off">
                    <button type="button" id="prsClearDeptSearch" class="prs-search-clear" style="display:none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Category Filter Pills --}}
                <div class="prs-cat-pills-wrap">
                    <button type="button" class="prs-cat-pill active prs-dept-cat-pill" data-dept-cat="all">
                        <i class="fas fa-th-large me-1"></i> Semua (23)
                    </button>
                    <button type="button" class="prs-cat-pill prs-dept-cat-pill" data-dept-cat="pusat">
                        <i class="fas fa-landmark me-1"></i> Pengurus Pusat (13)
                    </button>
                    <button type="button" class="prs-cat-pill prs-dept-cat-pill" data-dept-cat="fakultas">
                        <i class="fas fa-graduation-cap me-1"></i> LDKS Fakultas (10)
                    </button>
                </div>
            </div>

            {{-- Modal Body: Cards Grid --}}
            <div class="modal-body prs-modal-body">
                <div class="prs-letters-grid" id="prsDeptGrid">
                    @foreach (\App\Support\DepartmentRegistry::items() as $code => $dept)
                        <div class="prs-letter-card prs-dept-card"
                             data-code="{{ $code }}"
                             data-cat="{{ $dept['group'] }}"
                             data-name="{{ $dept['name'] }}"
                             data-badge="{{ $dept['badge'] }}"
                             data-icon="{{ $dept['icon'] }}"
                             data-desc="{{ $dept['desc'] }}">
                            <div class="prs-letter-card-icon">
                                <i class="fas {{ $dept['icon'] }}"></i>
                            </div>
                            <div class="prs-letter-card-content">
                                <div class="prs-letter-card-head">
                                    <h6 class="prs-letter-card-title">{{ $dept['name'] }}</h6>
                                    <span class="prs-letter-card-badge">{{ $dept['code'] }}</span>
                                </div>
                                <p class="prs-letter-card-desc">{{ $dept['desc'] }}</p>
                            </div>
                            <div class="prs-letter-card-check">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Empty Search Result --}}
                <div class="prs-empty-search text-center py-5" id="prsEmptyDeptSearch" style="display:none;">
                    <i class="fas fa-search mb-3" style="font-size: 2.5rem; color: #94a3b8;"></i>
                    <h6 class="fw-bold mb-1">Bidang / Fakultas Tidak Ditemukan</h6>
                    <p class="text-muted small">Coba gunakan kata kunci lain seperti <em>kaderisasi</em>, <em>humas</em>, <em>fst</em>, atau <em>tarbiyah</em>.</p>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer prs-modal-footer">
                <span class="text-muted small me-auto d-none d-sm-inline">
                    <i class="fas fa-info-circle text-primary me-1"></i> Klik untuk memilih asal divisi/fakultas pengaju surat
                </span>
                <button type="button" class="prs-btn-close-modal" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>