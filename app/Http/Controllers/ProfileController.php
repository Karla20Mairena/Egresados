<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        $usuario = User::find(auth()->user()->id);

        if (!$usuario) {
            // Manejar el caso en que el usuario no se encuentra
            return back()->withErrors(['error' => 'User not found.'.auth()->user()->id]);
        }

        $usuario->name = $request->name;
        $usuario->correo = $request->correo;
        $usuario->save();

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(ProfileRequest $request)
    {
        $usuario = User::find(auth()->user()->id);

        if (!$usuario) {
            // Manejar el caso en que el usuario no se encuentra
            return back()->withErrors(['error' => 'User not found.'.auth()->user()->id]);
        }

        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }
}