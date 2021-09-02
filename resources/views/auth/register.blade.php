<x-app-layout>
    @section('title')
    Register
    @endsection

    <x-auth-card>
        <h5 class="evogria mb-4 text-center">Register</h5>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4 alert alert-secondary" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="row align-items-center me-0 mb-3">
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="row align-items-center me-0 mb-3">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
            
            <!-- Phone Number -->
            <div class="row align-items-center me-0 mb-3">
                <x-label for="phone" :value="__('Phone')" />

                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            </div>
            
            <!-- Password -->
            <div class="row align-items-center me-0 mb-3">
                <x-label for="password" :value="__('Password')" />
                
                <x-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="new-password" />
            </div>
            
            <!-- Confirm Password -->
            <div class="row align-items-center me-0 mb-3">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
                
                <x-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation" required />
            </div>
            <div class="row mb-3 primary-color">
               <div class="d-flex justify-content-between align-items-center">
                    <a class="primary-color" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                    <x-button>
                        {{ __('Register') }}
                    </x-button>
               </div>
            </div>

            
        </form>
    </x-auth-card>
</x-app-layout>
