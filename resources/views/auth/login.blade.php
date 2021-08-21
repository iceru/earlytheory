<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div class="p-4 text-center logo-login">
                <a href="/">
                    <img src="/images/MainLogo.png" alt="Early Theory">
                </a>
            </div>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" class="container">
            @csrf

            <!-- Email Address -->
            <div class="row align-items-center me-0">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="row mt-2 me-0 align-items-center">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
           <div class="row mt-3 me-0">
                <label for="remember_me" class="d-flex align-items-center">
                    <input id="remember_me" type="checkbox" class="rounded pr-2" name="remember" style="margin-right: .5rem">
                    <span class="pl-2 ">{{ __('Remember me') }}</span>
                </label>
           </div>

            <div class="row align-items-center mt-3 me-0 ">
                @if (Route::has('password.request'))
                    <a class="col-8 primary-color" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="col-4 m-0">
                    {{ __('Log in') }}
                </x-button>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <a class="primary-color " href="{{ route('register') }}">
                        Doesn't have an account?
                    </a>
                </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
