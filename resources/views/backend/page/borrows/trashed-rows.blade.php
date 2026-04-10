@forelse($trashed as $key => $b)
<tr id="trashed-row-{{ $b->id }}">
    <td>{{ ($trashed->currentPage() - 1) * $trashed->perPage() + $key + 1 }}</td>

    <td>
        <div class="fw-semibold">{{ $b->student?->student_name ?? '—' }}</div>
        <small class="text-muted">
            {{ $b->student?->group?->group_name ?? '' }}
            {{ $b->student?->gender ? '· ' . $b->student->gender : '' }}
        </small>
    </td>

    <td>{{ $b->item?->display_name ?? '—' }}</td>

    <td>{{ $b->qty }}</td>

    <td>
        @if($b->borrow_date)
            <span class="d-block">{{ $b->borrow_date->format('d M Y') }}</span>
            <small class="text-muted">{{ $b->borrow_date->format('H:i') }}</small>
        @else
            —
        @endif
    </td>

    <td>
        @if($b->return_date)
            <span class="d-block">{{ $b->return_date->format('d M Y') }}</span>
            <small class="text-muted">{{ $b->return_date->format('H:i') }}</small>
        @else
            —
        @endif
    </td>

    <td>
        <span class="text-primary fw-semibold">{{ $b->deletedByUser?->name ?? '—' }}</span>
    </td>

    <td>
        @if($b->deleted_at)
            <span class="d-block">{{ $b->deleted_at->timezone('Asia/Jakarta')->format('d M Y') }}</span>
            <small class="text-muted">{{ $b->deleted_at->timezone('Asia/Jakarta')->format('H:i') }}</small>
        @else
            —
        @endif
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
        <span class="badge rounded-pill bg-{{ $cls }}">
            {{ ucfirst(strtolower($b->status)) }}
        </span>
        <br>
        <span class="badge rounded-pill bg-danger mt-1">Deleted</span>
    </td>

    <td class="text-end">
        <button class="btn btn-sm btn-success restore-btn" data-id="{{ $b->id }}">
            <i class="bi bi-arrow-clockwise"></i> Restore
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="10" class="text-center py-4 text-muted">
        <div style="font-size:28px; opacity:.3;">🗑️</div>
        No deleted records found.
    </td>
</tr>
@endforelse