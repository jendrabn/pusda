<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        return view('accounts.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'max:15', 'starts_with:+62,62,08'],
            'address' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image'],
        ]);

        $user->update($request->except('avatar'));

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $file = $request->file('avatar');
            $fileName = $user->username . '-' . $file->getClientOriginalName();

            $user->update([
                'avatar' =>  $file->storeAs('images/avatars', $fileName, 'public')
            ]);
        }

        return back();
    }

    public function password()
    {
        return view('accounts.changePassword');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'max:255', 'min:3'],
            'password' => ['required', 'string', 'min:3', 'max:255', 'confirmed'],
        ]);

        $user = auth()->user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->update($request->only('password'));

            return back();
        }

        return back();
    }
}
