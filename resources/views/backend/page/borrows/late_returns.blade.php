@extends('backend.layout.master')

@section('title', 'Returned Late')
@section('late_return_active', 'active')
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
                <h2 class="fw-bold mb-1">{{ __('app.returned Late') }}</h2>
                <div class="text-secondary">{{ __('app.Students who returned items late (more than 3 days).') }}</div>
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
                <a href="{{ url()->current() }}" class="btn btn-danger" >{{ __('app.reset') }}</a>
            </form>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4 w-100">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-secondary small">
                        {{ __('app.Total Late Returns') }}: {{ $lateReturns->count() }}
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0 w-100">
                        <thead>
                            <tr class="text-secondary small">
                                <th style="width:80px;">#</th>
                                <th>{{ __('app.students') }}</th>
                                <th>{{ __('app.item') }}</th>
                                <th class="text-center" style="width:160px;">{{ __('app.borrow_date') }}</th>
                                <th class="text-center" style="width:160px;">{{ __('app.return_date') }}</th>
                                <th class="text-center" style="width:150px;">{{ __('app.Total Days late') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($lateReturns as $k => $b)
                                @php
                                    $borrow = \Carbon\Carbon::parse($b->borrow_date);
                                    $return = \Carbon\Carbon::parse($b->return_date);
                                    $totalDays = ceil($borrow->diffInHours($return) / 24);
                                @endphp

                                <tr>
                                    <td class="text-secondary">{{ $lateReturns->firstItem() + $k }}</td>

                                    <td class="fw-semibold">{{ $b->student->student_name ?? '—' }}</td>

                                    <td>{{ $b->item->name ?? '—' }}</td>

                                    <td class="text-center">
                                        {{ $borrow->format('d M Y H:i') }}
                                    </td>

                                    <td class="text-center">
                                        {{ $return->format('d M Y H:i') }}
                                    </td>

                                    <td class="text-center">{{ $totalDays }} days</td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-danger py-3">
                                        No late returns found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    {{ $lateReturns->onEachSide(1)->links('vendor.pagination.adminlte-simple') }}
                </div>

            </div>
        </div>
    </div>
@endsection
