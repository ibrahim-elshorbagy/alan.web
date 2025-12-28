<?php

namespace App\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Analytic;
use Carbon\CarbonPeriod;
use App\Models\WhatsappStore;
use App\Models\ProductCategory;
use App\Models\WpStoreTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\WhatsappStoreProduct;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Database\Seeders\WhatsAppStoreTemplatesSeeder;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Intervention\Image\Facades\Image;
use Illuminate\Http\UploadedFile;

class WhatsappStoreRepository extends BaseRepository
{
  public $fieldSearchable = [
    'store_name',
  ];

  /**
   * {@inheritDoc}
   */
  public function getFieldsSearchable()
  {
    return $this->fieldSearchable;
  }
  public function model()
  {
    return WhatsappStore::class;
  }

  public function store($input)
  {
    $input['url_alias'] = str_replace(' ', '-', strtolower($input['store_name']));
    $input['template_id'] = WpStoreTemplate::first()->id;
    $input['news_letter_popup'] = $input['news_letter_popup'] ?? 0;
    $input['business_hours'] = $input['business_hours'] ?? 0;
    $input['hide_stickybar'] = $input['hide_stickybar'] ?? 0;
    $input['enable_download_qr_code'] = isset($input['enable_download_qr_code']) ? 1 : 0;
    $input['slider_video_banner'] = $input['slider_video_banner'] ?? null;

    $whatsappStore = WhatsappStore::create($input);

    if (isset($input['logo']) && !empty($input['logo'])) {
      $file = $input['logo'];
      $resizedImage = Image::make($file)->fit(100, 100);
      $tempPath = sys_get_temp_dir() . '/' . time() . '_logo.' . $file->extension();
      $resizedImage->save($tempPath);
      $resizedFile = new UploadedFile($tempPath, $file->getClientOriginalName(), $file->getMimeType(), null, true);

      $whatsappStore->newAddMedia($resizedFile)->toMediaCollection(
        WhatsappStore::LOGO,
        config('app.media_disc')
      );
    }
    if (isset($input['cover_img']) && !empty($input['cover_img'])) {
      $file = $input['cover_img'];
      $resizedImage = Image::make($file)->fit(576, 300);
      $tempPath = sys_get_temp_dir() . '/' . time() . '_cover.' . $file->extension();
      $resizedImage->save($tempPath);
      $resizedFile = new UploadedFile($tempPath, $file->getClientOriginalName(), $file->getMimeType(), null, true);

      $whatsappStore->newAddMedia($resizedFile)->toMediaCollection(WhatsappStore::COVER_IMAGE, config('app.media_disc'));
    }

    return $whatsappStore;
  }

  public function update($whatsappStore, $input)
  {
    try {
      DB::beginTransaction();
      $input['news_letter_popup'] = $input['news_letter_popup'] ?? 0;
      $input['business_hours'] = $input['business_hours'] ?? 0;
      $input['hide_stickybar'] = $input['hide_stickybar'] ?? 0;
      $input['enable_download_qr_code'] = isset($input['enable_download_qr_code']) ? 1 : 0;
      $whatsappStore->update($input);

      if (isset($input['logo']) && !empty($input['logo'])) {
        $file = $input['logo'];
        $resizedImage = Image::make($file)->fit(100, 100);
        $tempPath = sys_get_temp_dir() . '/' . time() . '_logo.' . $file->extension();
        $resizedImage->save($tempPath);
        $resizedFile = new UploadedFile($tempPath, $file->getClientOriginalName(), $file->getMimeType(), null, true);

        $tempLogoMedia = $whatsappStore->newAddMedia($resizedFile)->toMediaCollection(
          WhatsappStore::LOGO,
          config('app.media_disc')
        );

        $whatsappStore->media()
          ->where('id', '!=', $tempLogoMedia->id)
          ->where('collection_name', WhatsappStore::LOGO)
          ->delete();
      }
      if (isset($input['cover_img']) && !empty($input['cover_img'])) {
        $file = $input['cover_img'];
        $resizedImage = Image::make($file)->fit(576, 300);
        $tempPath = sys_get_temp_dir() . '/' . time() . '_cover.' . $file->extension();
        $resizedImage->save($tempPath);
        $resizedFile = new UploadedFile($tempPath, $file->getClientOriginalName(), $file->getMimeType(), null, true);

        $tempCoverMedia = $whatsappStore->newAddMedia($resizedFile)->toMediaCollection(
          WhatsappStore::COVER_IMAGE,
          config('app.media_disc')
        );

        $whatsappStore->media()
          ->where('id', '!=', $tempCoverMedia->id)
          ->where('collection_name', WhatsappStore::COVER_IMAGE)
          ->delete();
      }

      DB::commit();

      return $whatsappStore;
    } catch (\Exception $e) {
      DB::rollback();

      throw $e;
    }
  }

  public function analyticsData(
    $input,
    $whatsappStore
  ): array {
    $analytics = Analytic::where('whatsapp_store_id', $whatsappStore->id)->get();
    if ($analytics->count() > 0) {
      $DataCount = $analytics->count();
      $percentage = 100 / $DataCount;
      $browser = $analytics->groupBy('browser');
      $data = [];
      foreach ($browser as $key => $item) {
        $browser_record[$key]['count'] = $item->count();
        $browser_record[$key]['per'] = $item->count() * $percentage;
      }

      $browser_data = collect($browser_record)->sortBy('count')->reverse()->toArray();

      $data['browser'] = $browser_data;

      $device = $analytics->groupBy('device');

      foreach ($device as $key => $item) {
        $device_record[$key]['count'] = $item->count();
        $device_record[$key]['per'] = $item->count() * $percentage;
      }

      $device_data = collect($device_record)->sortBy('count')->reverse()->toArray();

      $data['device'] = $device_data;

      $country = $analytics->groupBy('country');

      foreach ($country as $key => $item) {
        $country_record[$key]['count'] = $item->count();
        $country_record[$key]['per'] = $item->count() * $percentage;
      }

      $country_data = collect($country_record)->sortBy('count')->reverse()->toArray();

      $data['country'] = $country_data;

      $operating_system = $analytics->groupBy('operating_system');

      foreach ($operating_system as $key => $item) {
        $operating_record[$key]['count'] = $item->count();
        $operating_record[$key]['per'] = $item->count() * $percentage;
      }

      $operating_data = collect($operating_record)->sortBy('count')->reverse()->toArray();

      $data['operating_system'] = $operating_data;

      $language = $analytics->groupBy('language');

      foreach ($language as $key => $item) {
        $language_record[$key]['count'] = $item->count();
        $language_record[$key]['per'] = $item->count() * $percentage;
      }

      $language_data = collect($language_record)->sortBy('count')->reverse()->toArray();

      $data['language'] = $language_data;

      $data['whatsappStoreID'] = $whatsappStore->id;

      return $data;
    }
    $data['noRecord'] = __('messages.common.no_data_available');

    return $data;
  }

  public function chartData(
    $input
  ): array {
    $startDate = isset($input['start_date']) ? Carbon::parse($input['start_date']) : '';
    $endDate = isset($input['end_date']) ? Carbon::parse($input['end_date']) : '';
    $data = [];

    $analytics = Analytic::where('whatsapp_store_id', $input['whatsappStoreID']);
    $visitor = $analytics->addSelect([DB::raw('DAY(created_at) as day,created_at')])
      ->addSelect([DB::raw('Month(created_at) as month,created_at')])
      ->addSelect([DB::raw('YEAR(created_at) as year,created_at')])
      ->orderBy('created_at')
      ->get();
    $period = CarbonPeriod::create($startDate, $endDate);

    foreach ($period as $date) {
      $data['totalVisitorCount'][] = $visitor->where('day', $date->format('d'))->where(
        'month',
        $date->format('m')
      )->where('year', $date->format('Y'))->count();
      $data['weeklyLabels'][] = $date->format('d-m-y');
    }

    return $data;
  }

  public function getDuplicateVcard(
    $whatsappStore,
    $userId = null
  ) {
    if (!$whatsappStore) {
      throw new Exception(__('messages.flash.whatsapp_store_null'));
    }
    $newWhatsappStore = $whatsappStore->replicate();
    if ($newWhatsappStore['tenant_id'] != getLogInTenantId()) {
      $user = User::findOrFail($userId);
      $tanentId = $user->tenant_id;
      $newWhatsappStore['tenant_id'] = $tanentId;
    } else {
      $tanentId = $whatsappStore->tenant_id;
    }
    $baseAlias = preg_replace('/[0-9]+/', '', $newWhatsappStore->url_alias);
    $matchAlias = WhatsappStore::where('url_alias', 'LIKE', '%' . $newWhatsappStore->url_alias . '%')->get();
    $lastCharArr = [];
    foreach ($matchAlias as $alias) {
      $aliasLastCharCheck = str_replace($newWhatsappStore->url_alias, '', $alias->url_alias);
      $lastCharArr[] = $aliasLastCharCheck;
    }
    $maxChar = max($lastCharArr);
    $maxChar++;
    $newWhatsappStore->url_alias = $newWhatsappStore->url_alias . $maxChar;
    $newWhatsappStore->save();

    if ($whatsappStore->logo_url) {
      try {
        $newWhatsappStore->addMediaFromUrl($whatsappStore->logo_url)->toMediaCollection(
          WhatsappStore::LOGO,
          config('app.media_disc')
        );
      } catch (Exception $e) {
        Log::error($e->getMessage());
      }
    }

    if ($whatsappStore->cover_url) {
      try {
        $newWhatsappStore->addMediaFromUrl($whatsappStore->cover_url)->toMediaCollection(
          WhatsappStore::COVER_IMAGE,
          config('app.media_disc')
        );
      } catch (Exception $e) {
        Log::error($e->getMessage());
      }
    }

    $categoryIdMap = [];
    foreach ($whatsappStore->categories as $category) {
      $newCategory = $category->replicate();
      $newCategory->whatsapp_store_id = $newWhatsappStore->id;
      $newCategory->tenant_id = $tanentId;
      $newCategory->save();

      $categoryIdMap[$category->id] = $newCategory->id;

      if ($category->image_url) {
        try {
          $newCategory->addMediaFromUrl($category->image_url)->toMediaCollection(
            ProductCategory::IMAGE,
            config('app.media_disc')
          );
        } catch (Exception $e) {
          Log::error($e->getMessage());
        }
      }
    }
    foreach ($whatsappStore->products as $product) {
      $newProduct = $product->replicate();
      $newProduct->whatsapp_store_id = $newWhatsappStore->id;
      $newProduct->tenant_id = $tanentId;
      $newProduct->category_id = $categoryIdMap[$product->category_id];
      $newProduct->save();

      foreach ($product->images_url as $imageUrl) {
        if ($imageUrl) {
          try {
            $newProduct->addMediaFromUrl($imageUrl)->toMediaCollection(
              WhatsappStoreProduct::PRODUCT_IMAGES,
              config('app.media_disc')
            );
          } catch (Exception $e) {
            Log::error($e->getMessage());
          }
        }
      }
    }
  }
}
