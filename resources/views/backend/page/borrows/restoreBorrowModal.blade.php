
<div class="modal fade" id="restoreBorrowModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius:18px; overflow:hidden;">

            {{-- HEADER --}}
            <div class="modal-header border-0 px-4 py-3"
                 style="background:linear-gradient(135deg,#fff1f2 0%,#ffe4e6 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:44px;height:44px;background:#fecdd3;border-radius:12px;
                                display:flex;align-items:center;justify-content:center;
                                box-shadow:0 4px 12px rgba(244,63,94,0.2);">
                        <i class="bi bi-trash3-fill text-danger fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">{{ __('app.restore_item') }}</h5>

                        <small class="text-muted" id="trashedCount">

                            <i class="bi bi-hourglass-split"></i> {{ __('app.Loading') }}…
                        </small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- TOOLBAR --}}
            <div class="px-4 py-3 border-bottom" style="background:#fafafa;">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <div class="input-group" style="max-width:340px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="trashedSearch" class="form-control border-start-0 ps-0"
                               placeholder="{{ __('app.Search student or item…') }}"
                               style="box-shadow:none;">
                    </div>
                    <button class="btn btn-primary btn-sm px-3" id="trashedSearchBtn">
                        <i class="bi bi-search me-1"></i> {{ __('app.search') }}
                    </button>
                    <button class="btn btn-light btn-sm border px-3" id="trashedResetBtn">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> {{ __('app.reset') }}
                    </button>

                    <div class="ms-auto d-none" id="bulkBar">
                        <span class="badge bg-dark me-2" id="bulkCount">0 {{ __('app.selected') }}</span>
                        <button class="btn btn-success btn-sm px-3" id="bulkRestoreBtn">
                            <i class="bi bi-arrow-clockwise me-1"></i> {{ __('app.Restore selected') }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="modal-body p-0" style="background:#fff;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:#f8f9fa; position:sticky; top:0; z-index:2;">
                            <tr style="font-size:12px; color:#6b7280;">
                                <th class="ps-4" style="width:40px;">
                                    <input type="checkbox" id="selectAllTrashed" class="form-check-input">
                                </th>
                                <th style="width:40px;">#</th>

                                <th>{{ __('app.students') }}</th>
                                <th>{{ __('app.items') }}</th>
                                <th class="text-center">{{ __('app.qty') }}</th>

                                <th>{{ __('app.borrow_date') }}</th>

                                <th>{{ __('app.deleted_by') }}</th>

                                <th>{{ __('app.deleted_at') }}</th>

                                <th>{{ __('app.Status') }}</th>

                                <th class="text-end pe-4">{{ __('app.action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="trashedTbody">
                            {{-- skeleton rows --}}
                            @for ($i = 0; $i < 4; $i++)
                                <tr class="skeleton-row">
                                    <td colspan="10" class="py-3">
                                        <div class="placeholder-glow">
                                            <span class="placeholder col-12" style="height:32px; border-radius:8px;"></span>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0 px-4 py-3" style="background:#fafafa;">
                <small class="text-muted me-auto">
                    <i class="bi bi-info-circle me-1"></i>
                    {{ __('app.Restored records return to the active borrow list.') }}
                </small>
                <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">
                    {{ __('app.Close') }}
                </button>
            </div>

        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Moul&display=swap');
    html[lang="kh"]{
        font-family: 'Moul', 'Noto Sans Khmer', sans-serif;
    }
    #restoreBorrowModal .table tbody tr {
        transition: background .15s ease, transform .15s ease;
    }
    #restoreBorrowModal .table tbody tr:hover {
        background: #fff7f7 !important;
    }
    #restoreBorrowModal .restore-btn {
        border-radius: 8px;
        transition: all .2s ease;
    }
    #restoreBorrowModal .restore-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(25,135,84,.25);
    }
    #restoreBorrowModal .empty-state {
        padding: 60px 20px;
    }
    #restoreBorrowModal .empty-state-icon {
        width: 80px; height: 80px;
        background: #f3f4f6;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        margin-bottom: 16px;
    }
    #restoreBorrowModal .row-removing {
        opacity: 0;
        transform: translateX(30px);
        transition: all .35s ease;
    }
    #restoreBorrowModal .skeleton-row .placeholder {
        background: linear-gradient(90deg,#eee 25%,#f5f5f5 50%,#eee 75%);
        background-size: 200% 100%;
        animation: shimmer 1.4s infinite;
    }
    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    
</style>

@push('scripts')
<script>
(function () {
    const modal        = document.getElementById('restoreBorrowModal');
    const tbody        = document.getElementById('trashedTbody');
    const countLabel   = document.getElementById('trashedCount');
    const searchInput  = document.getElementById('trashedSearch');
    const searchBtn    = document.getElementById('trashedSearchBtn');
    const resetBtn     = document.getElementById('trashedResetBtn');
    const selectAll    = document.getElementById('selectAllTrashed');
    const bulkBar      = document.getElementById('bulkBar');
    const bulkCount    = document.getElementById('bulkCount');
    const bulkBtn      = document.getElementById('bulkRestoreBtn');
    const csrfToken    = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function skeleton() {
        let rows = '';
        for (let i = 0; i < 4; i++) {
            rows += `<tr class="skeleton-row"><td colspan="10" class="py-3">
                <div class="placeholder-glow">
                    <span class="placeholder col-12" style="height:32px;border-radius:8px;"></span>
                </div></td></tr>`;
        }
        tbody.innerHTML = rows;
    }

    function emptyState() {
        tbody.innerHTML = `
            <tr><td colspan="10">
                <div class="empty-state text-center">
                    <div class="empty-state-icon">🗑️</div>
                    <h6 class="fw-bold mb-1">No deleted records</h6>
                    <div class="text-muted small">Deleted borrow records will appear here.</div>
                </div>
            </td></tr>`;
    }

    function updateCount(n) {
        countLabel.innerHTML = `<i class="bi bi-archive me-1"></i>
            <strong>${n}</strong> deleted record${n !== 1 ? 's' : ''}`;
    }

    function updateBulkBar() {
        const checked = tbody.querySelectorAll('.row-check:checked');
        if (checked.length > 0) {
            bulkBar.classList.remove('d-none');
            bulkCount.textContent = `${checked.length} selected`;
        } else {
            bulkBar.classList.add('d-none');
        }
    }

    function loadTrashed(q = '') {
        skeleton();
        fetch(`{{ route('borrows.trashed') }}?q=${encodeURIComponent(q)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            tbody.innerHTML = data.html;
            updateCount(data.total);
            if (data.total === 0) emptyState();
            bindRows();
            selectAll.checked = false;
            updateBulkBar();
        })
        .catch(() => {
            tbody.innerHTML = `<tr><td colspan="10" class="text-center py-4 text-danger">
                <i class="bi bi-exclamation-triangle me-1"></i> Failed to load. Please try again.</td></tr>`;
        });
    }

    function restoreOne(id, btn) {
        const row = document.getElementById('trashed-row-' + id);
        if (btn) { btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'; }

        return fetch(`/admin/borrows/${id}/restore`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success && row) {
                row.classList.add('row-removing');
                setTimeout(() => row.remove(), 350);
            }
            return data.success;
        });
    }

    function bindRows() {
        // per-row restore
        tbody.querySelectorAll('.restore-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                Swal.fire({
                    title: '{{ __("app.Restore this record?") }}',
                    text: '{{ __("app.Restored records return to the active borrow list.") }}',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '{{ __("app.Yes, restore") }}',
                }).then(res => {
                    if (!res.isConfirmed) return;
                    restoreOne(this.dataset.id, this).then(ok => {
                        if (ok) afterRestore(1);
                    });
                });
            });
        });

        // row checkboxes
        tbody.querySelectorAll('.row-check').forEach(cb => {
            cb.addEventListener('change', updateBulkBar);
        });
    }

    function afterRestore(n) {
        const remaining = tbody.querySelectorAll('tr[id^="trashed-row-"]').length - 0;
        updateCount(Math.max(0, remaining));
        Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: `Restored ${n} record${n !== 1 ? 's' : ''}`,
            showConfirmButton: false, timer: 1800
        });
        setTimeout(() => {
            if (tbody.querySelectorAll('tr[id^="trashed-row-"]').length === 0) emptyState();
            updateBulkBar();
            window.location.reload();
        }, 900);
    }

    // select all
    selectAll.addEventListener('change', function () {
        tbody.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
        updateBulkBar();
    });

    // bulk restore
    bulkBtn.addEventListener('click', function () {
        const ids = [...tbody.querySelectorAll('.row-check:checked')].map(cb => cb.value);
        if (ids.length === 0) return;
        Swal.fire({
            title: `Restore ${ids.length} record${ids.length !== 1 ? 's' : ''}?`,
            text: 'They will all move back to the active borrow list.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            confirmButtonText: 'Yes, restore all',
        }).then(res => {
            if (!res.isConfirmed) return;
            bulkBtn.disabled = true;
            bulkBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Restoring…';
            Promise.all(ids.map(id => restoreOne(id, null)))
                .then(() => afterRestore(ids.length))
                .finally(() => {
                    bulkBtn.disabled = false;
                    bulkBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-1"></i> Restore selected';
                });
        });
    });

    // modal events
    modal.addEventListener('show.bs.modal', () => { searchInput.value = ''; loadTrashed(); });
    searchBtn.addEventListener('click', () => loadTrashed(searchInput.value.trim()));
    searchInput.addEventListener('keydown', e => { if (e.key === 'Enter') loadTrashed(searchInput.value.trim()); });
    resetBtn.addEventListener('click', () => { searchInput.value = ''; loadTrashed(); });
})();
</script>
@endpush
