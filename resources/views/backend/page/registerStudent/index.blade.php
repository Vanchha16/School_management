<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Borrow Item Form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <style>
        html[lang="kh"] body {
            font-family: 'khmer os battambang', sans-serif !important;
        }
        body { background: #f6f7fb; }
        .card { border-radius: 16px; }
        .btn { border-radius: 12px; }
        .form-control, .form-select { height: 48px; border-radius: 12px; }
        textarea.form-control { min-height: 110px; }
        .item-preview-card {
            display: none;
            border: 1px solid #eef0f4;
            border-radius: 14px;
            background: #fff;
            padding: 14px;
        }
        .item-preview-image {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #ddd;
            background: #f8f9fa;
        }
        .language-btn {
            border-width: 1px;
            transition: all 0.25s ease;
            background: #fff;
        }
        .language-btn:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }
        .language-menu { min-width: 80px; }
        .language-menu .dropdown-item { transition: all 0.2s ease; }
        .language-menu .dropdown-item:hover {
            background-color: #f1f3f5;
            transform: scale(1.08);
        }
    </style>
</head>
<body>
    <div class="container py-4" style="max-width:700px">
        <div class="text-center mb-3">
            <h3 class="mb-1">{{ __('app.Form Borrow Item') }}</h3>
            <div class="text-muted">{{ __('app.fill_in_your_info') }}</div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0 p-3">
            <div class="dropdown text-end">
                <button class="btn btn-outline-dark rounded-pill px-3 py-2 shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (app()->getLocale() == 'kh')
                        <img src="{{ asset('assets/img/world.png') }}" alt="Khmer" width="22" height="22" class="rounded-circle">
                        {{ __('app.khmer') }}
                    @else
                        <img src="{{ asset('assets/img/united-states-of-america.png') }}" alt="English" width="22" height="22" class="rounded-circle">
                        {{ __('app.english') }}
                    @endif
                </button>

                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 p-2 mt-2 language-menu">
                    <li>
                        <a class="dropdown-item rounded-3 text-center py-2" href="{{ route('language.switch', 'en') }}" title="English">
                            <img src="{{ asset('assets/img/united-states-of-america.png') }}" alt="English" width="28" height="28" class="rounded-circle">
                            English
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item rounded-3 text-center py-2" href="{{ route('language.switch', 'kh') }}" title="Khmer">
                            <img src="{{ asset('assets/img/world.png') }}" alt="Khmer" width="28" height="28" class="rounded-circle">
                            ខ្មែរ
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('submissions.store') }}" id="registerForm">
                    @csrf

                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('app.Student Name') }} *</label>
                        <input type="text" id="student_name" name="student_name" class="form-control" list="students_list" autocomplete="off" required>
                        <datalist id="students_list">
                            @foreach ($students as $student)
                            <option value="{{ $student->student_name }}"></option>
                            @endforeach
                        </datalist>
                        <small id="student_help" class="text-muted"></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('app.groups') }} *</label>
                        <input type="text" id="group_search" name="group_search" class="form-control" list="groups_list" placeholder="Type group name" autocomplete="off" required>
                        <datalist id="groups_list">
                            @foreach ($groups as $g)
                                <option value="{{ $g->group_name }}" data-id="{{ $g->group_id }}"></option>
                            @endforeach
                        </datalist>
                        <input type="hidden" name="group_id" id="group_id">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('app.Gender') }} *</label>
                        <select id="gender" name="gender" class="form-select" required>
                            <option value="">-- {{ __('app.select_gender') }} --</option>
                            <option value="Male">{{ __('app.male') }}</option>
                            <option value="Female">{{ __('app.female') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('app.Phone Number') }} *</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" required>
                        @error('phone_number')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">{{ __('app.item') }} *</label>
                        <select id="item_id" name="item_id" placeholder="{{ __('app.Search or type item...') }}" required>
                            <option value="">Search item...</option>
                            @foreach ($items as $item)
                                <option
                                    value="{{ $item->Itemid }}"
                                    data-name="{{ $item->name }}"
                                    data-image="{{ $item->image ? asset('storage/' . $item->image) : '' }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                            
                        </select>

                        <div class="mb-3 d-none mt-3" id="otherItemBox">
                            <label class="form-label">{{ __('app.Other Items') }} *</label>
                            <input
                                type="text"
                                name="other_item"
                                id="other_item"
                                class="form-control"
                                placeholder="{{ __('app.Enter item name...') }}"
                                value="{{ old('other_item') }}">
                        </div>
                    </div>

                    <div id="itemPreview" class="item-preview-card mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <img id="previewImage" class="item-preview-image">
                            <div>
                                <div class="fw-bold" id="previewName"></div>
                                <div class="text-muted small">Selected item preview</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('app.qty') }} *</label>
                        <select name="qty" class="form-select">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('app.notes') }}</label>
                        <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-dark w-100" id="submitBtn">Submit</button>
                </form>
            </div>
        </div>

        <div class="text-center text-muted mt-3" style="font-size:13px">
            &copy; {{ date('Y') }} Setec Institute System. All rights reserved.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemPreview = document.getElementById('itemPreview');
            const previewImage = document.getElementById('previewImage');
            const previewName = document.getElementById('previewName');
            const otherItemBox = document.getElementById('otherItemBox');
            const otherItemInput = document.getElementById('other_item');

            const studentNameInput = document.getElementById('student_name');
            const genderSelect = document.getElementById('gender');
            const phoneInput = document.getElementById('phone_number');
            const groupSearchInput = document.getElementById('group_search');
            const groupIdInput = document.getElementById('group_id');
            const groupsList = document.getElementById('groups_list');
            const studentHelp = document.getElementById('student_help');

            const form = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');

            new TomSelect('#item_id', {
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                onChange: function (value) {
                    const option = this.options[value];

                    if (value === 'other') {
                        otherItemBox.classList.remove('d-none');
                        otherItemInput.required = true;
                        previewImage.src = '';
                        previewName.textContent = 'Other item';
                        itemPreview.style.display = 'block';
                        return;
                    } else {
                        otherItemBox.classList.add('d-none');
                        otherItemInput.required = false;
                        otherItemInput.value = '';
                    }

                    if (!value) {
                        previewImage.src = '';
                        previewName.textContent = '';
                        itemPreview.style.display = 'none';
                        return;
                    }

                    if (option && option.image) {
                        previewImage.src = option.image;
                        previewName.textContent = option.text || '';
                        itemPreview.style.display = 'block';
                    } else {
                        previewImage.src = '';
                        previewName.textContent = option?.text || value;
                        itemPreview.style.display = 'block';
                    }
                }
            });

            function syncGroupId() {
                const value = groupSearchInput.value.trim();
                groupIdInput.value = '';

                const options = groupsList.querySelectorAll('option');
                for (const opt of options) {
                    if (opt.value === value) {
                        groupIdInput.value = opt.dataset.id;
                        break;
                    }
                }
            }

            function clearAutoFilledFields() {
                genderSelect.value = '';
                phoneInput.value = '';
                groupSearchInput.value = '';
                groupIdInput.value = '';
            }

            let studentTimer = null;

            studentNameInput.addEventListener('input', function () {
                clearTimeout(studentTimer);

                const studentName = this.value.trim();
                studentHelp.textContent = '';

                if (studentName.length < 2) {
                    clearAutoFilledFields();
                    return;
                }

                studentTimer = setTimeout(() => {
                    fetch(`{{ route('register.checkStudentName') }}?student_name=${encodeURIComponent(studentName)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.exists) {
                                genderSelect.value = data.gender || '';
                                phoneInput.value = data.phone_number || '';
                                groupSearchInput.value = data.group_name || '';
                                syncGroupId();
                            } else {
                                clearAutoFilledFields();
                            }
                        })
                        .catch(() => {
                            clearAutoFilledFields();
                        });
                }, 300);
            });

            groupSearchInput.addEventListener('input', syncGroupId);
            groupSearchInput.addEventListener('blur', function () {
                syncGroupId();

                if (!groupIdInput.value) {
                    groupSearchInput.setCustomValidity('Please choose a group from the suggestion list.');
                } else {
                    groupSearchInput.setCustomValidity('');
                }
            });

            form.addEventListener('submit', function () {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Submitting...';
            });

            syncGroupId();
        });
    </script>
</body>
</html>