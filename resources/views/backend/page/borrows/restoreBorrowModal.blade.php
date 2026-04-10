<div class="modal fade" id="restoreBorrowModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header" style="background:#fef2f2;border-bottom:1px solid #fecaca;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:36px;height:36px;background:#fee2e2;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-trash-fill text-danger"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ __('app.restore_item') }}</div>
                        <small class="text-muted" id="trashedCount">Loading…</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Search bar --}}
            <div class="px-3 py-2 border-bottom d-flex gap-2">
                <div class="input-group" style="max-width:320px;">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" id="trashedSearch" class="form-control"
                           placeholder="Search student or item…">
                </div>
                <button class="btn btn-primary btn-sm" id="trashedSearchBtn">Search</button>
                <button class="btn btn-secondary btn-sm" id="trashedResetBtn">Reset</button>
            </div>

            {{-- Table --}}
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Borrow Date</th>
                                <th>Return Date</th>
                                <th>Deleted By</th>
                                <th>Deleted At</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="trashedTbody">
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">
                                    <div style="font-size:24px;">⏳</div>
                                    Loading…
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const modal       = document.getElementById('restoreBorrowModal');
    const tbody       = document.getElementById('trashedTbody');
    const countLabel  = document.getElementById('trashedCount');
    const searchInput = document.getElementById('trashedSearch');
    const searchBtn   = document.getElementById('trashedSearchBtn');
    const resetBtn    = document.getElementById('trashedResetBtn');
    const csrfToken   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function setLoading() {
        tbody.innerHTML = `<tr><td colspan="10" class="text-center py-4 text-muted">
            <div style="font-size:24px;">⏳</div>Loading…</td></tr>`;
    }

    function loadTrashed(q = '') {
        setLoading();
        fetch(`{{ route('borrows.trashed') }}?q=${encodeURIComponent(q)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            tbody.innerHTML = data.html;
            countLabel.textContent = data.total + ' deleted record' + (data.total !== 1 ? 's' : '');
            bindRestoreButtons();
        })
        .catch(() => {
            tbody.innerHTML = `<tr><td colspan="10" class="text-center py-4 text-danger">
                Failed to load. Please try again.</td></tr>`;
        });
    }

    function bindRestoreButtons() {
        tbody.querySelectorAll('.restore-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id  = this.dataset.id;
                const row = document.getElementById('trashed-row-' + id);

                this.disabled    = true;
                this.textContent = 'Restoring…';

                fetch(`/admin/borrows/${id}/restore`, {
                    method:  'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN':      csrfToken,
                        'Accept':            'application/json',
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        if (row) row.remove();

                        const current  = parseInt(countLabel.textContent) || 0;
                        const newCount = Math.max(0, current - 1);
                        countLabel.textContent = newCount + ' deleted record' + (newCount !== 1 ? 's' : '');

                        if (typeof showAjaxMessage === 'function') {
                            showAjaxMessage(data.message, 'success');
                        }

                        if (tbody.querySelectorAll('tr[id]').length === 0) {
                            tbody.innerHTML = `<tr><td colspan="10" class="text-center py-4 text-muted">
                                No deleted records found.</td></tr>`;
                        }

                        setTimeout(() => window.location.reload(), 800);
                    }
                })
                .catch(() => {
                    this.disabled    = false;
                    this.textContent = 'Restore';
                    if (typeof showAjaxMessage === 'function') {
                        showAjaxMessage('Restore failed. Please try again.', 'error');
                    }
                });
            });
        });
    }

    modal.addEventListener('show.bs.modal', function () {
        searchInput.value = '';
        loadTrashed();
    });

    searchBtn.addEventListener('click', () => loadTrashed(searchInput.value.trim()));
    searchInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') loadTrashed(searchInput.value.trim());
    });
    resetBtn.addEventListener('click', () => {
        searchInput.value = '';
        loadTrashed();
    });
})();
</script>
@endpush