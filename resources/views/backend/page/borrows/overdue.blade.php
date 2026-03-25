@extends('backend.layout.master')

@section('title', 'Overdue Borrow')
@section('overdue_borrow_active', 'active')
@section('contents')

    <style>
        .content-wrapper,
        .content,
        .container,
        .container-lg,
        .container-md,
        .container-sm {
            max-width: 100% !important;
            width: 100% !important;
        }
    </style>

    <div class="container-fluid" style="padding:3%;">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1">{{ __('app.overdue_borrow') }}</h2>
                <div class="text-secondary">{{ __('app.Borrowed more than 3 days and still not returned.') }}</div>
            </div>

            <form method="GET" action="{{ url()->current() }}" class="d-flex flex-wrap gap-2 align-items-center">
                <div class="input-group" style="min-width: 320px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0"
                        placeholder="{{ __('app.Search student or item...') }}">
                </div>
                <button class="btn btn-primary">{{ __('app.search') }}</button>
                <a href="{{ url()->current() }}" class="btn btn-danger">{{ __('app.reset') }}</a>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 mb-4 w-100">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table align-middle mb-0 w-100">
                        <thead>
                            <tr class="text-secondary small">
                                <th style="width:80px;">#</th>
                                <th>{{ __('app.students') }}</th>
                                <th style="width:180px;">{{ __('app.Phone Number') }}</th>
                                <th>{{ __('app.item') }}</th>
                                <th class="text-center" style="width:160px;">{{ __('app.borrow_date') }}</th>
                                <th class="text-center" style="width:130px;">{{ __('app.Total Days late') }}</th>
                                <th class="text-center" style="width:150px;">Call Status</th>
                                <th style="width:190px;">Call Note</th>
                                <th style="width:260px;">Update</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($overdues as $k => $b)
                                @php
                                    $lateDays = (int) \Carbon\Carbon::parse($b->borrow_date)->diffInDays(now());
                                    $callStatus = $b->call_status ?? 'not_yet_called';
                                @endphp

                                <tr>
                                    <td class="text-secondary">{{ $overdues->firstItem() + $k }}</td>

                                    <td class="fw-semibold">
                                        {{ $b->student->student_name ?? '—' }}
                                    </td>

                                    <td>
                                        <div>{{ $b->student->phone_number ?? '—' }}</div>

                                        @if(!empty($b->student->phone_number))
                                            <a href="tel:{{ $b->student->phone_number }}" class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="bi bi-telephone"></i> Call
                                            </a>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $b->item->display_name ?? '—' }}
                                    </td>

                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($b->borrow_date)->format('d M Y H:i') }}
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-danger-subtle text-danger border border-danger">
                                            {{ $lateDays }} days
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        @if($callStatus === 'not_yet_called')
                                            <span class="badge rounded-pill bg-secondary">Not yet call</span>
                                        @elseif($callStatus === 'called_done')
                                            <span class="badge rounded-pill bg-success">Call done</span>
                                        @elseif($callStatus === 'no_answer')
                                            <span class="badge rounded-pill bg-danger">No Answer</span>
                                        @endif

                                        @if($b->called_at)
                                            <div class="small text-muted mt-1">
                                                {{ $b->called_at->format('d M Y H:i') }}
                                            </div>
                                        @endif

                                        @if($b->calledByUser)
                                            <div class="small text-muted">
                                                by {{ $b->calledByUser->name }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $b->call_note ?: '—' }}
                                    </td>

                                    <td>
                                        <form method="POST" action="{{ route('borrows.overdue.call-status', $b->id) }}">
                                            @csrf
                                            @method('PATCH')

                                            <select name="call_status" class="form-select form-select-sm mb-2">
                                                <option value="not_yet_called" {{ $callStatus === 'not_yet_called' ? 'selected' : '' }}>
                                                    Not yet call
                                                </option>
                                                <option value="called_done" {{ $callStatus === 'called_done' ? 'selected' : '' }}>
                                                    Call done
                                                </option>
                                                <option value="no_answer" {{ $callStatus === 'no_answer' ? 'selected' : '' }}>
                                                    No Answer
                                                </option>
                                            </select>

                                            <textarea
                                                name="call_note"
                                                class="form-control form-control-sm mb-2"
                                                rows="2"
                                                placeholder="Write note...">{{ old('call_note', $b->call_note) }}</textarea>

                                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                                <i class="bi bi-save"></i> Save
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-danger py-3">
                                        No overdue borrows
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    {{ $overdues->onEachSide(1)->links('vendor.pagination.adminlte-simple') }}
                </div>

            </div>
        </div>
    </div>
@endsection