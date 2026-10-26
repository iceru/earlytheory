<x-app-layout>
    @section('title')
        Login
    @endsection

    @section('additional_header')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@29.5.6/dist/css/intlTelInput.css">
        <style>
            .auth-card.login-auth-card {
                box-sizing: border-box;
                width: 100%;
                padding: 2rem;
                margin: 1rem auto !important;
            }

            @media (min-width: 992px) {
                .auth-card.login-auth-card {
                    width: 50vw;
                    margin: 2rem auto !important;
                }
            }

            .login-fields {
                display: grid;
                gap: 1rem;
            }

            .login-field label {
                display: block;
                margin: 0 0 .4rem;
                font-weight: 600;
            }

            .login-field input {
                width: 100%;
                min-height: 2.8rem;
            }

            .login-actions {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
            }

            .login-field .iti {
                display: block;
                width: 100%;
            }

            .login-mode {
                display: flex;
                gap: 1.25rem;
                margin-bottom: .25rem;
            }

            .login-mode label {
                display: flex;
                align-items: center;
                gap: .4rem;
                font-weight: 400;
                margin: 0;
            }
        </style>
    @endsection

    <x-auth-card class="login-auth-card">
        <h5 class="evogria mb-4 text-center">Login</h5>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 alert alert-secondary" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4 alert alert-danger" :errors="$errors" />
        <div class="mb-3">
            <a href="{{ url('auth/google') }}">
                <img src="/images/btn_google_signin_light_normal_web.png">
            </a>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input id="login" type="hidden" name="login" value="{{ old('login') }}">
            <div class="login-fields">
                <div class="login-mode" role="group" aria-label="Login method">
                    <label for="login_method_phone">
                        <input id="login_method_phone" type="radio" name="login_method" value="phone"
                            @checked(!filter_var(old('login', ''), FILTER_VALIDATE_EMAIL))>
                        Telepon
                    </label>
                    <label for="login_method_email">
                        <input id="login_method_email" type="radio" name="login_method" value="email"
                            @checked(filter_var(old('login', ''), FILTER_VALIDATE_EMAIL))>
                        Email
                    </label>
                </div>

                <div class="login-field">
                    <label for="login_phone">Nomor Telepon</label>
                    <input id="login_phone" class="form-control" type="tel"
                        value="{{ filter_var(old('login', ''), FILTER_VALIDATE_EMAIL) ? '' : old('login') }}">
                </div>

                <div class="login-field" id="login_email_field" hidden>
                    <label for="login_email">Email</label>
                    <input id="login_email" class="form-control" type="email"
                        value="{{ filter_var(old('login', ''), FILTER_VALIDATE_EMAIL) ? old('login') : '' }}">
                </div>

                <div class="login-field">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" class="form-control" type="password" name="password" required
                        autocomplete="current-password">
                </div>

                <label for="remember_me" class="d-flex align-items-center">
                    <input id="remember_me" type="checkbox" class="rounded pr-2" name="remember"
                        style="margin-right: .5rem">
                    <span>{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="primary-color" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <div class="login-actions">
                    <a class="primary-color fw-bold" href="{{ route('register') }}">
                        Daftar sebagai pengguna baru
                    </a>
                    <x-button class="m-0">
                        {{ __('Login') }}
                    </x-button>
                </div>
            </div>
        </form>
    </x-auth-card>

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@29.5.6/dist/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('.login-auth-card form');
            const loginValue = document.querySelector('#login');
            const phoneInput = document.querySelector('#login_phone');
            const emailInput = document.querySelector('#login_email');
            const emailField = document.querySelector('#login_email_field');
            const phoneMethod = document.querySelector('#login_method_phone');
            const emailMethod = document.querySelector('#login_method_email');
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: 'id',
                separateDialCode: true,
                countrySelectorMode: 'DROPDOWN',
                countrySearch: true,
            });

            function updateMethod() {
                const usingEmail = emailMethod.checked;
                emailField.hidden = !usingEmail;
                phoneInput.closest('.login-field').hidden = usingEmail;
                emailInput.required = usingEmail;
                phoneInput.required = !usingEmail;
            }

            phoneMethod.addEventListener('change', updateMethod);
            emailMethod.addEventListener('change', updateMethod);
            updateMethod();

            let submitting = false;
            form.addEventListener('submit', async function (event) {
                if (submitting) return;

                event.preventDefault();
                if (emailMethod.checked) {
                    loginValue.value = emailInput.value.trim();
                } else {
                    try {
                        await window.intlTelInput.attachUtils(() =>
                            import('https://cdn.jsdelivr.net/npm/intl-tel-input@29.5.6/dist/js/utils.js')
                        );
                    } catch (error) {
                        window.alert('Phone validation is temporarily unavailable. Please try again.');
                        return;
                    }

                    if (!iti.isValidNumber()) {
                        phoneInput.setCustomValidity('Enter a valid phone number for the selected country.');
                        phoneInput.reportValidity();
                        phoneInput.setCustomValidity('');
                        return;
                    }

                    loginValue.value = iti.getNumber();
                }

                submitting = true;
                form.requestSubmit();
            });
        });
    </script>
</x-app-layout>
