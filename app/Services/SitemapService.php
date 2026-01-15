<?php

namespace App\Services;

use App\Models\Skpd;
use App\Models\Tabel8KelData;
use App\Models\TabelBps;
use App\Models\TabelIndikator;
use App\Models\TabelRpjmd;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapService
{
  public function generate(): string
  {
    $sitemap = Sitemap::create();

    $sitemap->add($this->makeUrl(route('home'), now(), Url::CHANGE_FREQUENCY_DAILY, 1.0));
    $sitemap->add($this->makeUrl(route('bps.index'), now(), Url::CHANGE_FREQUENCY_WEEKLY, 0.8));
    $sitemap->add($this->makeUrl(route('rpjmd.index'), now(), Url::CHANGE_FREQUENCY_WEEKLY, 0.8));
    $sitemap->add($this->makeUrl(route('delapankeldata.index'), now(), Url::CHANGE_FREQUENCY_WEEKLY, 0.8));
    $sitemap->add($this->makeUrl(route('indikator.index'), now(), Url::CHANGE_FREQUENCY_WEEKLY, 0.8));
    $sitemap->add($this->makeUrl(route('skpd'), now(), Url::CHANGE_FREQUENCY_WEEKLY, 0.7));

    foreach (TabelBps::cursor() as $tabel) {
      $sitemap->add($this->makeUrl(route('bps.tabel', $tabel), $tabel->updated_at));
    }

    foreach (TabelRpjmd::cursor() as $tabel) {
      $sitemap->add($this->makeUrl(route('rpjmd.tabel', $tabel), $tabel->updated_at));
    }

    foreach (Tabel8KelData::cursor() as $tabel) {
      $sitemap->add($this->makeUrl(route('delapankeldata.tabel', $tabel), $tabel->updated_at));
    }

    foreach (TabelIndikator::cursor() as $tabel) {
      $sitemap->add($this->makeUrl(route('indikator.tabel', $tabel), $tabel->updated_at));
    }

    foreach (Skpd::where('id', '!=', 1)->cursor() as $skpd) {
      $sitemap->add($this->makeUrl(route('delapankeldata.skpd', $skpd), $skpd->updated_at));
    }

    Storage::disk('local')->put('sitemaps/sitemap.xml', $sitemap->render());
    Cache::forget('sitemap.xml');

    return $this->path();
  }

  public function path(): string
  {
    return storage_path('app/sitemaps/sitemap.xml');
  }

  private function makeUrl(string $url, $lastModified = null, string $changeFrequency = Url::CHANGE_FREQUENCY_WEEKLY, float $priority = 0.7): Url
  {
    $tag = Url::create($url)
      ->setChangeFrequency($changeFrequency)
      ->setPriority($priority);

    if ($lastModified) {
      $tag->setLastModificationDate($lastModified);
    }

    return $tag;
  }
}
