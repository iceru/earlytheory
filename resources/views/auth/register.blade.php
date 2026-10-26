<x-app-layout>
    @section('title')
        Register
    @endsection

    @section('additional_header')
        <style>
            .auth-card.register-auth-card {
                box-sizing: border-box;
                width: 100%;
                padding: 2rem;
                margin: 1rem auto !important;
            }

            @media (min-width: 992px) {
                .auth-card.register-auth-card {
                    width: 55vw;
                    margin: 2rem auto !important;
                }
            }

            .register-google img {
                display: block;
                height: auto;
            }

            .register-fields {
                display: grid;
                gap: 1rem;
            }

            .register-field {
                display: flex;
                gap: 1rem;
                align-items: center;
            }

            .register-field label {
                display: block;
                margin: 0 0 .4rem;
                font-weight: 600;
                min-width: 8rem;
            }

            .register-input,
            .register-field .iti {
                display: block;
                width: 100%;
                max-width: 100%;
            }

            .register-input {
                min-height: 2.8rem;
                border-radius: .4rem;
            }

            .register-actions {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                margin-top: .25rem;
            }

            .register-whatsapp-confirmation {
                display: flex;
                align-items: flex-start;
                gap: .6rem;
            }

            .register-whatsapp-confirmation {
                margin: .65rem 0 0;
                font-weight: 400;
            }

            .register-whatsapp-confirmation input {
                margin-top: .25rem;
                flex: 0 0 auto;
            }
        </style>
    @endsection

    <x-auth-card class="register-auth-card">
        <h5 class="evogria mb-4 text-center">Create your account</h5>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4 alert alert-secondary" :errors="$errors" />
        <div class="register-google mb-3">
            <a href="{{ url('auth/google') }}">
                <img src="/images/btn_google_signin_light_normal_web.png">
                {{-- <div class="button inline primary">
                    <i class="fab fa-google me-2" aria-hidden="true"></i> Sign in with Google
                </div> --}}
            </a>
        </div>
        <form method="POST" action="{{ route('register') }}" class="register-form">
            @csrf
            <div class="register-fields">
                <div class="register-field">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" class="form-control register-input" type="text" name="name"
                        value="{{ old('name') }}" required autofocus>
                </div>

                <div class="register-field">
                    <label for="email">{{ __('Email (Optional)') }}</label>
                    <input id="email" class="form-control register-input" type="email" name="email"
                        value="{{ old('email') }}">
                </div>

                <div class="register-field">
                    <label for="phone">{{ __('Phone') }}</label>
                    <x-international-phone-input id="phone" name="phone" :value="old('phone')"
                        class="form-control register-input" required />
                </div>

                <div class="register-field">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" class="form-control register-input" type="password" name="password" required
                        autocomplete="new-password">
                </div>

                <div class="register-field">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" class="form-control register-input" type="password"
                        name="password_confirmation" required>
                </div>

                <label class="register-whatsapp-confirmation" for="whatsapp_phone_confirmed">
                    <input id="whatsapp_phone_confirmed" type="checkbox" name="whatsapp_phone_confirmed" value="1"
                        required @checked(old('whatsapp_phone_confirmed'))>
                    <span>Saya memastikan nomor telepon tersebut terdaftar di WhatsApp dan dapat dihubungi.</span>
                </label>

                <div class="register-actions">
                    <a class="primary-color" href="{{ route('login') }}">{{ __('Already registered?') }}</a>
                    <x-button>{{ __('Register') }}</x-button>
                </div>
            </div>
        </form>
    </x-auth-card>

</x-app-layout>
