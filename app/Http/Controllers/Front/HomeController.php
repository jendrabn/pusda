<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Visitor;

class HomeController extends Controller
{
  public function __invoke()
  {
    $visitor = new Visitor();

    return view('front.home', compact('visitor'));
  }
}
