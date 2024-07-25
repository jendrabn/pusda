<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthService
{
	/**
	 * Authenticate a user.
	 *
	 * @param Request $request
	 * @return bool
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function login(Request $request): bool
	{
		$throttleKey = strtolower($request->username . '|' . $request->ip());

		$maxAttempts = 3;

		if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
			$seconds = RateLimiter::availableIn($throttleKey);

			throw ValidationException::withMessages([
				'username' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.',
			]);
		}

		$fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		if (!Auth::attempt([$fieldType => $request->username, ...$request->only('password')], $request->remember)) {
			RateLimiter::hit($throttleKey);

			return false;
		}

		RateLimiter::clear($throttleKey);

		$request->session()->regenerate();

		return true;
	}

	/**
	 * Logs out the authenticated user.
	 *
	 * @param Request $request
	 */
	public function logout(Request $request): void
	{
		Auth::guard('web')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();
	}

	/**
	 * Resets the user's password.
	 *
	 * @param Request $request
	 * @return string
	 */
	public function resetPassword(Request $request): string
	{
		return Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function (User $user, string $password) {
				$user->forceFill(compact('password'))
					->setRememberToken(Str::random(60));

				$user->save();
			}
		);
	}
}
