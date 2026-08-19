{{-- Path: resources/views/admin-page/service-request/persuratan/components/_modal-choose-dept.blade.php --}}
<div class="modal fade" id="modalAdminChooseDept" tabindex="-1" role="dialog" aria-labelledby="modalAdminChooseDeptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <div>
                    <span class="small font-weight-bold text-primary text-uppercase letter-spacing-1 d-block mb-1">
                        <i class="fas fa-sitemap me-1"></i> Department Selector
                    </span>
                    <h5 class="modal-title font-weight-bold text-dark mb-0" id="modalAdminChooseDeptLabel">
                        Select Department / Faculty Division
                    </h5>
                </div>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close" style="font-size:1.5rem;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="px-4 py-3 border-bottom" style="background-color: #f8fafc;">
                {{-- Live Search Bar in Modal --}}
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" id="admSearchDeptModalInput" class="form-control form-control-sm border-start-0"
                           placeholder="Type to filter... (e.g. kaderisasi, humas, sains, fst, tarbiyah)">
                </div>

                {{-- Category Pills --}}
                <div class="adm-modal-cat-pills">
                    <button type="button" class="adm-modal-cat-pill active adm-dept-pill" data-cat="all">All (23)</button>
                    <button type="button" class="adm-modal-cat-pill adm-dept-pill" data-cat="pusat">Pengurus Pusat (13)</button>
                    <button type="button" class="adm-modal-cat-pill adm-dept-pill" data-cat="fakultas">LDKS Fakultas (10)</button>
                </div>
            </div>

            <div class="modal-body p-4" style="max-height: 440px; overflow-y: auto;">
                <div class="row g-2" id="admModalDeptGrid">
                    @foreach (\App\Support\DepartmentRegistry::items() as $code => $dept)
                        <div class="col-md-6 col-12 mb-2 adm-dept-modal-item"
                             data-cat="{{ $dept['group'] }}"
                             data-name="{{ strtolower($dept['name']) }} {{ strtolower($dept['code']) }}">
                            <div class="adm-letter-filter-item adm-dept-item {{ old('kode_bidang', $suratLog->kodeBidangPengaju()) === $code ? 'active' : '' }}"
                                 data-code="{{ $code }}"
                                 data-name="{{ $dept['name'] }}"
                                 data-icon="{{ $dept['icon'] }}"
                                 data-desc="{{ $dept['desc'] }}"
                                 role="button">
                                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:36px;height:36px; min-width:36px; background-color:#e0f2fe; color:#0284c7;">
                                    <i class="fas {{ $dept['icon'] }}"></i>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="d-flex align-items-center justify-content-between gap-1">
                                        <div class="small font-weight-bold text-dark text-truncate">{{ $dept['name'] }}</div>
                                        <span class="badge bg-light text-secondary font-monospace" style="font-size:0.65rem;">{{ $dept['code'] }}</span>
                                    </div>
                                    <div class="text-muted small text-truncate" style="font-size:0.72rem;">{{ $dept['desc'] }}</div>
                                </div>
                                <i class="fas fa-check text-primary ms-1 adm-dept-check {{ old('kode_bidang', $suratLog->kodeBidangPengaju()) === $code ? '' : 'd-none' }}"></i>
                            </div>
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
    var searchDeptInput = document.getElementById('admSearchDeptModalInput');
    var deptPills       = document.querySelectorAll('.adm-dept-pill');
    var deptItems       = document.querySelectorAll('.adm-dept-modal-item');
    var deptItemBtns    = document.querySelectorAll('.adm-dept-item');
    var hiddenDeptInput = document.getElementById('admin_kode_bidang');
    var triggerIcon     = document.getElementById('admDeptPickerIcon');
    var triggerTitle    = document.getElementById('admDeptPickerTitle');
    var triggerDesc     = document.getElementById('admDeptPickerDesc');
    var activeCat       = 'all';

    function filterDeptItems() {
        var query = (searchDeptInput ? searchDeptInput.value.toLowerCase().trim() : '');

        deptItems.forEach(function (item) {
            var itemCat  = item.getAttribute('data-cat');
            var itemName = item.getAttribute('data-name') || '';

            var matchesCat   = (activeCat === 'all' || itemCat === activeCat);
            var matchesQuery = (query === '' || itemName.indexOf(query) !== -1);

            if (matchesCat && matchesQuery) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    if (searchDeptInput) {
        searchDeptInput.addEventListener('input', filterDeptItems);
    }

    deptPills.forEach(function (pill) {
        pill.addEventListener('click', function () {
            deptPills.forEach(function (p) { p.classList.remove('active'); });
            this.classList.add('active');
            activeCat = this.getAttribute('data-cat');
            filterDeptItems();
        });
    });

    deptItemBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var code = this.getAttribute('data-code');
            var name = this.getAttribute('data-name');
            var icon = this.getAttribute('data-icon');
            var desc = this.getAttribute('data-desc');

            if (hiddenDeptInput) hiddenDeptInput.value = code;
            if (triggerIcon && icon) triggerIcon.innerHTML = '<i class="fas ' + icon + '"></i>';
            if (triggerTitle && name) triggerTitle.textContent = name;
            if (triggerDesc && desc) triggerDesc.textContent = desc;

            deptItemBtns.forEach(function (b) {
                b.classList.remove('active');
                var check = b.querySelector('.adm-dept-check');
                if (check) check.classList.add('d-none');
            });

            this.classList.add('active');
            var myCheck = this.querySelector('.adm-dept-check');
            if (myCheck) myCheck.classList.remove('d-none');

            $('#modalAdminChooseDept').modal('hide');
        });
    });

    $('#modalAdminChooseDept').on('shown.bs.modal', function () {
        if (searchDeptInput) searchDeptInput.focus();
    });
});
</script>