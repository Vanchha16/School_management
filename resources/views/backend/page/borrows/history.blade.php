@extends('backend.layout.master')

@section('title', 'Manage Item History')
@section('history_active', 'active')

@section('contents')
    <div class="container-fluid py-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-1">{{ __('app.manage_item_history') }}</h2>
                <br>
                
                {{-- <p class="text-muted mb-4">Shows which user approved and returned each item record.</p> --}}

                <form method="GET" id="filterForm" class="row g-2 mb-3">

                    <div class="col-md-4">
                        <input type="text" name="student" value="{{ request('student') }}" class="form-control"
                            placeholder="{{ __('app.Search student name...') }}">
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="user" value="{{ request('user') }}" class="form-control"
                            placeholder="{{ __('app.Search by user name...') }}">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="bi bi-search"></i> {{ __('app.search') }}
                        </button>
                    </div>

                    <div class="col-md-2">
                        <a href="{{ url()->current() }}" class="btn btn-danger w-100​">
                            {{ __('app.reset') }}
                        </a>
                    </div>

                </form>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>{{ __('app.users') }}</th>
                                <th>{{ __('app.action') }}</th>
                                <th>{{ __('app.students') }}</th>
                                <th>{{ __('app.item') }}</th>
                                <th>{{ __('app.approved_by') }}</th>
                                <th>{{ __('app.returned_by') }}</th>
                                <th>{{ __('app.details') }}</th>
                                <th>{{ __('app.time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($histories as $history)
                                <tr>

                                    <td class="fw-semibold">
                                        {{ $history->user->name ?? '-' }}
                                    </td>

                                    <td>
                                        @if ($history->action == 'Borrowed')
                                            <span class="badge bg-primary">Borrowed</span>
                                        @elseif($history->action == 'Returned')
                                            <span class="badge bg-success">Returned</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $history->action }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $history->borrow->student->student_name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $history->borrow->item->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $history->approvedByUser->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $history->returnedByUser->name ?? '-' }}
                                    </td>

                                    <td class="text-muted">
                                        {{ $history->details }}
                                    </td>

                                    <td>
                                        {{ optional($history->action_at)->format('d M Y H:i') }}
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        No history found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                   {{ $histories->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        function autoFilter() {
            clearTimeout(window.filterTimer);

            window.filterTimer = setTimeout(function() {
                document.getElementById('filterForm').submit();
            }, 500);
        }
    </script>
@endsection
