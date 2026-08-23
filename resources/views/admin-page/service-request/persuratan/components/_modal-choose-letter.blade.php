{{-- Path: resources/views/admin-page/service-request/persuratan/components/_modal-choose-letter.blade.php --}}
<div class="modal fade" id="modalAdminChooseLetter" tabindex="-1" role="dialog" aria-labelledby="modalAdminChooseLetterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <div>
                    <span class="small font-weight-bold text-primary text-uppercase letter-spacing-1 d-block mb-1">
                        <i class="fas fa-filter me-1"></i> Filter by Letter Type
                    </span>
                    <h5 class="modal-title font-weight-bold text-dark mb-0" id="modalAdminChooseLetterLabel">
                        Select Official Letter Template
                    </h5>
                </div>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close" style="font-size:1.5rem;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="px-4 py-3 adm-modal-search-wrap">
                {{-- Live Search Bar in Modal --}}
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" id="admSearchModalInput" class="form-control form-control-sm border-start-0"
                           placeholder="Type to filter... (e.g. izin, pinjam, narasumber, rekomendasi)">
                </div>

                {{-- Category Pills --}}
                <div class="adm-modal-cat-pills">
                    <button type="button" class="adm-modal-cat-pill active" data-cat="all">All (18)</button>
                    <button type="button" class="adm-modal-cat-pill" data-cat="izin_peminjaman">Izin &amp; Peminjaman (8)</button>
                    <button type="button" class="adm-modal-cat-pill" data-cat="permohonan_kemitraan">Permohonan &amp; Mitra (5)</button>
                    <button type="button" class="adm-modal-cat-pill" data-cat="keterangan_undangan">Keterangan &amp; Undangan (5)</button>
                </div>
            </div>

            <div class="modal-body p-4" style="max-height: 440px; overflow-y: auto;">
                <div class="row g-2" id="admModalLetterGrid">
                    {{-- Option: All Types --}}
                    <div class="col-md-6 col-12 mb-2 adm-modal-item" data-cat="all" data-name="all letter types">
                        <a href="{{ route('admin.persuratan.index', request()->except('jenis', 'page')) }}"
                           class="adm-letter-filter-item {{ !request('jenis') ? 'active' : '' }}">
                            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:36px;height:36px; min-width:36px; background-color:#e0f2fe; color:#0284c7;">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <div class="small font-weight-bold text-dark text-truncate">All Letter Types</div>
                                <div class="text-muted small" style="font-size:0.72rem;">Show all requests from every template</div>
                            </div>
                            @if (!request('jenis'))
                                <i class="fas fa-check text-primary"></i>
                            @endif
                        </a>
                    </div>

                    @foreach ($suratTypes as $key => $surat)
                        <div class="col-md-6 col-12 mb-2 adm-modal-item"
                             data-cat="{{ $surat['category'] ?? 'all' }}"
                             data-name="{{ strtolower($surat['label']) }} {{ strtolower($surat['badge'] ?? '') }}">
                            <a href="{{ route('admin.persuratan.index', array_merge(request()->except('page'), ['jenis' => $key])) }}"
                               class="adm-letter-filter-item {{ request('jenis') === $key ? 'active' : '' }}">
                                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:36px;height:36px; min-width:36px; background-color:#e0f2fe; color:#0284c7;">
                                    <i class="fas {{ $surat['icon'] ?? 'fa-file-alt' }}"></i>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="d-flex align-items-center justify-content-between gap-1">
                                        <div class="small font-weight-bold text-dark text-truncate">{{ $surat['label'] }}</div>
                                        <span class="badge bg-light text-secondary font-monospace" style="font-size:0.65rem;">{{ $surat['badge'] ?? 'Ph-e' }}</span>
                                    </div>
                                    <div class="text-muted small text-truncate" style="font-size:0.72rem;">{{ $surat['description'] ?? 'Surat resmi' }}</div>
                                </div>
                                @if (request('jenis') === $key)
                                    <i class="fas fa-check text-primary ms-1"></i>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="modal-footer border-top px-4 py-2 bg-light">
                <button type="button" class="btn btn-secondary btn-sm rounded-3 px-3" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var searchInput = document.getElementById('admSearchModalInput');
    var catPills    = document.querySelectorAll('.adm-modal-cat-pill');
    var items       = document.querySelectorAll('.adm-modal-item');
    var activeCat   = 'all';

    function filterModalItems() {
        var query = (searchInput ? searchInput.value.toLowerCase().trim() : '');

        items.forEach(function (item) {
            var itemCat  = item.getAttribute('data-cat');
            var itemName = item.getAttribute('data-name') || '';

            var matchesCat   = (activeCat === 'all' || itemCat === activeCat || itemCat === 'all');
            var matchesQuery = (query === '' || itemName.indexOf(query) !== -1);

            if (matchesCat && matchesQuery) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterModalItems);
    }

    catPills.forEach(function (pill) {
        pill.addEventListener('click', function () {
            catPills.forEach(function (p) { p.classList.remove('active'); });
            this.classList.add('active');
            activeCat = this.getAttribute('data-cat');
            filterModalItems();
        });
    });

    $('#modalAdminChooseLetter').on('shown.bs.modal', function () {
        if (searchInput) searchInput.focus();
    });
});
</script>