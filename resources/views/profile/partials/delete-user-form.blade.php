<section class="mb-4">
    <header>
        <h2 class="h4 text-dark">
            {{ __(translate("Delete Account")) }}
        </h2>
        <p class="text-muted small mt-1">
            {{ __(translate("Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.")) }}
        </p>
    </header>

    <button
        class="btn btn-danger mt-3"
        data-bs-toggle="modal"
        data-bs-target="#confirmUserDeletionModal"
    >
        {{ __(translate("Delete Account")) }}
    </button>

    <!-- Modal for Confirm User Deletion -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">
                            {{ __(translate("Are you sure you want to delete your account?")) }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted">
                            {{ __(translate("Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.")) }}
                        </p>

                        <!-- Password Input -->
                        <div class="form-group mt-4">
                            <label for="password" class="form-label">{{ __(translate("Password")) }}</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                placeholder="{{ __(translate("Password")) }}"
                                required
                            >
                            @if ($errors->userDeletion->has('password'))
                                <div class="text-danger mt-2">{{ $errors->userDeletion->first('password') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __(translate("Cancel")) }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            {{ __(translate("Delete Account")) }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
