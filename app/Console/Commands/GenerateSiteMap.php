<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Vcard;
use App\Models\VcardBlog;
use App\Models\CustomPage;
use App\Models\WhatsappStore;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Log;

class GenerateSiteMap extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'sitemap:generate';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Generate a comprehensive sitemap for the website including vcards, blogs, whatsapp stores, and custom pages';

  /**
   * Execute the console command.
   */
  public function handle(): void
  {
    try {
      Log::info('Sitemap generation started at ' . now()->toDateTimeString());
      $this->info('Starting sitemap generation...');

      // Update robots.txt
      $content = 'Sitemap: ' . config('app.url') . '/sitemap.xml
User-agent: *
Disallow:';

      file_put_contents(public_path('robots.txt'), $content);

      // Create sitemap instance
      $sitemap = Sitemap::create();

      // Add homepage
      $sitemap->add(
        Url::create(config('app.url'))
          ->setLastModificationDate(now())
          ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
          ->setPriority(1.0)
      );

      // Add active VCards
      $activeVcards = Vcard::where('status', true)
        ->select('url_alias', 'updated_at')
        ->get();

      foreach ($activeVcards as $vcard) {
        $sitemap->add(
          Url::create(route('vcard.show', ['alias' => $vcard->url_alias]))
            ->setLastModificationDate($vcard->updated_at ?? now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.9)
        );
      }

      // Add VCard Blogs
      $vcardBlogs = VcardBlog::with('vcard:id,url_alias,status')
        ->whereHas('vcard', function ($query) {
          $query->where('status', true);
        })
        ->select('id', 'vcard_id', 'updated_at')
        ->get();

      foreach ($vcardBlogs as $blog) {
        if ($blog->vcard && $blog->vcard->url_alias) {
          $sitemap->add(
            Url::create(route('vcard.show-blog', ['alias' => $blog->vcard->url_alias, 'id' => $blog->id]))
              ->setLastModificationDate($blog->updated_at ?? now())
              ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
              ->setPriority(0.8)
          );
        }
      }

      // Add active WhatsApp Stores
      $whatsappStores = WhatsappStore::where('status', true)
        ->select('url_alias', 'updated_at')
        ->get();

      foreach ($whatsappStores as $store) {
        $sitemap->add(
          Url::create(route('whatsapp.store.show', ['alias' => $store->url_alias]))
            ->setLastModificationDate($store->updated_at ?? now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8)
        );
      }

      // Add active Blogs (main site blogs)
      $blogs = Blog::where('status', Blog::IS_ACTIVE)
        ->select('slug', 'updated_at')
        ->get();

      foreach ($blogs as $blog) {
        $sitemap->add(
          Url::create(route('fornt-blog-show', ['slug' => $blog->slug]))
            ->setLastModificationDate($blog->updated_at ?? now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8)
        );
      }

      // Add active Custom Pages
      $customPages = CustomPage::where('status', true)
        ->select('slug', 'updated_at')
        ->get();

      foreach ($customPages as $page) {
        $sitemap->add(
          Url::create(route('fornt-custom-page-show', ['slug' => $page->slug]))
            ->setLastModificationDate($page->updated_at ?? now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.7)
        );
      }

      // Write sitemap to file
      $sitemap->writeToFile(public_path('sitemap.xml'));

      // Store generation timestamp
      $this->updateSitemapGeneratedAt();

      $this->info('Sitemap generated successfully!');
      $this->info('Total URLs: ' . $this->countUrls($activeVcards, $vcardBlogs, $whatsappStores, $blogs, $customPages));
    } catch (\Exception $e) {
      Log::error('Sitemap generation failed: ' . $e->getMessage());
      $this->error('Sitemap generation failed: ' . $e->getMessage());
    }
  }

  /**
   * Update the sitemap generation timestamp in settings
   */
  private function updateSitemapGeneratedAt(): void
  {
    \App\Models\Setting::updateOrCreate(
      ['key' => 'sitemap_generated_at'],
      ['value' => now()->toIso8601String()]
    );
  }

  /**
   * Count total URLs in sitemap
   */
  private function countUrls($vcards, $vcardBlogs, $stores, $blogs, $pages): int
  {
    return 1 + $vcards->count() + $vcardBlogs->count() + $stores->count() + $blogs->count() + $pages->count();
  }
}