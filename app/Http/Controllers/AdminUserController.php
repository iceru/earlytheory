<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find($request->id);

        $request->validate([
            'name' => 'required',
            'email' => ['nullable', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => 'required',
            'birthdate' => 'required',
        ]);

        $phoneRegion = $request->input('phone_region', 'ID');
        if (!PhoneNumber::isValid($request->phone, $phoneRegion)) {
            return back()->withErrors(['phone' => 'Enter a valid phone number for the selected country.'])->withInput();
        }

        if (User::whereIn('phone', PhoneNumber::lookupCandidates($request->phone, $phoneRegion))
            ->where('id', '!=', $user->id)->exists()) {
            return back()->withErrors(['phone' => __('validation.unique', ['attribute' => 'phone'])])->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = PhoneNumber::normalize($request->phone, $phoneRegion);
        $user->birthdate = $request->birthdate;

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Data berhasil terupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
