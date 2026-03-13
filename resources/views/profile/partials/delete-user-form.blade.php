<section>
    <p class="text-secondary mb-3">
        Once your account is deleted, all of its resources and data will be permanently deleted.
    </p>

    <button type="button" class="btn btn-outline-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
        Delete Account
    </button>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold text-danger">Delete Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-secondary">
                            Are you sure you want to delete your account? This action cannot be undone.
                        </p>

                        <label for="password" class="form-label fw-semibold">Enter your password</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Password">

                        @if ($errors->userDeletion->get('password'))
                            <div class="text-danger small mt-1">{{ $errors->userDeletion->first('password') }}</div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>