<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $login = $this->input('login');
        $authenticated = false;

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $authenticated = Auth::attempt([
                'email' => $login,
                'password' => $this->input('password'),
            ], $this->filled('remember'));
        } else {
            $candidate = User::whereIn('phone', $this->phoneCandidates($login))->first();

            if ($candidate && Hash::check($this->input('password'), $candidate->password)) {
                Auth::login($candidate, $this->filled('remember'));
                $authenticated = true;
            }
        }

        if (! $authenticated) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('login')).'|'.$this->ip();
    }

    protected function phoneCandidates($phone)
    {
        $trimmed = trim((string) $phone);
        $digits = preg_replace('/\D+/', '', $trimmed);

        if ($digits === '') {
            return [$trimmed];
        }

        $candidates = [$trimmed, $digits];

        if (Str::startsWith($digits, '62')) {
            $candidates[] = '0'.substr($digits, 2);
        }

        if (Str::startsWith($digits, '0')) {
            $candidates[] = '62'.substr($digits, 1);
            $candidates[] = '+62'.substr($digits, 1);
        }

        return array_values(array_unique(array_filter($candidates)));
    }
}
