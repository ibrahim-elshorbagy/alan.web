<?php

namespace App\Repositories;

use App\Models\VcardBlog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Yajra\DataTables\Exceptions\Exception;
use Image;

class VcardBlogRepository extends BaseRepository
{
  /**
   * @var array
   */
  protected $fieldSearchable = [
    'title',
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
    return VcardBlog::class;
  }

  /**
   * @return mixed
   */
  public function store($input)
  {
    try {
      DB::beginTransaction();

      $vcardBlog = VcardBlog::create($input);

      if (isset($input['blog_icon']) && ! empty($input['blog_icon'])) {
        // Auto-resize blog icon to 576x300
        $image = Image::make($input['blog_icon']);
        $image->fit(576, 300);

        $tempPath = sys_get_temp_dir() . '/' . uniqid() . '_blog_icon.png';
        $image->save($tempPath, 100, 'png');

        $resizedBlogIcon = new \Illuminate\Http\UploadedFile(
          $tempPath,
          'blog_icon.png',
          'image/png',
          null,
          true
        );

        $vcardBlog->newAddMedia($resizedBlogIcon)->toMediaCollection(
          VcardBlog::BLOG_PATH,
          config('app.media_disc')
        );
      }

      DB::commit();

      return $vcardBlog;
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

      $vcardBlog = VcardBlog::findOrFail($id);
      $vcardBlog->update($input);

      if (isset($input['blog_icon']) && ! empty($input['blog_icon'])) {
        // Auto-resize blog icon to 576x300
        $image = Image::make($input['blog_icon']);
        $image->fit(576, 300);

        $tempPath = sys_get_temp_dir() . '/' . uniqid() . '_blog_icon.png';
        $image->save($tempPath, 100, 'png');

        $resizedBlogIcon = new \Illuminate\Http\UploadedFile(
          $tempPath,
          'blog_icon.png',
          'image/png',
          null,
          true
        );

        $vcardBlog->newClearMediaCollection($input['blog_icon'], VcardBlog::BLOG_PATH);
        $vcardBlog->newAddMedia($resizedBlogIcon)->toMediaCollection(
          VcardBlog::BLOG_PATH,
          config('app.media_disc')
        );
      }

      DB::commit();

      return $vcardBlog;
    } catch (Exception $e) {
      DB::rollBack();

      throw new UnprocessableEntityHttpException($e->getMessage());
    }
  }
}
