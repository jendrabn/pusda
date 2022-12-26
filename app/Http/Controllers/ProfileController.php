<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileInformationUpdateRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('profile', ['user' => auth()->user()]);
    }

    public function updateProfileInformation(ProfileInformationUpdateRequest $request): RedirectResponse
    {
        auth()->user()->update($request->all());

        return back()->with('message', 'Profil successfully updated.');
    }

    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        auth()->user()->update($request->only('password'));

        return back()->with('message', 'Password successfully updated.');
    }
}
