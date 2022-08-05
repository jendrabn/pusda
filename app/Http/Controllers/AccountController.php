<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AccountController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $this->validate($request, [
            'name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'no_hp' => ['nullable', 'max:15', 'starts_with:+62,62,08'],
            'avatar' => ['nullable', 'mimes:jpg,png,jpeg', 'max:1000'],
            'alamat' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['avatar'] = $user->avatar;

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = 'storage/' . $request->file('avatar')->store('images/avatars', 'public');
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->update($validated);

        return back()->with('alert-success', 'Profil berhasil diupdate');
    }

    public function password()
    {
        return view('account.change_password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string', 'max:255', 'min:3'],
            'password' => ['required', 'string', 'min:3', 'max:255', 'confirmed'],
        ]);

        if (Hash::check($request->current_password, $user->password)) {
            $user = $user->update(['password' => Hash::make($request->password)]);

            return back()->with('alert-success', 'Password berhasil diubah');
        }

        return back()->with('alert-danger', 'Password lama Anda salah');
    }
}
