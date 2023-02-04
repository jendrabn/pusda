<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Blade::if('role', fn ($value) => auth()->user()->role === $value);
    Blade::if('admin', fn () => auth()->user()->role === User::ROLE_ADMIN);
    Blade::if('skpd', fn () => auth()->user()->role === User::ROLE_SKPD);
  }
}
