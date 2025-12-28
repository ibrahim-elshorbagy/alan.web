<?php

namespace App\Repositories;

use App\Models\VcardService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Yajra\DataTables\Exceptions\Exception;
use Image;

class VcardServiceRepository extends BaseRepository
{
  /**
   * @var array
   */
  protected $fieldSearchable = [
    'name',
  ];

  /**
   * Return searchable fields
   */
  public function getFieldsSearchable(): array
  {
    return $this->fieldSearchable;
  }

  /**
   * Configure the Model
   **/
  public function model()
  {
    return VcardService::class;
  }

  /**
   * @return mixed
   */
  public function store($input)
  {
    try {
      DB::beginTransaction();

      $vcardService = VcardService::create($input);

      if (isset($input['service_icon']) && ! empty($input['service_icon'])) {
        // Auto-resize service icon to 100x100
        $serviceIconFile = $input['service_icon'];
        $image = Image::make($serviceIconFile);
        $image->fit(100, 100); // Service icon: 100x100

        $tempPath = sys_get_temp_dir() . '/' . uniqid() . '_service_icon.png';
        $image->save($tempPath, 100, 'png');

        $resizedServiceIcon = new \Illuminate\Http\UploadedFile(
          $tempPath,
          'service_icon.png',
          'image/png',
          null,
          true
        );

        $vcardService->newAddMedia($resizedServiceIcon)->toMediaCollection(
          VcardService::SERVICES_PATH,
          config('app.media_disc')
        );
      }

      DB::commit();

      return $vcardService;
    } catch (Exception $e) {
      DB::rollBack();

      throw new UnprocessableEntityHttpException($e->getMessage());
    }
  }

  /**
   * @return Builder|Builder[]|Collection|Model
   */
  public function update($input, $id)
  {
    try {
      DB::beginTransaction();

      $vcardService = VcardService::findOrFail($id);
      $vcardService->update($input);

      if (isset($input['service_icon']) && ! empty($input['service_icon'])) {
        // Auto-resize service icon to 100x100
        $serviceIconFile = $input['service_icon'];
        $image = Image::make($serviceIconFile);
        $image->fit(100, 100); // Service icon: 100x100

        $tempPath = sys_get_temp_dir() . '/' . uniqid() . '_service_icon.png';
        $image->save($tempPath, 100, 'png');

        $resizedServiceIcon = new \Illuminate\Http\UploadedFile(
          $tempPath,
          'service_icon.png',
          'image/png',
          null,
          true
        );

        $vcardService->newClearMediaCollection($input['service_icon'], VcardService::SERVICES_PATH);
        $vcardService->newAddMedia($resizedServiceIcon)->toMediaCollection(
          VcardService::SERVICES_PATH,
          config('app.media_disc')
        );
      }

      DB::commit();

      return $vcardService;
    } catch (Exception $e) {
      DB::rollBack();

      throw new UnprocessableEntityHttpException($e->getMessage());
    }
  }
}
