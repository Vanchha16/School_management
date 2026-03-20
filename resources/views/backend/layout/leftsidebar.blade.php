 <div
     class="d-lg-none mobile-topbar bg-white border-bottom px-3 py-2 d-flex align-items-center justify-content-between ">
     <button class="btn btn-dark btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
         <i class="bi bi-list"></i>
     </button>

     <div class="fw-semibold">IT Room</div>

     <div style="width: 38px;">
         <div class="dashboard-user-row">
             <button type="button"
                 class="btn btn-light rounded-circle d-flex align-items-center justify-content-center position-relative flex-shrink-0"
                 style="width:44px; height:44px;">
                 <i class="bi bi-bell"></i>
                 {{-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                     style="font-size:10px;">
                     3
                 </span> --}}
             </button>

             @php
                 $user = Auth::user();
                 $profilePhoto = !empty($user?->photo) ? asset('storage/' . $user->photo) : null;
                 $userInitial = strtoupper(substr($user->name ?? 'A', 0, 1));
             @endphp

             <div class="dropdown" style="">
                 <button
                     class="dashboard-profile-btn btn btn-light border-0 rounded-pill px-2 px-sm-3 py-2 d-flex align-items-center gap-2 shadow-sm"
                     type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">

                     <div class="position-relative flex-shrink-0">
                         @if (!empty($user->photo))
                             <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile"
                                 class="dashboard-user-avatar rounded-circle border">
                         @else
                             <div
                                 class="dashboard-user-initial rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase border">
                                 {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                             </div>
                         @endif

                         <span
                             class="position-absolute bottom-0 end-0 translate-middle p-1 bg-success border border-white rounded-circle"
                             style="width:10px; height:10px;"></span>
                     </div>

                     <div class="text-start lh-sm d-none d-sm-block">
                         <div class="fw-semibold text-dark" style="font-size: 14px;">
                             {{ $user->name ?? 'Admin' }}
                         </div>
                         <div class="text-muted text-truncate" style="font-size: 12px; max-width: 180px;">
                             {{ $user->email ?? 'Administrator' }}
                         </div>
                     </div>

                     <i class="bi bi-chevron-down small text-muted"></i>
                 </button>

                 <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 p-2 mt-2"
                     style="min-width: 280px; z-index: 1055;">
                     <li class="px-3 py-3">
                         <div class="d-flex align-items-center gap-3">
                             @if ($profilePhoto)
                                 <img src="{{ $profilePhoto }}" alt="Profile"
                                     class="dashboard-dropdown-avatar rounded-circle border">
                             @else
                                 <div
                                     class="dashboard-dropdown-initial rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase border">
                                     {{ $userInitial }}
                                 </div>
                             @endif

                             <div class="min-w-0">
                                 <div class="fw-bold text-truncate">{{ $user->name ?? 'Admin' }}</div>
                                 <div class="text-muted small text-truncate">{{ $user->email ?? '' }}
                                 </div>
                                 <span class="badge bg-success-subtle text-success mt-1">Online</span>
                             </div>
                         </div>
                     </li>

                     <li>
                         <hr class="dropdown-divider my-2">
                     </li>

                     <li>
                         <a class="dropdown-item rounded-3 py-2" href="{{ route('profile') }}">
                             <i class="bi bi-person me-2"></i> My Profile
                         </a>
                     </li>

                     <li>
                         <form method="POST" action="{{ route('logout') }}">
                             @csrf
                             <button type="submit" class="dropdown-item rounded-3 py-2 text-danger">
                                 <i class="bi bi-box-arrow-right me-2"></i> {{ __('app.logout') }}
                             </button>
                         </form>
                     </li>
                 </ul>
             </div>
         </div>
     </div>
 </div>
 <div class="app d-flex">
     <aside id="sidebar" class="sidebar d-flex flex-column p-2 ">
         <div class="brand">
             <div class="brand-badge">
                 <a href="{{ url('dashboard') }}" style="text-decoration: none; color:inherit;">
                     <img src="{{ asset('assets/img/photo_2024-05-27_08-46-50.jpg') }}" alt="Profile"
                         class="rounded-circle border" style="width:38px; height:38px; object-fit:cover;">
                 </a>
             </div>
             <div>
                 <a href="{{ url('dashboard') }}" style="text-decoration: none; color:inherit;">
                     <div style="line-height:1;">IT <span class="text-muted">Room</span></div>
                 </a>
                 <div class="text-muted" style="font-size:12px;font-weight:600;">
                     {{ auth()->user()?->name ?? 'Guest' }} • {{ ucfirst(auth()->user()?->role ?? 'User') }}
                 </div>
             </div>
         </div>
         {{-- Mobile --}}
         <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileSidebar">
             <div class="offcanvas-header border-bottom">
                 <h5 class="offcanvas-title mb-0">{{ __('app.menu') }}</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
             </div>

             <div class="offcanvas-body p-0">
                 <div class="p-3 border-bottom">
                     <div class="fw-bold">Setec School</div>
                     <small class="text-muted">{{ __('app.admin_panel') }}</small>
                 </div>

                 <ul class="nav flex-column p-2">
                     <li class="nav-item">
                         <a href="{{ route('dashboard') }}"
                             class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold text-dark' : 'text-secondary' }}">
                             <i class="bi bi-speedometer2 me-2"></i> {{ __('app.dashboard') }}
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ route('students.index') }}"
                             class="nav-link {{ request()->routeIs('students.*') ? 'active fw-bold text-dark' : 'text-secondary' }}">
                             <i class="bi bi-people me-2"></i> {{ __('app.students') }}
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ route('groups.index') }}"
                             class="nav-link {{ request()->routeIs('groups.*') ? 'active fw-bold text-dark' : 'text-secondary' }}">
                             <i class="bi bi-diagram-3 me-2"></i> {{ __('app.groups') }}
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ route('items.index') }}"
                             class="nav-link {{ request()->routeIs('items.*') ? 'active fw-bold text-dark' : 'text-secondary' }}">
                             <i class="bi bi-box-seam me-2"></i> {{ __('app.items') }}
                         </a>
                     </li>
                     
                     <li>
                         <a href="{{ route('borrows.history') }}" class="nav-pill @yield('history_active')">
                             <i class="fa-sharp fa-regular fa-clock-rotate-left"></i>
                             {{ __('app.manage_item_history') }}
                         </a>
                     </li>
                     <li>
                         @php $role = strtolower(auth()->user()->role ?? ''); @endphp

                         @if (in_array($role, ['admin', 'super admin', 'superadmin']))
                             <a href="{{ url('admin/users') }}" class="nav-pill @yield('users_active')">
                                 <i class="fa-utility-fill fa-semibold fa-user"></i>{{ __('app.users') }}
                             </a>
                         @endif
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('borrows.index') }}"
                             class="nav-link {{ request()->routeIs('borrows.*') ? 'active fw-bold text-dark' : 'text-secondary' }}">
                             <i class="bi bi-arrow-left-right me-2"></i> {{ __('app.borrow') }}
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ route('submissions.index') }}"
                             class="nav-link d-flex align-items-center {{ request()->routeIs('submissions.*') ? 'active fw-bold text-dark' : 'text-secondary' }}">
                             <i class="bi bi-inbox me-2"></i>
                             {{ __('app.submissions') }}

                             @if (($pendingSubmissionCount ?? 0) > 0)
                                 <span
                                     class="ms-auto d-inline-flex align-items-center justify-content-center bg-danger text-white"
                                     style="width:22px;height:22px;border-radius:50%;font-size:12px;font-weight:700;">
                                     {{ $pendingSubmissionCount }}
                                 </span>
                             @endif
                         </a>
                     </li>
                     <a href="{{ route('borrows.late_returns') }}" class="nav-pill @yield('late_return_active')">
                         <i class="bi bi-hourglass-split"></i>
                         {{ __('app.returned_late') }}

                         @if (($lateReturnedCount ?? 0) > 0)
                             <span
                                 class="ms-auto d-inline-flex align-items-center justify-content-center bg-danger text-white"
                                 style="width:22px;height:22px;border-radius:50%;font-size:12px;font-weight:700;">
                                 {{ $lateReturnedCount }}
                             </span>
                         @endif
                     </a>
                     <a href="{{ route('borrows.overdue') }}" class="nav-pill @yield('overdue_borrow_active')">
                         <i class="bi bi-clock-history"></i>
                         {{ __('app.overdue_borrow') }}

                         @if (($overdueCount ?? 0) > 0)
                             <span
                                 class="ms-auto d-inline-flex align-items-center justify-content-center bg-danger text-white"
                                 style="width:22px;height:22px;border-radius:50%;font-size:12px;font-weight:700;">
                                 {{ $overdueCount }}
                             </span>
                         @endif
                     </a>
                 </ul>
                 <div class="mt-3 pt-2 border-top sidebar-language-switch">
                     <div class="small text-muted px-2 mb-2">{{ __('app.language') }}</div>
                     <div class="d-flex gap-2 px-2">
                         <a href="{{ route('language.switch', 'en') }}"
                             class="btn btn-sm btn-light w-100">{{ __('app.english') }}</a>
                         <a href="{{ route('language.switch', 'kh') }}"
                             class="btn btn-sm btn-light w-100">{{ __('app.khmer') }}</a>
                     </div>
                 </div>
                  <div class="mt-auto">
            <span style="color: gray; font-size: 12px;">Version 1.0.0</span>
         </div>
                </div>
             
         </div>
         <div class="px-2 mt-2">
             <a href="{{ route('admin.dashboard') }}" class="nav-pill @yield('dashboard_active')">
                 <i class="bi bi-speedometer2"></i> {{ __('app.dashboard') }}
             </a>
             <a href="{{ url('admin/students') }}" class="nav-pill @yield('student_active')" data-page="students"><i
                     class="bi bi-people"></i>{{ __('app.students') }}</a>
             <a href="{{ url('admin/items') }}" class="nav-pill @yield('item_active')"><i
                     class="bi bi-box-seam me-1"></i>{{ __('app.items') }}</a>
             <a href="{{ url('admin/groups') }}" class="nav-pill @yield('group_active')"><i
                     class="fa-duotone fa-regular fa-user-group"></i>{{ __('app.groups') }}</a>
             <a href="{{ url('admin/borrows') }}" class="nav-pill @yield('borrow_active')"><i
                     class="fa-sharp fa-regular fa-hand-holding-box"></i>{{ __('app.manage_items') }}</a>
             <a href="{{ route('borrows.history') }}" class="nav-pill @yield('history_active')">
                 <i class="fa-sharp fa-regular fa-clock-rotate-left"></i>
                 {{ __('app.manage_item_history') }}
             </a>
             <a href="{{ url('admin/register-student') }}" class="nav-pill @yield('register_student_active')"><i
                     class="fa-sharp fa-regular fa-hand-holding-box"></i>{{ __('app.register_student') }}</a>

             <a href="{{ url('admin/submissions') }}" class="nav-pill @yield('submission_active')">
                 <i class="bi bi-inbox me-1"></i>
                 {{ __('app.submissions') }}

                 @if (($pendingSubmissionCount ?? 0) > 0)
                     <span class="ms-auto d-inline-flex align-items-center justify-content-center bg-danger text-white"
                         style="width:22px;height:22px;border-radius:50%;font-size:12px;font-weight:700;">
                         {{ $pendingSubmissionCount }}
                     </span>
                 @endif
             </a>
             @php $role = strtolower(auth()->user()->role ?? ''); @endphp

             @if (in_array($role, ['admin', 'super admin', 'superadmin']))
                 <a href="{{ url('admin/users') }}" class="nav-pill @yield('users_active')">
                     <i class="fa-utility-fill fa-semibold fa-user"></i>{{ __('app.users') }}
                 </a>
             @endif
             <a href="{{ route('borrows.late_returns') }}" class="nav-pill @yield('late_return_active')">
                 <i class="fa-sharp fa-regular fa-hand-holding-box"></i>
                 {{ __('app.returned_late') }}

                 @if (($lateReturnedCount ?? 0) > 0)
                     <span class="ms-auto d-inline-flex align-items-center justify-content-center bg-danger text-white"
                         style="width:22px;height:22px;border-radius:50%;font-size:12px;font-weight:700;">
                         {{ $lateReturnedCount }}
                     </span>
                 @endif
             </a>
             <a href="{{ route('borrows.overdue') }}" class="nav-pill @yield('overdue_borrow_active')">
                 <i class="fa-sharp fa-regular fa-hand-holding-box"></i>
                 {{ __('app.overdue_borrow') }}

                 @if (($overdueCount ?? 0) > 0)
                     <span class="ms-auto d-inline-flex align-items-center justify-content-center bg-danger text-white"
                         style="width:22px;height:22px;border-radius:50%;font-size:12px;font-weight:700;">
                         {{ $overdueCount }}
                     </span>
                 @endif
             </a>
             <div class="mt-3 pt-2 border-top sidebar-language-switch">
                 <div class="small text-muted px-2 mb-2">{{ __('app.language') }}</div>
                 <div class="d-flex gap-2 px-2">
                     <a href="{{ route('language.switch', 'en') }}"
                         class="btn btn-sm btn-light w-100">{{ __('app.english') }}</a>
                     <a href="{{ route('language.switch', 'kh') }}"
                         class="btn btn-sm btn-light w-100">{{ __('app.khmer') }}</a>
                 </div>
             </div>
             <div class="mt-auto">
                <span style="color: gray; font-size: 12px;">Version 1.0.0</span>
             </div>
         </div>
         {{-- <div class="mt-auto p-2">
             <div class="soft-card p-3">
                 <div class="d-flex align-items-center gap-2">
                     <i class="bi bi-shield-check text-success"></i>
                     <div class="fw-bold">Super Admin</div>
                 </div>
                 <div class="text-muted" style="font-size:12px;">Maths Teacher</div>
             </div>
         </div> --}}
     </aside>
