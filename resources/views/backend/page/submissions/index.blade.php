@extends('backend.layout.master')

@section('title', 'Submissions')
@section('submission_active', 'active')
@section('contents')

    <div class="container-fluid py-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

@if (session('group_change_request'))
    @php $change = session('group_change_request'); @endphp
    <div class="alert alert-warning">
        <div class="mb-2">
            {{ __('app.This student') }} <strong>{{ $change['student_name'] }}</strong>
            {{ __('app.is already in group') }}
            <strong>{{ $change['current_group'] }}</strong>.
            {{ __('app.Do you want to change the student to group') }}
            <strong>{{ $change['new_group'] }}</strong>?
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <form method="POST" action="{{ route('submissions.changeGroup', $change['submission_id']) }}">
                @csrf
                <button type="submit" class="btn btn-success">
                    {{ __('app.Yes, Change Group') }}
                </button>
            </form>

            <form method="POST" action="{{ route('submissions.approveBorrow', $change['submission_id']) }}">
                @csrf
                <input type="hidden" name="skip_group_change" value="1">
                <button type="submit" class="btn btn-primary">
                    {{ __('app.Approve Borrow') }}
                </button>
            </form>

            <a href="{{ route('submissions.index') }}" class="btn btn-danger">
                {{ __('app.Cancel') }}
            </a>
        </div>
    </div>
@endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h2 class="fw-bold mb-0">{{ __('app.submissions') }}</h2>
                <div class="text-muted">{{ __('app.New student registrations waiting for approval') }}</div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <form method="GET" class="d-flex gap-2">
                    <input class="form-control" name="q" value="{{ request('q') }}"
                        placeholder="{{ __('app.Search student name...') }}">
                    <button class="btn btn-primary">{{ __('app.search') }}</button>
                </form>

                <a href="{{ url()->current() }}" class="btn btn-secondary">{{ __('app.reset') }}</a>

                <form method="POST" action="{{ route('submissions.cancelAll') }}"
                    onsubmit="return confirm('Are you sure you want to cancel all submissions?');">
                    @csrf
                    <button type="submit" class="btn btn-danger">{{ __('app.delete all') }}</button>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('app.Student Name') }}</th>
                            <th>{{ __('app.Phone Number') }}</th>
                            <th>{{ __('app.Group') }}</th>
                            <th>{{ __('app.item') }}</th>
                            <th>{{ __('app.notes') }}</th>
                            <th>{{ __('app.Image') }}</th>
                            <th>{{ __('app.qty') }}</th>
                            <th>{{ __('app.Status') }}</th>
                            <th style="width: 260px;">{{ __('app.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $row)
                            <tr>
                                <td>{{ $row->student_name }}</td>
                                <td>{{ $row->phone_number }}</td>
                                <td>{{ $row->group->group_name ?? '-' }}</td>

                                <td>
                                    @if ($row->item && $row->item_id)
                                        {{ $row->item->display_name }}
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            {{ $row->other_item ?? '-' }}
                                        </span>
                                    @endif
                                </td>

                                <td>{{ $row->note ?? '-' }}</td>

                                <td>
                                    @if (!empty($row->item?->image))
                                        <img src="{{ Storage::url('' . $row->item->image) }}" width="60"
                                            height="60" style="object-fit:cover;border-radius:8px;">
                                    @else
                                        <span>No image</span>
                                    @endif
                                </td>

                                <td>{{ $row->qty }}</td>

                                <td>
                                    @if ($row->is_borrow_approved)
                                        <span class="badge bg-success">Approved</span>
                                    @elseif ($row->match_status === 'different_group')
                                        <span class="badge bg-warning text-dark">Group Change Needed</span>
                                    @elseif ($row->match_status === 'same_group' || $row->student_id)
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-secondary">New Student</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex flex-column gap-2">
                                        @if ($row->is_borrow_approved)
                                            <span class="text-success small">{{ __('app.Borrow already approved') }}</span>
                                        @elseif ($row->match_status === 'different_group')
                                            <form method="POST" action="{{ route('submissions.addStudent', $row->id) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-warning w-100">
                                                    {{ __('app.Review Group Change') }}
                                                </button>
                                            </form>
                                        @elseif ($row->match_status === 'same_group' || $row->student_id)
                                            <form method="POST"
                                                action="{{ route('submissions.approveBorrow', $row->id) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-primary w-100">
                                                    {{ __('app.Approve Borrow') }}
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('submissions.addStudent', $row->id) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-dark w-100">
                                                    {{ __('app.Add Student') }}
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('submissions.remove', $row->id) }}"
                                            onsubmit="return confirm('Remove this submission?');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="btn btn-sm btn-outline-danger w-100">{{ __('app.Remove') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No submissions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-end">
                    {{ $submissions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
