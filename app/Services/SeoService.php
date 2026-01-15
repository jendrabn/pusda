<?php

namespace App\Services;

use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\URL;

class SeoService
{
  private string $siteName;
  private string $defaultDescription;
  private string $defaultImage;

  public function __construct()
  {
    $this->siteName = config('app.name', 'Pusat Data Situbondo');
    $this->defaultDescription = 'Portal data dan informasi Pemerintah Kabupaten Situbondo.';
    $this->defaultImage = asset('img/logo.png');
  }

  public function setPage(string $title, ?string $description = null, array $options = []): void
  {
    $description = $description ?: $this->defaultDescription;
    $canonical = $options['canonical'] ?? URL::current();
    $image = $options['image'] ?? $this->defaultImage;
    $robots = $options['robots'] ?? 'index,follow';
    $ogType = $options['og_type'] ?? 'website';
    $schemaType = $options['schema_type'] ?? 'WebPage';
    $fullTitle = $title !== '' ? $title . ' - ' . $this->siteName : $this->siteName;

    SEOTools::setTitle($fullTitle);
    SEOTools::setDescription($description);
    SEOTools::setCanonical($canonical);

    SEOMeta::setRobots($robots);
    SEOMeta::addKeyword($options['keywords'] ?? []);

    OpenGraph::setTitle($fullTitle);
    OpenGraph::setDescription($description);
    OpenGraph::setUrl($canonical);
    OpenGraph::addProperty('type', $ogType);
    OpenGraph::addImage($image);

    TwitterCard::setType('summary_large_image');
    TwitterCard::setTitle($fullTitle);
    TwitterCard::setDescription($description);
    TwitterCard::setImage($image);

    SEOTools::jsonLd()->setTitle($fullTitle);
    SEOTools::jsonLd()->setDescription($description);
    SEOTools::jsonLd()->setType($schemaType);
    SEOTools::jsonLd()->setUrl($canonical);
    SEOTools::jsonLd()->addImage($image);
  }

  public function setHome(): void
  {
    $this->setPage('Beranda', $this->defaultDescription, [
      'schema_type' => 'WebSite',
      'og_type' => 'website',
    ]);

    JsonLdMulti::newJsonLd()
      ->setType('Organization')
      ->setTitle($this->siteName)
      ->setUrl(URL::to('/'))
      ->addValue('logo', $this->defaultImage);
  }
}
