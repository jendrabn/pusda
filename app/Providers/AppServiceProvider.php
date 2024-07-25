<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		Blade::if('role', fn($value) => auth()->user()->role === $value);
		Blade::if('admin', fn() => auth()->user()->role === User::ROLE_ADMIN);
		Blade::if('skpd', fn() => auth()->user()->role === User::ROLE_SKPD);

		ResetPassword::createUrlUsing(function (User $user, string $token) {
			return route('auth.reset-password', ['token' => $token, 'email' => $user->email]);
		});
	}
}
