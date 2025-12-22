<?php

namespace App\Repositories;

use App\Models\Blog;
use DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Yajra\DataTables\Exceptions\Exception;

class BlogRepository extends BaseRepository
{
    /**
     * @var array
     */
    public $fieldSearchable = [
        'title',
    ];

    /**
     * {@inheritDoc}
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * {@inheritDoc}
     */
    public function model()
    {
        return Blog::class;
    }

    /**
     * @return mixed
     */
    public function store($input)
    {

        try {
            DB::beginTransaction();
            $blog = Blog::create($input);

            if (isset($input['blog_image']) && !empty($input['blog_image'])) {
                $blog->addMedia($input['blog_image'])->toMediaCollection(Blog::BLOGIMAGE, config('app.media_disc'));
            }

            DB::commit();

            return $blog;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $id)
    {
        try {
            DB::beginTransaction();
            $blog = Blog::findOrFail($id);
            $blog->update($input);
            if (isset($input['blog_image']) && !empty($input['blog_image'])) {
                $blog->clearMediaCollection(Blog::BLOGIMAGE);
                $blog->addMedia($input['blog_image'])->toMediaCollection(Blog::BLOGIMAGE, config('app.media_disc'));
            }
            DB::commit();
            return $blog;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
