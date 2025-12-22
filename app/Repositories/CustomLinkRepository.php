<?php

namespace App\Repositories;

use App\Models\Banner;
use App\Models\CustomLink;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Yajra\DataTables\Exceptions\Exception;

class CustomLinkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        return CustomLink::class;
    }

        /**
     * @return mixed
     */
    public function store($input)
    {
        try {
            DB::beginTransaction();
            $customLink = CustomLink::create($input);
            DB::commit();
            return $customLink;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function update($input,$id)
    {
        try {
            DB::beginTransaction();
            $customLink = CustomLink::findOrFail($id);
            $input['show_as_button'] = $input['show_as_button'] ?? 0;
            $input['open_new_tab'] = $input['open_new_tab'] ?? 0;
            $customLink->update($input);
            DB::commit();
            return $customLink;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
