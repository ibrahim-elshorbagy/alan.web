<?php

namespace App\Repositories;

use Exception;
use App\Models\CustomPage;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CustomPageRepository extends BaseRepository
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
        return CustomPage::class;
    }

    /**
     * @return mixed
     */
    public function store($input)
    {

        try {
            DB::beginTransaction();
            $CustomPage = CustomPage::create($input);

            DB::commit();

            return $CustomPage;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $id)
    {
        try {
            DB::beginTransaction();
            $CustomPage = CustomPage::findOrFail($id);
            $CustomPage->update($input);
            DB::commit();
            return $CustomPage;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
