{{-- Alerts --}}
        <div id="alert-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999; max-width: 400px;">

            {{-- Success --}}
            @if (session('success'))
                <div class="alert custom-toast alert-success border-0 border-start border-5 border-success shadow-sm rounded-4 fade show bg-white mb-3"
                    role="alert">
                    <div class="d-flex align-items-center p-2">
                        <div class="me-3 fs-4 text-success"><i class="bi bi-check-circle-fill"></i></div>
                        <div>
                            <strong class="d-block text-dark">Success</strong>
                            <span class="text-muted small">{{ session('success') }}</span>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                    <div class="progress-loader bg-success"></div>
                </div>
            @endif

            {{-- Errors --}}
            @if ($errors->any())
                @foreach ($errors->all() as $e)
                    <div class="alert custom-toast alert-danger border-0 border-start border-5 border-danger shadow-sm rounded-4 fade show bg-white mb-2"
                        role="alert">
                        <div class="d-flex align-items-center p-2">
                            <div class="me-3 fs-4 text-danger"><strong>!</strong></div>
                            <div>
                                <strong class="d-block text-dark">Error</strong>
                                <span class="text-muted small">{{ $e }}</span>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                        </div>
                        <div class="progress-loader bg-danger"></div>
                    </div>
                @endforeach
            @endif
        </div>