<?php

namespace App\Http\Controllers\Skpd;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

  public function __invoke(Request $request)
  {
    return view('skpd.dashboard', [
      'users_count' => User::count()
    ]);
  }
}
