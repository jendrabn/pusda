<?php

use App\Http\Middleware\Role;
use App\Http\Middleware\VisitorCounter;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__ . '/../routes/web.php',
		commands: __DIR__ . '/../routes/console.php',
		health: '/up',
	)
	->withMiddleware(function (Middleware $middleware) {
		$middleware->web(append: [
			\Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
		]);

		$middleware->alias([
			'visitor_counter' => VisitorCounter::class,
			'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
			'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
			'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
		]);

		$middleware->redirectGuestsTo('/');
	})
	->withExceptions(function (Exceptions $exceptions) {
		//
	})->create();
