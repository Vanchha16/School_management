@extends('backend.layout.master')

@section('title', 'Dashboard')
@section('dashboard_active', 'active')

@section('contents')
    <style>
        .dashboard-hero {
            background: linear-gradient(135deg, #111827 0%, #1f2937 45%, #4338ca 100%);
        }

        .dashboard-icon-box {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(8px);
        }

        .dashboard-user-avatar {
            width: 42px;
            height: 42px;
            object-fit: cover;
        }

        .dashboard-user-initial {
            width: 42px;
            height: 42px;
            background: #e0e7ff;
            color: #3730a3;
            font-size: 16px;
        }

        .dashboard-dropdown-avatar {
            width: 56px;
            height: 56px;
            object-fit: cover;
        }

        .dashboard-dropdown-initial {
            width: 56px;
            height: 56px;
            background: #e0e7ff;
            color: #3730a3;
            font-size: 20px;
        }

        .dashboard-stat-icon {
            width: 44px;
            height: 44px;
        }

        @media (max-width: 991.98px) {
            .dashboard-top-right {
                width: 100%;
                align-items: stretch !important;
            }

            .dashboard-top-right .dashboard-links {
                width: 100%;
            }

            .dashboard-top-right .dashboard-links a {
                flex: 1 1 100%;
                text-align: center;
            }

            .dashboard-profile-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 767.98px) {
            .container-fluid {
                padding-left: 12px;
                padding-right: 12px;
            }

            .dashboard-hero {
                padding: 1rem !important;
            }

            .dashboard-title {
                font-size: 1.5rem;
            }

            .dashboard-subinfo {
                gap: 8px !important;
                flex-direction: column;
                align-items: flex-start !important;
            }

            .dashboard-icon-box {
                width: 52px;
                height: 52px;
            }

            .dashboard-icon-box i {
                font-size: 1.25rem !important;
            }

            .card-header,
            .card-body {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            .dashboard-list-row {
                flex-direction: column;
                gap: 10px !important;
            }

            .dashboard-list-row .text-end {
                text-align: left !important;
            }

            .dashboard-borrow-row {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .dashboard-borrow-row .text-end {
                text-align: left !important;
            }

            .dropdown-menu {
                min-width: 100% !important;
            }
        }
    </style>

    <div class="container-fluid py-4">

        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="dashboard-hero p-3 p-md-4 text-white rounded-4">
                    <div class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center gap-3">

                        <div class="d-flex align-items-start align-items-sm-center gap-3 flex-grow-1">
                            <div
                                class="dashboard-icon-box rounded-4 d-flex align-items-center justify-content-center shadow-sm flex-shrink-0">
                                <i class="bi bi-speedometer2 fs-3"></i>
                            </div>

                            <div class="min-w-0">
                                <h2 class="fw-bold mb-1 text-white dashboard-title">Dashboard</h2>
                                <div class="text-white-50 mb-1">
                                    Welcome back, {{ Auth::user()->name ?? 'Admin' }}
                                </div>
                                <div class="small text-white-50 d-flex flex-wrap dashboard-subinfo">
                                    <span>
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ now()->timezone('Asia/Jakarta')->format('d M Y') }}
                                    </span>
                                    <span>
                                        <i class="bi bi-clock me-1"></i>
                                        {{ now()->timezone('Asia/Jakarta')->format('H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="dashboard-top-right d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2">
                            <div class="dashboard-links d-flex flex-wrap gap-2">
                                <a href="{{ route('students.index') }}" class="btn btn-light rounded-pill px-3 fw-medium">
                                    <i class="bi bi-people me-1"></i> Students
                                </a>

                                <a href="{{ route('items.index') }}"
                                    class="btn btn-outline-light rounded-pill px-3 fw-medium">
                                    <i class="bi bi-box-seam me-1"></i> Items
                                </a>

                                <a href="{{ route('submissions.index') }}"
                                    class="btn btn-outline-light rounded-pill px-3 fw-medium">
                                    <i class="bi bi-inbox me-1"></i> Submissions
                                </a>
                            </div>

                            
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small">Total Students</div>
                                <div class="fs-2 fw-bold mt-1">{{ $totalStudents ?? 0 }}</div>
                            </div>
                            <div
                                class="dashboard-stat-icon bg-dark-subtle text-dark rounded-3 p-2 d-flex align-items-center justify-content-center">
                                <i class="bi bi-people fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small">Active Students</div>
                                <div class="fs-2 fw-bold mt-1 text-success">{{ $activeStudents ?? 0 }}</div>
                            </div>
                            <div
                                class="dashboard-stat-icon bg-success-subtle text-success rounded-3 p-2 d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-check fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small">Inactive Students</div>
                                <div class="fs-2 fw-bold mt-1 text-secondary">{{ $inactiveStudents ?? 0 }}</div>
                            </div>
                            <div
                                class="dashboard-stat-icon bg-secondary-subtle text-secondary rounded-3 p-2 d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-dash fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small">Total Groups</div>
                                <div class="fs-2 fw-bold mt-1">{{ $totalGroups ?? 0 }}</div>
                            </div>
                            <div
                                class="dashboard-stat-icon bg-primary-subtle text-primary rounded-3 p-2 d-flex align-items-center justify-content-center">
                                <i class="bi bi-diagram-3 fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small">Total Items</div>
                                <div class="fs-2 fw-bold mt-1">{{ $totalItems ?? 0 }}</div>
                            </div>
                            <div
                                class="dashboard-stat-icon bg-warning-subtle text-warning rounded-3 p-2 d-flex align-items-center justify-content-center">
                                <i class="bi bi-box-seam fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small">Available Items</div>
                                <div class="fs-2 fw-bold mt-1 text-primary">{{ $availableItems ?? 0 }}</div>
                            </div>
                            <div
                                class="dashboard-stat-icon bg-info-subtle text-info rounded-3 p-2 d-flex align-items-center justify-content-center">
                                <i class="bi bi-check2-square fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small">Borrowed Items</div>
                                <div class="fs-2 fw-bold mt-1 text-danger">{{ $borrowedItems ?? 0 }}</div>
                            </div>
                            <div
                                class="dashboard-stat-icon bg-danger-subtle text-danger rounded-3 p-2 d-flex align-items-center justify-content-center">
                                <i class="bi bi-arrow-left-right fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-secondary small">Pending Submissions</div>
                                <div class="fs-2 fw-bold mt-1 text-warning">{{ $pendingSubmissions ?? 0 }}</div>
                            </div>
                            <div
                                class="dashboard-stat-icon bg-warning-subtle text-warning rounded-3 p-2 d-flex align-items-center justify-content-center">
                                <i class="bi bi-inbox fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-xl-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                            <div>
                                <h5 class="fw-bold mb-1">Recent Submissions</h5>
                                <div class="text-secondary small">Latest student requests</div>
                            </div>
                            <a href="{{ route('submissions.index') }}" class="btn btn-sm btn-light">View All</a>
                        </div>
                    </div>

                    <div class="card-body px-4">
                        @forelse ($recentSubmissions ?? [] as $submission)
                            <div
                                class="dashboard-list-row d-flex justify-content-between align-items-start py-3 border-bottom">
                                <div>
                                    <div class="fw-semibold">{{ $submission->student_name }}</div>
                                    <div class="text-secondary small">
                                        {{ $submission->group?->group_name ?? '-' }}
                                        •
                                        {{ $submission->item?->name ?? '-' }}
                                    </div>
                                </div>

                                <div class="text-end">
                                    @if ($submission->is_borrow_approved)
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                    <div class="text-secondary small mt-1">
                                        {{ $submission->created_at ? $submission->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-secondary py-5">No recent submissions</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                            <div>
                                <h5 class="fw-bold mb-1">Recent Borrows</h5>
                                <div class="text-secondary small">Latest borrow activity</div>
                            </div>
                            <a href="{{ route('borrows.index') }}" class="btn btn-sm btn-light">View All</a>
                        </div>
                    </div>

                    <div class="card-body px-4">
                        @forelse ($recentBorrows ?? [] as $borrow)
                            <div class="dashboard-borrow-row d-flex align-items-start gap-3 py-3 border-bottom">
                                <div>
                                    @if (!empty($borrow->item?->image))
                                        <img src="{{ asset('storage/' . $borrow->item->image) }}" width="54"
                                            height="54" style="object-fit:cover;border-radius:10px;">
                                    @else
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                            style="width:54px;height:54px;">
                                            <i class="bi bi-image text-secondary"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $borrow->student?->student_name ?? '-' }}</div>
                                    <div class="text-secondary small">
                                        {{ $borrow->item?->name ?? '-' }} • Qty: {{ $borrow->qty ?? 0 }}
                                    </div>
                                </div>

                                <div class="text-end">
                                    <span class="badge bg-primary">{{ $borrow->status ?? 'BORROWED' }}</span>
                                    <div class="text-secondary small mt-1">
                                        {{ $borrow->borrow_date ? \Carbon\Carbon::parse($borrow->borrow_date)->timezone('Asia/Jakarta')->format('d M Y H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-secondary py-5">No recent borrows</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mt-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Quick Actions</h5>

                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <a href="{{ route('students.index') }}" class="btn btn-light border w-100 py-3">
                            <i class="bi bi-people d-block fs-4 mb-2"></i>
                            Students
                        </a>
                    </div>

                    <div class="col-6 col-md-3">
                        <a href="{{ route('groups.index') }}" class="btn btn-light border w-100 py-3">
                            <i class="bi bi-diagram-3 d-block fs-4 mb-2"></i>
                            Groups
                        </a>
                    </div>

                    <div class="col-6 col-md-3">
                        <a href="{{ route('items.index') }}" class="btn btn-light border w-100 py-3">
                            <i class="bi bi-box-seam d-block fs-4 mb-2"></i>
                            Items
                        </a>
                    </div>

                    <div class="col-6 col-md-3">
                        <a href="{{ route('borrows.index') }}" class="btn btn-light border w-100 py-3">
                            <i class="bi bi-arrow-left-right d-block fs-4 mb-2"></i>
                            Borrows
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
