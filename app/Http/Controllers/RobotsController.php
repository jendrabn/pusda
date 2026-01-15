<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
  public function __invoke(): Response
  {
    $lines = ['User-agent: *'];

    if (!app()->environment('production')) {
      $lines[] = 'Disallow: /';
    } else {
      $lines[] = 'Allow: /';
      $lines[] = 'Disallow: /admin';
      $lines[] = 'Disallow: /admin-skpd';
      $lines[] = 'Disallow: /auth';
      $lines[] = 'Disallow: /login';
      $lines[] = 'Disallow: /register';
      $lines[] = 'Disallow: /profile';
      $lines[] = 'Disallow: /api';
      $lines[] = 'Disallow: /storage';
      $lines[] = 'Disallow: /vendor';
      $lines[] = 'Disallow: /*?';
      $lines[] = 'Sitemap: ' . url('/sitemap.xml');
    }

    return response(implode("\n", $lines), 200, ['Content-Type' => 'text/plain']);
  }
}
