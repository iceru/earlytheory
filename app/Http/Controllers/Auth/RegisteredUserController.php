<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\PhoneNumber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|string|max:32',
            'whatsapp_phone_confirmed' => 'accepted',
        ]);

        $phoneRegion = $request->input('phone_region', 'ID');
        if (!PhoneNumber::isValid($request->phone, $phoneRegion)) {
            return back()->withErrors(['phone' => 'Enter a valid phone number for the selected country.'])->withInput();
        }

        $normalizedPhone = PhoneNumber::normalize($request->phone, $phoneRegion);
        if (User::whereIn('phone', PhoneNumber::lookupCandidates($request->phone, $phoneRegion))->exists()) {
            return back()->withErrors(['phone' => __('validation.unique', ['attribute' => 'phone'])])->withInput();
        }

        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $normalizedPhone,
        ]));
        $user->addRole('user');

        event(new Registered($user));

        return redirect('/');
    }
}
