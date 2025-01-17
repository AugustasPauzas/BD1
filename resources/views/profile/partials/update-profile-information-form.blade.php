<section>
    <header>
        <h2 class="h4 text-dark">
            {{ __(translate("Profile Information")) }}
        </h2>
        <p class="text-muted small mt-1">
            {{ __(translate("Update your account's profile information and email address.")) }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>


    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">{{ __(translate("Name")) }}</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __(translate("Email")) }}</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="small text-dark">
                        {{ __(translate("Your email address is unverified.")) }}
                        <button form="send-verification" class="btn btn-link p-0 text-decoration-underline text-muted">
                            {{ __(translate("Click here to re-send the verification email.")) }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success small mt-2">
                            {{ __(translate("A new verification link has been sent to your email address.")) }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Save Button and Status Message -->
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __(translate("Save")) }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="small text-muted mb-0"
                >{{ __(translate("Saved.")) }}</p>
            @endif
        </div>
    </form>
</section>
