<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Services\SeoService;

class HomeController extends Controller
{
  private SeoService $seo;

  public function __construct(SeoService $seo)
  {
    $this->seo = $seo;
  }

  public function __invoke()
  {
    $this->seo->setHome();

    $visitor = new Visitor();

    return view('front.home', compact('visitor'));
  }
}
