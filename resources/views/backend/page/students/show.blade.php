@extends('backend.layout.master')

@section('title', 'Student Details')

@section('contents')
<div class="container-fluid py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h3 class="fw-bold mb-0">{{ __('app.Student Details') }}</h3>
      <div class="text-secondary">{{ __('app.View full information for this student.') }}</div>
    </div>
    <a href="{{ route('students.index') }}" class="btn btn-light">
      <i class="bi bi-arrow-left me-1"></i> {{ __('app.Back to Students') }}
    </a>
  </div>

  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

      <h4 class="fw-bold mb-1">{{ $student->student_name }}</h4>

      <div class="row g-3 mt-3">
        <div class="col-12 col-md-4">
          <div class="border rounded-4 p-3">
            <div class="text-secondary small">{{ __('app.Phone Number') }}</div>
            <div class="fw-semibold">{{ $student->phone_number ?? '-' }}</div>
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="border rounded-4 p-3">
            <div class="text-secondary small">{{ __('app.Group') }}</div>
            <div class="fw-semibold">
              {{ $student->group ? $student->group->group_name : '-' }}
            </div>
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="border rounded-4 p-3">
            <div class="text-secondary small">{{ __('app.Status') }}</div>
            <div class="fw-semibold">{{ $student->status == 1 ? __('app.active_students') : __('app.inactive_students') }}</div>
          </div>
        </div>
      </div>

      <div class="d-flex gap-2 mt-4">
        <a href="{{ route('students.index') }}" class="btn btn-dark">
          <i class="bi bi-list me-1"></i> {{ __('app.Back to Students') }}
        </a>

        
      </div>

    </div>
  </div>

</div>
@endsection