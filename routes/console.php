<?php

use App\Services\SitemapService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('sitemap:generate', function (SitemapService $service) {
  $path = $service->generate();
  $this->info('Sitemap generated at ' . $path);
})->purpose('Generate sitemap.xml for public pages');

Schedule::command('sitemap:generate')->daily();
