@forelse($trashed as $key => $b)
<tr id="trashed-row-{{ $b->id }}">
    <td class="ps-4">
        <input type="checkbox" class="form-check-input row-check" value="{{ $b->id }}">
    </td>
    <td class="text-muted">{{ ($trashed->currentPage() - 1) * $trashed->perPage() + $key + 1 }}</td>

    <td>
        <div class="d-flex align-items-center gap-2">
            <div style="width:36px;height:36px;border-radius:50%;
                        background:{{ $b->student?->gender === 'Female' ? '#fce7f3' : '#dbeafe' }};
                        display:flex;align-items:center;justify-content:center;
                        color:{{ $b->student?->gender === 'Female' ? '#be185d' : '#1d4ed8' }};
                        font-weight:700; font-size:13px;">
                {{ strtoupper(mb_substr($b->student?->student_name ?? '?', 0, 1)) }}
            </div>
            <div>
                <div class="fw-semibold" style="font-size:14px;">{{ $b->student?->student_name ?? '—' }}</div>
                <small class="text-muted" style="font-size:11px;">
                    {{ $b->student?->group?->group_name ?? '' }}
                    {{ $b->student?->gender ? '· ' . $b->student->gender : '' }}
                </small>
            </div>
        </div>
    </td>

    <td>
        <div class="fw-semibold" style="font-size:13px;">{{ $b->item?->display_name ?? '—' }}</div>
    </td>

    <td class="text-center">
        <span class="badge rounded-pill bg-light text-dark border">{{ $b->qty }}</span>
    </td>

    <td>
        @if($b->borrow_date)
            <div style="font-size:13px;">{{ $b->borrow_date->format('d M Y') }}</div>
            <small class="text-muted" style="font-size:11px;">{{ $b->borrow_date->format('H:i') }}</small>
        @else — @endif
    </td>

    <td>
        <span class="text-primary fw-semibold" style="font-size:13px;">
            <i class="bi bi-person-circle me-1"></i>{{ $b->deletedByUser?->name ?? '—' }}
        </span>
    </td>

    <td>
        @if($b->deleted_at)
            <div style="font-size:13px;">{{ $b->deleted_at->timezone('Asia/Jakarta')->format('d M Y') }}</div>
            <small class="text-muted" style="font-size:11px;">{{ $b->deleted_at->timezone('Asia/Jakarta')->format('H:i') }}</small>
        @else — @endif
    </td>

    <td>
        @php
            $cls = match($b->status) {
                'RETURNED' => 'success',
                'BORROWED' => 'warning',
                'OVERDUE'  => 'danger',
                default    => 'secondary',
            };
        @endphp
        <span class="badge rounded-pill bg-{{ $cls }} text-white border">
            {{ ucfirst(strtolower($b->status)) }}
        </span>
    </td>

    <td class="text-end pe-4">
        <button class="btn btn-sm btn-success restore-btn" data-id="{{ $b->id }}" title="Restore">
            <i class="bi bi-arrow-clockwise me-1"></i> Restore
        </button>
    </td>
</tr>
@empty
{{-- empty state handled by JS --}}
@endforelse