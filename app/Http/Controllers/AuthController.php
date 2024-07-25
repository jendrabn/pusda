<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Flasher\Prime\Notification\Type;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Auth\ResetPasswordRequest;

class AuthController extends Controller
{

	public function __construct(private AuthService $service)
	{
	}

	/**
	 * Handle the login request.
	 *
	 * @param LoginRequest $request
	 * @return View|RedirectResponse
	 */
	public function login(LoginRequest $request): View|RedirectResponse
	{
		if ($request->isMethod('GET')) {
			return view('auth.login');
		}

		if (!$this->service->login($request)) {

			toastr('Invalid credentials.', Type::ERROR);

			return redirect()->back();
		}

		$routeName = match (auth()->user()->role) {
			User::ROLE_ADMIN => 'admin.dashboard',
			User::ROLE_SKPD => 'admin_skpd.dashboard',
			default => 'home'
		};

		return redirect()->intended(route($routeName, absolute: false));
	}

	/**
	 * Logs out the user and redirects to the homepage.
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function logout(Request $request): RedirectResponse
	{
		$this->service->logout($request);

		return redirect('/');
	}

	/**
	 * Returns the view for the forgot password page.
	 *
	 * @return View
	 */
	public function forgotPassword(): View
	{
		return view('auth.forgot-password');
	}

	/**
	 * Sends a password reset email to the specified email address.
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function sendResetPasswordLink(Request $request): RedirectResponse
	{
		$request->validate(['username' => ['required', 'string']]);

		$fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		if ($fieldType === 'email') {
			$request->merge([$fieldType => $request->username]);
		}

		$status = Password::sendResetLink($request->only($fieldType));

		if ($status !== Password::RESET_LINK_SENT) {
			toastr($status, Type::ERROR);

			return redirect()->back();
		}

		toastr('We have emailed your password reset link.', Type::SUCCESS);

		return redirect()->back();
	}

	/**
	 * Resets the password for a user.
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function resetPassword(ResetPasswordRequest $request, string $token = ''): View|RedirectResponse
	{
		if ($request->isMethod('GET')) {
			return view('auth.reset-password', ['params' => $request->query()]);
		}

		$status = $this->service->resetPassword($request);

		if ($status !== Password::PASSWORD_RESET) {
			toastr($status, Type::ERROR);

			return redirect()->back();
		}

		toastr('Your password has been reset.', Type::SUCCESS);

		return to_route('auth.login');
	}
}
