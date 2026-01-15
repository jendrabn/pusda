<?php

namespace App\Http\Controllers;

use App\Services\SitemapService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class SitemapController extends Controller
{
  private SitemapService $service;

  public function __construct(SitemapService $service)
  {
    $this->service = $service;
  }

  public function __invoke(): Response
  {
    $content = Cache::remember('sitemap.xml', now()->addHours(6), function () {
      $path = $this->service->path();

      if (!File::exists($path)) {
        $this->service->generate();
      }

      return File::exists($path) ? File::get($path) : '';
    });

    if ($content === '') {
      abort(404);
    }

    return response($content, 200, ['Content-Type' => 'text/xml']);
  }
}
